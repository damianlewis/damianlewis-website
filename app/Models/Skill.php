<?php

namespace App\Models;

use App\Contracts\EnableInterface;
use App\Events\SkillDeleting;
use App\Traits\HasEnabled;
use Database\Factories\SkillFactory;
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
 * App\Models\Skill
 *
 * @property string $id
 * @property string|null $skill_category_id
 * @property string|null $parent_id
 * @property string $name
 * @property string $slug
 * @property bool $enabled
 * @property int $sort_order
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read SkillCategory|null $category
 * @property-read Collection<int, Skill> $children
 * @property-read Skill|null $parent
 *
 * @method static SkillFactory factory($count = null, $state = [])
 * @method static Builder|Skill newModelQuery()
 * @method static Builder|Skill newQuery()
 * @method static Builder|Skill onlyTrashed()
 * @method static Builder|Skill ordered(string $direction = 'asc')
 * @method static Builder|Skill query()
 * @method static Builder|Skill withTrashed()
 * @method static Builder|Skill withoutTrashed()
 *
 * @mixin Eloquent
 */
class Skill extends BaseModel implements EnableInterface, Sortable
{
    use HasEnabled,
        HasFactory,
        SortableTrait;

    protected $casts = [
        'enabled' => 'boolean',
    ];

    protected $fillable = [
        'skill_category_id',
        'parent_id',
        'name',
        'slug',
        'enabled',
    ];

    protected $dispatchesEvents = [
        'deleting' => SkillDeleting::class,
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
        return $this->belongsTo(SkillCategory::class, 'skill_category_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(__CLASS__, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(__CLASS__, 'parent_id');
    }

    public function hasParent(): bool
    {
        $foreignKeyName = $this->parent()->getForeignKeyName();

        return $this->{$foreignKeyName} !== null;
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
