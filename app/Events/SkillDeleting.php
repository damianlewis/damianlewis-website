<?php

namespace App\Events;

use App\Models\Skill;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SkillDeleting
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Skill $skill,
    ) {
    }
}
