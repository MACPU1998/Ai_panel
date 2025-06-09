<?php

namespace App\Http\Requests\SubProduct;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSubProductRequest extends FormRequest
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
        $subProductId = $this->route('subProduct')?->id;

        $rules = [
            'product_id' => 'required|integer|exists:products,id',
            'barcode'=>
            [
                'required',
                'string',
                'min:10',
                'max:32',
                Rule::unique('sub_products')->ignore($subProductId),
            ],
            'serial_prefix' => 'nullable|string',
            'serie_year' => 'required|string',
            'serie_month' => 'required|string',
            'label' => 'nullable|string',
            'production_date'=>'nullable|string',
            'expiration_date'=>'nullable|string',
            'status' => 'required|integer',
            'warehouse_id' => 'required|integer|exists:warehouses,id',
        ];

        return $rules;

    }
}
