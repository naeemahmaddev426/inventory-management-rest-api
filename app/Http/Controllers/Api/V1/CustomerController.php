<?php

namespace App\Http\Controllers\Api\V1;

use Throwable;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use App\Services\CustomerService;
use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\CustomerCollection;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;

class CustomerController extends Controller
{
    protected CustomerService $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    /**
     * Display a listing of customers.
     */
    public function index(): CustomerCollection
    {
        $customers = $this->customerService->paginate(10);

        return new CustomerCollection($customers);
    }

    /**
     * Store a newly created customer.
     */
    public function store(StoreCustomerRequest $request): JsonResponse
    {
        try {

            $customer = $this->customerService->create(
                $request->validated()
            );

            return response()->json([
                'success' => true,
                'message' => 'Customer created successfully.',
                'data' => new CustomerResource($customer),
            ], 201);

        } catch (Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);

        }
    }

    /**
     * Display the specified customer.
     */
    public function show(Customer $customer): CustomerResource
    {
        return new CustomerResource($customer);
    }

    /**
     * Update the specified customer.
     */
    public function update(
        UpdateCustomerRequest $request,
        Customer $customer
    ): JsonResponse {

        try {

            $customer = $this->customerService->update(
                $customer,
                $request->validated()
            );

            return response()->json([
                'success' => true,
                'message' => 'Customer updated successfully.',
                'data' => new CustomerResource($customer),
            ]);

        } catch (Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);

        }
    }

    /**
     * Remove the specified customer.
     */
    public function destroy(Customer $customer): JsonResponse
    {
        try {

            $this->customerService->delete($customer);

            return response()->json([
                'success' => true,
                'message' => 'Customer deleted successfully.',
            ]);

        } catch (Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);

        }
    }
}