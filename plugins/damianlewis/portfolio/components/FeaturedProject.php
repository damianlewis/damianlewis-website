<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Components;

use Cms\Classes\Page;
use DamianLewis\Portfolio\Classes\Transformers\ProjectItemTransformer;
use DamianLewis\Portfolio\Models\Project;
use DamianLewis\Transformer\Components\TransformerComponent;

class FeaturedProject extends TransformerComponent
{
    /**
     * @var ProjectItemTransformer
     */
    protected $transformer;

    public function componentDetails(): array
    {
        return [
            'name' => 'Featured Project',
            'description' => 'Select a project to be featured.'
        ];
    }

    public function defineProperties(): array
    {
        return [
            'id' => [
                'title' => 'Project',
                'type' => 'dropdown',
                'description' => 'The project to display.',
                'placeholder' => 'Select a project'
            ],
            'projectPage' => [
                'title' => 'Project page',
                'description' => 'The page used to display the project details.',
                'type' => 'dropdown'
            ]
        ];
    }

    public function init(): void
    {
        $this->transformer = resolve(ProjectItemTransformer::class);
    }

    public function onRun(): void
    {
        $id = (int) $this->property('id');
        $project = $this->getProjectById($id);

        if ($project !== null) {
            $this->transformer->setBasePath($this->property('projectPage'));
            $this->page['project'] = $this->transformItem($project);
        }
    }

    /**
     * Return an array of CMS pages.
     *
     * @return array
     */
    public function getProjectPageOptions(): array
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    /**
     * Returns an array of active projects with the id as the key and title as the value.
     *
     * @return array
     */
    public function getIdOptions(): array
    {
        $projects = Project::active()->get();

        return $projects->pluck('title', 'id')->all();
    }

    /**
     * Returns a project from the database with the given id.
     *
     * @param  int  $id
     * @return ProjectDetails|null
     */
    protected function getProjectById(int $id): ?Project
    {
        return Project::active()
            ->visible()
            ->where('id', $id)
            ->first();
    }
}
