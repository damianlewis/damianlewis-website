<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio;

use App;
use Backend;
use DamianLewis\Portfolio\Classes\Providers\TransformerServiceProvider;
use DamianLewis\Portfolio\Components\ClientLogos;
use DamianLewis\Portfolio\Components\FeaturedProject;
use DamianLewis\Portfolio\Components\Project;
use DamianLewis\Portfolio\Components\Projects;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function pluginDetails(): array
    {
        return [
            'name' => 'Portfolio',
            'description' => 'Create and manage portfolios for showcasing projects.',
            'author' => 'Damian Lewis',
            'icon' => 'icon-briefcase'
        ];
    }

    public function boot()
    {
        App::register(TransformerServiceProvider::class);
    }

    public function registerComponents(): array
    {
        return [
            Projects::class => 'projects',
            Project::class => 'project',
            FeaturedProject::class => 'featuredProject',
            ClientLogos::class => 'clientLogos'
        ];
    }

    public function registerPermissions(): array
    {
        return [
            'damianlewis.portfolio.access_projects' => [
                'tab' => 'Portfolio',
                'label' => 'Manage the projects.'
            ],
            'damianlewis.portfolio.access_project_skills' => [
                'tab' => 'Portfolio',
                'label' => 'Manage the project skills.'
            ],
            'damianlewis.portfolio.access_project_technologies' => [
                'tab' => 'Portfolio',
                'label' => 'Manage the project technologies.'
            ],
            'damianlewis.portfolio.access_clients' => [
                'tab' => 'Portfolio',
                'label' => 'Manage the client list.'
            ]
        ];
    }

    public function registerNavigation(): array
    {
        return [
            'portfolio' => [
                'label' => 'Portfolio',
                'url' => Backend::url('damianlewis/portfolio/projects'),
                'icon' => 'icon-briefcase',
                'iconSvg' => 'plugins/damianlewis/portfolio/assets/images/icon_briefcase.svg',
                'permissions' => ['damianlewis.portfolio.*'],
                'order' => 999,

                'sideMenu' => [
                    'projects' => [
                        'label' => 'Projects',
                        'url' => Backend::url('damianlewis/portfolio/projects'),
                        'icon' => 'icon-trophy',
                        'permissions' => ['damianlewis.portfolio.access_projects']
                    ],
                    'skills' => [
                        'label' => 'Skills',
                        'url' => Backend::url('damianlewis/portfolio/skills'),
                        'icon' => 'icon-graduation-cap',
                        'permissions' => ['damianlewis.portfolio.access_project_skills']
                    ],
                    'technologies' => [
                        'label' => 'Technologies',
                        'url' => Backend::url('damianlewis/portfolio/technologies'),
                        'icon' => 'icon-desktop',
                        'permissions' => ['damianlewis.portfolio.access_project_technologies']
                    ],
                    'clients' => [
                        'label' => 'Clients',
                        'url' => Backend::url('damianlewis/portfolio/clients'),
                        'icon' => 'icon-users',
                        'permissions' => ['damianlewis.portfolio.access_clients']
                    ]
                ]
            ]
        ];
    }
}
