<?php

declare(strict_types=1);

namespace DamianLewis\Shared\Models;

use Model;
use October\Rain\Database\Traits\Validation;
use System\Behaviors\SettingsModel;

class CustomColumns extends Model
{
    use Validation;

    public $implement = [
        SettingsModel::class
    ];

    public string $settingsCode = 'damianlewis_custom_columns_settings';

    public string $settingsFields = 'fields.yaml';

    public array $rules = [
        'preview_image_width' => 'integer',
        'preview_image_height' => 'integer'
    ];
}
