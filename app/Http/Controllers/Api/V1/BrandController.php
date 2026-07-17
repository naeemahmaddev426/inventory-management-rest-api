<?php

namespace app\Http\Controllers\Api\V1;

use app\Http\Controllers\Controller;
use app\Http\Requests\Brand\StoreBrandRequest;
use app\Http\Requests\Brand\UpdateBrandRequest;
use app\Http\Resources\BrandResource;
use app\Services\BrandService;
use app\Traits\ApiResponseTrait;

class BrandController extends Controller
{
    use ApiResponseTrait;

    protected BrandService $service;

    public function __construct(BrandService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of brands.
     */
    public function index()
    {
        return $this->success(
            BrandResource::collection(
                $this->service->getAllBrands(request()->all())
            ),
            'Brand List'
        );
    }

    /**
     * Store a newly created brand.
     */
    public function store(StoreBrandRequest $request)
    {
        $brand = $this->service->createBrand(
            $request->validated()
        );

        return $this->success(
            new BrandResource($brand),
            'Brand Created Successfully',
            201
        );
    }

    /**
     * Display the specified brand.
     */
    public function show($id)
    {
        return $this->success(
            new BrandResource(
                $this->service->getBrand($id)
            )
        );
    }

    /**
     * Update the specified brand.
     */
    public function update(UpdateBrandRequest $request, $id)
    {
        $brand = $this->service->updateBrand(
            $id,
            $request->validated()
        );

        return $this->success(
            new BrandResource($brand),
            'Brand Updated Successfully'
        );
    }

    /**
     * Remove the specified brand.
     */
    public function destroy($id)
    {
        $this->service->deleteBrand($id);

        return $this->success(
            null,
            'Brand Deleted Successfully'
        );
    }
}