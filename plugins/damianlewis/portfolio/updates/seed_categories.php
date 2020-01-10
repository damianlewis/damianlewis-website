<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Updates;

use DamianLewis\Portfolio\Models\Category;
use Seeder;

class SeedCategories extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => Category::CATEGORY_NAME_SKILLS],
            ['name' => Category::CATEGORY_NAME_TECHNOLOGIES]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}