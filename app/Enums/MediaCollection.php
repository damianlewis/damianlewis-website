<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum MediaCollection: string
{
    use EnumTrait;

    case AvatarImages = 'avatar-images';
}
