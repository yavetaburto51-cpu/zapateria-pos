<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can view any users.
     */
    public function viewAny(User $authUser): bool
    {
        return $authUser->isAdmin() || $authUser->isOwner();
    }

    /**
     * Determine whether the user can view the specific user.
     */
    public function view(User $authUser, User $user): bool
    {
        if ($authUser->isAdmin()) {
            return true;
        }

        if ($authUser->isOwner()) {
            return ! $user->isAdmin() && ! $user->isOwner();
        }

        return false;
    }

    /**
     * Determine whether the user can create users.
     */
    public function create(User $authUser): bool
    {
        return $authUser->isAdmin() || $authUser->isOwner();
    }

    /**
     * Determine whether the user can update the specific user.
     */
    public function update(User $authUser, User $user): bool
    {
        if ($authUser->isAdmin()) {
            return true;
        }

        if ($authUser->isOwner()) {
            return ! $user->isAdmin() && ! $user->isOwner();
        }

        return false;
    }

    /**
     * Determine whether the user can delete the specific user.
     */
    public function delete(User $authUser, User $user): bool
    {
        // No se permite eliminar usuarios con rol admin
        if ($user->isAdmin()) {
            return false;
        }

        // Un owner no puede eliminar a otro owner
        if ($authUser->isOwner() && $user->isOwner()) {
            return false;
        }

        return $authUser->isAdmin() || $authUser->isOwner();
    }
}
