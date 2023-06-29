<?php

namespace App\Policies;

use App\Models\Package;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PackagePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Package $package): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        // Only administrator role can create a package
        return $user->hasRole('administrator')
            ? Response::allow()
            : Response::deny('Only administrator can create a package.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Package $package): Response
    {
        // Only administrator role can update a package
        return $user->hasRole('administrator')
            ? Response::allow()
            : Response::deny('Only administrator can update a package.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Package $package): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Package $package): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Package $package): bool
    {
        //
    }
}
