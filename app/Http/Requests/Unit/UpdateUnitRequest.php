<?php

namespace App\Http\Requests\Unit;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUnitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules.
     */
    public function rules(): array
    {
        $unitId = $this->route('unit');

        return [
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('units', 'name')->ignore($unitId),
            ],

            'short_name' => [
                'required',
                'string',
                'max:20',
                Rule::unique('units', 'short_name')->ignore($unitId),
            ],

            'description' => [
                'nullable',
                'string',
                'max:1000',
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
            'name.required' => 'Unit name is required.',
            'name.unique' => 'Unit name already exists.',

            'short_name.required' => 'Short name is required.',
            'short_name.unique' => 'Short name already exists.',

            'status.required' => 'Status field is required.',
        ];
    }
}