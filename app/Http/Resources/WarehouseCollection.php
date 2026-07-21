<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class WarehouseCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     */
    public function toArray(Request $request): array
    {
        return [

            'data' => WarehouseResource::collection($this->collection),

        ];
    }

    /**
     * Additional response data.
     */
    public function with(Request $request): array
    {
        return [

            'success' => true,

            'message' => 'Warehouse list retrieved successfully.',
        ];
    }
}