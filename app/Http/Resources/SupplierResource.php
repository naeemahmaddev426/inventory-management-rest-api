<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupplierResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'supplier_code' => $this->supplier_code,

            'company_name' => $this->company_name,

            'contact_person' => $this->contact_person,

            'email' => $this->email,

            'phone' => $this->phone,

            'mobile' => $this->mobile,

            'ntn' => $this->ntn,

            'strn' => $this->strn,

            'address' => $this->address,

            'city' => $this->city,

            'country' => $this->country,

            'credit_limit' => $this->credit_limit,

            'payment_days' => $this->payment_days,

            'status' => $this->status,

            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),

            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}