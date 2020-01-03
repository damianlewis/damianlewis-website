<?php

declare(strict_types=1);

namespace DamianLewis\CustomColumns\Models;

use Model;
use October\Rain\Database\Traits\Validation;
use System\Behaviors\SettingsModel;

class Settings extends Model
{
    use Validation;

    public $implement = [
        SettingsModel::class
    ];

    public $settingsCode = 'damianlewis_custom_columns_settings';

    public $settingsFields = 'fields.yaml';

    public $rules = [
        'preview_image_width' => 'integer',
        'preview_image_height' => 'integer'
    ];
}
