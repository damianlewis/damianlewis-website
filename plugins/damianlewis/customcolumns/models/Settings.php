<?php

declare(strict_types=1);

namespace DamianLewis\CustomColumns\Models;

use Model;
use System\Behaviors\SettingsModel;

class Settings extends Model
{
    public $implement = [
        SettingsModel::class
    ];

    public $settingsCode = 'damianlewis_custom_columns_settings';

    public $settingsFields = 'fields.yaml';
}
