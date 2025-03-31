<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserNameUpdateRequest extends FormRequest
{
    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
        ];
    }
}
