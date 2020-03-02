<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Components;

use DamianLewis\Api\Components\TransformerComponent;
use DamianLewis\Portfolio\Classes\Transformers\ProjectTransformer;
use DamianLewis\Portfolio\Models\Project;

class ProjectDetails extends TransformerComponent
{
    public function componentDetails()
    {
        return [
            'name' => 'Project',
            'description' => 'Get the details for a project.'
        ];
    }

    public function onRun(): void
    {
        $transformer = resolve(ProjectTransformer::class);
        $project = $this->getProjectBySlug($this->param('slug'));

        $this->page['project'] = $this->transformItem($project, $transformer);
    }

    /**
     * Returns a project from the database with the given slug.
     *
     * @param  string  $slug
     * @return Project|null
     */
    protected function getProjectBySlug(string $slug): ?Project
    {
        return Project::active()
            ->visible()
            ->where('slug', $slug)
            ->first();
    }
}
