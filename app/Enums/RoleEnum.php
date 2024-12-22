<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @uses self::ADMIN Admin
 * @uses self::USER User
 */
final class RoleEnum extends Enum
{
    const ADMIN = 'admin';
    const USER = 'user';
}
