<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Purchase\StorePurchaseRequest;
use App\Http\Requests\Purchase\UpdatePurchaseRequest;
use App\Http\Resources\PurchaseResource;
use App\Models\Purchase;
use App\Services\PurchaseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PurchaseController extends Controller
{
    public function __construct(
        protected PurchaseService $purchaseService
    ) {
    }

    /**
     * Display a paginated list of purchases.
     */
    public function index(): AnonymousResourceCollection
    {
        $perPage = request()->integer('per_page', 15);

        $purchases = $this->purchaseService->paginate($perPage);

        return PurchaseResource::collection($purchases);
    }

    /**
     * Store a newly created purchase.
     */
    public function store(StorePurchaseRequest $request): JsonResponse
    {
        $purchase = $this->purchaseService->create(
            $request->validated()
        );

        $purchase->load([
            'supplier',
            'warehouse',
        ]);

        return (new PurchaseResource($purchase))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified purchase.
     */
    public function show(Purchase $purchase): PurchaseResource
    {
        $purchase = $this->purchaseService->findById(
            $purchase->id
        );

        if (!$purchase) {
            abort(404, 'Purchase not found.');
        }

        return new PurchaseResource($purchase);
    }

    /**
     * Update the specified purchase.
     */
    public function update(
        UpdatePurchaseRequest $request,
        Purchase $purchase
    ): PurchaseResource {
        $purchase = $this->purchaseService->update(
            $purchase,
            $request->validated()
        );

        return new PurchaseResource($purchase);
    }

    /**
     * Remove the specified purchase.
     */
    public function destroy(Purchase $purchase): JsonResponse
    {
        $this->purchaseService->delete($purchase);

        return response()->json([
            'message' => 'Purchase deleted successfully.',
        ]);
    }
}