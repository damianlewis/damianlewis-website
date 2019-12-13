<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio;

use Backend;
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

    public function registerComponents(): array
    {
        return [
            Projects::class => 'projects'
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
            ]
        ];
    }

    public function registerNavigation(): array
    {
        return [
            'portfolio' => [
                'label' => 'Portfolio',
                'url' => Backend::url('damianlewis/portfolio/projects'),
                'icon' => 'icon-archive',
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
                    ]
                ]
            ]
        ];
    }
}
