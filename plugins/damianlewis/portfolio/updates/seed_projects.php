<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Updates;

use DamianLewis\Portfolio\Models\Project;
use Seeder;

class SeedProjects extends Seeder
{
    public function run(): void
    {
        factory(Project::class, 4)->states([
//            'with preview'
        ])->create();

        factory(Project::class, 10)->states([
            'active',
            'with skills',
            'with technologies',
//            'with preview'
        ])->create();

        factory(Project::class, 2)->states([
            'archived',
            'with skills',
            'with technologies',
//            'with preview'
        ])->create();

//        factory(Project::class)->states([
//            'active',
//            'with skills',
//            'with technologies',
//            'with preview',
//            'with device images',
//            'with full frame images'
//        ])->create();
    }
}
