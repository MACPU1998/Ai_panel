<?php

namespace App\Http\Requests\SubProduct;

use Illuminate\Foundation\Http\FormRequest;

class SubProductRequest extends FormRequest
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
            'product_id' => 'required|integer|exists:products,id',
            'barcode' => 'required|string|max:255',
            'serie_year' => 'required|string',
            'serie_month' => 'required|string',
            'label' => 'nullable|string',
            'status' => 'required|integer',
        ];

        return $rules;

    }
}
