<?php

namespace App\Policies;

use App\Models\Technology;
use App\Models\User;

// use Illuminate\Auth\Access\Response;

class TechnologyPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_technology');
    }

    public function view(User $user, Technology $technology): bool
    {
        return $user->can('view_technology');
    }

    public function create(User $user): bool
    {
        return $user->can('create_technology');
    }

    public function update(User $user, Technology $technology): bool
    {
        return $user->can('update_technology');
    }

    public function delete(User $user, Technology $technology): bool
    {
        return $user->can('delete_technology');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_technology');
    }

    public function forceDelete(User $user, Technology $technology): bool
    {
        return $user->can('force_delete_technology');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_technology');
    }

    public function restore(User $user, Technology $technology): bool
    {
        return $user->can('restore_technology');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_technology');
    }

    public function reorder(User $user): bool
    {
        return $user->can('reorder_technology');
    }
}
