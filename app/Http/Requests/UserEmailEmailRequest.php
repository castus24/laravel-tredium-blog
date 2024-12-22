<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     title="UserEmailEmailRequest",
 *     type="object",
 *     required={"email", "password"},
 *     @OA\Property(
 *         property="email",
 *         title="email",
 *         type="string",
 *         maxLength=255,
 *         example="email@example.com",
 *         description="Адрес электронной почты от учетной записи пользователя",
 *     ),
 *     @OA\Property(
 *         property="password",
 *         title="password",
 *         type="string",
 *         example="yourpassword",
 *         description="Пароль от учетной записи пользователя",
 *     ),
 * )
 */
class UserEmailEmailRequest extends FormRequest
{
    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'unique' => trans('user.unique'),
        ];
    }
}
