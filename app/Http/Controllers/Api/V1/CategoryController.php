<?php

namespace app\Http\Controllers\Api\V1;

use app\Traits\ApiResponseTrait;
use app\Services\CategoryService;
use app\Http\Controllers\Controller;
use app\Http\Requests\StoreCategoryRequest;
use app\Http\Requests\UpdateCategoryRequest;
use app\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    use ApiResponseTrait;

    protected CategoryService $service;

    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->success(
            CategoryResource::collection($this->service->all()),
            'Category List'
        );
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = $this->service->store($request->validated());

        return $this->success(
            new CategoryResource($category),
            'Category Created Successfully',
            201
        );
    }

    public function show($id)
    {
        return $this->success(
            new CategoryResource($this->service->find($id))
        );
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        $category = $this->service->update($id, $request->validated());

        return $this->success(
            new CategoryResource($category),
            'Category Updated Successfully'
        );
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return $this->success(
            null,
            'Category Deleted Successfully'
        );
    }
}