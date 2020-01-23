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
        'name',
        'sort_order'
    ];

    /**
     * @var Category
     */
    protected Category $rootCategory;

    /**
     * Returns the root category for the skill.
     *
     * @return Category
     */
    public function getRootCategoryAttribute(): Category
    {
        $this->setRootCategoryForSkill($this);

        return $this->rootCategory;
    }

    /**
     * Traverses the skills looking for the parent category.
     *
     * @param  Skill  $skill
     */
    protected function setRootCategoryForSkill(Skill $skill): void
    {
        if ($skill->parent()->exists()) {
            $this->setRootCategoryForSkill($skill->parent);
        }

        if ($skill->category()->exists()) {
            $this->setRootCategory($skill->category);
        }
    }

    /**
     * Traverses the categories looking for the root category.
     *
     * @param  Category  $category
     */
    protected function setRootCategory(Category $category): void
    {
        $this->rootCategory = $category;

        if ($category->parent()->exists()) {
            $this->setRootCategory($category->parent);
        }
    }
}
