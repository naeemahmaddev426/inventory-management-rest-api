<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'category_id' => 'sometimes|exists:categories,id',

            'name' => 'sometimes|string|max:255',

            'description' => 'nullable|string',

            'purchase_price' => 'sometimes|numeric|min:0',

            'selling_price' => 'sometimes|numeric|min:0',

            'discount_price' => 'nullable|numeric|min:0',

            'quantity' => 'sometimes|integer|min:0',

            'minimum_quantity' => 'nullable|integer|min:0',

            'maximum_quantity' => 'nullable|integer|min:0',

            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'status' => 'sometimes|boolean',

        ];
    }
}