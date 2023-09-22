<?php

namespace App\Policies;

use App\Models\ActivationCode;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ActivationCodePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        // Only administrator role and user with permission "view activation code" can view all activation codes
        return $user->hasRole('administrator') || $user->can('view activation code') ?
            Response::allow()
            : Response::deny('You can\'t view any activation code.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ActivationCode $activationCode): Response
    {
        // Only administrator role and user with permission "view activation code" can view the activation code
        return $user->hasRole('administrator') || $user->can('view activation code') ?
            Response::allow()
            : Response::deny('You can\'t view this activation code.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        // Only administrator role and user with permission "add activation code" can create a activation code
        return $user->hasRole('administrator') || $user->can('add activation code') ?
            Response::allow()
            : Response::deny('You can\'t create a activation code.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ActivationCode $activationCode): Response
    {
        // Only administrator role and user with permission "edit activation code" can update a activation code
        return $user->hasRole('administrator') || $user->can('edit activation code') ?
            Response::allow()
            : Response::deny('You can\'t update this activation code.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ActivationCode $activationCode): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ActivationCode $activationCode): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ActivationCode $activationCode): bool
    {
        //
    }
}
