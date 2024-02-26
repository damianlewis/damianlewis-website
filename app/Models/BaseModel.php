<?php

namespace App\Models;

use App\Traits\CascadeDelete;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

abstract class BaseModel extends Model
{
    use CascadeDelete, // Included in base model so that the $cascadeDeleteRelationships property is available to override in child models
        HasUlids,
        SoftDeletes;
}
