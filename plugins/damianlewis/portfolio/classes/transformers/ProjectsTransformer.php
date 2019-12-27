<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Classes\Transformers;

use Model;

class ProjectsTransformer extends Transformer implements Transformable
{
    /**
     * @var array
     */
    private $properties;

    /**
     * Transforms the given project model to include the attributes required by the frontend.
     *
     * @param  Model  $item
     * @return array
     */
    public function transformItem(Model $item): array
    {
        $data = $item->only([
            'title'
        ]);

        $data = array_merge($data, [
            'text' => $item->summary,
            'image' => $item->mockup_multiple_image,
            'imageReversed' => $item->mockup_multiple_reversed_image,
            'url' => url($this->properties['projectPage'], $item->slug)
        ]);

        return $data;
    }

    /**
     * Sets the properties used by the transformer.
     *
     * @param  array  $properties
     */
    public function setProperties(array $properties = []): void
    {
        $this->properties = $properties;
    }
}