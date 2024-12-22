<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     title="UserPasswordUpdateRequest",
 *     type="object",
 *     required={"password_current", "password"},
 *     @OA\Property(
 *         property="password_current",
 *         title="password_current",
 *         type="string",
 *         example="yourpassword",
 *         description="Текущий пароль для учетной записи пользователя",
 *     ),
 *     @OA\Property(
 *         property="password",
 *         title="password",
 *         type="string",
 *         example="yourpassword",
 *         description="Новый пароль для учетной записи пользователя",
 *     ),
 *     @OA\Property(
 *         property="password_confirmation",
 *         title="password_confirmation",
 *         type="string",
 *         example="yourpassword",
 *         description="Новый пароль для учетной записи пользователя",
 *     ),
 * )
 */
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
