<?php

declare(strict_types=1);

namespace DamianLewis\Pages\Controllers;

use Backend\Behaviors\FormController;
use Backend\Behaviors\ListController;
use BackendMenu;
use Backend\Classes\Controller;
use DamianLewis\Pages\Models\Hero;
use Model;

class Heroes extends Controller
{
    public $requiredPermissions = ['damianlewis.pages.access_heroes'];

    public $implement = [
        ListController::class,
        FormController::class
    ];

    public $formConfig = 'config/form.yaml';
    public $listConfig = 'config/list.yaml';

    public $bodyClass = 'compact-container';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('DamianLewis.Pages', 'pages', 'heroes');
    }

    public function listInjectRowClass(Model $record): string
    {
        if (!$record instanceof Hero) {
            return '';
        }

        return $record->is_active ? '' : 'safe disabled';
    }
}
