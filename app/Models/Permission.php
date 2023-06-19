<?php

namespace App\Models;

class Permission extends \Spatie\Permission\Models\Permission
{

    public static function defaultPermissions()
    {
        return [
            'view user',
            'add user',
            'edit user',
            'delete user',

            'view role',
            'add role',
            'edit role',
            'delete role',
        ];
    }
}
