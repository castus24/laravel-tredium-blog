<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     title="UserNameRequest",
 *     type="object",
 *     required={"name"},
 *     @OA\Property(
 *         property="name",
 *         title="name",
 *         type="string",
 *         maxLength=255,
 *         example="User Name",
 *         description="Имя пользователя",
 *     ),
 * )
 */
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
