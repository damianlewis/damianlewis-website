<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Classes;

use Model;

interface Transformable
{
    /**
     * Transform the attributes of the given model.
     *
     * @param  Model  $item
     * @return array
     */
    public function transformItem(Model $item): array;
}
