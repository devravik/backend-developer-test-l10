<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get Current Badge Name Attribute for User
    */
    public function getBadgeNameAttribute()
    {
        return $this->currentBadgeName();
    }


    /**
     * Get Latest Badge for User
    */
    public function currentBadgeName()
    {
        $latestBadge = $this->badges()->latest()->first();
        return $latestBadge ? $latestBadge->name : Badge::BADGE_BEGINNER;
    }

    // next badge
    public function nextBadgeName()
    {
        $currentBadgeName = $this->currentBadgeName();
        $nextBadgeName = null;

        if ($currentBadgeName == Badge::BADGE_BEGINNER) {
            $nextBadgeName = Badge::BADGE_INTERMEDIATE;
        } elseif ($currentBadgeName == Badge::BADGE_INTERMEDIATE) {
            $nextBadgeName = Badge::BADGE_ADVANCED;
        } elseif ($currentBadgeName == Badge::BADGE_ADVANCED) {
            $nextBadgeName = Badge::BADGE_MASTER;
        }

        return $nextBadgeName;
    }

    /**
     * Get Current Badge Name Attribute for User
     */
    public function getNextBadgeNameAttribute()
    {
        return $this->nextBadgeName();
    }

    /**
     * The comments that belong to the user.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * The lessons that a user has access to.
     */
    public function lessons()
    {
        return $this->belongsToMany(Lesson::class);
    }

    /**
     * The lessons that a user has watched.
     */
    public function watched()
    {
        return $this->belongsToMany(Lesson::class)->wherePivot('watched', true);
    }

    /**
     * The achievements that belong to the user.
     */
    public function achievements()
    {
        return $this->hasMany(Achievement::class);
    }

    /**
     * The badges that belong to the user.
     */
    public function badges()
    {
        return $this->hasMany(Badge::class);
    }

    // next_available_achievements
    public function nextAvailableAchievements()
    {
        $unlockedAchievements = $this->achievements->pluck('name')->toArray();
        $nextAvailableAchievements = array_diff(Achievement::ALL_ACHIEVEMENTS_LIST, $unlockedAchievements);
        return $nextAvailableAchievements;
    }

    //remaing_to_unlock_next_badge
    public function remainingToUnlockNextBadge()
    {
        $nextBadgeName = $this->nextBadgeName();
        if(!$nextBadgeName) return 0;
        
        // Get the next badge count from constants
        $nextBadgeCount = constant('App\Models\Badge::BADGE_' . strtoupper($nextBadgeName) . '_COUNT');

        
        $remainingToUnlockNextBadge = $nextBadgeCount - $this->achievements()->count();
        return $remainingToUnlockNextBadge > 0 ? $remainingToUnlockNextBadge : 0;
    }
}

