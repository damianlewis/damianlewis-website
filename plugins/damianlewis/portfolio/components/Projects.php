<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Components;

use Cms\Classes\ComponentBase;
use Cms\Classes\Page;
use DamianLewis\Portfolio\Classes\Transformers\ProjectListTransformer;
use DamianLewis\Portfolio\Models\Project;
use October\Rain\Database\Collection;

class Projects extends ComponentBase
{
    /**
     * @var array|null
     */
    protected ?array $transformedProjects = null;

    /**
     * @var ProjectListTransformer
     */
    protected ProjectListTransformer $transformer;

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
                'default' => 'sort_order'
            ],
            'orderDirection' => [
                'title' => 'Order direction',
                'type' => 'dropdown',
                'default' => 'asc'
            ],
            'featured' => [
                'title' => 'Featured',
                'description' => 'Display only featured projects.',
                'type' => 'checkbox',
                'default' => false
            ],
            'limit' => [
                'title' => 'Maximum',
                'description' => 'Maximum number of projects to display.',
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

    public function init(): void
    {
        $this->transformer = resolve(ProjectListTransformer::class);
    }

    public function onRun(): void
    {
        $projects = $this->getProjects();

        $this->transformer->setBasePath($this->property('projectPage'));
        $this->page['projects'] = $this->transformProjects($projects);
    }

    /**
     * Returns an array of order by options.
     *
     * @return array
     */
    public function getOrderByOptions(): array
    {
        return Project::$orderByOptions;
    }

    /**
     * Returns an array of order direction options.
     *
     * @return array
     */
    public function getOrderDirectionOptions(): array
    {
        return Project::$orderDirectionOptions;
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
     * Returns an ordered collection of projects from the database.
     *
     * @return Collection
     */
    protected function getProjects(): Collection
    {
        $options = [
            'featured' => $this->property('featured') == true,
            'limit' => (int) $this->property('limit'),
            'orderBy' => $this->property('orderBy'),
            'orderDirection' => $this->property('orderDirection')
        ];

        return Project::frontEndCollection($options)->get();
    }

    /**
     * Returns an array of transformed projects.
     *
     * @param  Collection  $projects
     * @return array
     */
    protected function transformProjects(Collection $projects): array
    {
        if ($this->transformedProjects !== null) {
            return $this->transformedProjects;
        }

        return $this->transformedProjects = $this->transformer->transformCollection($projects);
    }
}
