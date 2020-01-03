<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Components;

use Cms\Classes\ComponentBase;
use DamianLewis\Portfolio\Classes\Transformers\ProjectTransformer;
use DamianLewis\Portfolio\Models\Project as ProjectModel;

class Project extends ComponentBase
{
    /**
     * @var ProjectTransformer
     */
    protected $transformer;

    /**
     * @var array
     */
    protected $transformedProject;

    /**
     * @var ProjectModel|null
     */
    protected $item;

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
        $this->item = $this->getProjectBySlug($this->param('slug'));

        $this->page['project'] = $this->getTransformedProject();
    }

    /**
     * Returns a project from the database with the given slug.
     *
     * @param  string  $slug
     * @return ProjectModel|null
     */
    protected function getProjectBySlug(string $slug): ?ProjectModel
    {
        return ProjectModel::query()
            ->active()
            ->visible()
            ->where('slug', $slug)
            ->first();
    }

    /**
     * Returns the transformed project.
     *
     * @return array
     */
    protected function getTransformedProject(): array
    {
        if ($this->transformedProject !== null) {
            return $this->transformedProject;
        }

        return $this->transformedProject = $this->transformer->transformItem($this->item);
    }
}
