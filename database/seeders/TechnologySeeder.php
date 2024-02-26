<?php

namespace Database\Seeders;

use App\Models\Technology;
use App\Models\TechnologyCategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TechnologySeeder extends Seeder
{
    public function run(): void
    {
        DB::table((new Technology)->getTable())->delete();

        TechnologyCategory::all()
            ->each(fn (TechnologyCategory $category): Collection => Technology::factory()
                ->enabled()
                ->for($category, 'category')
                ->count(10)
                ->create()
            );
    }
}
