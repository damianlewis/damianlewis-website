<?php

declare(strict_types=1);

namespace DamianLewis\Education\Classes\Transformers;

use DamianLewis\Api\Classes\Transformer;
use DamianLewis\Api\Classes\TransformerInterface;
use DamianLewis\Education\Models\Qualification;
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
    public function transform(Model $item): ?array
    {
        if (!$item instanceof Qualification) {
            return null;
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

    /**
     * Set to true to include the completed date in the transformed data.
     *
     * @param  bool  $isIncluded
     */
    public function setIncludeCompletedDate(bool $isIncluded): void
    {
        $this->includeCompletedDate = $isIncluded;
    }
}