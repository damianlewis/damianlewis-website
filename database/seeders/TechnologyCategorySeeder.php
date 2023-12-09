<?php

namespace Database\Seeders;

use App\Models\TechnologyCategory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TechnologyCategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table((new TechnologyCategory)->getTable())->delete();

        $technologies = [
            'Frontend',
            'Backend',
            'Software',
        ];

        TechnologyCategory::factory()
            ->count(count($technologies))
            ->sequence(fn (Sequence $sequence) => [
                'name' => $technologies[$sequence->index],
            ])
            ->enabled()
            ->create();
    }
}
