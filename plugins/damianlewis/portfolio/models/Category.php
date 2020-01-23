<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Models;

use Model;
use October\Rain\Database\Builder;
use October\Rain\Database\Collection;
use October\Rain\Database\Traits\Nullable;
use October\Rain\Database\Traits\SimpleTree;
use October\Rain\Database\Traits\Sortable;
use October\Rain\Halcyon\Traits\Validation;

class Category extends Model
{
    use Nullable;
    use SimpleTree;
    use Sortable;
    use Validation;

    const CATEGORY_NAME_SKILLS = 'Skills';
    const CATEGORY_NAME_TECHNOLOGIES = 'Technologies';

    public $rules = [
        'name' => 'required'
    ];

    public $hasMany = [
        'skills' => [
            Skill::class
        ]
    ];

    protected $table = 'damianlewis_portfolio_categories';

    protected $casts = [
        'is_hidden' => 'boolean'
    ];

    protected $nullable = [
        'parent_id',
        'name'
    ];

    /**
     * @var array
     */
    protected array $flattenedSkills;

    /**
     * Select visible categories.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_hidden', false);
    }

    /**
     * Select the top level root categories.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeRoot(Builder $query): Builder
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Returns a collection of flattened skills for the category.
     *
     * @return \October\Rain\Support\Collection
     */
    public function getFlattenedSkillsAttribute(): \October\Rain\Support\Collection
    {
        $this->flattenedSkills = [];

        $this->flattenSkillsForCategory($this);

        return collect($this->flattenedSkills);
    }

    /**
     * Flattens the skills for the given category.
     *
     * @param  Category  $category
     * @return void
     */
    public function flattenSkillsForCategory(Category $category): void
    {
        if ($category->children()->exists()) {
            $this->flattenSkillsForCategories($category->getChildren());
        }

        if ($category->skills()->exists()) {
            $this->flattenSkills($category->skills);
        }
    }

    /**
     * Appends a skill to the flattened skills array.
     *
     * @param  Skill  $skill
     * @return void
     */
    public function flattenSkill(Skill $skill): void
    {
        if ($skill->children()->exists()) {
            $this->flattenSkills($skill->getChildren());
        }

        $relations = $skill->getRelations();
        unset($relations['children']);
        $skill->setRelations($relations);

        $this->flattenedSkills[] = $skill;
    }

    /**
     * Flatten the skills for the given category collection.
     *
     * @param  Collection  $categories
     */
    protected function flattenSkillsForCategories(Collection $categories): void
    {
        $categories->each([$this, 'flattenSkillsForCategory']);
    }

    /**
     * Flattens the skills for the given skills collection.
     *
     * @param  Collection  $skills
     */
    protected function flattenSkills(Collection $skills): void
    {
        $skills->each([$this, 'flattenSkill']);
    }
}
