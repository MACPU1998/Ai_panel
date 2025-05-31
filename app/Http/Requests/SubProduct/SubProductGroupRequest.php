<?php

namespace App\Http\Requests\SubProduct;

use Illuminate\Foundation\Http\FormRequest;

class SubProductGroupRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        $rules = [
            'product_id' => 'nullable|integer|exists:products,id',
            'barcode' => 'required|string|max:255',
            'serial_prefix' => 'nullable|string',
            'serie_year' => 'required|string',
            'serie_month' => 'required|string',
            'label' => 'nullable|string',
            'production_date'=>'nullable|string',
            'expiration_date'=>'nullable|string',
            'status' => 'required|integer',
            'count' => 'nullable|integer|min:1|max:1000',
            'warehouse_id' => 'required|integer|exists:warehouses,id',
        ];

        return $rules;

    }
}
