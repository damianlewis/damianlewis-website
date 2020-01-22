<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Components;

use DamianLewis\Portfolio\Classes\Transformers\ProjectTransformer;
use DamianLewis\Portfolio\Models\Project;
use DamianLewis\Transformer\Components\TransformerComponent;

class ProjectDetails extends TransformerComponent
{
    public function componentDetails()
    {
        return [
            'name' => 'Project',
            'description' => 'Get the details for a project.'
        ];
    }

    public function init(): void
    {
        $this->transformer = resolve(ProjectTransformer::class);
    }

    public function onRun(): void
    {
        $project = $this->getProjectBySlug($this->param('slug'));

        $this->page['project'] = $this->transformItem($project);
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
