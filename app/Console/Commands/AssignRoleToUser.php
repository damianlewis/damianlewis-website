<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;

use function Laravel\Prompts\info;
use function Laravel\Prompts\select;
use function Laravel\Prompts\text;
use function Laravel\Prompts\warning;

class AssignRoleToUser extends Command
{
    protected $signature = 'app:assign-role-to-user
        {--user-email= : The email of user to assign the role to.}
        {--role-name= : The name of the role to assign.}';

    protected $description = 'Assign a role to a user.';

    public function handle(): int
    {
        $user = null;

        if ($this->option('user-email')) {
            $email = $this->option('user-email');
        } else {
            $user = User::first();

            $email = text(
                label: 'Please provide the the users email.',
                default: $user?->email,
                required: true,
            );
        }

        if ($user === null || $user->email !== $email) {
            $user = User::query()
                ->where('email', $email)
                ->first();
        }

        if ($user === null) {
            warning('User not found.');

            return static::FAILURE;
        }

        $roles = Role::all();

        if ($this->option('role-name')) {
            $roleName = $this->option('role-name');
        } else {
            $roleName = select(
                label: 'Select the role to assign.',
                options: $roles->pluck('display_name', 'name')->toArray(),
                default: $roles->first()?->name,
            );
        }

        $role = $roles->firstWhere('name', $roleName);

        if ($role === null) {
            warning('Role not found.');

            return static::FAILURE;
        }

        $user->assignRole($role);

        info('Role assigned to user.');

        return static::SUCCESS;
    }
}
