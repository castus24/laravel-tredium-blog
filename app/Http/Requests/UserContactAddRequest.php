<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserContactAddRequest extends FormRequest
{
    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            'type' => [
                'required',
                'string',
                'in:phone,telegram_id',
                'unique:user_contacts,type,NULL,id,user_id,' . auth()->id(),
            ],
            'value' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'type.in' => "The type must be one of the following: phone, or telegram_id.",
            'type.unique' => "The selected type is already in use for this user.",
        ];
    }
}
