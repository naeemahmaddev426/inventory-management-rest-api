<?php

namespace App\Http\Requests\Tax;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaxRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation Rules
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:100',
                'unique:taxes,name',
            ],

            'rate' => [
                'required',
                'numeric',
                'min:0',
            ],

            'type' => [
                'required',
                'in:percentage,fixed',
            ],

            'status' => [
                'required',
                'boolean',
            ],

            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ];
    }

    /**
     * Custom Messages
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Tax name is required.',
            'name.unique' => 'Tax name already exists.',

            'rate.required' => 'Tax rate is required.',
            'rate.numeric' => 'Tax rate must be numeric.',

            'type.required' => 'Tax type is required.',
            'type.in' => 'Tax type must be percentage or fixed.',

            'status.required' => 'Status field is required.',
        ];
    }
}