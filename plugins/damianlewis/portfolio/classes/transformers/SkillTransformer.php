<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Classes\Transformers;

use DamianLewis\Api\Classes\Transformer;
use DamianLewis\Api\Classes\TransformerInterface;
use DamianLewis\Portfolio\Models\Skill;
use League\Fractal\Resource\Collection;
use Model;

class SkillTransformer extends Transformer implements TransformerInterface
{
    protected $defaultIncludes = [
        'skills'
    ];

    /**
     * @inheritDoc
     */
    public function transform(Model $item): ?array
    {
        if (!$item instanceof Skill) {
            return null;
        }

        $data = $item->only([
            'name'
        ]);

        $data = array_merge($data, [
            'isProjectOnly' => $item->is_project_only === true,
        ]);

        return $data;
    }

    /**
     * Includes the related skills in the transformed data.
     *
     * @param  Skill  $skill
     * @return Collection
     */
    protected function includeSkills(Skill $skill): Collection
    {
        return $this->collection($skill->getChildren(), resolve(SkillTransformer::class));
    }
}
