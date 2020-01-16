<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio;

use App;
use Backend;
use DamianLewis\Portfolio\Classes\Providers\TransformerServiceProvider;
use DamianLewis\Portfolio\Components\ClientLogos;
use DamianLewis\Portfolio\Components\FeaturedProject;
use DamianLewis\Portfolio\Components\CategorisedSkills;
use DamianLewis\Portfolio\Components\FeaturedTestimonial;
use DamianLewis\Portfolio\Components\ProjectDetails;
use DamianLewis\Portfolio\Components\ProjectsList;
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
            ClientLogos::class => 'clientLogos',
            FeaturedProject::class => 'featuredProject',
            ProjectDetails::class => 'projectDetails',
            ProjectsList::class => 'projectsList',
            CategorisedSkills::class => 'categorisedSkills',
            FeaturedTestimonial::class => 'featuredTestimonial'
        ];
    }

    public function registerPermissions(): array
    {
        return [
            'damianlewis.portfolio.access_projects' => [
                'tab' => 'Portfolio',
                'label' => 'Manage the projects.'
            ],
            'damianlewis.portfolio.access_skills' => [
                'tab' => 'Portfolio',
                'label' => 'Manage the skills.'
            ],
            'damianlewis.portfolio.access_categories' => [
                'tab' => 'Portfolio',
                'label' => 'Manage the skill categories.'
            ],
            'damianlewis.portfolio.access_clients' => [
                'tab' => 'Portfolio',
                'label' => 'Manage the client list.'
            ],
            'damianlewis.portfolio.access_testimonials' => [
                'tab' => 'Portfolio',
                'label' => 'Manage the testimonials.'
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
                        'permissions' => ['damianlewis.portfolio.access_skills']
                    ],
                    'categories' => [
                        'label' => 'Categories',
                        'url' => Backend::url('damianlewis/portfolio/categories'),
                        'icon' => 'icon-list-ul',
                        'permissions' => ['damianlewis.portfolio.access_categories']
                    ],
                    'clients' => [
                        'label' => 'Clients',
                        'url' => Backend::url('damianlewis/portfolio/clients'),
                        'icon' => 'icon-users',
                        'permissions' => ['damianlewis.portfolio.access_clients']
                    ],
                    'testimonials' => [
                        'label' => 'Testimonials',
                        'url' => Backend::url('damianlewis/portfolio/testimonials'),
                        'icon' => 'icon-thumbs-up',
                        'permissions' => ['damianlewis.portfolio.access_testimonials']
                    ]
                ]
            ]
        ];
    }
}
