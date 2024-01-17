<?php

namespace App\Listeners;

use App\Events\BadgeUnlocked;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class BadgeUnlockedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BadgeUnlocked $event): void
    {
        $user = $event->user;
        $badgeName = $event->badgeName;

        // Check if the badge already exists
        $badge = $user->badges()->where('name', $badgeName)->first();

        // If the badge exist do nothing
        if ($badge) {
            return;
        }

        $badge = $user->badges()->create([
            'name' => $badgeName,
        ]);
    }
}
