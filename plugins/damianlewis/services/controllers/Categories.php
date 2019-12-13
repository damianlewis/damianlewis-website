<?php

declare(strict_types=1);

namespace DamianLewis\Services\Controllers;

use Backend\Behaviors\FormController;
use Backend\Behaviors\ListController;
use Backend\Behaviors\ReorderController;
use BackendMenu;
use Backend\Classes\Controller;

class Categories extends Controller
{
    public $requiredPermissions = ['damianlewis.services.access_categories'];

    public $implement = [
        ListController::class,
        FormController::class,
        ReorderController::class
    ];

    public $formConfig = 'config/form.yaml';
    public $listConfig = 'config/list.yaml';
    public $reorderConfig = 'config/reorder.yaml';

    public function __construct()
    {
        parent::__construct();

        if (in_array($this->action, ['create', 'update'])) {
            $this->bodyClass = 'compact-container';
        }

        BackendMenu::setContext('DamianLewis.Services', 'services', 'categories');
    }
}
