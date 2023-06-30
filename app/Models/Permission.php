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

            // Package
            'view package',
            'add package',
            'edit package',
            'delete package',

            // Coupon
            'view coupon',
            'add coupon',
            'edit coupon',
            'delete coupon',

            // Activation Code
            'view activation code',
            'add activation code',
            'edit activation code',
            'delete activation code',

            // Subscription
            'view subscription',
            'add subscription',
            'edit subscription',
            'delete subscription',
        ];
    }
}
