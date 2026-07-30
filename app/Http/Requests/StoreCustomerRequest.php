<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules.
     */
    public function rules(): array
    {
        return [
            'name'              => ['required', 'string', 'max:255'],
            'company_name'      => ['nullable', 'string', 'max:255'],
            'email'             => ['nullable', 'email', 'unique:customers,email'],
            'phone'             => ['required', 'string', 'max:20', 'unique:customers,phone'],
            'alternate_phone'   => ['nullable', 'string', 'max:20'],
            'address'           => ['nullable', 'string'],
            'city'              => ['nullable', 'string', 'max:100'],
            'state'             => ['nullable', 'string', 'max:100'],
            'country'           => ['nullable', 'string', 'max:100'],
            'postal_code'       => ['nullable', 'string', 'max:20'],
            'credit_limit'      => ['nullable', 'numeric', 'min:0'],
            'opening_balance'   => ['nullable', 'numeric'],
            'current_balance'   => ['nullable', 'numeric'],
            'status'            => ['nullable', 'boolean'],
            'notes'             => ['nullable', 'string'],
        ];
    }
}