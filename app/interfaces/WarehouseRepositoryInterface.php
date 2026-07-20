<?php

namespace App\Interfaces;

use App\Models\Warehouse;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface WarehouseRepositoryInterface
{
    /**
     * Display paginated warehouses.
     */
    public function getAll(array $filters = []): LengthAwarePaginator;

    /**
     * Get all active warehouses.
     */
    public function getActive(): Collection;

    /**
     * Find warehouse by id.
     */
    public function findById(int $id): ?Warehouse;

    /**
     * Create warehouse.
     */
    public function create(array $data): Warehouse;

    /**
     * Update warehouse.
     */
    public function update(Warehouse $warehouse, array $data): bool;

    /**
     * Soft delete warehouse.
     */
    public function delete(Warehouse $warehouse): bool;

    /**
     * Restore warehouse.
     */
    public function restore(int $id): bool;

    /**
     * Permanently delete warehouse.
     */
    public function forceDelete(int $id): bool;
}