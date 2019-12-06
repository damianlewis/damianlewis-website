<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Controllers;

use Backend\Behaviors\FormController;
use Backend\Behaviors\ListController;
use BackendMenu;
use Backend\Classes\Controller;
use DamianLewis\Portfolio\Models\Technology;
use Model;

class Technologies extends Controller
{
    public $requiredPermissions = ['damianlewis.portfolio.access_project_technologies'];

    public $implement = [
        ListController::class,
        FormController::class
    ];

    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('DamianLewis.Portfolio', 'portfolio', 'technologies');
    }

    /**
     * {@inheritDoc}
     */
    public function listInjectRowClass(Model $record): string
    {
        if (!$record instanceof Technology) {
            return '';
        }

        return $record->is_visible ? '' : 'safe disabled';
    }
}
