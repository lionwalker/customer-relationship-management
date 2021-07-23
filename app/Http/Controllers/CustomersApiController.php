<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Imports\CustomersImport;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

class CustomersApiController extends Controller
{
    /**
     * @OA\Get(
     *      path="/customers",
     *      operationId="getCustomerList",
     *      tags={"Customers"},
     *      summary="Get list of customers",
     *      description="Returns list of customers",
     *      security={{"sanctum": {}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/CustomerResource")
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function index()
    {
        return new CustomerResource(Customer::paginate(20));
    }

    /**
     * @OA\Post(
     *      path="/customers",
     *      operationId="storeCustomer",
     *      tags={"Customers"},
     *      summary="Store new customers",
     *      description="Returns customers data",
     *      security={{"sanctum":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/CreateCustomerRequest")
     *      ),
     *     @OA\Parameter(
     *          name="bulk",
     *          in="query",
     *          description="CSV file to create / update customers",
     *          required=true,
     *          @OA\Schema(type="file"),
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Customer")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function store(CreateCustomerRequest $createCustomerRequest)
    {
        // Process bulk files if exists
        if ($createCustomerRequest->hasFile('bulk')) {
            $import = new CustomersImport();
            $import->import($createCustomerRequest->file('bulk'));
            $failures = $import->failures();
            if ($failures->count() > 0) {
                $customers = collect();
                foreach ($failures as $failure) {
                    $errors = implode(" ", $failure->errors());
                    $customer = $failure->values()['email'];
                    $customers->push(['email' => $customer, 'error' => $errors]);
                }
                return response()->json([
                    'message' => 'The given data was invalid.',
                    'errors' => [
                        $customers->toArray()
                    ]
                ]);
            } else {
                return response()->json(['message' => 'Customers bulk uploaded.'])->setStatusCode(Response::HTTP_CREATED);
            }
        }

        // Process form data if exists
        if (!empty($createCustomerRequest['email'])) {
            $customer = Customer::create([
                'first_name' => $createCustomerRequest['first_name'],
                'last_name' => $createCustomerRequest['last_name'],
                'email' => $createCustomerRequest['email'],
                'phone_number' => $createCustomerRequest['phone_number'],
            ]);
            return (new CustomerResource($customer))
                ->response()
                ->setStatusCode(Response::HTTP_CREATED);
        }

    }

    /**
     * @OA\Get(
     *      path="/customers/{id}",
     *      operationId="getCustomerById",
     *      tags={"Customers"},
     *      summary="Get customer information",
     *      description="Returns customer data",
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="Customer id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Customer")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function show(Customer $customer)
    {
        return new CustomerResource($customer);
    }

    /**
     * @OA\Put(
     *      path="/customers/{id}",
     *      operationId="updateCustomer",
     *      tags={"Customers"},
     *      summary="Update existing customer",
     *      description="Returns updated customer data",
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="Customer id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UpdateCustomerRequest")
     *      ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Customer")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function update(UpdateCustomerRequest $updateCustomerRequest, Customer $customer)
    {
        $customer->first_name = $updateCustomerRequest['first_name'];
        $customer->last_name = $updateCustomerRequest['last_name'];
        $customer->email = $updateCustomerRequest['email'];
        $customer->phone_number = $updateCustomerRequest['phone_number'];
        $customer->save();

        return (new CustomerResource($customer))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * @OA\Delete(
     *      path="/customers/{id}",
     *      operationId="deleteCustomer",
     *      tags={"Customers"},
     *      summary="Delete existing customer",
     *      description="Deletes a record and returns no content",
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="Customer id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
