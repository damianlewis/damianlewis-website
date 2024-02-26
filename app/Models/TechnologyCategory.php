<?php

namespace App\Models;

use App\Contracts\EnableInterface;
use App\Traits\HasEnabled;
use Database\Factories\TechnologyCategoryFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
 * @property int $sort_order
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
class TechnologyCategory extends BaseModel implements EnableInterface, Sortable
{
    use HasEnabled,
        HasFactory,
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

    protected array $cascadeDeleteRelationships = [
        'technologies',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->mergeFillable([
            config('eloquent-sortable.order_column_name'),
        ]);
    }

    public function technologies(): HasMany
    {
        return $this->hasMany(Technology::class);
    }
}
