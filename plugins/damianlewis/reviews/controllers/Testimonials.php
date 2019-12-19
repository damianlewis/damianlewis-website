<?php

declare(strict_types=1);

namespace DamianLewis\Reviews\Controllers;

use Backend\Behaviors\FormController;
use Backend\Behaviors\ListController;
use BackendMenu;
use Backend\Classes\Controller;
use DamianLewis\Reviews\Models\Testimonial;
use Model;

class Testimonials extends Controller
{
    public $requiredPermissions = ['damianlewis.reviews.access_testimonials'];

    public $implement = [
        ListController::class,
        FormController::class
    ];

    public $listConfig = 'config/list.yaml';
    public $formConfig = 'config/form.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('DamianLewis.Reviews', 'reviews', 'testimonials');

        if (in_array($this->action, ['create', 'update'])) {
            $this->bodyClass = 'compact-container';
        }
    }

    /**
     * {@inheritDoc}
     */
    public function listInjectRowClass(Model $record): string
    {
        if (!$record instanceof Testimonial) {
            return '';
        }

        return $record->is_active ? '' : 'safe disabled';
    }
}
