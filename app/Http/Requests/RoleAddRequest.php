<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleAddRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:255', 'unique:roles'],
            'guard_name' => ['required'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', 'exists:permissions,name'],
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'unique' => trans('role.unique'),
            'permissions.*.exists' => trans('permissions.invalid'),
        ];
    }
}
