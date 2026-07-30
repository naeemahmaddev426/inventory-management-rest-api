<?php

namespace App\Services;

use App\Models\Customer;
use Illuminate\Support\Str;
use App\Repositories\Interfaces\CustomerRepositoryInterface;

class CustomerService
{
    public function __construct(
        protected CustomerRepositoryInterface $customerRepository
    ) {}

    /**
     * Display paginated customers.
     */
    public function paginate(int $perPage = 10)
    {
        return $this->customerRepository->paginate($perPage);
    }

    /**
     * Get all customers.
     */
    public function all()
    {
        return $this->customerRepository->getAll();
    }

    /**
     * Create customer.
     */
    public function create(array $data): Customer
    {
        $data['customer_code'] = $this->generateCustomerCode();

        return $this->customerRepository->create($data);
    }

    /**
     * Update customer.
     */
    public function update(Customer $customer, array $data): Customer
    {
        return $this->customerRepository->update($customer->id, $data);
    }

    /**
     * Delete customer.
     */
    public function delete(Customer $customer): bool
    {
        return $this->customerRepository->delete($customer->id);
    }

    /**
     * Generate unique customer code.
     */
    private function generateCustomerCode(): string
    {
        do {
            $code = 'CUS-' . strtoupper(Str::random(6));
        } while (Customer::where('customer_code', $code)->exists());

        return $code;
    }
}