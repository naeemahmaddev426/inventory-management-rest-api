<?php

namespace App\Repositories\Eloquent;

use App\Models\Supplier;
use App\Repositories\Interfaces\SupplierRepositoryInterface;

class SupplierRepository implements SupplierRepositoryInterface
{
    /**
     * Get all suppliers.
     */
    public function all()
    {
        return Supplier::latest()->get();
    }

    /**
     * Paginate suppliers.
     */
    public function paginate(int $perPage = 10)
    {
        return Supplier::latest()->paginate($perPage);
    }

    /**
     * Find supplier by ID.
     */
    public function find(int $id): ?Supplier
    {
        return Supplier::find($id);
    }

    /**
     * Store supplier.
     */
    public function create(array $data): Supplier
    {
        return Supplier::create($data);
    }

    /**
     * Update supplier.
     */
    public function update(Supplier $supplier, array $data): Supplier
    {
        $supplier->update($data);

        return $supplier->fresh();
    }

    /**
     * Delete supplier.
     */
    public function delete(Supplier $supplier): bool
    {
        return $supplier->delete();
    }
}