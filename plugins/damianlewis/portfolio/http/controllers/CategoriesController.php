<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Http\Controllers;

use DamianLewis\Portfolio\Classes\ApiController;
use DamianLewis\Portfolio\Classes\Transformers\CategoriesTransformer;
use DamianLewis\Portfolio\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoriesController extends ApiController
{
    /**
     * @param  CategoriesTransformer  $transformer
     * @return JsonResponse
     */
    public function index(CategoriesTransformer $transformer): JsonResponse
    {
        $categories = Category::root()->get();

        return $this->respond([
            'data' => $transformer->transformCollection($categories)
        ]);
    }

    /**
     * @param  int  $id
     * @param  CategoriesTransformer  $transformer
     * @return JsonResponse
     */
    public function show(int $id, CategoriesTransformer $transformer): JsonResponse
    {
        $category = Category::find($id);

        if (!$category) {
            return $this->respondedNotFound('Project not found');
        }

        return $this->respond([
            'data' => $transformer->transformItem($category)
        ]);
    }

}