<?php

namespace App\Http\Resources;

use App\Models\UserContact;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @method getFirstMediaUrl(string $avatars)
 * @property RoleResource $roles
 * @property UserContact $contacts
 */
class UserShowResource extends JsonResource
{
    private string $type = 'user';
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'main_image' => $this->getFirstMediaUrl('avatars'),
            'roles' => RoleResource::collection($this->roles),
            'contacts' => $this->whenLoaded('contacts', function () {
                return UserContactResource::collection($this->contacts);
            }),
            'type' => $this->type
        ];
    }
}
