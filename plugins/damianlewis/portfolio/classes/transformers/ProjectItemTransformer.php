<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Classes\Transformers;

use DamianLewis\Portfolio\Models\Project;
use DamianLewis\Shared\Classes\CommonTransformers;
use DamianLewis\Shared\Classes\UrlGenerator;
use DamianLewis\Transformer\Classes\FileTransformer;
use DamianLewis\Transformer\Classes\Transformer;
use DamianLewis\Transformer\Classes\TransformerInterface;
use Model;

class ProjectItemTransformer extends Transformer implements TransformerInterface
{
    use UrlGenerator;
    use CommonTransformers;

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

        if ($slug = $item->slug !== null) {
            $slug = $this->getUrl([$item->slug]);
        }

        $data = array_merge($data, [
            'text' => $item->summary,
            'image' => $this->transformFile($item->mockup_multiple_image),
            'url' => $slug
        ]);

        return $data;
    }
}