<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupplierRequest extends FormRequest
{
    /**
     * Determine if the user is authorized.
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

            'company_name' => [
                'required',
                'string',
                'max:255'
            ],

            'contact_person' => [
                'required',
                'string',
                'max:255'
            ],

            'email' => [
                'nullable',
                'email',
                'unique:suppliers,email'
            ],

            'phone' => [
                'nullable',
                'string',
                'max:30'
            ],

            'mobile' => [
                'nullable',
                'string',
                'max:30'
            ],

            'ntn' => [
                'nullable',
                'string',
                'max:100'
            ],

            'strn' => [
                'nullable',
                'string',
                'max:100'
            ],

            'address' => [
                'nullable',
                'string'
            ],

            'city' => [
                'nullable',
                'string',
                'max:100'
            ],

            'country' => [
                'nullable',
                'string',
                'max:100'
            ],

            'credit_limit' => [
                'nullable',
                'numeric',
                'min:0'
            ],

            'payment_days' => [
                'nullable',
                'integer',
                'min:0'
            ],

            'status' => [
                'nullable',
                'boolean'
            ],

        ];
    }

    /**
     * Custom Messages
     */
    public function messages(): array
    {
        return [

            'company_name.required' =>
                'Company Name is required.',

            'contact_person.required' =>
                'Contact Person is required.',

            'email.email' =>
                'Please enter a valid email.',

            'email.unique' =>
                'Supplier email already exists.',

        ];
    }
}