<?php

declare(strict_types=1);

namespace DamianLewis\Pages\Components;

use Cms\Classes\ComponentBase;
use DamianLewis\Pages\Classes\Transformers\HeroTransformer;
use DamianLewis\Pages\Models\Hero as HeroModel;

class Hero extends ComponentBase
{
    /**
     * @var HeroTransformer
     */
    protected HeroTransformer $transformer;

    /**
     * @var array|null
     */
    protected ?array $transformedHero = null;

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

    public function init(): void
    {
        $this->transformer = resolve(HeroTransformer::class);
    }

    public function onRun(): void
    {
        $id = (int) $this->property('id');
        $hero = $this->getHeroById($id);

        $this->page['hero'] = $this->transformHero($hero);
    }

    /**
     * Returns an array of active heros with the id as the key and description as the value.
     *
     * @return array
     */
    public function getIdOptions(): array
    {
        $heroes = HeroModel::active()->get();

        return $heroes->pluck('description', 'id')->all();
    }

    /**
     * Returns a hero from the database with the given id.
     *
     * @param  int  $id
     * @return HeroModel|null
     */
    protected function getHeroById(int $id): ?HeroModel
    {
        return HeroModel::query()
            ->active()
            ->where('id', $id)
            ->first();
    }

    /**
     * Returns the transformed hero.
     *
     * @param  HeroModel|null  $hero
     * @return array|null
     */
    protected function transformHero(?HeroModel $hero): ?array
    {
        if ($this->transformedHero !== null) {
            return $this->transformedHero;
        }

        if ($hero !== null) {
            return $this->transformedHero = $this->transformer->transformItem($hero);
        }

        return null;
    }
}
