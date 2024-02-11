<?php

namespace Database\Factories;

use App\Helpers\Faker;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SkillCategoryFactory extends Factory
{
    /**
     * @throws Exception
     */
    public function definition(): array
    {
        $name = Faker::uniqueName(random_int(1, 3));

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => Faker::htmlParagraphs(random_int(1, 3)),
            'enabled' => false,
        ];
    }

    public function enabled(): static
    {
        return $this->state(fn (array $attributes): array => [
            'enabled' => true,
        ]);
    }
}