<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Http\Controllers;

use DamianLewis\Portfolio\Classes\ApiController;
use DamianLewis\Portfolio\Http\Transformers\ProjectsTransformer;
use DamianLewis\Portfolio\Models\Project;
use Illuminate\Http\JsonResponse;

class ProjectsController extends ApiController
{
    /**
     * @var ProjectsTransformer
     */
    protected $transformer;

    /**
     * ProjectsController constructor.
     *
     * @param  ProjectsTransformer  $transformer
     */
    public function __construct(ProjectsTransformer $transformer)
    {
        parent::__construct();

        $this->transformer = $transformer;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $projects = Project::all();

        return $this->respond([
            'data' => $this->transformer->transformCollection($projects)
        ]);
    }

    /**
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $project = Project::find($id);

        if (!$project) {
            return $this->respondedNotFound('Project not found');
        }

//        try {
//            $data = $this->transformer->transformItem($project);
//        } catch (\ApplicationException $exception) {
//            return
//        }

        return $this->respond([
            'data' => $this->transformer->transformItem($project)
        ]);
    }

}
