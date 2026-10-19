<?php

namespace App\Http\Requests\Admin;

use App\Models\Admin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AdminUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $target = $this->route('admin');
        $adminId = $target instanceof Admin ? $target->id : Auth::guard('admin')->id();

        return [
            'first_name' => 'required|string|min:3|max:50',
            'last_name' => 'required|string|min:3|max:255',
            'email' => [
                'required', 'email',
                Rule::unique('admins', 'email')->ignore($adminId)->whereNull('deleted_at'),
            ],
            'phone' => 'required|min:11',
            'role' => ['sometimes', 'required', Rule::exists('roles', 'name')->where('guard_name', 'admin')],
        ];
    }
}
