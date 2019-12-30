<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Classes\Transformers;

use DamianLewis\Portfolio\Classes\UrlGenerator;
use DamianLewis\Portfolio\Classes\UrlGeneratorInterface;
use DamianLewis\Portfolio\Models\Project;
use Model;

class ProjectsTransformer extends Transformer implements TransformerInterface, UrlGeneratorInterface
{
    use UrlGenerator;

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

        $fileTransformer = resolve(FileTransformer::class);

        $data = $item->only([
            'title'
        ]);

        $data = array_merge($data, [
            'text' => $item->summary,
            'image' => $fileTransformer->transformItem($item->mockup_multiple_image),
            'imageReversed' => $fileTransformer->transformItem($item->mockup_multiple_reversed_image),
            'url' => $this->getUrl([$item->slug])
        ]);

        return $data;
    }
}
