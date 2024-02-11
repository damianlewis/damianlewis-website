<?php

namespace App\Models;

use App\Contracts\EnableInterface;
use App\Traits\HasEnabled;
use Database\Factories\SkillCategoryFactory;
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
 * App\Models\SkillCategory
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
 * @property-read Collection<int, Skill> $skills
 *
 * @method static SkillCategoryFactory factory($count = null, $state = [])
 * @method static Builder|SkillCategory newModelQuery()
 * @method static Builder|SkillCategory newQuery()
 * @method static Builder|SkillCategory onlyTrashed()
 * @method static Builder|SkillCategory ordered(string $direction = 'asc')
 * @method static Builder|SkillCategory query()
 * @method static Builder|SkillCategory withTrashed()
 * @method static Builder|SkillCategory withoutTrashed()
 *
 * @mixin Eloquent
 */
class SkillCategory extends BaseModel implements EnableInterface, Sortable
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
        'skills',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->mergeFillable([
            config('eloquent-sortable.order_column_name'),
        ]);
    }

    public function skills(): HasMany
    {
        return $this->hasMany(Skill::class);
    }
}
