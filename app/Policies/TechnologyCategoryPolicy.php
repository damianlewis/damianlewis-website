<?php

namespace App\Policies;

use App\Models\TechnologyCategory;
use App\Models\User;

// use Illuminate\Auth\Access\Response;

class TechnologyCategoryPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_technology_category');
    }

    public function view(User $user, TechnologyCategory $technologyCategory): bool
    {
        return $user->can('view_technology_category');
    }

    public function create(User $user): bool
    {
        return $user->can('create_technology_category');
    }

    public function update(User $user, TechnologyCategory $technologyCategory): bool
    {
        return $user->can('update_technology_category');
    }

    public function delete(User $user, TechnologyCategory $technologyCategory): bool
    {
        return $user->can('delete_technology_category');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_technology_category');
    }

    public function restore(User $user, TechnologyCategory $technologyCategory): bool
    {
        return $user->can('restore_technology_category');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_technology_category');
    }

    public function forceDelete(User $user, TechnologyCategory $technologyCategory): bool
    {
        return $user->can('force_delete_technology_category');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_technology_category');
    }

    public function reorder(User $user): bool
    {
        return $user->can('reorder_technology_category');
    }
}
