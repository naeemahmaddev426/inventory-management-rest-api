<?php

namespace App\Repositories;

use App\Interfaces\UnitRepositoryInterface;
use App\Models\Unit;

class UnitRepository implements UnitRepositoryInterface
{
    public function getAll(array $filters = [])
    {
        return Unit::query()
            ->when(isset($filters['search']), function ($query) use ($filters) {
                $query->where(function ($q) use ($filters) {
                    $q->where('name', 'like', '%' . $filters['search'] . '%')
                      ->orWhere('short_name', 'like', '%' . $filters['search'] . '%');
                });
            })
            ->when(isset($filters['status']), function ($query) use ($filters) {
                $query->where('status', $filters['status']);
            })
            ->latest()
            ->paginate($filters['per_page'] ?? 10);
    }

    public function findById(int $id)
    {
        return Unit::findOrFail($id);
    }

    public function create(array $data)
    {
        return Unit::create($data);
    }

    public function update(int $id, array $data)
    {
        $unit = $this->findById($id);

        $unit->update($data);

        return $unit->fresh();
    }

    public function delete(int $id)
    {
        return $this->findById($id)->delete();
    }

    public function restore(int $id)
    {
        $unit = Unit::onlyTrashed()->findOrFail($id);

        $unit->restore();

        return $unit;
    }

    public function forceDelete(int $id)
    {
        return Unit::onlyTrashed()->findOrFail($id)->forceDelete();
    }
}