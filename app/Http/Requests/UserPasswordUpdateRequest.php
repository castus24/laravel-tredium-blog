<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserPasswordUpdateRequest extends FormRequest
{
    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            'password_current' => ['required', 'string'],
            'password' => ['required', 'string', 'confirmed'],
        ];
    }
}
