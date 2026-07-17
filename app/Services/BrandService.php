<?php

namespace app\Services;

use app\Interfaces\BrandRepositoryInterface;
use Illuminate\Support\Str;

class BrandService
{
    public function __construct(
        protected BrandRepositoryInterface $brandRepository
    ) {
    }

    public function getAllBrands(array $filters = [])
    {
        return $this->brandRepository->getAll($filters);
    }

    public function getBrand(int $id)
    {
        return $this->brandRepository->findById($id);
    }

    public function createBrand(array $data)
    {
        $data['slug'] = Str::slug($data['name']);

        return $this->brandRepository->create($data);
    }

    public function updateBrand(int $id, array $data)
    {
        $brand = $this->getBrand($id);

        if (
            isset($data['name']) &&
            $brand->name !== $data['name']
        ) {
            $data['slug'] = Str::slug($data['name']);
        }

        return $this->brandRepository->update($id, $data);
    }

    public function deleteBrand(int $id)
    {
        return $this->brandRepository->delete($id);
    }

    public function restoreBrand(int $id)
    {
        return $this->brandRepository->restore($id);
    }

    public function forceDeleteBrand(int $id)
    {
        return $this->brandRepository->forceDelete($id);
    }
}