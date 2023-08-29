<?php

namespace App\Policies;

use App\Models\Dealer;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DealerPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Only administrator role and user with permission "view dealer" can view all dealers
        return $user->hasRole('administrator') || $user->can('view dealer') ?
        Response::allow()
        : Response::deny('You can\'t view any dealers.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Dealer $dealer): bool
    {
        // Only administrator role and user with permission "view dealer" can view the dealer
        return $user->hasRole('administrator') || $user->can('view dealer') ?
        Response::allow()
        : Response::deny('You can\'t view this dealer.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Only administrator role and user with permission "add dealer" can create a dealer
        return $user->hasRole('administrator') || $user->can('add dealer') ?
        Response::allow()
        : Response::deny('You can\'t create a dealer.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Dealer $dealer): bool
    {
        // Only administrator role and user with permission "edit dealer" can update a dealer
        return ($user->hasRole('administrator') || $user->can('edit dealer')) && $dealer->isValid() ?
        Response::allow()
        : Response::deny('You can\'t update this dealer.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Dealer $dealer): bool
    {
        // Only administrator role and user with permission "delete dealer" can delete a dealer
        return ($user->hasRole('administrator') || $user->can('delete dealer')) && $dealer->isValid() ?
        Response::allow()
        : Response::deny('You can\'t delete this dealer.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Dealer $dealer): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Dealer $dealer): bool
    {
        //
    }
}
