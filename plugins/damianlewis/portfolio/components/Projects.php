<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Components;

use Cms\Classes\ComponentBase;
use Cms\Classes\Page;
use DamianLewis\Portfolio\Models\Project;
use October\Rain\Database\Collection;

class Projects extends ComponentBase
{
    /**
     * @var Collection|null
     */
    public $projects;

    public function componentDetails(): array
    {
        return [
            'name' => 'Projects',
            'description' => 'Get a collection of active projects.'
        ];
    }

    public function defineProperties(): array
    {
        return [
            'orderBy' => [
                'title' => 'Order by',
                'description' => 'The attribute to order the projects by.',
                'type' => 'dropdown',
                'options' => [
                    'sort_order' => 'Sort Order',
                    'completed_at' => 'Completed Date',
                    'created_at' => 'Created Date',
                    'updated_at' => 'Updated Date',
                    'title' => 'Title'
                ],
                'default' => 'sort_order'
            ],
            'orderDirection' => [
                'title' => 'Order direction',
                'type' => 'dropdown',
                'options' => [
                    'asc' => 'Ascending',
                    'desc' => 'Descending'
                ],
                'default' => 'asc'
            ],
            'featured' => [
                'title' => 'Featured',
                'description' => 'Only display featured projects.',
                'type' => 'checkbox',
                'default' => false
            ],
            'limit' => [
                'title' => 'Maximum',
                'description' => 'Maximum number of project to display.',
                'type' => 'string',
                'validationPattern' => '^[\d]*$',
                'validationMessage' => 'The value can only contain numbers.',
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

    public function onRun()
    {
        $this->projects = $this->page['projects'] = $this->getActiveProjects();

        $this->setUrlForProjects($this->projects);
    }

    /**
     * Return an ordered collection of active portfolio projects.
     *
     * @return Collection
     */
    protected function getActiveProjects(): Collection
    {
        $limit = $this->property('limit');

        return Project::active()
            ->when($this->property('featured'), function ($query) {
                return $query->featured();
            })
            ->when($limit > 0, function ($query) use ($limit) {
                return $query->take($limit);
            })
            ->orderBy($this->property('orderBy'), $this->property('orderDirection'))
            ->get();
    }

    /**
     * Set the page URL for the portfolio projects.
     *
     * @param  Collection  $projects
     */
    protected function setUrlForProjects(Collection $projects): void
    {
        $projects->each(function (Project $project) {
            $project->setUrl($this->property('projectPage'), $this->controller);
        });
    }
}
