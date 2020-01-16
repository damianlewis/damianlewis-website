<?php

declare(strict_types=1);

namespace DamianLewis\Education\Models;

use Model;
use October\Rain\Database\Traits\Nullable;
use October\Rain\Database\Traits\Sortable;
use October\Rain\Database\Traits\Validation;

class Qualification extends Model
{
    use Nullable;
    use Sortable;
    use Validation;

    public $rules = [
        'title' => 'required'
    ];

    protected $table = 'damianlewis_education_qualifications';

    protected $casts = [
        'is_hidden' => 'boolean'
    ];

    protected $dates = [
        'completed_at'
    ];

    protected $nullable = [
        'title',
        'score',
        'sort_order',
        'completed_at'
    ];
}
