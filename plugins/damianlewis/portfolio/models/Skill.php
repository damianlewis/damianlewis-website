<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Models;

use Model;
use October\Rain\Database\Traits\Nullable;
use October\Rain\Database\Traits\SimpleTree;
use October\Rain\Database\Traits\Sortable;
use October\Rain\Database\Traits\Validation;

class Skill extends Model
{
    use Nullable;
    use SimpleTree;
    use Sortable;
    use Validation;

    public $rules = [
        'name' => 'required'
    ];

    public $belongsTo = [
        'category' => [
            Category::class
        ]
    ];

    public $belongsToMany = [
        'projects' => [
            Project::class,
            'table' => 'damianlewis_portfolio_project_skill'
        ]
    ];

    protected $table = 'damianlewis_portfolio_skills';

    protected $casts = [
        'is_hidden' => 'boolean'
    ];

    protected $nullable = [
        'parent_id',
        'name',
        'sort_order'
    ];
}
