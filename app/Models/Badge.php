<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    use HasFactory;

    const BADGE_BEGINNER = 'Beginner';
    const BADGE_BEGINNER_COUNT = 0;
    const BADGE_INTERMEDIATE = 'Intermediate';
    const BADGE_INTERMEDIATE_COUNT = 4;
    const BADGE_ADVANCED = 'Advanced';
    const BADGE_ADVANCED_COUNT = 8;
    const BADGE_MASTER = 'Master';
    const BADGE_MASTER_COUNT = 10;


    protected $fillable = [
        'name',
        'user_id',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
