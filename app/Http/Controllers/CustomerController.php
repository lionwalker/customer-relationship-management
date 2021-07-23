<?php

namespace App\Http\Controllers;

use App\Exports\FailedCustomersExport;
use App\Http\Requests\CreateCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Imports\CustomersImport;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $customers = Customer::query();
        if ($request->has('keyword')) {
            $customers = $customers->where('first_name', 'like', '%' . $request->keyword . '%')
                ->orWhere('last_name', 'like', '%' . $request->keyword . '%')
                ->orWhere('email', 'like', '%' . $request->keyword . '%')
                ->orWhere('phone_number', 'like', '%' . $request->keyword . '%');
        }
        $customers = $customers->paginate(10);
        return Inertia::render('Customers', [
            'customersList' => $customers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateCustomerRequest $createCustomerRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateCustomerRequest $createCustomerRequest)
    {

        // Process bulk files if exists
        if ($createCustomerRequest->hasFile('bulk')) {
            $import = new CustomersImport();
            $import->import($createCustomerRequest->file('bulk'));
            if ($import->failures()->count() > 0) {
                $file_name = strtotime(Carbon::now());
                $this->createFailedCustomersListExcel($import->failures(), $file_name);
                $msg = "One or more customer details had errors while adding. <a href='failed-customers/$file_name.xlsx' style='color: #1d68a7 !important;'>Click here</a> to download detailed report.";
                return redirect()->back()->withErrors($msg);
            }
        }

        // Process form data if exists
        if (!empty($createCustomerRequest['email'])) {
            Customer::create([
                'first_name' => $createCustomerRequest['first_name'],
                'last_name' => $createCustomerRequest['last_name'],
                'email' => $createCustomerRequest['email'],
                'phone_number' => $createCustomerRequest['phone_number'],
            ]);
        }

        return redirect()->back()->with('message', 'Customer Created Successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCustomerRequest $updateCustomerRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateCustomerRequest $updateCustomerRequest)
    {
        if ($updateCustomerRequest->has('id')) {
            $customer = Customer::find($updateCustomerRequest['id']);
            $customer->first_name = $updateCustomerRequest['first_name'];
            $customer->last_name = $updateCustomerRequest['last_name'];
            $customer->email = $updateCustomerRequest['email'];
            $customer->phone_number = $updateCustomerRequest['phone_number'];
            $customer->save();
            return redirect()->back()->with('message', 'Customer Updated Successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        if ($request->has('id')) {
            Customer::find($request->input('id'))->delete();
            return redirect()->back()->with('message', 'Customer Deleted Successfully.');
        }
    }

    /**
     * Return total customer count.
     *
     * @return \Inertia\Response
     */
    public function counts()
    {
        $customerCount = Customer::all()->count();
        return Inertia::render('Dashboard', [
            'customerCount' => $customerCount
        ]);
    }

    /**
     * This will create excel file of failed customers list.
     *
     * @return array|\Inertia\Response|string|string[]
     */
    public function createFailedCustomersListExcel($failures, $file_name)
    {
        $customers = collect();
        if (!empty($failures) && $failures->count() > 0) {
            foreach ($failures as $failure) {
                $errors = implode(" ", $failure->errors());
                $customer = $failure->values()['email'];
                $customers->push([$customer, $errors]);
            }
        }

        $filePath = "failed_customers/$file_name.xlsx";
        Excel::store(new FailedCustomersExport($customers), $filePath);
        return str_replace('failed_customers/', '', $filePath);
    }

    /**
     * This will initiate the download of the failed customers list and will delete the file after downloaded.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadFailedCustomers($filePath)
    {
        return response()->download(storage_path() . '/app/failed_customers/' . $filePath)->deleteFileAfterSend();
    }
}
