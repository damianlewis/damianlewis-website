<?php

namespace Database\Seeders;

use App\Models\SkillCategory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SkillCategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table((new SkillCategory)->getTable())->delete();

        $categories = [
            'Design',
            'Development',
            'Infrastructure',
        ];

        SkillCategory::factory()
            ->count(count($categories))
            ->sequence(fn (Sequence $sequence) => [
                'name' => $categories[$sequence->index],
                'slug' => Str::slug($categories[$sequence->index]),
            ])
            ->enabled()
            ->create();
    }
}
