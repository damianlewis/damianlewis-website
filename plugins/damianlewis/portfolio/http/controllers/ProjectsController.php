<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Http\Controllers;

use DamianLewis\Portfolio\Classes\ApiController;
use DamianLewis\Portfolio\Classes\Transformers\ProjectsTransformer;
use DamianLewis\Portfolio\Classes\Transformers\ProjectTransformer;
use DamianLewis\Portfolio\Models\Project;
use Illuminate\Http\JsonResponse;

class ProjectsController extends ApiController
{
    /**
     * @param  ProjectsTransformer  $transformer
     * @return JsonResponse
     */
    public function index(ProjectsTransformer $transformer): JsonResponse
    {
        $projects = Project::all();

        return $this->respond([
            'data' => $transformer->transformCollection($projects)
        ]);
    }

    /**
     * @param  int  $id
     * @param  ProjectTransformer  $transformer
     * @return JsonResponse
     */
    public function show(int $id, ProjectTransformer $transformer): JsonResponse
    {
        $project = Project::find($id);

        if (!$project) {
            return $this->respondedNotFound('Project not found');
        }

        return $this->respond([
            'data' => $transformer->transformItem($project)
        ]);
    }

}
