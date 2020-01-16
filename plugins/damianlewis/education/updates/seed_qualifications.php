<?php

declare(strict_types=1);

namespace DamianLewis\Education\Updates;

use DamianLewis\Education\Models\Qualification;
use Seeder;

class SeedQualifications extends Seeder
{
    public function run()
    {
        $qualifications = [
            [
                'title' => 'BA (Hons), Interactive Systems Design',
                'score' => '1st Class'
            ],
            [
                'title' => 'MSc, Computer Science',
                'score' => 'Distinction (Outstanding)'
            ]
        ];

        foreach ($qualifications as $qualification) {
            Qualification::create($qualification);
        }
    }
}