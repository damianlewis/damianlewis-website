<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Components;

use Cms\Classes\Page;
use DamianLewis\Api\Components\TransformerComponent;
use DamianLewis\Portfolio\Classes\Transformers\ProjectListTransformer;
use DamianLewis\Portfolio\Models\Project;
use Illuminate\Pagination\LengthAwarePaginator;
use October\Rain\Database\Collection;

class ProjectsList extends TransformerComponent
{
    /**
     * @var array
     */
    public array $projects;

    public function componentDetails(): array
    {
        return [
            'name' => 'Projects',
            'description' => 'Get a collection of projects.'
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
                'default' => true
            ],
            'notFeatured' => [
                'title' => 'Non featured',
                'description' => 'Display only non featured projects.',
                'type' => 'checkbox',
                'default' => true
            ],
            'projectPage' => [
                'title' => 'Project page',
                'description' => 'The page used to display the project details.',
                'type' => 'dropdown'
            ],
            'limit' => [
                'title' => 'Maximum',
                'description' => 'Maximum number of projects to display.',
                'type' => 'string',
                'validationPattern' => '^[\d]*$',
                'validationMessage' => 'The value can only contain numbers.',
            ],
            'usePagination' => [
                'group' => 'Pagination',
                'title' => 'Use pagination',
                'description' => 'Display projects.',
                'type' => 'checkbox',
                'default' => false
            ],
            'pageNumber' => [
                'group' => 'Pagination',
                'title' => 'Page number',
                'description' => 'This value is used to determine the current page.',
                'type' => 'string',
                'default' => '{{ :page }}'
            ]
        ];
    }

    public function onRun(): void
    {
        $transformer = resolve(ProjectListTransformer::class);
        $transformer->setBasePath($this->property('projectPage'));
        $transformer->setResourceId('slug');
//        $transformer->useAbsolutePath();

        if ($this->property('usePagination')) {
            $projects = $this->getPaginatedProjects();
            $transformedProjects = $this->transformPagination($projects, $transformer);
        } else {
            $projects = $this->getProjects();
            $transformedProjects = $this->transformCollection($projects, $transformer);
        }

        $this->page['projects'] = $this->projects = $transformedProjects;
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
            'notFeatured' => $this->property('notFeatured') == true,
            'limit' => (int) $this->property('limit'),
            'orderBy' => $this->property('orderBy'),
            'orderDirection' => $this->property('orderDirection')
        ];

        return Project::frontEndCollection($options)->get();
    }

    /**
     * Returns an ordered collection of paginated projects from the database.
     *
     * @return LengthAwarePaginator
     */
    protected function getPaginatedProjects(): LengthAwarePaginator
    {
        $options = [
            'orderBy' => $this->property('orderBy'),
            'orderDirection' => $this->property('orderDirection')
        ];

        $currentPage = (int) $this->property('pageNumber');
        $limit = (int) $this->property('limit');

        return Project::frontEndCollection()->paginate($limit, $currentPage);
    }
}
