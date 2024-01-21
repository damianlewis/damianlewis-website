<?php

namespace App\Models;

use App\Contracts\EnableInterface;
use App\Events\TechnologyDeleting;
use App\Traits\HasEnabled;
use Database\Factories\TechnologyFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

/**
 * App\Models\Technology
 *
 * @property string $id
 * @property string|null $technology_category_id
 * @property string|null $parent_id
 * @property string $name
 * @property string $slug
 * @property bool $enabled
 * @property int $sort_order
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read TechnologyCategory|null $category
 * @property-read Collection<int, Technology> $children
 * @property-read Technology|null $parent
 *
 * @method static TechnologyFactory factory($count = null, $state = [])
 * @method static Builder|Technology newModelQuery()
 * @method static Builder|Technology newQuery()
 * @method static Builder|Technology onlyTrashed()
 * @method static Builder|Technology ordered(string $direction = 'asc')
 * @method static Builder|Technology query()
 * @method static Builder|Technology withTrashed()
 * @method static Builder|Technology withoutTrashed()
 *
 * @mixin Eloquent
 */
class Technology extends BaseModel implements EnableInterface, Sortable
{
    use HasEnabled,
        HasFactory,
        SortableTrait;

    protected $casts = [
        'enabled' => 'boolean',
    ];

    protected $fillable = [
        'technology_category_id',
        'parent_id',
        'name',
        'slug',
        'enabled',
    ];

    protected $dispatchesEvents = [
        'deleting' => TechnologyDeleting::class,
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->mergeFillable([
            config('eloquent-sortable.order_column_name'),
        ]);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(TechnologyCategory::class, 'technology_category_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(__CLASS__, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(__CLASS__, 'parent_id');
    }

    public function hasCategory(): bool
    {
        return $this->category()->exists();
    }

    public function doesntHaveCategory(): bool
    {
        return $this->category()->doesntExist();
    }

    public function hasParent(): bool
    {
        return $this->parent()->exists();
    }

    public function hasChildren(): bool
    {
        return $this->children()->exists();
    }

    public function removeParent(): void
    {
        $foreignKeyName = $this->parent()->getForeignKeyName();

        if ($this->{$foreignKeyName} === null) {
            return;
        }

        $this->{$foreignKeyName} = null;
        $this->save();
    }

    public function buildSortQuery(): Builder
    {
        $foreignKeyName = $this->category()->getForeignKeyName();

        return static::query()->where($foreignKeyName, $this->{$foreignKeyName});
    }
}
