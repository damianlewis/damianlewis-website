<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Http\Controllers;

use DamianLewis\Api\Classes\ApiController;
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

        return $this->respondWithCollection($categories, $transformer);
    }

    /**
     * @param  int  $id
     * @param  CategoriesTransformer  $transformer
     * @return JsonResponse
     */
    public function show(int $id, CategoriesTransformer $transformer): JsonResponse
    {
        $category = Category::find($id);
//        $category = Category::active()
//            ->visible()
//            ->where('id', $id)
//            ->first();

        if (!$category) {
            return $this->respondedNotFound('Category not found');
        }

//        return $this->respond([
//            'data' => $transformer->transformItem($category)
//        ]);
//        return $this->respond([
//            'data' => $category->flattened_skills
//        ]);
        return $this->respondWithItem($category, $transformer);
    }
}
