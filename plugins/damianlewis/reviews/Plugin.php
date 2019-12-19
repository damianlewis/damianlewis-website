<?php

declare(strict_types=1);

namespace DamianLewis\Reviews;

use Backend;
use DamianLewis\Reviews\Components\Testimonial;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function pluginDetails(): array
    {
        return [
            'name' => 'Reviews',
            'description' => 'Create and manage reviews from clients.',
            'author' => 'Damian Lewis',
            'icon' => 'icon-thumbs-up'
        ];
    }

    public function registerComponents(): array
    {
        return [
            Testimonial::class => 'testimonial'
        ];
    }

    public function registerPermissions(): array
    {
        return [
            'damianlewis.reviews.access_testimonials' => [
                'tab' => 'Reviews',
                'label' => 'Manage the testimonials.'
            ],
        ];
    }

    public function registerNavigation(): array
    {
        return [
            'reviews' => [
                'label' => 'Reviews',
                'url' => Backend::url('damianlewis/reviews/testimonials'),
                'icon' => 'icon-thumbs-up',
                'iconSvg' => 'plugins/damianlewis/reviews/assets/images/icon_review.svg',
                'permissions' => ['damianlewis.reviews.*'],
                'order' => 999
            ]
        ];
    }
}
