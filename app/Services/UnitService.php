<?php

namespace App\Services;

use App\Interfaces\UnitRepositoryInterface;

class UnitService
{
    public function __construct(
        protected UnitRepositoryInterface $unitRepository
    ) {
    }

    public function getAllUnits(array $filters = [])
    {
        return $this->unitRepository->getAll($filters);
    }

    public function getUnit(int $id)
    {
        return $this->unitRepository->findById($id);
    }

    public function createUnit(array $data)
    {
        return $this->unitRepository->create($data);
    }

    public function updateUnit(int $id, array $data)
    {
        return $this->unitRepository->update($id, $data);
    }

    public function deleteUnit(int $id)
    {
        return $this->unitRepository->delete($id);
    }

    public function restoreUnit(int $id)
    {
        return $this->unitRepository->restore($id);
    }

    public function forceDeleteUnit(int $id)
    {
        return $this->unitRepository->forceDelete($id);
    }
}