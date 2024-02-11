<?php

namespace App\Policies;

use App\Models\SkillCategory;
use App\Models\User;

// use Illuminate\Auth\Access\Response;

class SkillCategoryPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_skill_category');
    }

    public function view(User $user, SkillCategory $skillCategory): bool
    {
        return $user->can('view_skill_category');
    }

    public function create(User $user): bool
    {
        return $user->can('create_skill_category');
    }

    public function update(User $user, SkillCategory $skillCategory): bool
    {
        return $user->can('update_skill_category');
    }

    public function delete(User $user, SkillCategory $skillCategory): bool
    {
        return $user->can('delete_skill_category');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_skill_category');
    }

    public function restore(User $user, SkillCategory $skillCategory): bool
    {
        return $user->can('restore_skill_category');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_skill_category');
    }

    public function forceDelete(User $user, SkillCategory $skillCategory): bool
    {
        return $user->can('force_delete_skill_category');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_skill_category');
    }

    public function reorder(User $user): bool
    {
        return $user->can('reorder_skill_category');
    }
}
