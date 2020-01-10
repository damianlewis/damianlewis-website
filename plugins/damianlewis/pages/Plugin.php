<?php

declare(strict_types=1);

namespace DamianLewis\Pages;

use App;
use Backend;
use DamianLewis\Pages\Classes\Providers\TransformerServiceProvider;
use DamianLewis\Pages\Components\HeroComponent;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function pluginDetails(): array
    {
        return [
            'name' => 'Pages',
            'description' => 'Manage the static page content.',
            'author' => 'Damian Lewis',
            'icon' => 'icon-files-o'
        ];
    }

    public function boot()
    {
        App::register(TransformerServiceProvider::class);
    }

    public function registerComponents(): array
    {
        return [
            HeroComponent::class => 'heroComponent'
        ];
    }

    public function registerPermissions(): array
    {
        return [
            'damianlewis.pages.access_heroes' => [
                'tab' => 'Pages',
                'label' => 'Manage the hero sections.'
            ],
        ];
    }

    public function registerNavigation(): array
    {
        return [
            'pages' => [
                'label' => 'Pages',
                'url' => Backend::url('damianlewis/pages/heroes'),
                'icon' => 'icon-files-o',
                'iconSvg' => 'plugins/damianlewis/pages/assets/images/icon_pages.svg',
                'permissions' => ['damianlewis.pages.*'],
                'order' => 999,

                'sideMenu' => [
                    'heroes' => [
                        'label' => 'Heroes',
                        'url' => Backend::url('damianlewis/pages/heroes'),
                        'icon' => 'icon-image',
                        'permissions' => ['damianlewis.page.access_heroes']
                    ]
                ]
            ]
        ];
    }
}
