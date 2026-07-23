<?php

namespace App\Services;

use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\Interfaces\SupplierRepositoryInterface;

class SupplierService
{
    protected SupplierRepositoryInterface $supplierRepository;

    public function __construct(
        SupplierRepositoryInterface $supplierRepository
    ) {
        $this->supplierRepository = $supplierRepository;
    }

    /**
     * Get all suppliers
     */
    public function all()
    {
        return $this->supplierRepository->all();
    }

    /**
     * Paginate suppliers
     */
    public function paginate(int $perPage = 10)
    {
        return $this->supplierRepository->paginate($perPage);
    }

    /**
     * Find supplier
     */
    public function find(int $id): ?Supplier
    {
        return $this->supplierRepository->find($id);
    }

    /**
     * Store supplier
     */
    public function create(array $data): Supplier
    {
        return DB::transaction(function () use ($data) {

            $supplier = $this->supplierRepository->create($data);

            Log::info('Supplier Created', [
                'supplier_id' => $supplier->id,
                'company_name' => $supplier->company_name,
            ]);

            return $supplier;
        });
    }

    /**
     * Update supplier
     */
    public function update(Supplier $supplier, array $data): Supplier
    {
        return DB::transaction(function () use ($supplier, $data) {

            $supplier = $this->supplierRepository->update($supplier, $data);

            Log::info('Supplier Updated', [
                'supplier_id' => $supplier->id,
            ]);

            return $supplier;
        });
    }

    /**
     * Delete supplier
     */
    public function delete(Supplier $supplier): bool
    {
        return DB::transaction(function () use ($supplier) {

            Log::info('Supplier Deleted', [
                'supplier_id' => $supplier->id,
            ]);

            return $this->supplierRepository->delete($supplier);
        });
    }
}