<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Controllers;

use Backend\Behaviors\FormController;
use Backend\Behaviors\ListController;
use Backend\Behaviors\ReorderController;
use Backend\Classes\Controller;
use Backend\Widgets\Filter;
use BackendMenu;
use DamianLewis\Portfolio\Models\Project;
use Model;

class Projects extends Controller
{
    public $requiredPermissions = ['damianlewis.portfolio.access_projects'];

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

        BackendMenu::setContext('DamianLewis.Portfolio', 'portfolio', 'projects');

        if (in_array($this->action, ['create', 'update'])) {
            $this->bodyClass = 'compact-container';
        }
    }

    /**
     * {@inheritDoc}
     */
    public function listInjectRowClass(Model $record): string
    {
        if (!$record instanceof Project) {
            return '';
        }

        return $record->status->code == 'archived' ? 'safe disabled' : '';
    }

    /**
     * {@inheritDoc}
     */
    public function listFilterExtendScopes(Filter $filter): void
    {
        $filter->addScopes([
            'completed_at' => [
                'label' => 'Completed at',
                'type' => 'daterange',
                'minDate' => Project::min('completed_at'),
                'maxDate' => Project::max('completed_at'),
                'conditions' => "completed_at >= ':after' AND completed_at <= ':before'"
            ]
        ]);
    }
}
