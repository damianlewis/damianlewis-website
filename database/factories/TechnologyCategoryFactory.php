<?php

namespace Database\Factories;

use App\Helpers\Faker;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

class TechnologyCategoryFactory extends Factory
{
    /**
     * @throws Exception
     */
    public function definition(): array
    {
        return [
            'name' => Faker::uniqueName(random_int(1, 3)),
            'description' => Faker::htmlParagraphs(random_int(1, 3)),
            'enabled' => false,
        ];
    }

    public function enabled(): static
    {
        return $this->state(fn (array $attributes) => [
            'enabled' => true,
        ]);
    }
}
