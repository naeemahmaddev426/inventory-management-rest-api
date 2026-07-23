<?php

namespace App\Repositories\Interfaces;

use App\Models\Supplier;

interface SupplierRepositoryInterface
{
    /**
     * Get all suppliers.
     */
    public function all();

    /**
     * Paginated suppliers.
     */
    public function paginate(int $perPage = 10);

    /**
     * Find supplier by ID.
     */
    public function find(int $id): ?Supplier;

    /**
     * Store supplier.
     */
    public function create(array $data): Supplier;

    /**
     * Update supplier.
     */
    public function update(Supplier $supplier, array $data): Supplier;

    /**
     * Delete supplier.
     */
    public function delete(Supplier $supplier): bool;
}