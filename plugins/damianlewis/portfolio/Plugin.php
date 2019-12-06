<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio;

use Backend;
use Backend\Classes\ListColumn;
use DamianLewis\Portfolio\Models\Settings;
use Model;
use System\Classes\PluginBase;
use System\Models\File;

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
            'damianlewis.portfolio.access_settings' => [
                'tab' => 'Portfolio',
                'label' => 'Manage the portfolio settings.'
            ],
        ];
    }

    public function registerNavigation(): array
    {
        return [
            'portfolio' => [
                'label' => 'Portfolio',
                'url' => Backend::url('damianlewis/portfolio/projects'),
                'icon' => 'icon-archive',
                'iconSvg' => 'plugins/damianlewis/portfolio/assets/images/briefcase-icon.svg',
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

    public function registerSettings(): array
    {
        return [
            'settings' => [
                'label' => 'Portfolio',
                'description' => 'Manage the portfolio settings.',
                'category' => 'Portfolio',
                'icon' => 'icon-briefcase',
                'permissions' => ['damianlewis.portfolio.access_settings'],
                'class' => Settings::class,
                'order' => 999
            ]
        ];
    }

    public function registerListColumnTypes(): array
    {
        return [
            'status' => [$this, 'statusListColumn'],
            'visible' => [$this, 'visibleListColumn'],
            'featured' => [$this, 'featuredListColumn'],
            'previewimage' => [$this, 'previewImageListColumn']
        ];
    }

    /**
     * @param  string  $statusCode
     * @param  ListColumn  $column
     * @param  Model  $record
     * @return string
     */
    public function statusListColumn(string $statusCode, ListColumn $column, Model $record): string
    {
        switch ($statusCode) {
            case 'draft':
                $class = 'oc-icon-circle-o text-info';
                $name = $record->status->name;
                break;
            case 'active':
                $class = 'oc-icon-check text-success';
                $name = $record->status->name;
                break;
            case 'archived':
                $class = 'oc-icon-archive text-muted';
                $name = $record->status->name;
                break;
            default:
                $class = 'oc-icon-exclamation text-danger';
                $name = 'Unknown';
        }

        return '<span class="'.$class.'">'.$name.'</span>';
    }

    /**
     * @param  bool  $isVisible
     * @return string
     */
    public function visibleListColumn(bool $isVisible): string
    {
        if (!$isVisible) {
            $class = 'oc-icon-toggle-off text-muted';
        } else {
            $class = 'oc-icon-toggle-on text-success';
        }

        return '<span class="'.$class.'"></span>';
    }

    /**
     * @param  bool  $isFeatured
     * @return string
     */
    public function featuredListColumn(bool $isFeatured): string
    {
        if ($isFeatured) {
//            return '<span class="oc-icon-check text-success"></span>';
            return '<span class="list-badge badge-success"><i class="icon-check"></i></span>';
        }

        return '';
    }

    /**
     * @param  File|null  $image
     * @return string
     */
    public function previewImageListColumn(File $image = null): string
    {
        if ($image) {
            return '<img src="'.$image->getThumb(
                    Settings::get('preview_image_width'),
                    Settings::get('preview_image_height'),
                    ['mode' => Settings::get('preview_image_mode')]
                ).'">';
        }

        return '';
    }
}
