<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Models;

use Model;

class Attribute extends Model
{
    const PROJECT_STATUS = 'project.status';

    public $timestamps = false;

    protected $table = 'damianlewis_portfolio_attributes';
}
