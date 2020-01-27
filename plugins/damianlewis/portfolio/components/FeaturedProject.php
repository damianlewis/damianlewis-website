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
        $project = $this->getFirstActiveFeaturedProject();

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
     * Returns the first active featured project from the database.
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
}
