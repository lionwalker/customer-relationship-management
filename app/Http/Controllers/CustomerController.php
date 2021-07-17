<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Inertia\Inertia;

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
            $customers = $customers->where('first_name','like','%' . $request->keyword . '%')
                ->orWhere('last_name','like','%' . $request->keyword . '%')
                ->orWhere('email','like','%' . $request->keyword . '%')
                ->orWhere('phone_number','like','%' . $request->keyword . '%');
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
        Customer::create([
            'first_name' => $createCustomerRequest['first_name'],
            'last_name' => $createCustomerRequest['last_name'],
            'email' => $createCustomerRequest['email'],
            'phone_number' => $createCustomerRequest['phone_number'],
        ]);

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
            return redirect()->back();
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
}
