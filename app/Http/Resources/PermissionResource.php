<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="PermissionResource",
 *     type="object",
 *     @OA\Property(
 *         property="id",
 *         title="id",
 *         type="int",
 *         example="1",
 *         description="ID разрешения",
 *     ),
 *     @OA\Property(
 *         property="name",
 *         title="name",
 *         type="string",
 *         example="user.list",
 *         description="Название разрешения",
 *     ),
 *     @OA\Property(
 *         property="guard_name",
 *         title="guard_name",
 *         type="string",
 *         example="api",
 *         description="Имя гарды аутентификации",
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         title="created_at",
 *         type="string",
 *         example="1970-01-01T00:00:00.000000Z",
 *         description="Дата и время создания разрешения",
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         title="updated_at",
 *         type="string",
 *         example="1970-01-01T00:00:00.000000Z",
 *         description="Дата и время обновления разрешения",
 *     ),
 * )
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property string $created_at
 * @property string $updated_at
 */
class PermissionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'guard_name' => $this->guard_name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
