<?php

namespace App\Policies;

use App\Models\Skill;
use App\Models\User;

// use Illuminate\Auth\Access\Response;

class SkillPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_skill');
    }

    public function view(User $user, Skill $skill): bool
    {
        return $user->can('view_skill');
    }

    public function create(User $user): bool
    {
        return $user->can('create_skill');
    }

    public function update(User $user, Skill $skill): bool
    {
        return $user->can('update_skill');
    }

    public function delete(User $user, Skill $skill): bool
    {
        return $user->can('delete_skill');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_skill');
    }

    public function restore(User $user, Skill $skill): bool
    {
        return $user->can('restore_skill');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_skill');
    }

    public function forceDelete(User $user, Skill $skill): bool
    {
        return $user->can('force_delete_skill');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_skill');
    }

    public function reorder(User $user): bool
    {
        return $user->can('reorder_skill');
    }
}
