<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Classes\Transformers;

use DamianLewis\Portfolio\Models\Project;
use DamianLewis\Transformer\Classes\FileTransformer;
use DamianLewis\Transformer\Classes\TransformerInterface;
use Model;
use October\Rain\Database\Collection;

class ProjectTransformer implements TransformerInterface
{
    use Transformers;

    public function __construct()
    {
        $this->fileTransformer = resolve(FileTransformer::class);
        $this->attributeTransformer = resolve(AttributeTransformer::class);
        $this->testimonialTransformer = resolve(TestimonialTransformer::class);
    }

    /**
     * @inheritDoc
     */
    public function transformItem(Model $item): array
    {
        if (!$item instanceof Project) {
            return [];
        }

        $data = $item->only([
            'title'
        ]);

        $skills = $this->getRelation($item, 'skills');
        $technologies = $this->getRelation($item, 'technologies');
        $testimonial = $this->getRelation($item, 'testimonial')->first();

        $data = array_merge($data, [
            'text' => $item->description,
            'tagLine' => $item->tag_line,
            'skills' => $this->transformAttributes($skills),
            'technologies' => $this->transformAttributes($technologies),
            'testimonial' => $this->transformTestimonial($testimonial),
            'mobileImage' => $this->transformFile($item->mobile_full_frame_image),
            'tabletImage' => $this->transformFile($item->tablet_full_frame_image),
            'desktopImage' => $this->transformFile($item->desktop_full_frame_image),
            'mockupImage' => $this->transformFile($item->mockup_multiple_in_sequence_image),
            'additionalImages' => $this->transformFiles($item->design_images)
        ]);

        return $data;
    }

    /**
     * Returns a collection of visible relationships.
     *
     * @param  Model  $item
     * @param  string  $relation
     * @return Collection
     */
    protected function getRelation(Model $item, string $relation): Collection
    {
        return $item->$relation()->where('is_hidden', false)->get();
    }
}
