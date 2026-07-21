<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWarehouseRequest;
use App\Http\Requests\UpdateWarehouseRequest;
use App\Http\Resources\WarehouseResource;
use App\Models\Warehouse;
use App\Services\WarehouseService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Throwable;

class WarehouseController extends Controller
{
    use ApiResponseTrait;

    protected WarehouseService $warehouseService;

    public function __construct(WarehouseService $warehouseService)
    {
        $this->warehouseService = $warehouseService;
    }

    /**
     * Display a listing of warehouses.
     */
    public function index(Request $request): JsonResponse
    {
        try {

            $filters = [

                'search'          => $request->search,

                'status'          => $request->status,

                'city'            => $request->city,

                'country'         => $request->country,

                'sort_by'         => $request->sort_by ?? 'id',

                'sort_direction'  => $request->sort_direction ?? 'desc',

                'per_page'        => $request->per_page ?? 10,

            ];

            $warehouses = $this->warehouseService->getAll($filters);

            return $this->success(

                WarehouseResource::collection($warehouses),

                'Warehouses retrieved successfully.'

            );

        } catch (Throwable $e) {

            report($e);

            return $this->error(
                'Failed to retrieve warehouses.'
            );

        }
    }

    /**
     * Store warehouse.
     */
    public function store(StoreWarehouseRequest $request): JsonResponse
    {
        try {

            $warehouse = $this->warehouseService->create(
                $request->validated()
            );

            return $this->success(
                new WarehouseResource($warehouse),
                'Warehouse created successfully.',
                201
            );

        } catch (Throwable $e) {

            report($e);

            return $this->error(
                'Warehouse creation failed.'
            );
        }
    }

    /**
     * Display warehouse.
     */
    public function show(Warehouse $warehouse): JsonResponse
    {
        try {

            return $this->success(
                new WarehouseResource($warehouse),
                'Warehouse retrieved successfully.'
            );

        } catch (Throwable $e) {

            report($e);

            return $this->error(
                'Unable to retrieve warehouse.'
            );
        }
    }

    /**
     * Update warehouse.
     */
    public function update(
        UpdateWarehouseRequest $request,
        Warehouse $warehouse
    ): JsonResponse {

        try {

            $this->warehouseService->update(

                $warehouse,

                $request->validated()

            );

            $warehouse->refresh();

            return $this->success(

                 new WarehouseResource($warehouse),
                'Warehouse updated successfully.'

            );

        } catch (Throwable $e) {

            report($e);

            return $this->error(
                'Warehouse update failed.'
            );

        }
    }

    /**
     * Soft delete warehouse.
     */
    public function destroy(Warehouse $warehouse): JsonResponse
    {
        try {

            $this->warehouseService->delete($warehouse);

            return $this->success(
                null,
                'Warehouse deleted successfully.'
            );

        } catch (Throwable $e) {

            report($e);

            return $this->error(
                'Warehouse deletion failed.'
            );
        }
    }
    /**
     * Restore warehouse.
     */
    public function restore(int $id): JsonResponse
    {
        try {

            $this->warehouseService->restore($id);

            $warehouse = $this->warehouseService->find($id);

            return $this->success(

                new WarehouseResource($warehouse),

                'Warehouse restored successfully.'

            );

        } catch (Throwable $e) {

            report($e);

            return $this->error(
                'Warehouse restore failed.'
            );

        }
    }

    /**
     * Permanently delete warehouse.
     */
   public function forceDelete(int $id): JsonResponse
    {
        try {

            $this->warehouseService->forceDelete($id);

            return $this->success(
                null,
                'Warehouse permanently deleted.'
            );

        } catch (Throwable $e) {

            report($e);

            return $this->error(
                'Warehouse permanent deletion failed.'
            );
        }
    }
}