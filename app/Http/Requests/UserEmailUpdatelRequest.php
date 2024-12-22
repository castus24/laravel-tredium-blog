<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     title="UserEmailUpdatelRequest",
 *     type="object",
 *     required={"code"},
 *     @OA\Property(
 *         property="code",
 *         title="code",
 *         type="string",
 *         example="123456",
 *         description="Код подтверждения для изменения адреса электронной почты пользователя",
 *     ),
 * )
 */
class UserEmailUpdatelRequest extends FormRequest
{
    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            'code' => ['required', 'string'],
        ];
    }
}
