<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Models;

use Model;
use October\Rain\Database\Traits\Validation;

class Technology extends Model
{
    use Validation;

    public $rules = [
        'name' => 'required'
    ];

    public $belongsToMany = [
        'projects' => [
            Project::class,
            'table' => 'damianlewis_portfolio_project_technology'
        ]
    ];

    protected $table = 'damianlewis_portfolio_technologies';

    protected $fillable = ['name'];

    protected $casts = [
        'is_hidden' => 'boolean'
    ];
}
