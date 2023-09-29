<?php

namespace App\Policies;

use App\Models\ApkVersion;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ApkVersionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ApkVersion $apkVersion): Response
    {
        // 
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        // 
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): Response
    {
        return $user->hasRole('administrator')
            ? Response::allow()
            : Response::deny('You do not have permission to update APk versions.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ApkVersion $apkVersion): Response
    {
        // 
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ApkVersion $apkVersion): Response
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ApkVersion $apkVersion): Response
    {
        //
    }
}
