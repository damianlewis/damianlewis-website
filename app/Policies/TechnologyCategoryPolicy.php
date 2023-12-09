<?php

namespace App\Policies;

use App\Models\TechnologyCategory;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TechnologyCategoryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_technology::category');
    }

    public function view(User $user, TechnologyCategory $technologyCategory): bool
    {
        return $user->can('view_technology::category');
    }

    public function create(User $user): bool
    {
        return $user->can('create_technology::category');
    }

    public function update(User $user, TechnologyCategory $technologyCategory): bool
    {
        return $user->can('update_technology::category');
    }

    public function delete(User $user, TechnologyCategory $technologyCategory): bool
    {
        return $user->can('delete_technology::category');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_technology::category');
    }

    public function forceDelete(User $user, TechnologyCategory $technologyCategory): bool
    {
        return $user->can('force_delete_technology::category');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_technology::category');
    }

    public function restore(User $user, TechnologyCategory $technologyCategory): bool
    {
        return $user->can('restore_technology::category');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_technology::category');
    }

    public function replicate(User $user, TechnologyCategory $technologyCategory): bool
    {
        return $user->can('replicate_technology::category');
    }

    public function reorder(User $user): bool
    {
        return $user->can('reorder_technology::category');
    }
}
