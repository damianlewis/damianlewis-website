<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Updates;

use DamianLewis\Portfolio\Models\Project;
use Seeder;

class SeedProjects extends Seeder
{
    public function run(): void
    {
        factory(Project::class, 4)->create();

        factory(Project::class, 8)->states([
            'active',
            'with skills',
            'with technologies'
        ])->create();

        factory(Project::class, 2)->states([
            'active',
            'with skills',
            'with technologies',
            'featured'
        ])->create();

        factory(Project::class)->states([
            'active',
            'with skills',
            'with technologies',
            'hidden'
        ])->create();

        factory(Project::class, 2)->states([
            'archived',
            'with skills',
            'with technologies'
        ])->create();
    }
}
