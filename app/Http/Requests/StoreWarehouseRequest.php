<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreWarehouseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => trim((string) $this->name),
            'code' => strtoupper(trim((string) $this->code)),
            'manager_name' => $this->manager_name
                ? trim($this->manager_name)
                : null,
            'email' => $this->email
                ? strtolower(trim($this->email))
                : null,
        ]);
    }

    /**
     * Validation Rules.
     */
    public function rules(): array
    {
        return [

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'code' => [
                'required',
                'string',
                'max:50',
                'unique:warehouses,code',
            ],

            'manager_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'address' => [
                'nullable',
                'string',
            ],

            'city' => [
                'nullable',
                'string',
                'max:100',
            ],

            'state' => [
                'nullable',
                'string',
                'max:100',
            ],

            'country' => [
                'nullable',
                'string',
                'max:100',
            ],

            'postal_code' => [
                'nullable',
                'string',
                'max:20',
            ],

            'status' => [
                'required',
                'boolean',
            ],
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [

            'name.required' => 'Warehouse name is required.',

            'code.required' => 'Warehouse code is required.',

            'code.unique' => 'Warehouse code already exists.',

            'email.email' => 'Please enter a valid email address.',

            'status.required' => 'Status is required.',
        ];
    }

    /**
     * Friendly attribute names.
     */
    public function attributes(): array
    {
        return [

            'manager_name' => 'manager name',

            'postal_code' => 'postal code',
        ];
    }   
}
