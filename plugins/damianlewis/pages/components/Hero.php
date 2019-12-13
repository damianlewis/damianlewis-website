<?php

declare(strict_types=1);

namespace DamianLewis\Pages\Components;

use Cms\Classes\ComponentBase;
use DamianLewis\Pages\Models\Hero as HeroModel;

class Hero extends ComponentBase
{
    public $hero;

    public function componentDetails(): array
    {
        return [
            'name' => 'Hero',
            'description' => 'Get the details for a single hero section.'
        ];
    }

    public function defineProperties(): array
    {
        return [
            'hero' => [
                'title' => 'Hero',
                'description' => 'The hero section to display',
                'type' => 'dropdown',
                'placeholder' => 'Select a hero'
            ]
        ];
    }

    /**
     * Return the hero models as an array with the id as the key and description as the value.
     *
     * @return array
     */
    public function getHeroOptions(): array
    {
        return HeroModel::all()->pluck('description', 'id')->all();
    }

    public function onRun(): void
    {
        $this->hero = $this->page['hero'] = HeroModel::where('id', $this->property('hero'))->firstOrFail();
    }
}
