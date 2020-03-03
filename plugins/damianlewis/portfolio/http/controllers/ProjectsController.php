<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Http\Controllers;

use DamianLewis\Api\Classes\ApiController;
use DamianLewis\Portfolio\Classes\Transformers\ProjectListTransformer;
use DamianLewis\Portfolio\Classes\Transformers\ProjectTransformer;
use DamianLewis\Portfolio\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectsController extends ApiController
{
    /**
     * @param  Request  $request
     * @param  ProjectListTransformer  $transformer
     * @return JsonResponse
     */
    public function index(Request $request, ProjectListTransformer $transformer): JsonResponse
    {
//        $paginator = Project::paginate(3);
//        $projects = Project::all();
//        $projects = Project::frontEndCollection()->get();
        $paginator = Project::frontEndCollection()->paginate(3);

        $transformer->setBasePath($request->path());
//        $transformer->setResourceId('id');
        $transformer->useAbsolutePath();

        return $this->respondWithPagination($paginator, $transformer);
//        return $this->respondWithCollection($projects, $transformer);
    }

    /**
     * @param  int  $id
     * @param  ProjectTransformer  $transformer
     * @return JsonResponse
     */
    public function show(int $id, ProjectTransformer $transformer): JsonResponse
    {
        $project = Project::find($id);
//        $project = Project::active()
//            ->visible()
//            ->where('id', $id)
//            ->first();

        if (!$project) {
            return $this->respondedNotFound('Project not found');
        }

        return $this->respondWithItem($project, $transformer);
    }

}
