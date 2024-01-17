<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

    const ACHIEVEMENT_FIRST_LESSON = 'First Lesson Watched';
    const ACHIEVEMENT_FIRST_LESSON_COUNT = 1;

    const ACHIEVEMENT_5_LESSONS = '5 Lessons Watched';
    const ACHIEVEMENT_5_LESSONS_COUNT = 5;

    const ACHIEVEMENT_10_LESSONS = '10 Lessons Watched';
    const ACHIEVEMENT_10_LESSONS_COUNT = 10;

    const ACHIEVEMENT_25_LESSONS = '25 Lessons Watched';
    const ACHIEVEMENT_25_LESSONS_COUNT = 25;

    const ACHIEVEMENT_50_LESSONS = '50 Lessons Watched';
    const ACHIEVEMENT_50_LESSONS_COUNT = 50;


    // Comment Achievements
    const ACHIEVEMENT_FIRST_COMMENT = 'First Comment Written';
    const ACHIEVEMENT_FIRST_COMMENT_COUNT = 1;

    const ACHIEVEMENT_3_COMMENTS = '3 Comments Written';
    const ACHIEVEMENT_3_COMMENTS_COUNT = 3;

    const ACHIEVEMENT_5_COMMENTS = '5 Comments Written';
    const ACHIEVEMENT_5_COMMENTS_COUNT = 5;

    const ACHIEVEMENT_10_COMMENTS = '10 Comments Written';
    const ACHIEVEMENT_10_COMMENTS_COUNT = 10;

    const ACHIEVEMENT_20_COMMENTS = '20 Comments Written';
    const ACHIEVEMENT_20_COMMENTS_COUNT = 20;

    const LESSON_ACHIEVEMENTS_LIST = [
        self::ACHIEVEMENT_FIRST_LESSON_COUNT => self::ACHIEVEMENT_FIRST_LESSON,
        self::ACHIEVEMENT_5_LESSONS_COUNT => self::ACHIEVEMENT_5_LESSONS,
        self::ACHIEVEMENT_10_LESSONS_COUNT => self::ACHIEVEMENT_10_LESSONS,
        self::ACHIEVEMENT_25_LESSONS_COUNT => self::ACHIEVEMENT_25_LESSONS,
        self::ACHIEVEMENT_50_LESSONS_COUNT => self::ACHIEVEMENT_50_LESSONS,
    ];

    const COMMENT_ACHIEVEMENTS_LIST = [
        self::ACHIEVEMENT_FIRST_COMMENT_COUNT => self::ACHIEVEMENT_FIRST_COMMENT,
        self::ACHIEVEMENT_3_COMMENTS_COUNT => self::ACHIEVEMENT_3_COMMENTS,
        self::ACHIEVEMENT_5_COMMENTS_COUNT => self::ACHIEVEMENT_5_COMMENTS,
        self::ACHIEVEMENT_10_COMMENTS_COUNT => self::ACHIEVEMENT_10_COMMENTS,
        self::ACHIEVEMENT_20_COMMENTS_COUNT => self::ACHIEVEMENT_20_COMMENTS,
    ];

    const ALL_ACHIEVEMENTS_LIST = [
        self::ACHIEVEMENT_FIRST_LESSON,
        self::ACHIEVEMENT_5_LESSONS,
        self::ACHIEVEMENT_10_LESSONS,
        self::ACHIEVEMENT_25_LESSONS,
        self::ACHIEVEMENT_50_LESSONS,
        self::ACHIEVEMENT_FIRST_COMMENT,
        self::ACHIEVEMENT_3_COMMENTS,
        self::ACHIEVEMENT_5_COMMENTS,
        self::ACHIEVEMENT_10_COMMENTS,
        self::ACHIEVEMENT_20_COMMENTS,
    ];


    protected $fillable = [
        'name',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
