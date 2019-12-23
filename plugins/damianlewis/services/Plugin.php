<?php

declare(strict_types=1);

namespace DamianLewis\Services;

use Backend;
use DamianLewis\Services\Components\FeaturedCategories;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function pluginDetails(): array
    {
        return [
            'name' => 'Services',
            'description' => 'Manage the skills and technologies offered to clients.',
            'author' => 'Damian Lewis',
            'icon' => 'icon-wrench'
        ];
    }

    public function registerComponents(): array
    {
        return [
            FeaturedCategories::class => 'featuredCategories'
        ];
    }

    public function registerPermissions(): array
    {
        return [
            'damianlewis.services.access_categories' => [
                'tab' => 'Services',
                'label' => 'Manage the service categories.'
            ],
        ];
    }

    public function registerNavigation(): array
    {
        return [
            'services' => [
                'label' => 'Services',
                'url' => Backend::url('damianlewis/services/categories'),
                'icon' => 'icon-wrench',
                'iconSvg' => 'plugins/damianlewis/services/assets/images/icon_tools.svg',
                'permissions' => ['damianlewis.services.*'],
                'order' => 999,

                'sideMenu' => [
                    'categories' => [
                        'label' => 'Categories',
                        'url' => Backend::url('damianlewis/services/categories'),
                        'icon' => 'icon-list-ul',
                        'permissions' => ['damianlewis.portfolio.access_categories']
                    ]
                ]
            ],
        ];
    }
}
