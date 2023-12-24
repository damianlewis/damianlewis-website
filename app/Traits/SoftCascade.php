<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait SoftCascade
{
    protected static bool $allowCascadeDelete = true;

    protected static bool $allowCascadeRestore = false;

    public static function bootSoftCascade(): void
    {
        if (static::$allowCascadeDelete) {
            static::deleted(static fn (Model $model) => $model->cascadeDelete());
        }

        if (static::$allowCascadeRestore) {
            static::restored(static fn (Model $model) => $model->cascadeRestore());
        }
    }

    protected function cascadeDelete(): void
    {
        $this->cascade('delete');
    }

    protected function cascadeRestore(): void
    {
        $this->cascade('restore');
    }

    protected function cascade(string $action): void
    {
        if (isset($this->softCascade)) {
            foreach ($this->getSoftCascadeRelationships() as $relationship) {
                if (method_exists($this, $relationship)) {
                    $collection = match ($action) {
                        'delete' => $this->{$relationship},
                        'restore' => $this->{$relationship}()->onlyTrashed()->get(),
                    };

                    foreach ($collection as $model) {
                        $model->{$action}();
                    }
                }
            }
        }
    }

    protected function getSoftCascadeRelationships(): array
    {
        return $this->softCascade ?? [];
    }
}
