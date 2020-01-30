<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Components;

use Cms\Classes\Page;
use DamianLewis\Portfolio\Classes\Transformers\ProjectItemTransformer;
use DamianLewis\Portfolio\Models\Project;
use DamianLewis\Transformer\Components\TransformerComponent;
use October\Rain\Database\Collection;

class FeaturedProject extends TransformerComponent
{
    /**
     * @var ProjectItemTransformer
     */
    protected $transformer;

    /**
     * @var array
     */
    public array $project;

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
        if ($this->property('id') !== null) {
            $id = (int) $this->property('id');
            $project = $this->getFeaturedProjectById($id);
        } else {
            $project = $this->getFirstActiveFeaturedProject();
        }

        if ($project !== null) {
            $this->transformer->setBasePath($this->property('projectPage'));
            $this->page['project'] = $this->project = $this->transformItem($project);
        }
    }

    /**
     * Returns an array of featured projects with the id as the key and title as the value.
     *
     * @return array
     */
    public function getIdOptions(): array
    {
        $projects = Project::active()
            ->featured()
            ->get();

        return $projects->pluck('title', 'id')->all();
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
     * Returns the first featured project from the database.
     *
     * @return ProjectDetails|null
     */
    protected function getFirstActiveFeaturedProject(): ?Project
    {
        return Project::active()
            ->featured()
            ->visible()
            ->first();
    }

    /**
     * Returns a featured project from the database with the given id.
     *
     * @param  int  $id
     * @return Project|null
     */
    protected function getFeaturedProjectById(int $id): ?Project
    {
        return Project::active()
            ->featured()
            ->visible()
            ->where('id', $id)
            ->first();
    }
}
