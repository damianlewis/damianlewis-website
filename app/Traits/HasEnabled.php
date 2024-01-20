<?php

namespace App\Traits;

trait HasEnabled
{
    /**
     * Enable the model.
     *
     * @return void
     */
    public function enable(): void
    {
        if ($this->enabled) {
            return;
        }

        $this->enabled = true;
        $this->save();
    }

    /**
     * Disable the model.
     *
     * @return void
     */
    public function disable(): void
    {
        if (! $this->enabled) {
            return;
        }

        $this->enabled = false;
        $this->save();
    }
}
