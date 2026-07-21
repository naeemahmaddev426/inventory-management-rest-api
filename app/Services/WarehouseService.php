<?php

namespace App\Services;

use App\Interfaces\WarehouseRepositoryInterface;
use App\Models\Warehouse;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Throwable;

class WarehouseService
{
    /**
     * Repository instance.
     */
    protected WarehouseRepositoryInterface $warehouseRepository;

    /**
     * Create a new service instance.
     */
    public function __construct(WarehouseRepositoryInterface $warehouseRepository)
    {
        $this->warehouseRepository = $warehouseRepository;
    }

    /**
     * Get paginated warehouses.
     */
    public function getAll(array $filters = []): LengthAwarePaginator
    {
        return $this->warehouseRepository->getAll($filters);
    }

    /**
     * Get all active warehouses.
     */
    public function getActive(): Collection
    {
        return $this->warehouseRepository->getActive();
    }

    /**
     * Get warehouse by id.
     */
    public function find(int $id): ?Warehouse
    {
        return $this->warehouseRepository->findById($id);
    }

    /**
     * Create a warehouse.
     *
     * @throws Throwable
     */
    public function create(array $data): Warehouse
    {
        try {

            $warehouse = $this->warehouseRepository->create($data);

            /*
            |--------------------------------------------------------------------------
            | Future Features
            |--------------------------------------------------------------------------
            |
            | event(new WarehouseCreated($warehouse));
            | Notification::send(...);
            | Mail::to(...)->send(...);
            |
            */

            return $warehouse;

        } catch (Throwable $exception) {

            Log::error('Warehouse creation failed.', [
                'message' => $exception->getMessage(),
                'trace'   => $exception->getTraceAsString(),
            ]);

            throw $exception;
        }
    }

    /**
     * Update warehouse.
     *
     * @throws Throwable
     */
    public function update(Warehouse $warehouse, array $data): bool
    {
        try {

            $updated = $this->warehouseRepository->update($warehouse, $data);

            /*
            event(new WarehouseUpdated($warehouse));
            */

            return $updated;

        } catch (Throwable $exception) {

            Log::error('Warehouse update failed.', [
                'warehouse_id' => $warehouse->id,
                'message'      => $exception->getMessage(),
            ]);

            throw $exception;
        }
    }

    /**
     * Soft delete warehouse.
     *
     * @throws Throwable
     */
    public function delete(Warehouse $warehouse): bool
    {
        try {

            $deleted = $this->warehouseRepository->delete($warehouse);

            /*
            event(new WarehouseDeleted($warehouse));
            */

            return $deleted;

        } catch (Throwable $exception) {

            Log::error('Warehouse deletion failed.', [
                'warehouse_id' => $warehouse->id,
                'message'      => $exception->getMessage(),
            ]);

            throw $exception;
        }
    }

    /**
     * Restore warehouse.
     *
     * @throws Throwable
     */
    public function restore(int $id): bool
    {
        try {

            return $this->warehouseRepository->restore($id);

        } catch (Throwable $exception) {

            Log::error('Warehouse restore failed.', [
                'warehouse_id' => $id,
                'message'      => $exception->getMessage(),
            ]);

            throw $exception;
        }
    }

    /**
     * Permanently delete warehouse.
     *
     * @throws Throwable
     */
    public function forceDelete(int $id): bool
    {
        try {

            return $this->warehouseRepository->forceDelete($id);

        } catch (Throwable $exception) {

            Log::error('Warehouse force delete failed.', [
                'warehouse_id' => $id,
                'message'      => $exception->getMessage(),
            ]);

            throw $exception;
        }
    }
}