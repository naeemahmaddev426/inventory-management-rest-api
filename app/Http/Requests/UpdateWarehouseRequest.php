<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateWarehouseRequest extends FormRequest
{
    /**
     * Determine whether the user is authorized.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare data before validation.
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
        $warehouse = $this->route('warehouse');

        $warehouseId = is_object($warehouse)
            ? $warehouse->id
            : $warehouse;

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
                Rule::unique('warehouses', 'code')->ignore($warehouseId),
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

            'code.unique' => 'Warehouse code already exists.',

            'email.email' => 'Please enter a valid email address.',
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