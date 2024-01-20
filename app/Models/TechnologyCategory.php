<?php

namespace App\Models;

use App\Traits\CascadeDelete;
use Database\Factories\TechnologyCategoryFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Mews\Purifier\Casts\CleanHtml;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

/**
 * App\Models\TechnologyCategory
 *
 * @property string $id
 * @property string $name
 * @property string $slug
 * @property array|null $description
 * @property bool $enabled
 * @property int $order_column
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection<int, Technology> $technologies
 *
 * @method static TechnologyCategoryFactory factory($count = null, $state = [])
 * @method static Builder|TechnologyCategory newModelQuery()
 * @method static Builder|TechnologyCategory newQuery()
 * @method static Builder|TechnologyCategory onlyTrashed()
 * @method static Builder|TechnologyCategory ordered(string $direction = 'asc')
 * @method static Builder|TechnologyCategory query()
 * @method static Builder|TechnologyCategory withTrashed()
 * @method static Builder|TechnologyCategory withoutTrashed()
 *
 * @mixin Eloquent
 */
class TechnologyCategory extends Model implements Sortable
{
    use CascadeDelete,
        HasFactory,
        HasUlids,
        SoftDeletes,
        SortableTrait;

    protected $casts = [
        'description' => CleanHtml::class,
        'enabled' => 'boolean',
    ];

    protected $fillable = [
        'name',
        'slug',
        'description',
        'enabled',
    ];

    protected array $cascadeDelete = [
        'technologies',
    ];

    protected static function booted(): void
    {
        static::retrieved(static function (TechnologyCategory $technologyCategory): void {
            $technologyCategory->mergeFillable([
                config('eloquent-sortable.order_column_name'),
            ]);
        });
    }

    public function technologies(): HasMany
    {
        return $this->hasMany(Technology::class);
    }

    public function enable(): void
    {
        $this->enabled = true;
        $this->save();
    }

    public function disable(): void
    {
        $this->enabled = false;
        $this->save();
    }
}
