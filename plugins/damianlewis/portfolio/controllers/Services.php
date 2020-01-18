<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Controllers;

use Backend\Behaviors\FormController;
use Backend\Behaviors\ListController;
use Backend\Behaviors\ReorderController;
use BackendMenu;
use Backend\Classes\Controller;
use DamianLewis\Portfolio\Models\Service;
use Model;

class Services extends Controller
{
    public $implement = [
        ListController::class,
        FormController::class,
        ReorderController::class
    ];


    /**
     * Reference to the list behaviour configuration file.
     *
     * @var string
     */
    public string $listConfig = 'config/list.yaml';

    /**
     * Reference to the form behaviour configuration file.
     *
     * @var string
     */
    public string $formConfig = 'config/form.yaml';

    /**
     * Reference to the reorder behaviour configuration file.
     *
     * @var string
     */
    public string $reorderConfig = 'config/reorder.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('DamianLewis.Portfolio', 'portfolio', 'services');

        if (in_array($this->action, ['create', 'update'])) {
            $this->bodyClass = 'compact-container';
        }
    }

    /**
     * Returns a CSS class name for a list row (<tr class="...">).
     *
     * @param  Model  $record  The populated model used for the column
     * @return string HTML view
     */
    public function listInjectRowClass(Model $record): string
    {
        if (!$record instanceof Service) {
            return '';
        }

        return $record->is_hidden ? 'safe disabled' : '';
    }
}
