<?php

namespace App\Models;


class Role extends \Spatie\Permission\Models\Role
{
    public static function defaultRoles()
    {
        return [
            'administrator',
            'manager',
            'client'
        ];
    }

    public static function fixedRoles()
    {
        return [
            'administrator',
        ];
    }

    public function isFixed()
    {
        return in_array($this->name, self::fixedRoles());
    }
}
