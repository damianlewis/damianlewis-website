<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Updates;

use DamianLewis\Portfolio\Models\Category;
use DamianLewis\Portfolio\Models\Skill;
use October\Rain\Database\Collection;
use Seeder;

class SeedSkills extends Seeder
{
    public function run(): void
    {
        $skillsCategory = Category::root()
            ->where('name', Category::CATEGORY_NAME_SKILLS)
            ->first();
        $technologiesCategory = Category::root()
            ->where('name', Category::CATEGORY_NAME_TECHNOLOGIES)
            ->first();

        $skillsCategory->children()->saveMany($this->createCategorisedSkills());
        $technologiesCategory->children()->saveMany($this->createCategorisedSkills());
    }

    /**
     * @return Collection
     */
    protected function createCategorisedSkills(): Collection
    {
        return factory(Category::class, rand(2, 4))
            ->create()
            ->each(function (Category $category) {
                $skills = factory(Skill::class, rand(3, 12))
                    ->create()
                    ->each(function (Skill $skill) {
                        $subSkills = factory(Skill::class, rand(0, 6))->create();
                        $skill->children()->saveMany($subSkills);
                    });
                $category->skills()->saveMany($skills);
            });
    }
}
