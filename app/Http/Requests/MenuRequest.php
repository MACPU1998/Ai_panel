<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MenuRequest extends FormRequest
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
        $menuId = $this->route('menu')?->id;

        return [
            'title' => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('menus')->ignore($menuId)->whereNull('deleted_at'),

            ],
            'icon' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:menus,id',
            'link' => 'nullable|string|max:255',
            'status' => 'required',
        ];
    }
    protected function prepareForValidation(){
        $this->merge([
            'title' => $this->title,
            'icon' => $this->icon ?: '#',
            'parent_id' => $this->parent_id ?: null,
            'link' => $this->link ?: '#',
            'status' => (int)$this->status,
        ]);
    }
}
