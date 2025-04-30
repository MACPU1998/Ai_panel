<?php

namespace App\Http\Requests\ProductCurrency;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductCurrencyRequest extends FormRequest
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
        $productCurrencyId = $this->route('productCurrency')?->id;

        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('product_currencies')->ignore($productCurrencyId)->whereNull('deleted_at')

            ],
            'slug' => 'required|string|min:3|max:255',
            'status' => 'required',
        ];
    }
}
