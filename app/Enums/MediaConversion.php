<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum MediaConversion: string
{
    use EnumTrait;

    case Thumbnail = 'thumb';
    case Small = 'small';
    case Medium = 'medium';
    case Large = 'large';
}
