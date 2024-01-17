<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use App\Events\BadgeUnlocked;
use App\Events\LessonWatched;
use App\Models\Achievement;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LessonWatchedListener
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
    public function handle(LessonWatched $event): void
    {
        $user = $event->user;
        
        // Define the milestone values for achievements
        $milestones = array_keys(Achievement::LESSON_ACHIEVEMENTS_LIST);

        $watchedCount = $user->watched()->count();

        // Check for achievements based on milestones
        foreach ($milestones as $milestone) {
            if ($watchedCount == $milestone) {
                $achievementName = Achievement::LESSON_ACHIEVEMENTS_LIST[$milestone];
                event(new AchievementUnlocked($achievementName, $user));
            }
        }
    }

}
