<?php

namespace App\Repositories;

use App\Interfaces\BrandRepositoryInterface;
use App\Models\Brand;

class BrandRepository implements BrandRepositoryInterface
{
    public function getAll(array $filters = [])
    {
        return Brand::query()
            ->when(isset($filters['search']), function ($query) use ($filters) {
                $query->where('name', 'like', '%' . $filters['search'] . '%');
            })
            ->when(isset($filters['status']), function ($query) use ($filters) {
                $query->where('status', $filters['status']);
            })
            ->latest()
            ->paginate($filters['per_page'] ?? 10);
    }

    public function findById(int $id)
    {
        return Brand::findOrFail($id);
    }

    public function create(array $data)
    {
        return Brand::create($data);
    }

    public function update(int $id, array $data)
    {
        $brand = $this->findById($id);

        $brand->update($data);

        return $brand->fresh();
    }

    public function delete(int $id)
    {
        return $this->findById($id)->delete();
    }

    public function restore(int $id)
    {
        $brand = Brand::onlyTrashed()->findOrFail($id);

        $brand->restore();

        return $brand;
    }

    public function forceDelete(int $id)
    {
        return Brand::onlyTrashed()->findOrFail($id)->forceDelete();
    }
}