<?php

declare(strict_types=1);

namespace DamianLewis\CustomColumns;

use Backend\Classes\ListColumn;
use DamianLewis\CustomColumns\Models\Settings;
use Model;
use System\Classes\PluginBase;
use System\Models\File;

class Plugin extends PluginBase
{
    public function pluginDetails(): array
    {
        return [
            'name' => 'Custom Columns',
            'description' => 'Provides custom columns for the backend lists.',
            'author' => 'Damian Lewis',
            'icon' => 'icon-columns'
        ];
    }

    public function registerPermissions(): array
    {
        return [
            'damianlewis.custom_columns.access_settings' => [
                'tab' => 'Portfolio',
                'label' => 'Manage the portfolio settings.'
            ],
        ];
    }

    public function registerSettings(): array
    {
        return [
            'settings' => [
                'label' => 'Custom Columns',
                'description' => 'Manage the settings for the custom backend column types.',
                'icon' => 'icon-columns',
                'permissions' => ['damianlewis.custom_columns.access_settings'],
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
            return '<span class="oc-icon-check text-success"></span>';
//            return '<span class="list-badge badge-success"><i class="icon-check"></i></span>';
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
