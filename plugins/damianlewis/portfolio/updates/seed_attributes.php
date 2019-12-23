<?php

declare(strict_types=1);

namespace damianlewis\portfolio\updates;

use DamianLewis\Portfolio\Models\Attribute;
use Seeder;

class SeedAttributes extends Seeder
{
    public function run(): void
    {
        $projectStatuses = [
            ['name' => 'Draft', 'code' => 'draft'],
            ['name' => 'Active', 'code' => 'active'],
            ['name' => 'Archived', 'code' => 'archived']
        ];

        foreach ($projectStatuses as $status) {
            Attribute::create(array_merge($status, ['type' => Attribute::PROJECT_STATUS]));
        }
    }
}
