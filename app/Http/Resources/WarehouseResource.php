<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WarehouseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'name' => $this->name,

            'code' => $this->code,

            'manager_name' => $this->manager_name,

            'phone' => $this->phone,

            'email' => $this->email,

            'address' => $this->address,

            'city' => $this->city,

            'state' => $this->state,

            'country' => $this->country,

            'postal_code' => $this->postal_code,

            'status' => $this->status,

            'status_label' => $this->status
                ? 'Active'
                : 'Inactive',

            'created_at' => optional($this->created_at)
                ->format('Y-m-d H:i:s'),

            'updated_at' => optional($this->updated_at)
                ->format('Y-m-d H:i:s'),

            'deleted_at' => optional($this->deleted_at)
                ->format('Y-m-d H:i:s'),
        ];
    }
}