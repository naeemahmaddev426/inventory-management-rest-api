<?php

namespace App\Interfaces;

interface BrandRepositoryInterface
{
    public function getAll(array $filters);

    public function findById(int $id);

    public function create(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);

    public function restore(int $id);

    public function forceDelete(int $id);
}