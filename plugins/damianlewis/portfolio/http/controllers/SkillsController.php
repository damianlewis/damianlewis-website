<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Http\Controllers;

use DamianLewis\Portfolio\Classes\ApiController;
use DamianLewis\Portfolio\Classes\Transformers\SkillTransformer;
use DamianLewis\Portfolio\Models\Skill;
use Illuminate\Http\JsonResponse;

class SkillsController extends ApiController
{
    /**
     * @param  SkillTransformer  $transformer
     * @return JsonResponse
     */
    public function index(SkillTransformer $transformer): JsonResponse
    {
        $skills = Skill::all();

        return $this->respond([
            'data' => $transformer->transformCollection($skills)
        ]);
    }

    /**
     * @param  int  $id
     * @param  SkillTransformer  $transformer
     * @return JsonResponse
     */
    public function show(int $id, SkillTransformer $transformer): JsonResponse
    {
        $skill = Skill::find($id);

        if (!$skill) {
            return $this->respondedNotFound('Project not found');
        }

        return $this->respond([
            'data' => $transformer->transformItem($skill)
        ]);
//        return $this->respond([
//            'data' => $skill->root_category
//        ]);
    }
}