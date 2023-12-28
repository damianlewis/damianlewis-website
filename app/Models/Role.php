<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Spatie\Permission\Models\Role as SpatieRole;

/**
 * App\Models\Role
 *
 * @property string $id
 * @property string $name
 * @property string|null $display_name
 * @property string|null $description
 * @property string $guard_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Permission> $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role withoutPermission($permissions)
 *
 * @mixin \Eloquent
 */
class Role extends SpatieRole
{
    use HasUlids;
}
