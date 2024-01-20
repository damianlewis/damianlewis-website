<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait CascadeDelete
{
    protected array $cascadeDelete = [];

    public static function bootCascadeDelete(): void
    {
        static::deleted(static fn (Model $model) => $model->cascadeDelete());
    }

    protected function cascadeDelete(): void
    {
        foreach ($this->getCascadeDeleteRelationships() as $relationship) {
            if (method_exists($this, $relationship)) {
                foreach ($this->{$relationship} as $model) {
                    $model->delete();
                }
            }
        }
    }

    public function getCascadeDeleteRelationships(): array
    {
        return $this->cascadeDelete;
    }
}
