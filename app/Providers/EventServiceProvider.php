<?php

namespace App\Providers;

use App\Events\SkillDeleting;
use App\Events\TechnologyDeleting;
use App\Listeners\DetachParentSkillFromChildren;
use App\Listeners\DetachParentTechnologyFromChildren;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        TechnologyDeleting::class => [
            DetachParentTechnologyFromChildren::class,
        ],
        SkillDeleting::class => [
            DetachParentSkillFromChildren::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
