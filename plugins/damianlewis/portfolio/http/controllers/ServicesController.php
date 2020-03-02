<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Http\Controllers;

use DamianLewis\Api\Classes\ApiController;
use DamianLewis\Portfolio\Classes\Transformers\ServicesTransformer;
use DamianLewis\Portfolio\Models\Service;
use Illuminate\Http\JsonResponse;

class ServicesController extends ApiController
{
    /**
     * @param  ServicesTransformer  $transformer
     * @return JsonResponse
     */
    public function index(ServicesTransformer $transformer): JsonResponse
    {
        $transformer->setIncludeIcon(true);

        $services = Service::all();

        return $this->respondWithCollection($services, $transformer);
    }

    /**
     * @param  int  $id
     * @param  ServicesTransformer  $transformer
     * @return JsonResponse
     */
    public function show(int $id, ServicesTransformer $transformer): JsonResponse
    {
        $transformer->setIncludeIcon(true);

        $service = Service::find($id);

        if (!$service) {
            return $this->respondedNotFound('Service not found');
        }

        return $this->respondWithItem($service, $transformer);
    }
}