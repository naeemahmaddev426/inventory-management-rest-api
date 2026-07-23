<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tax\StoreTaxRequest;
use App\Http\Requests\Tax\UpdateTaxRequest;
use App\Http\Resources\TaxResource;
use App\Services\TaxService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    /**
     * Constructor
     */
    public function __construct(protected TaxService $taxService)
    {}
    /**
     * Display a listing of taxes.
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page', 10);

        $taxes = $this->taxService->getPaginated($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Taxes retrieved successfully.',
            'data' => TaxResource::collection($taxes),
        ]);
    }

    /**
     * Store a newly created tax.
     */
    public function store(StoreTaxRequest $request): JsonResponse
    {
        $tax = $this->taxService->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Tax created successfully.',
            'data' => new TaxResource($tax),
        ], 201);
    }

    /**
     * Display the specified tax.
     */
    public function show(int $id): JsonResponse
    {
        $tax = $this->taxService->findById($id);

        if (!$tax) {
            return response()->json([
                'success' => false,
                'message' => 'Tax not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new TaxResource($tax),
        ]);
    }

    /**
     * Update the specified tax.
     */
    public function update(UpdateTaxRequest $request, int $id): JsonResponse
    {
        $tax = $this->taxService->update($id, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Tax updated successfully.',
            'data' => new TaxResource($tax),
        ]);
    }

    /**
     * Remove the specified tax.
     */
    public function destroy(int $id): JsonResponse
    {
        $this->taxService->delete($id);

        return response()->json([
            'success' => true,
            'message' => 'Tax deleted successfully.',
        ]);
    }
}