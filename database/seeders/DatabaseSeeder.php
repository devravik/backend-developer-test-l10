<?php

namespace Database\Seeders;

use App\Models\Lesson;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Lessons
        $lessons = Lesson::factory()
            ->count(20)
            ->create();

        // Seed Users
        $users = \App\Models\User::factory()
            ->count(10)
            ->create();
    }
}
