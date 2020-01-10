<?php

declare(strict_types=1);

namespace DamianLewis\Shared\Classes;

use Model;
use October\Rain\Database\Collection;

trait HasRelation
{
    /**
     * Returns a collection of visible relationships.
     *
     * @param  Model  $model
     * @param  string  $relation
     * @return Collection
     */
    protected function getRelation(Model $model, string $relation): Collection
    {
        return $model->$relation()->where('is_hidden', false)->get();
    }

}