<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Updates;

use DamianLewis\Portfolio\Models\Skill;
use Seeder;

class SeedSkills extends Seeder
{
    public function run(): void
    {
        factory(Skill::class, 10)->create();
    }
}
