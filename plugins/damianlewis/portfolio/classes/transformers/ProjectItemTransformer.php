<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Classes\Transformers;

use DamianLewis\Api\Classes\Transformer;
use DamianLewis\Api\Classes\TransformerInterface;
use DamianLewis\Api\Classes\Transformers\ImageTransformer;
use DamianLewis\Api\Classes\UriGenerator;
use DamianLewis\Portfolio\Models\Project;
use Model;

class ProjectItemTransformer extends Transformer implements TransformerInterface
{
    use UriGenerator;

    /**
     * @var ImageTransformer
     */
    protected $imageTransformer;

    public function __construct()
    {
        $this->imageTransformer = resolve(ImageTransformer::class);
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

        $data = array_merge($data, [
            'text' => $item->summary,
            'previewImage' => $this->transformFile($item->preview_image, $this->imageTransformer),
            'mockupImage' => $this->transformFile($item->mockup_multiple_image, $this->imageTransformer),
            'link' => [
                'rel' => 'self',
                'uri' => $this->getUri([$item->{$this->resourceId}])
            ]
        ]);

        return $data;
    }
}
