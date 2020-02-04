<?php

declare(strict_types=1);

namespace DamianLewis\Shared;

use App;
use Backend\Classes\ListColumn;
use DamianLewis\Shared\Classes\Providers\TransformerServiceProvider;
use DamianLewis\Shared\Models\CustomColumns;
use Model;
use System\Classes\PluginBase;
use System\Models\File;

class Plugin extends PluginBase
{
    public function pluginDetails(): array
    {
        return [
            'name' => 'Shared',
            'description' => 'Common functionality used across plugins.',
            'author' => 'Damian Lewis',
            'icon' => 'icon-leaf'
        ];
    }

    public function boot()
    {
        App::register(TransformerServiceProvider::class);
    }

    public function registerSettings(): array
    {
        return [
            'customColumns' => [
                'label' => 'Custom Columns',
                'description' => 'Manage the settings for the custom backend column types.',
                'icon' => 'icon-columns',
                'permissions' => ['damianlewis.custom_columns.access_settings'],
                'class' => CustomColumns::class,
                'order' => 999
            ]
        ];
    }

    public function registerListColumnTypes(): array
    {
        return [
            'status' => [$this, 'statusListColumn'],
            'active' => [$this, 'activeListColumn'],
            'hidden' => [$this, 'hiddenListColumn'],
            'featured' => [$this, 'featuredListColumn'],
            'listed' => [$this, 'listedListColumn'],
            'previewimage' => [$this, 'previewImageListColumn'],
            'textlimit' => [$this, 'textLimitListColumn'],
            'rating' => [$this, 'ratingListColumn']
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
     * @param  bool  $isActive
     * @return string
     */
    public function activeListColumn(bool $isActive): string
    {
        if ($isActive) {
            return '<span class="oc-icon-check text-success"></span>';
        }

        return '';
    }

    /**
     * @param  bool  $isHidden
     * @return string
     */
    public function hiddenListColumn(bool $isHidden): string
    {
        if ($isHidden) {
            $class = 'oc-icon-eye-slash text-muted';
        } else {
            $class = 'oc-icon-eye text-success';
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
        }

        return '';
    }

    /**
     * @param  bool  $isListed
     * @return string
     */
    public function listedListColumn(bool $isListed): string
    {
        if ($isListed) {
            return '<span class="oc-icon-check text-success"></span>';
        }

        return '';
    }

    /**
     * @param  File|null  $image
     * @return string
     */
    public function previewImageListColumn(?File $image): string
    {
        if ($image) {
            return '<img src="'.$image->getThumb(
                CustomColumns::get('preview_image_width'),
                CustomColumns::get('preview_image_height'),
                ['mode' => CustomColumns::get('preview_image_mode')]
            ).'">';
        }

        return '';
    }

    /**
     * @param  string  $text
     * @param  ListColumn  $column
     * @return string
     */
    public function textLimitListColumn(string $text, ListColumn $column): string
    {
        $wordLimit = 100;

        if (array_key_exists('limit', $column->config)) {
            $wordLimit = $column->config['limit'];
        }

        return str_limit($text, $wordLimit);
    }

    public function ratingListColumn(?int $rating, ListColumn $column): string
    {
        $max = 5;
        $stars = '';

        if (!$rating) {
            return $stars;
        }

        if (array_key_exists('max', $column->config)) {
            $max = $column->config['max'];
        }

        foreach (range(1, $max) as $count) {
            if ($rating >= $count) {
                $class = 'icon-star';
            } else {
                $class = 'icon-star-o';
            }

            $stars .= '<span class="'.$class.'" style="color: #cb7f00; margin-right: 2px;"></span>';
        }

        return $stars;
    }
}
