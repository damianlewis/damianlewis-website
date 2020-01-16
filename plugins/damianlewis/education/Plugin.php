<?php

declare(strict_types=1);

namespace DamianLewis\Education;

use App;
use Backend;
use DamianLewis\Education\Classes\Providers\TransformerServiceProvider;
use Damianlewis\Education\Components\QualificationsList;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function pluginDetails(): array
    {
        return [
            'name' => 'Education',
            'description' => 'No description provided yet...',
            'author' => 'Damian Lewis',
            'icon' => 'icon-graduation-cap'
        ];
    }

    public function boot()
    {
        App::register(TransformerServiceProvider::class);
    }

    public function registerComponents(): array
    {
        return [
            QualificationsList::class => 'qualificationsList'
        ];
    }

    public function registerPermissions(): array
    {
        return [
            'damianlewis.education.access_qualifications' => [
                'tab' => 'Education',
                'label' => 'Manage the qualifications.'
            ]
        ];
    }

    public function registerNavigation(): array
    {
        return [
            'education' => [
                'label' => 'Education',
                'url' => Backend::url('damianlewis/education/qualifications'),
                'icon' => 'icon-graduation-cap',
                'iconSvg' => 'plugins/damianlewis/education/assets/images/icon_education.svg',
                'permissions' => ['damianlewis.education.*'],
                'order' => 999,

                'sideMenu' => [
                    'qualifications' => [
                        'label' => 'Qualifications',
                        'url' => Backend::url('damianlewis/education/qualifications'),
                        'icon' => 'icon-certificate',
                        'permissions' => ['damianlewis.education.access_qualifications']
                    ]
                ]
            ]
        ];
    }
}
