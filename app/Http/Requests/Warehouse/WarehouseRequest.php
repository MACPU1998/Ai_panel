<?php

namespace App\Http\Requests\Warehouse;

use Illuminate\Foundation\Http\FormRequest;

class WarehouseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:255',
            'address' => 'nullable|string|max:1000',
            'description' => 'nullable|string|max:5000',
            'status' => 'required|in:0,1',
            'make_default' => [
                'required',
                'in:0,1',
                function ($attribute, $value, $fail) {
                    if (
                        (string) $value === '1' &&
                        (string) $this->input('status') !== '1'
                    ) {
                        $fail('انبار غیرفعال نمی‌تواند انبار پیش‌فرض باشد.');
                    }
                },
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'نام انبار',
            'address' => 'آدرس',
            'description' => 'توضیحات',
            'status' => 'وضعیت',
            'make_default' => 'انبار پیش‌فرض',
        ];
    }
}
