<?php

namespace App\Http\Controllers\Api\V1;

use Throwable;
use App\Models\Supplier;
use Illuminate\Http\JsonResponse;
use App\Services\SupplierService;
use App\Http\Controllers\Controller;
use App\Http\Resources\SupplierResource;
use App\Http\Resources\SupplierCollection;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;

class SupplierController extends Controller
{
    protected SupplierService $supplierService;

    public function __construct(SupplierService $supplierService)
    {
        $this->supplierService = $supplierService;
    }

    /**
     * Display a listing of suppliers.
     */
    public function index(): SupplierCollection
    {
        $suppliers = $this->supplierService->paginate(10);

        return new SupplierCollection($suppliers);
    }

    /**
     * Store a newly created supplier.
     */
    public function store(StoreSupplierRequest $request): JsonResponse
    {
        try {

            $supplier = $this->supplierService->create(
                $request->validated()
            );

            return response()->json([
                'success' => true,
                'message' => 'Supplier created successfully.',
                'data' => new SupplierResource($supplier)
            ], 201);

        } catch (Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);

        }
    }

    /**
     * Display the specified supplier.
     */
    public function show(Supplier $supplier): SupplierResource
    {
        return new SupplierResource($supplier);
    }

    /**
     * Update the specified supplier.
     */
    public function update(
        UpdateSupplierRequest $request,
        Supplier $supplier
    ): JsonResponse {

        try {

            $supplier = $this->supplierService->update(
                $supplier,
                $request->validated()
            );

            return response()->json([
                'success' => true,
                'message' => 'Supplier updated successfully.',
                'data' => new SupplierResource($supplier)
            ]);

        } catch (Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);

        }
    }

    /**
     * Remove the specified supplier.
     */
    public function destroy(Supplier $supplier): JsonResponse
    {
        try {

            $this->supplierService->delete($supplier);

            return response()->json([
                'success' => true,
                'message' => 'Supplier deleted successfully.'
            ]);

        } catch (Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);

        }
    }
}