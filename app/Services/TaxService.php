<?php

namespace App\Services;

use App\Interfaces\TaxRepositoryInterface;
use App\Models\Tax;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class TaxService
{
    protected TaxRepositoryInterface $taxRepository;

    /**
     * Constructor
     */
    public function __construct(TaxRepositoryInterface $taxRepository)
    {
        $this->taxRepository = $taxRepository;
    }

    /**
     * Get All Taxes
     */
    public function getAll(): Collection
    {
        return $this->taxRepository->getAll();
    }

    /**
     * Get Paginated Taxes
     */
    public function getPaginated(int $perPage = 10): LengthAwarePaginator
    {
        return $this->taxRepository->getPaginated($perPage);
    }

    /**
     * Find Tax
     */
    public function findById(int $id): ?Tax
    {
        return $this->taxRepository->findById($id);
    }

    /**
     * Store Tax
     */
    public function create(array $data): Tax
    {
        return $this->taxRepository->create($data);
    }

    /**
     * Update Tax
     */
    public function update(int $id, array $data): Tax
    {
        return $this->taxRepository->update($id, $data);
    }

    /**
     * Delete Tax
     */
    public function delete(int $id): bool
    {
        return $this->taxRepository->delete($id);
    }
}