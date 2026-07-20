<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Interfaces\CategoryRepositoryInterface;

class CategoryService
{
    protected $repository;

    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function all()
    {
        return $this->repository->all();
    }

    public function store(array $data)
    {
        $data['slug'] = Str::slug($data['name']);

        return $this->repository->create($data);
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function update($id, array $data)
    {
        $data['slug'] = Str::slug($data['name']);

        return $this->repository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }
}