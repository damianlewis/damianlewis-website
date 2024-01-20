<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use League\Csv\Exception;
use League\Csv\UnavailableStream;

class PermissionsSeeder extends BaseSeeder
{
    private Collection $permissions;

    private EloquentCollection $roles;

    public function __construct()
    {
        $this->roles = Role::all();
        $this->permissions = collect();
    }

    /**
     * @throws UnavailableStream
     * @throws Exception
     */
    public function run(): void
    {
        $this->createOrUpdatePermissions();

        $this->deleteRedundantPermissions();
    }

    private static function getPermissionModel()
    {
        return config('permission.models.permission');
    }

    /**
     * @throws UnavailableStream
     * @throws Exception
     */
    private function createOrUpdatePermissions(): void
    {
        foreach ($this->getDataArray('permissions.csv') as $permissionData) {
            $permission = self::getPermissionModel()::updateOrCreate([
                'name' => $permissionData['name'],
                'guard_name' => $permissionData['guard_name'],
            ], [
                'display_name' => $permissionData['display_name'],
                'description' => $permissionData['description'],
            ]);

            $this->syncRoles($permission, $permissionData['roles']);

            $this->permissions->push($permission);
        }
    }

    private function syncRoles(Permission $permission, string $roleNames): void
    {
        $roles = collect();

        foreach (explode('|', $roleNames) as $roleName) {
            $role = $this->roles->firstOrFail(fn (Role $role) => $role->name === $roleName);

            $roles->push($role);
        }

        $permission->syncRoles($roles);
    }

    private function deleteRedundantPermissions(): void
    {
        $this->findRedundantPermissions()->each(
            fn (Permission $permission): ?bool => $permission->delete()
        );
    }

    private function findRedundantPermissions(): EloquentCollection
    {
        return Permission::all()
            ->reject(fn (Permission $existingPermission): bool => $this->permissionExistsFor($existingPermission));
    }

    private function permissionExistsFor(Permission $existingPermission): bool
    {
        return $this->permissions
            ->contains(fn (Permission $permission): bool => $permission->getKey() === $existingPermission->getKey());
    }
}
