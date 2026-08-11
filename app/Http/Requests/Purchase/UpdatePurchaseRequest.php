<?php

namespace App\Http\Requests\Purchase;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePurchaseRequest extends FormRequest
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
        $purchaseId = $this->route('purchase');

        return [
            'supplier_id' => [
                'sometimes',
                'integer',
                'exists:suppliers,id',
            ],

            'warehouse_id' => [
                'sometimes',
                'integer',
                'exists:warehouses,id',
            ],

            'purchase_number' => [
                'sometimes',
                'string',
                'max:100',
                Rule::unique('purchases', 'purchase_number')
                    ->ignore($purchaseId),
            ],

            'invoice_number' => [
                'nullable',
                'string',
                'max:100',
            ],

            'purchase_date' => [
                'sometimes',
                'date',
            ],

            'subtotal' => [
                'sometimes',
                'numeric',
                'min:0',
            ],

            'tax_amount' => [
                'sometimes',
                'numeric',
                'min:0',
            ],

            'discount_amount' => [
                'sometimes',
                'numeric',
                'min:0',
            ],

            'shipping_amount' => [
                'sometimes',
                'numeric',
                'min:0',
            ],

            'grand_total' => [
                'sometimes',
                'numeric',
                'min:0',
            ],

            'payment_status' => [
                'sometimes',
                'in:unpaid,partial,paid',
            ],

            'status' => [
                'sometimes',
                'in:pending,received,cancelled',
            ],

            'notes' => [
                'nullable',
                'string',
            ],
        ];
    }
}