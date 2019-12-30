<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Classes\Transformers;

use DamianLewis\Portfolio\Models\Project;
use Model;
use October\Rain\Database\Collection;

class ProjectTransformer implements TransformerInterface
{
    /**
     * Transforms the given project model to include the attributes required by the frontend.
     *
     * @param  Model  $item
     * @return array
     */
    public function transformItem(Model $item): array
    {
        if (!$item instanceof Project) {
            return [];
        }

        $attributeTransformer = resolve(AttributeTransformer::class);
        $fileTransformer = resolve(FileTransformer::class);

        $data = $item->only([
            'title',
        ]);

        $skills = $this->getAttributes($item, 'skills');
        $technologies = $this->getAttributes($item, 'technologies');

        $data = array_merge($data, [
            'text' => $item->description,
            'tagLine' => $item->tag_line,
            'skills' => $attributeTransformer->transformCollection($skills),
            'technologies' => $attributeTransformer->transformCollection($technologies),
            'mobileImage' => $fileTransformer->transformItem($item->mobile_full_frame_image),
            'tabletImage' => $fileTransformer->transformItem($item->tablet_full_frame_image),
            'desktopImage' => $fileTransformer->transformItem($item->desktop_full_frame_image),
            'mockupImage' => $fileTransformer->transformItem($item->mockup_multiple_in_sequence_image),
            'additionalImages' => $fileTransformer->transformCollection($item->design_images),
        ]);

        return $data;
    }

    /**
     * Returns a collection of visible attributes.
     *
     * @param  Model  $item
     * @param  string  $attribute
     * @return Collection
     */
    protected function getAttributes(Model $item, string $attribute): Collection
    {
        return $item->$attribute()->where('is_hidden', false)->get();
    }
}
