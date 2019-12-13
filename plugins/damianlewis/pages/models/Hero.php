<?php

declare(strict_types=1);

namespace DamianLewis\Pages\Models;

use Model;
use System\Models\File;

class Hero extends Model
{
    public $table = 'damianlewis_pages_heroes';

    public $attachOne = [
        'image' => File::class,
        'background_image_tablet' => File::class,
        'background_image_mobile' => File::class
    ];
}
