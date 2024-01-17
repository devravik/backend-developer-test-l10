<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use App\Events\CommentWritten;
use App\Models\Achievement;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CommentWrittenListener
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
    public function handle(CommentWritten $event): void
    {
        $user = $event->comment->user;

        // Define the milestone values for achievements
        $milestones = array_keys(Achievement::COMMENT_ACHIEVEMENTS_LIST);

        $commentsCount = $user->comments()->count();

        // Check for achievements based on milestones
        foreach ($milestones as $milestone) {
            if ($commentsCount == $milestone) {
                $achievementName = Achievement::COMMENT_ACHIEVEMENTS_LIST[$milestone];
                event(new AchievementUnlocked($achievementName, $user));
            }
        }
    }
}
