<?php

namespace App\Listeners;

use App\Events\TechnologyDeleting;
use App\Models\Technology;

class DetachParentTechnologyFromChildren
{
    public function handle(TechnologyDeleting $event): void
    {
        $event->technology->children()->withTrashed()->each(
            fn (Technology $child) => $child->removeParent()
        );
    }
}
