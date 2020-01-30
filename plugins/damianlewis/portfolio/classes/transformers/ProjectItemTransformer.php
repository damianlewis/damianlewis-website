<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Classes\Transformers;

use DamianLewis\Portfolio\Models\Project;
use DamianLewis\Shared\Classes\UrlGenerator;
use DamianLewis\Transformer\Classes\CanTransform;
use DamianLewis\Transformer\Classes\Transformer;
use DamianLewis\Transformer\Classes\TransformerInterface;
use DamianLewis\Transformer\Classes\Transformers\FileTransformer;
use Model;

class ProjectItemTransformer extends Transformer implements TransformerInterface
{
    use CanTransform;
    use UrlGenerator;

    /**
     * @var FileTransformer
     */
    protected $fileTransformer;

    public function __construct()
    {
        $this->fileTransformer = resolve(FileTransformer::class);
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

        $slug = $item->slug;

        $data = array_merge($data, [
            'text' => $item->summary,
            'previewImage' => $this->transformItemOrNull($this->fileTransformer, $item->preview_image),
            'mockupImage' => $this->transformItemOrNull($this->fileTransformer, $item->mockup_multiple_image),
            'url' => $this->getUrlOrNull($slug, [$slug])
        ]);

        return $data;
    }
}