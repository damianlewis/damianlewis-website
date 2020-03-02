<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Classes\Transformers;

use DamianLewis\Api\Classes\TransformerInterface;
use DamianLewis\Portfolio\Models\Project;
use Model;

class ProjectListTransformer extends ProjectItemTransformer implements TransformerInterface
{
    /**
     * @inheritDoc
     */
    public function transform(Model $item): ?array
    {
        if (!$item instanceof Project) {
            return null;
        }

        $data = parent::transform($item);

        $data = array_merge($data, [
            'mockupImageReversed' => $this->transformFile(
                $item->mockup_multiple_reversed_image,
                $this->imageTransformer
            )
        ]);

        return $data;
    }
}
