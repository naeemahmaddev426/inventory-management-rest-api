<?php

namespace App\Repositories\Interfaces;

interface CustomerRepositoryInterface
{
    public function paginate(int $perPage = 10);

    public function getAll();
}