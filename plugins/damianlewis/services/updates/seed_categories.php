<?php

declare(strict_types=1);

namespace DamianLewis\Services\Updates;

use DamianLewis\Services\Models\Category;
use Seeder;

class SeedCategories extends Seeder
{
    public function run()
    {
        factory(Category::class, 3)->states([
            'featured'
        ])->create();
    }
}