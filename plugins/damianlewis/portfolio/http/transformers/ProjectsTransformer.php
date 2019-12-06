<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Http\Transformers;

use DamianLewis\Portfolio\Classes\Transformable;
use DamianLewis\Portfolio\Classes\Transformer;
use DamianLewis\Portfolio\Models\Project;
use Model;

//use ApplicationException;

class ProjectsTransformer extends Transformer implements Transformable
{

    /**
     * Transform the given project to include the attributes required by the API.
     *
     * @param  Model  $item
     *
     * @return array
     */
    public function transformItem(Model $item): array
    {
        if (!$item instanceof Project) {
//            throw new ApplicationException(
//                'Instance of Project expected, but '.class_basename($item).' provided.'
//            );
            return [];
        }

//        $project = Project::create($item->attributes);

        return [
            'title' => $item['title'],
            'description' => $item['description'],
//            'status' => $item['status_id']
//            'title' => $project->title,
//            'description' => $project->description,
//            'active' => (boolean) $project->is_active
        ];
    }
}
