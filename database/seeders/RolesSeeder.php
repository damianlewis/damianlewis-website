<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use League\Csv\Exception;
use League\Csv\UnavailableStream;

class RolesSeeder extends BaseSeeder
{
    private Collection $roles;

    public function __construct()
    {
        $this->roles = collect();
    }

    /**
     * @throws UnavailableStream
     * @throws Exception
     */
    public function run(): void
    {
        $this->createOrUpdateRoles();

        $this->deleteRedundantRoles();
    }

    private static function getRoleModel()
    {
        return config('permission.models.role');
    }

    /**
     * @throws UnavailableStream
     * @throws Exception
     */
    private function createOrUpdateRoles(): void
    {
        foreach ($this->getDataArray('roles.csv') as $roleData) {
            $role = self::getRoleModel()::updateOrCreate([
                'name' => $roleData['name'],
                'guard_name' => $roleData['guard_name'],
            ], [
                'display_name' => $roleData['display_name'],
                'description' => $roleData['description'],
            ]);

            $this->roles->push($role);
        }
    }

    private function deleteRedundantRoles(): void
    {
        $this->findRedundantRoles()->each->delete();
    }

    private function findRedundantRoles(): EloquentCollection
    {
        return Role::all()
            ->reject(fn (Role $existingRole): bool => $this->roleExistsFor($existingRole));
    }

    private function roleExistsFor(Role $existingRole): bool
    {
        return $this->roles
            ->contains(fn (Role $role): bool => $role->getKey() === $existingRole->getKey());
    }
}
