<?php

namespace app\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            'category'         => [
                'id'   => $this->category?->id,
                'name' => $this->category?->name,
            ],
            'name'             => $this->name,
            'slug'             => $this->slug,
            'sku'              => $this->sku,
            'barcode'          => $this->barcode,
            'qr_code'          => $this->qr_code,
            'description'      => $this->description,
            'purchase_price'   => $this->purchase_price,
            'selling_price'    => $this->selling_price,
            'discount_price'   => $this->discount_price,
            'quantity'         => $this->quantity,
            'minimum_quantity' => $this->minimum_quantity,
            'maximum_quantity' => $this->maximum_quantity,
            'image' => $this->image 
                ? asset('storage/'.$this->image) 
                : null,
            'thumbnail' => $this->thumbnail 
                ? asset('storage/'.$this->thumbnail)
                : null,
            'status'           => $this->status,
            'created_at'       => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at'       => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }

}