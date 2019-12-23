<?php

declare(strict_types=1);

namespace DamianLewis\Pages\Components;

use Cms\Classes\ComponentBase;
use DamianLewis\Pages\Models\Hero as HeroModel;

class Hero extends ComponentBase
{
    /**
     * @var HeroModel|null
     */
    private $hero;

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
     * Returns a transformed hero model for consumption by the frontend.
     *
     * @return array The transformed model data.
     */
    public function item(): array
    {
        if (!$this->isAvailable()) {
            return [];
        }

        return $this->transformItem($this->hero);
    }

    /**
     * Returns true if a hero model has been set for the component.
     *
     * @return bool
     */
    public function isAvailable(): bool
    {
        return !!$this->hero;
    }

    public function onRun(): void
    {
        $id = (int) $this->property('hero');

        $this->hero = $this->getActiveHeroById($id);
    }

    /**
     * Returns an array of active heros with the id as the key and description as the value.
     *
     * @return array
     */
    public function getHeroOptions(): array
    {
        $activeHeroes = HeroModel::active()->get();

        return $activeHeroes->pluck('description', 'id')->all();
    }

    /**
     * Transforms a hero model into the data required by the frontend.
     *
     * @param  HeroModel  $hero
     * @return array The transformed model data.
     */
    protected function transformItem(HeroModel $hero): array
    {
        $data = $hero->only([
            'header',
            'body',
            'image'
        ]);

        return array_merge($data, [
            'bgTablet' => $hero->background_image_tablet,
            'bgMobile' => $hero->background_image_mobile
        ]);
    }

    /**
     * Returns the active hero model with the given id.
     *
     * @param  int  $id
     * @return HeroModel|null
     */
    protected function getActiveHeroById(int $id): ?HeroModel
    {
        return HeroModel::active()->where('id', $id)->first();
    }
}
