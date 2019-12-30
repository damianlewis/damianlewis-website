<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Controllers;

use Backend\Behaviors\FormController;
use Backend\Behaviors\ListController;
use BackendMenu;
use Backend\Classes\Controller;
use DamianLewis\Portfolio\Models\Skill;
use Model;

class Skills extends Controller
{
    public $requiredPermissions = ['damianlewis.portfolio.access_project_skills'];

    public $implement = [
        ListController::class,
        FormController::class
    ];

    public $listConfig = 'config/list.yaml';
    public $formConfig = 'config/form.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('DamianLewis.Portfolio', 'portfolio', 'skills');

        if (in_array($this->action, ['create', 'update'])) {
            $this->bodyClass = 'compact-container';
        }
    }

    /**
     * {@inheritDoc}
     */
    public function listInjectRowClass(Model $record): string
    {
        if (!$record instanceof Skill) {
            return '';
        }

        return $record->is_hidden ? 'safe disabled' : '';
    }
}
