<?php

namespace App\Models;

use App\Traits\SoftCascade;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
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
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Technology> $technologies
 *
 * @method static \Database\Factories\TechnologyCategoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|TechnologyCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TechnologyCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TechnologyCategory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TechnologyCategory ordered(string $direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|TechnologyCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|TechnologyCategory withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TechnologyCategory withoutTrashed()
 *
 * @mixin \Eloquent
 */
class TechnologyCategory extends Model implements Sortable
{
    use HasFactory,
        HasUlids,
        SoftCascade,
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

    protected array $softCascade = [
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
}
