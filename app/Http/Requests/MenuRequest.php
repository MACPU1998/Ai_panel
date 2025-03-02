<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'title' => 'required|string|min:3|max:255',
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
