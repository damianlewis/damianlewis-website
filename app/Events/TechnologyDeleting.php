<?php

namespace App\Events;

use App\Models\Technology;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TechnologyDeleting
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Technology $technology,
    ) {
    }
}
