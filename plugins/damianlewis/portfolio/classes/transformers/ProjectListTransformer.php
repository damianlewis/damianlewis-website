<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Classes\Transformers;

use DamianLewis\Portfolio\Models\Project;
use DamianLewis\Transformer\Classes\TransformerInterface;
use Model;

class ProjectListTransformer extends ProjectItemTransformer implements TransformerInterface
{
    /**
     * @inheritDoc
     */
    public function transformItem(Model $item): array
    {
        if (!$item instanceof Project) {
            return [];
        }

        $data = parent::transformItem($item);

        $data = array_merge($data, [
            'mockupImageReversed' => $this->transformItemOrNull(
                $this->fileTransformer,
                $item->mockup_multiple_reversed_image
            )
        ]);

        return $data;
    }
}
