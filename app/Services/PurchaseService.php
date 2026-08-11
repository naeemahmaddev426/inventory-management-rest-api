<?php

namespace App\Services;

use App\Models\Purchase;
use App\Repositories\Contracts\PurchaseRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class PurchaseService
{
    public function __construct(
        protected PurchaseRepositoryInterface $purchaseRepository
    ) {
    }

    public function getAll(): Collection
    {
        return $this->purchaseRepository->getAll();
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->purchaseRepository->paginate($perPage);
    }

    public function findById(int $id): ?Purchase
    {
        return $this->purchaseRepository->findById($id);
    }

    public function create(array $data): Purchase
    {
        return $this->purchaseRepository->create($data);
    }

    public function update(Purchase $purchase, array $data): Purchase
    {
        return $this->purchaseRepository->update(
            $purchase,
            $data
        );
    }

    public function delete(Purchase $purchase): bool
    {
        return $this->purchaseRepository->delete($purchase);
    }
}