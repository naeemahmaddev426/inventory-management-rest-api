<?php

namespace App\Repositories;

use App\Interfaces\TaxRepositoryInterface;
use App\Models\Tax;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TaxRepository implements TaxRepositoryInterface
{
    /**
     * Get all taxes.
     */
    public function getAll(): Collection
    {
        return Tax::latest()->get();
    }

    /**
     * Get paginated taxes.
     */
    public function getPaginated(int $perPage = 10): LengthAwarePaginator
    {
        return Tax::latest()->paginate($perPage);
    }

    /**
     * Find tax by ID.
     */
    public function findById(int $id): ?Tax
    {
        return Tax::find($id);
    }

    /**
     * Create tax.
     */
    public function create(array $data): Tax
    {
        return Tax::create($data);
    }

    /**
     * Update tax.
     */
    public function update(int $id, array $data): Tax
    {
        $tax = Tax::findOrFail($id);

        $tax->update($data);

        return $tax->fresh();
    }

    /**
     * Delete tax.
     */
    public function delete(int $id): bool
    {
        $tax = Tax::findOrFail($id);

        return $tax->delete();
    }
}