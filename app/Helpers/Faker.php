<?php

namespace App\Helpers;

class Faker
{
    public static function uniqueName(int $number = 3): string
    {
        return ucfirst(fake()->unique()->words($number, true));
    }

    public static function htmlParagraphs(int $number = 3): string
    {
        return implode(
            array_map(
                static fn (string $paragraph): string => '<p>' . $paragraph . '</p>',
                fake()->paragraphs($number)
            )
        );
    }
}
