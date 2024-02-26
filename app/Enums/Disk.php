<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum Disk: string
{
    use EnumTrait;

    case AvatarImages = 'local-avatar-images';
}
