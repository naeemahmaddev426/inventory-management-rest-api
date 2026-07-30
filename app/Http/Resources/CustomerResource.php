<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'customer_code'     => $this->customer_code,
            'name'              => $this->name,
            'company_name'      => $this->company_name,
            'email'             => $this->email,
            'phone'             => $this->phone,
            'alternate_phone'   => $this->alternate_phone,
            'address'           => $this->address,
            'city'              => $this->city,
            'state'             => $this->state,
            'country'           => $this->country,
            'postal_code'       => $this->postal_code,
            'credit_limit'      => $this->credit_limit,
            'opening_balance'   => $this->opening_balance,
            'current_balance'   => $this->current_balance,
            'status'            => $this->status,
            'notes'             => $this->notes,

            'created_at'        => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at'        => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}