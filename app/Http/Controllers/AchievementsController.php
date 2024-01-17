<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AchievementsController extends Controller
{
    public function index(User $user)
    {
        return response()->json([
            'unlocked_achievements' => $user->achievements->pluck('name')->toArray(),
            'next_available_achievements' => $user->nextAvailableAchievements(),
            'current_badge' => $user->badge_name,
            'next_badge' => $user->next_badge_name,
            'remaining_to_unlock_next_badge' => $user->remainingToUnlockNextBadge(),
        ]);
    }
}
