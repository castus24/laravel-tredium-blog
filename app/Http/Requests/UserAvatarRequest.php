<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserAvatarRequest extends FormRequest
{
    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            'avatar' => ['required', 'mimes:png,jpeg', 'max:2048'],
        ];
    }
}
