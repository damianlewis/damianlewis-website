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
        $data = parent::transformItem($item);

        if (!$item instanceof Project) {
            return [];
        }

        $data = array_merge($data, [
            'imageReversed' => $this->transformFile($item->mockup_multiple_reversed_image),
        ]);

        return $data;
    }
}
