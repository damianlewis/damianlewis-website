<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Models;

use Model;
use October\Rain\Database\Traits\NestedTree;
use October\Rain\Database\Traits\Nullable;
use October\Rain\Database\Traits\Validation;

class Skill extends Model
{
    use NestedTree;
    use Nullable;
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
            'table' => 'damianlewis_portfolio_project_skill',
            'timestamps' => true
        ]
    ];

    protected $table = 'damianlewis_portfolio_skills';

    protected $casts = [
        'is_hidden' => 'boolean'
    ];

    protected $nullable = [
        'parent_id',
        'name'
    ];


    /**
     * Returns the root category for the skill.
     *
     * @return Category|null
     */
    public function getRootCategoryAttribute(): ?Category
    {
        $rootSkill = $this->getRoot();

        if ($rootSkill->category()->doesntExist()) {
            return null;
        }

        return $rootSkill->category->getRoot();
    }
}
