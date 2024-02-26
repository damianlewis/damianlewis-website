<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait CascadeDelete
{
    /**
     * The relationships that should be cascade deleted.
     *
     * @var array<string>
     */
    protected array $cascadeDeleteRelationships = [];

    /**
     * Boot the cascade delete trait for a model.
     *
     * @return void
     */
    public static function bootCascadeDelete(): void
    {
        static::deleted(static fn (Model $model) => $model->cascadeDelete());
    }

    /**
     * Cascade delete the model relationships.
     *
     * @return void
     */
    protected function cascadeDelete(): void
    {
        if (empty($relationships = $this->getCascadeDeleteRelationships())) {
            return;
        }

        foreach ($relationships as $relationship) {
            if (method_exists($this, $relationship)) {
                foreach ($this->{$relationship} as $model) {
                    $model->delete();
                }
            }
        }
    }

    /**
     * Set the cascade delete relationships for the model.
     *
     * @param array<string> $relationships
     * @return $this
     */
    public function cascadeDeleteRelationships(array $relationships): static
    {
        $this->cascadeDeleteRelationships = $relationships;

        return $this;
    }

    /**
     * Get the cascade delete relationships for the model.
     *
     * @return array<string>
     */
    public function getCascadeDeleteRelationships(): array
    {
        return $this->cascadeDeleteRelationships;
    }

    /**
     * Merge new cascade delete relationships with existing cascade delete relationships on the model.
     *
     * @param array<string> $relationships
     * @return $this
     */
    public function mergeCascadeDeleteRelationships(array $relationships): static
    {
        $this->cascadeDeleteRelationships = array_values(array_unique(array_merge($this->cascadeDeleteRelationships, $relationships)));

        return $this;
    }

    /**
     * Determines if the given relationship can be cascade deleted.
     *
     * @param string $relationship
     * @return bool
     */
    public function canBeCascadeDeleted(string $relationship): bool
    {
        return in_array($relationship, $this->getCascadeDeleteRelationships(), true);
    }
}
