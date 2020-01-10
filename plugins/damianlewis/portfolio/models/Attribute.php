<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Models;

use Model;
use October\Rain\Database\Builder;
use October\Rain\Database\Traits\Nullable;

class Attribute extends Model
{
    use Nullable;

    const PROJECT_STATUS = 'project.status';
    const ATTRIBUTE_CODE_DRAFT = 'draft';
    const ATTRIBUTE_CODE_ACTIVE = 'active';
    const ATTRIBUTE_CODE_ARCHIVED = 'archived';

    protected $table = 'damianlewis_portfolio_attributes';

    protected $nullable = [
        'type',
        'name',
        'label',
        'code'
    ];

    /**
     * Select the active project status.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeActiveProjectStatus(Builder $query): Builder
    {
        return $query->where(
            ['type', Attribute::PROJECT_STATUS],
            ['code', Attribute::ATTRIBUTE_CODE_ACTIVE]
        );
    }
}
