<?php

namespace App\Interfaces;

use App\Models\Tax;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface TaxRepositoryInterface
{
    /**
     * Get all taxes.
     */
    public function getAll(): Collection;

    /**
     * Get paginated taxes.
     */
    public function getPaginated(int $perPage = 10): LengthAwarePaginator;

    /**
     * Find tax by ID.
     */
    public function findById(int $id): ?Tax;

    /**
     * Create a new tax.
     */
    public function create(array $data): Tax;

    /**
     * Update tax.
     */
    public function update(int $id, array $data): Tax;

    /**
     * Delete tax.
     */
    public function delete(int $id): bool;
}