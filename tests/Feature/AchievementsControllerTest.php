<?php

namespace Tests\Feature;

use App\Events\AchievementUnlocked;
use App\Events\BadgeUnlocked;
use App\Models\Comment;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class AchievementsControllerTest extends TestCase
{
    public function testAchievementsEndpoint()
    {
        // Create a user
        $user = User::factory()->create();

        // Scenario 1: Watch 2 lessons to unlock 'First Lesson Watched' achievement
        $this->lessonWatched($user, Lesson::factory()->create());
        $this->lessonWatched($user, Lesson::factory()->create());
        $response = $this->json('GET', '/users/' . $user->id . '/achievements');
        $response->assertJsonFragment(['First Lesson Watched']);
      
        // Scenario 2: Write 1 comment to unlock 'First Comment Written' achievement
        $this->createComment($user, Comment::factory()->create());
        $response = $this->json('GET', '/users/' . $user->id . '/achievements');
        $response->assertJsonFragment(['First Comment Written']);

        // Scenario 3: Write 3 comments to unlock '3 Comments Written' achievement
        foreach (range(1, 2) as $index) {
            $this->createComment($user, Comment::factory()->create());
        }
        $response = $this->json('GET', '/users/' . $user->id . '/achievements');
        $response->assertJsonFragment(['3 Comments Written']);

        // Scenario 4: Watch 10 lessons to unlock '5 Lessons Watched' and '10 Lessons Watched' achievements
        foreach (range(1, 10) as $index) {
            $this->lessonWatched($user, Lesson::factory()->create());
        }
        $response = $this->json('GET', '/users/' . $user->id . '/achievements');
        $response->assertJsonFragment(['5 Lessons Watched']);
        $response->assertJsonFragment(['10 Lessons Watched']);

        // Scenario 5: Watch 25 lessons to unlock '25 Lessons Watched' achievement
        foreach (range(1, 15) as $index) {
            $this->lessonWatched($user, Lesson::factory()->create());
        }
        $response = $this->json('GET', '/users/' . $user->id . '/achievements');
        $response->assertJsonFragment(['25 Lessons Watched']);

        // Scenario 6: Write 5 comments to unlock '5 Comments Written' achievement
        foreach (range(1, 2) as $index) {
            $this->createComment($user, Comment::factory()->create());
        }
        $response = $this->json('GET', '/users/' . $user->id . '/achievements');
        $response->assertJsonFragment(['5 Comments Written']);

        // Scenario 7: Write 10 comments to unlock '10 Comments Written' achievement
        foreach (range(1, 5) as $index) {
            $this->createComment($user, Comment::factory()->create());
        }
        $response = $this->json('GET', '/users/' . $user->id . '/achievements');
        $response->assertJsonFragment(['10 Comments Written']);

        // Scenario 8: Write 20 comments to unlock '20 Comments Written' achievement
        foreach (range(1, 10) as $index) {
            $this->createComment($user, Comment::factory()->create());
        }
        $response = $this->json('GET', '/users/' . $user->id . '/achievements');
        $response->assertJsonFragment(['20 Comments Written']);

        // Scenario 9: Watch 50 lessons to unlock '50 Lessons Watched' achievement and 'Master' badge
        foreach (range(1, 25) as $index) {
            $this->lessonWatched($user, Lesson::factory()->create());
        }
        $response = $this->json('GET', '/users/' . $user->id . '/achievements');
        $response->assertJsonFragment(['50 Lessons Watched']);
        $response->assertJsonFragment(['Master']);

        

        // Fetch achievements endpoint
        $response = $this->json('GET', '/users/' . $user->id . '/achievements');

        // Assert response structure and status
        $response->assertStatus(200)
            ->assertJsonStructure([
                'unlocked_achievements',
                'next_available_achievements',
                'current_badge',
                'next_badge',
                'remaining_to_unlock_next_badge',
            ]);

        // You can also assert the database records if needed
        $this->assertDatabaseHas('achievements', ['user_id' => $user->id]);
        $this->assertDatabaseHas('badges', ['user_id' => $user->id]);
    }

    function createComment(User $user, Comment $comment)
    {
        $user->comments()->save($comment);
        event(new \App\Events\CommentWritten($comment));
    }

    function lessonWatched(User $user, Lesson $lesson)
    {
        $user->watched()->attach($lesson->id, ['watched' => true]);
        event(new \App\Events\LessonWatched($lesson, $user));
    }

    
}
