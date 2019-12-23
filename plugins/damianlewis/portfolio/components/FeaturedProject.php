<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Components;

use Cms\Classes\ComponentBase;
use Cms\Classes\Page;
use DamianLewis\Portfolio\Models\Project;

class FeaturedProject extends ComponentBase
{
    /**
     * @var Project|null
     */
    private $project;

    public function componentDetails(): array
    {
        return [
            'name' => 'Featured Project',
            'description' => 'Get a featured portfolio project.'
        ];
    }

    public function defineProperties(): array
    {
        return [
            'project' => [
                'title' => 'Project',
                'type' => 'dropdown'
            ],
            'projectPage' => [
                'title' => 'Project page',
                'description' => 'The page used to display the project details.',
                'type' => 'dropdown'
            ]
        ];
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
    public function getProjectOptions(): array
    {
        $activeProjects = Project::active()->get();

        return $activeProjects->pluck('title', 'id')->all();
    }

    public function onRun(): void
    {
        $id = (int) $this->property('project');

        $this->project = $this->getActiveProjectById($id);
    }

    /**
     * Returns a transformed project model for consumption by the frontend.
     *
     * @return array
     */
    public function item(): array
    {
        if (!$this->isAvailable()) {
            return [];
        }

        $this->setProjectUrl($this->project);

        return $this->transformProject($this->project);
    }

    /**
     * Returns true is a project model has been set for the component.
     *
     * @return bool
     */
    public function isAvailable(): bool
    {
        return !!$this->project;
    }

    /**
     * Returns the active project model with the given id.
     *
     * @param  int  $id
     * @return Project|null
     */
    protected function getActiveProjectById(int $id): ?Project
    {
        return Project::active()->where('id', $id)->first();
    }

    /**
     * Set the page URL for the  project.
     *
     * @param  Project  $project
     */
    protected function setProjectUrl(Project $project): void
    {
        $project->setUrl($this->property('projectPage'));
    }

    /**
     * Transforms a project model into the data required by the frontend.
     *
     * @param  Project  $project
     * @return array
     */
    protected function transformProject(Project $project): array
    {
        $data = $project->only([
            'title',
            'url'
        ]);

        return array_merge($data, [
            'text' => $project->summary,
            'image' => $project->mockup_multiple_image
        ]);
    }
}
