<?php

namespace App\Models;

use App\Traits\CascadeDelete;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

abstract class BaseModel extends Model
{
    use CascadeDelete,
        HasUlids,
        SoftDeletes;
}
