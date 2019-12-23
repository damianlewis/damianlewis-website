<?php

declare(strict_types=1);

namespace DamianLewis\Services\Updates;

use DamianLewis\Services\Models\Category;
use Seeder;

class SeedDummyCategories extends Seeder
{
    public function run(): void
    {
        factory(Category::class, 3)->states(['featured'])->create();
    }
}