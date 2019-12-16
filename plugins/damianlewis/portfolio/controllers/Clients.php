<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Controllers;

use Backend\Behaviors\FormController;
use Backend\Behaviors\ListController;
use Backend\Behaviors\ReorderController;
use BackendMenu;
use Backend\Classes\Controller;
use DamianLewis\Portfolio\Models\Client;
use Model;

class Clients extends Controller
{
    public $requiredPermissions = ['damianlewis.portfolio.access_clients'];

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

        BackendMenu::setContext('DamianLewis.Portfolio', 'portfolio', 'clients');

        if (in_array($this->action, ['create', 'update'])) {
            $this->bodyClass = 'compact-container';
        }
    }

    /**
     * {@inheritDoc}
     */
    public function listInjectRowClass(Model $record): string
    {
        if (!$record instanceof Client) {
            return '';
        }

        return $record->is_active ? '' : 'safe disabled';
    }
}
