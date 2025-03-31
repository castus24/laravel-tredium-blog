<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticlePhotoRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'image' => ['required', 'mimes:png,jpg,jpeg', 'max:2048'],
        ];
    }
}
