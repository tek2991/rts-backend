<?php

namespace App\Policies;

use App\Models\Coupon;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CouponPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        // Only administrator role and user with permission "view coupon" can view all coupons
        return $user->hasRole('administrator') || $user->can('view coupon') ?
            Response::allow()
            : Response::deny('You can\'t view any coupon.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Coupon $coupon): Response
    {
        // Only administrator role and user with permission "view coupon" can view the coupon
        return $user->hasRole('administrator') || $user->can('view coupon')?
            Response::allow()
            : Response::deny('You can\'t view this coupon.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        // Only administrator role and user with permission "add coupon" can create a coupon
        return $user->hasRole('administrator') || $user->can('add coupon') ?
            Response::allow()
            : Response::deny('You can\'t create a coupon.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Coupon $coupon): Response
    {
        // Only administrator role and user with permission "edit coupon" can update a coupon
        return $user->hasRole('administrator') || $user->can('edit coupon') ?
            Response::allow()
            : Response::deny('You can\'t update this coupon.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Coupon $coupon): Response
    {
        // Only administrator role and user with permission "delete coupon" can delete a coupon
        return $user->hasRole('administrator') || $user->can('delete coupon') ?
            Response::allow()
            : Response::deny('You can\'t delete this coupon.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Coupon $coupon): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Coupon $coupon): bool
    {
        //
    }
}
