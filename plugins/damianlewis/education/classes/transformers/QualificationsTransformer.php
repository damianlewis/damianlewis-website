<?php

declare(strict_types=1);

namespace DamianLewis\Education\Classes\Transformers;

use DamianLewis\Education\Models\Qualification;
use DamianLewis\Transformer\Classes\Transformer;
use DamianLewis\Transformer\Classes\TransformerInterface;
use Model;

class QualificationsTransformer extends Transformer implements TransformerInterface
{
    /**
     * @var bool
     */
    protected bool $includeCompletedDate;

    /**
     * @inheritDoc
     */
    public function transformItem(Model $item): array
    {
        if (!$item instanceof Qualification) {
            return [];
        }

        $data = $item->only([
            'title',
            'score'
        ]);

        if ($this->includeCompletedDate === true) {
            $data = array_add($data, 'completedDate', $item->completed_at);
        }

        return $data;
    }

    public function setIncludeCompletedDate(bool $isIncluded): void
    {
        $this->includeCompletedDate = $isIncluded;
    }
}