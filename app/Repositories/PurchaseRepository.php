<?php

namespace App\Repositories;

use App\Models\Purchase;
use App\Repositories\Contracts\PurchaseRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class PurchaseRepository implements PurchaseRepositoryInterface
{
    public function getAll(): Collection
    {
        return Purchase::with([
            'supplier',
            'warehouse',
            'purchaseDetails.product',
        ])
            ->latest()
            ->get();
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Purchase::with([
            'supplier',
            'warehouse',
            'purchaseDetails.product',
        ])
            ->latest()
            ->paginate($perPage);
    }

    public function findById(int $id): ?Purchase
    {
        return Purchase::with([
            'supplier',
            'warehouse',
            'purchaseDetails.product',
        ])->find($id);
    }

    public function create(array $data): Purchase
    {
        return Purchase::create($data);
    }

    public function update(Purchase $purchase, array $data): Purchase
    {
        $purchase->update($data);

        return $purchase->fresh([
            'supplier',
            'warehouse',
            'purchaseDetails.product',
        ]);
    }

    public function delete(Purchase $purchase): bool
    {
        return (bool) $purchase->delete();
    }
}