<?php

namespace App\Repositories;

use App\Interfaces\WarehouseRepositoryInterface;
use App\Models\Warehouse;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

class WarehouseRepository implements WarehouseRepositoryInterface
{
    /**
     * Display paginated warehouses with filters.
     */
    public function getAll(array $filters = []): LengthAwarePaginator
    {
        $query = Warehouse::query();

        // Search by name, code, manager
        if (!empty($filters['search'])) {
            $search = trim($filters['search']);

            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('code', 'LIKE', "%{$search}%")
                    ->orWhere('manager_name', 'LIKE', "%{$search}%")
                    ->orWhere('city', 'LIKE', "%{$search}%")
                    ->orWhere('country', 'LIKE', "%{$search}%");
            });
        }

        // Status Filter
        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('status', $filters['status']);
        }

        // City Filter
        if (!empty($filters['city'])) {
            $query->where('city', $filters['city']);
        }

        // Country Filter
        if (!empty($filters['country'])) {
            $query->where('country', $filters['country']);
        }

        // Sorting
        $sortBy = $filters['sort_by'] ?? 'id';
        $sortDirection = strtolower($filters['sort_direction'] ?? 'desc');

        $allowedSorts = [
            'id',
            'name',
            'code',
            'city',
            'country',
            'created_at',
        ];

        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'id';
        }

        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'desc';
        }

        $perPage = (int) ($filters['per_page'] ?? 10);

        return $query
            ->orderBy($sortBy, $sortDirection)
            ->paginate($perPage)
            ->withQueryString();
    }

    /**
     * Return all active warehouses.
     */
    public function getActive(): Collection
    {
        return Warehouse::where('status', true)
            ->orderBy('name')
            ->get();
    }

    /**
     * Find warehouse by id.
     */
    public function findById(int $id): ?Warehouse
    {
        return Warehouse::find($id);
    }

    /**
     * Create warehouse.
     *
     * @throws Throwable
     */
    public function create(array $data): Warehouse
    {
        return DB::transaction(function () use ($data) {
            return Warehouse::create($data);
        });
    }

    /**
     * Update warehouse.
     *
     * @throws Throwable
     */
    public function update(Warehouse $warehouse, array $data): bool
    {
        return DB::transaction(function () use ($warehouse, $data) {
            return $warehouse->update($data);
        });
    }

    /**
     * Soft delete warehouse.
     *
     * @throws Throwable
     */
    public function delete(Warehouse $warehouse): bool
    {
        return DB::transaction(function () use ($warehouse) {
            return (bool) $warehouse->delete();
        });
    }

    /**
     * Restore soft deleted warehouse.
     *
     * @throws Throwable
     */
    public function restore(int $id): bool
    {
        return DB::transaction(function () use ($id) {

            $warehouse = Warehouse::withTrashed()->findOrFail($id);

            return (bool) $warehouse->restore();
        });
    }

    /**
     * Permanently delete warehouse.
     *
     * @throws Throwable
     */
    public function forceDelete(int $id): bool
    {
        return DB::transaction(function () use ($id) {

            $warehouse = Warehouse::withTrashed()->findOrFail($id);

            return (bool) $warehouse->forceDelete();
        });
    }
}