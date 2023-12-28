<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Technology extends Model implements Sortable
{
    use HasFactory,
        HasUlids,
        SoftDeletes,
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

    protected static function booted(): void
    {
        static::retrieved(static function (Technology $technology): void {
            $technology->mergeFillable([
                config('eloquent-sortable.order_column_name'),
            ]);
        });
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
        //        return $this->category()->exists();
        return $this->category !== null;
    }

    public function hasParent(): bool
    {
        //        return $this->children()->exists();
        return $this->parent !== null;
    }

    public function hasChildren(): bool
    {
        //        return $this->children()->exists();
        return $this->children->isNotEmpty();
    }

    public function buildSortQuery(): Builder
    {
        return static::query()
            ->where('technology_category_id', $this->technology_category_id);
    }
}
