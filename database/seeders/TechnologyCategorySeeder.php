<?php

namespace Database\Seeders;

use App\Models\TechnologyCategory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TechnologyCategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table((new TechnologyCategory)->getTable())->delete();

        $categories = [
            'Frontend',
            'Backend',
            'Software',
        ];

        TechnologyCategory::factory()
            ->count(count($categories))
            ->sequence(fn (Sequence $sequence) => [
                'name' => $categories[$sequence->index],
                'slug' => Str::slug($categories[$sequence->index]),
            ])
            ->enabled()
            ->create();
    }
}
