<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Mews\Purifier\Casts\CleanHtml;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class TechnologyCategory extends Model implements Sortable
{
    use HasFactory,
        HasUlids,
        SortableTrait;

    protected $casts = [
        'description' => CleanHtml::class,
        'enabled' => 'boolean',
    ];

    protected $fillable = [
        'name',
        'description',
        'enabled',
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
