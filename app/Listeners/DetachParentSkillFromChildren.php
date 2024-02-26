<?php

namespace App\Listeners;

use App\Events\SkillDeleting;
use App\Models\Skill;

class DetachParentSkillFromChildren
{
    public function handle(SkillDeleting $event): void
    {
        $event->skill->children()->withTrashed()->each(
            fn (Skill $child) => $child->removeParent()
        );
    }
}
