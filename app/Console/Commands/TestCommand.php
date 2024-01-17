<?php

namespace App\Console\Commands;

use App\Models\Lesson;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = \App\Models\User::create(
            [
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
            ]
        );

        // $commentMilestones = [1, 3, 5, 10, 20];

        // create 1 comment
        $this->createComment($user, 1);

        // create 3 comment
        $this->createComment($user, 2);

        // create 5 comment
        $this->createComment($user, 2);

        // create 10 comment
        $this->createComment($user, 5);

        // create 20 comment
        $this->createComment($user, 10);

        // $lessonMilestones = [1, 5, 10, 25, 50];

        // create 1 lesson
        $this->lessonWatched($user, Lesson::find(1));

        // create 5 lesson
        foreach (range(2, 6) as $lessonId) {
            $this->lessonWatched($user, Lesson::find($lessonId));
        }

        // create 10 lesson
        foreach (range(7, 16) as $lessonId) {
            $this->lessonWatched($user, Lesson::find($lessonId));
        }
       

        // create 25 lesson
        foreach (range(17, 40) as $lessonId) {
            $this->lessonWatched($user, Lesson::find($lessonId));
        }

        // create 50 lesson
        foreach (range(41, 105) as $lessonId) {
            $this->lessonWatched($user, Lesson::find($lessonId));
        }


        $this->info('Test command executed');
    }

    function createComment(User $user, int $count)
    {
        for ($i = 0; $i < $count; $i++) {
            $comment = $user->comments()->create([
                'body' => 'This is a comment. ' . time()
            ]);
            event(new \App\Events\CommentWritten($comment));
        }
    }

    function lessonWatched(User $user, Lesson $lesson)
    {
        $user->watched()->attach($lesson->id, ['watched' => true]);
        event(new \App\Events\LessonWatched($lesson, $user));
    }
}
