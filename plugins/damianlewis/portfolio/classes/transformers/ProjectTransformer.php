<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Classes\Transformers;

use DamianLewis\Portfolio\Models\Project;
use DamianLewis\Shared\Classes\HasRelation;
use DamianLewis\Transformer\Classes\CanTransform;
use DamianLewis\Transformer\Classes\Transformer;
use DamianLewis\Transformer\Classes\TransformerInterface;
use DamianLewis\Transformer\Classes\Transformers\FileTransformer;
use Model;

class ProjectTransformer extends Transformer implements TransformerInterface
{
    use CanTransform;
    use HasRelation;

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

        $fileTransformer = resolve(FileTransformer::class);
        $skillTransformer = resolve(SkillTransformer::class);
        $testimonialTransformer = resolve(TestimonialTransformer::class);

        $skills = $this->getRelation($item, 'skills');
        $technologies = $this->getRelation($item, 'technologies');
        $testimonial = $this->getRelation($item, 'testimonial')->first();

        $data = array_merge($data, [
            'text' => $item->description,
            'tagLine' => $item->tag_line,
            'skills' => $this->transformCollectionOrNull($skillTransformer, $skills),
            'technologies' => $this->transformCollectionOrNull($skillTransformer, $technologies),
            'testimonial' => $this->transformItemOrNull($testimonialTransformer, $testimonial),
            'mobileImage' => $this->transformItemOrNull($fileTransformer, $item->mobile_full_frame_image),
            'tabletImage' => $this->transformItemOrNull($fileTransformer, $item->tablet_full_frame_image),
            'desktopImage' => $this->transformItemOrNull($fileTransformer, $item->desktop_full_frame_image),
            'mockupImage' => $this->transformItemOrNull($fileTransformer, $item->mockup_multiple_in_sequence_image),
            'previewImage' => $this->transformItemOrNull($fileTransformer, $item->preview_image),
            'additionalImages' => $this->transformCollectionOrNull($fileTransformer, $item->design_images)
        ]);

        return $data;
    }
}
