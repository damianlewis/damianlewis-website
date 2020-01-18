<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Classes\Transformers;

use DamianLewis\Portfolio\Models\Service;
use DamianLewis\Transformer\Classes\CanTransform;
use DamianLewis\Transformer\Classes\Transformer;
use DamianLewis\Transformer\Classes\TransformerInterface;
use DamianLewis\Transformer\Classes\Transformers\FileTransformer;
use Model;

class ServicesTransformer extends Transformer implements TransformerInterface
{
    use CanTransform;

    /**
     * @var bool
     */
    protected bool $includeIcon;

    /**
     * @inheritDoc
     */
    public function transformItem(Model $item): array
    {
        if (!$item instanceof Service) {
            return [];
        }

        $data = $item->only([
            'title'
        ]);

        $data = array_merge($data, [
            'text' => $item->description,
        ]);

        if ($this->includeIcon === true) {
            $fileTransformer = resolve(FileTransformer::class);
            $data = array_add($data, 'icon', $this->transformItemOrNull($fileTransformer, $item->icon));
        }

        return $data;
    }

    public function setIncludeIcon(bool $isIncluded): void
    {
        $this->includeIcon = $isIncluded;
    }
}