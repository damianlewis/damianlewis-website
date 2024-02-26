<?php

namespace Database\Seeders;

use App\Models\Skill;
use App\Models\SkillCategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkillSeeder extends Seeder
{
    public function run(): void
    {
        DB::table((new Skill)->getTable())->delete();

        SkillCategory::all()
            ->each(fn (SkillCategory $category): Collection => Skill::factory()
                ->enabled()
                ->for($category, 'category')
                ->count(10)
                ->create()
            );
    }
}
