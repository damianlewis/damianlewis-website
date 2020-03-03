<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Classes\Transformers;

use DamianLewis\Api\Classes\Transformer;
use DamianLewis\Api\Classes\TransformerInterface;
use DamianLewis\Api\Classes\Transformers\ImageTransformer;
use DamianLewis\Portfolio\Models\Project;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use Model;

class ProjectTransformer extends Transformer implements TransformerInterface
{
    protected $defaultIncludes = [
        'skills',
        'technologies',
        'testimonial'
    ];

    /**
     * @var SkillTransformer
     */
    private $skillTransformer;

    /**
     * ProjectTransformer constructor.
     */
    public function __construct()
    {
        $this->skillTransformer = resolve(SkillTransformer::class);
    }

    /**
     * @inheritDoc
     */
    public function transform(Model $item): ?array
    {
        if (!$item instanceof Project) {
            return null;
        }

        $data = $item->only([
            'title'
        ]);

        $imageTransformer = resolve(ImageTransformer::class);

        $data = array_merge($data, [
            'text' => $item->description,
            'tagLine' => $item->tag_line,
            'mobileImage' => $this->transformFile($item->mobile_full_frame_image, $imageTransformer),
            'tabletImage' => $this->transformFile($item->tablet_full_frame_image, $imageTransformer),
            'desktopImage' => $this->transformFile($item->desktop_full_frame_image, $imageTransformer),
            'mockupImage' => $this->transformFile($item->mockup_multiple_in_sequence_image, $imageTransformer),
            'previewImage' => $this->transformFile($item->preview_image, $imageTransformer),
            'additionalImages' => $this->transformFiles($item->design_images, $imageTransformer),
        ]);

        return $data;
    }

    /**
     * Includes the related skills in the transformed data.
     *
     * @param  Project  $project
     * @return Collection
     */
    protected function includeSkills(Project $project): Collection
    {
        return $this->collection($project->skills, $this->skillTransformer);
    }

    /**
     * Includes the related technologies in the transformed data.
     *
     * @param  Project  $project
     * @return Collection
     */
    protected function includeTechnologies(Project $project): Collection
    {
        return $this->collection($project->technologies, $this->skillTransformer);
    }

    /**
     * Includes the related testimonial in the transformed data.
     *
     * @param  Project  $project
     * @return Item|null
     */
    protected function includeTestimonial(Project $project): ?Item
    {
        if ($project->testimonial !== null) {
            return $this->item($project->testimonial, resolve(TestimonialTransformer::class));
        }

        return null;
    }
}
