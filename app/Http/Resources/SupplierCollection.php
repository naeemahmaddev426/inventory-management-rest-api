<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SupplierCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => SupplierResource::collection($this->collection),
        ];
    }

    /**
     * Add additional meta data.
     */
    public function with(Request $request): array
    {
        return [
            'success' => true,
            'message' => 'Suppliers fetched successfully.',
        ];
    }
}