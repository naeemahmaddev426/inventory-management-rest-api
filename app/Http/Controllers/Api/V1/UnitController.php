<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Unit\StoreUnitRequest;
use App\Http\Requests\Unit\UpdateUnitRequest;
use App\Http\Resources\UnitResource;
use App\Services\UnitService;
use App\Traits\ApiResponseTrait;

class UnitController extends Controller
{
    use ApiResponseTrait;

    protected UnitService $service;

    public function __construct(UnitService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->success(
            UnitResource::collection(
                $this->service->getAllUnits(request()->all())
            ),
            'Unit List'
        );
    }

    public function store(StoreUnitRequest $request)
    {
        $unit = $this->service->createUnit(
            $request->validated()
        );

        return $this->success(
            new UnitResource($unit),
            'Unit Created Successfully',
            201
        );
    }

    public function show($id)
    {
        return $this->success(
            new UnitResource(
                $this->service->getUnit($id)
            )
        );
    }

    public function update(UpdateUnitRequest $request, $id)
    {
        $unit = $this->service->updateUnit(
            $id,
            $request->validated()
        );

        return $this->success(
            new UnitResource($unit),
            'Unit Updated Successfully'
        );
    }

    public function destroy($id)
    {
        $this->service->deleteUnit($id);

        return $this->success(
            null,
            'Unit Deleted Successfully'
        );
    }
}