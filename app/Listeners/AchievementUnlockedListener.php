<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use App\Events\BadgeUnlocked;
use App\Models\Badge;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AchievementUnlockedListener
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
    public function handle(AchievementUnlocked $event): void
    {
        $user = $event->user;
        $achievementName = $event->achievementName;

        // Check if the achievement already exists
        $achievement = $user->achievements()->where('name', $achievementName)->first();

        // If the achievement exist do nothing

        if ($achievement) {
            return;
        }

        $achievement = $user->achievements()->create([
            'name' => $achievementName,
        ]);

        $this->unlockBadges($user);

    }

    protected function unlockBadges(User $user)
    {
        // Check for badge unlock
        $unlockedAchievementsCount = $user->achievements()->count();

        if ($unlockedAchievementsCount == Badge::BADGE_INTERMEDIATE_COUNT) {
            event(new BadgeUnlocked(Badge::BADGE_INTERMEDIATE, $user));
        } elseif ($unlockedAchievementsCount == Badge::BADGE_ADVANCED_COUNT) {
            event(new BadgeUnlocked(Badge::BADGE_ADVANCED, $user));
        } elseif ($unlockedAchievementsCount == Badge::BADGE_MASTER_COUNT) {
            event(new BadgeUnlocked(Badge::BADGE_MASTER, $user));
        }
    }
}
