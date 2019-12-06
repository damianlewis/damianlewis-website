<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Models;

use Model;
use System\Behaviors\SettingsModel;

class Settings extends Model
{
    public $implement = [
        SettingsModel::class
    ];

    public $settingsCode = 'damianlewis_portfolio_settings';

    public $settingsFields = 'fields.yaml';

}
