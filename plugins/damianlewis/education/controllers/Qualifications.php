<?php

declare(strict_types=1);

namespace DamianLewis\Education\Controllers;

use Backend\Behaviors\FormController;
use Backend\Behaviors\ListController;
use Backend\Behaviors\ReorderController;
use BackendMenu;
use Backend\Classes\Controller;
use DamianLewis\Education\Models\Qualification;
use Model;

class Qualifications extends Controller
{
    public $implement = [
        ListController::class,
        FormController::class,
        ReorderController::class
    ];

    public $listConfig = 'config/list.yaml';
    public $formConfig = 'config/form.yaml';
    public $reorderConfig = 'config/reorder.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('DamianLewis.Education', 'education', 'qualifications');

        if (in_array($this->action, ['create', 'update'])) {
            $this->bodyClass = 'compact-container';
        }
    }

    public function listInjectRowClass(Model $record): string
    {
        if (!$record instanceof Qualification) {
            return '';
        }

        return $record->is_hidden ? 'safe disabled' : '';
    }
}
