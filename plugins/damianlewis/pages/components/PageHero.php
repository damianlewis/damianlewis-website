<?php

declare(strict_types=1);

namespace DamianLewis\Pages\Components;

use DamianLewis\Api\Components\TransformerComponent;
use DamianLewis\Pages\Classes\Transformers\HeroTransformer;
use DamianLewis\Pages\Models\Hero;

class PageHero extends TransformerComponent
{
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
            'id' => [
                'title' => 'Hero',
                'description' => 'The hero section to display',
                'type' => 'dropdown',
                'placeholder' => 'Select a hero'
            ]
        ];
    }

    public function onRun(): void
    {
        $transformer = resolve(HeroTransformer::class);
        $id = (int) $this->property('id');
        $hero = $this->getHeroById($id);

        if ($hero !== null) {
            $this->page['hero'] = $this->transformItem($hero, $transformer);
        }
    }

    /**
     * Returns an array of active heros with the id as the key and description as the value.
     *
     * @return array
     */
    public function getIdOptions(): array
    {
        $heroes = Hero::active()->get();

        return $heroes->pluck('description', 'id')->all();
    }

    /**
     * Returns a hero from the database with the given id.
     *
     * @param  int  $id
     * @return Hero|null
     */
    protected function getHeroById(int $id): ?Hero
    {
        return Hero::active()
            ->where('id', $id)
            ->first();
    }
}
