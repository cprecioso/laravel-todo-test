<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $mainUser = User::create([
            'name' => 'Carlos Precioso',
            'email' => 'me@example.com',
            'password' => Hash::make('password'),
        ]);

        $otherUser = User::create([
            'name' => 'Guest Guéstez',
            'email' => 'guest@example.com',
            'password' => Hash::make('password'),
        ]);

        for ($i = 0; $i < 10; $i++) {
            $project = Project::create([
                'name' => "Project $i",
                'owner_id' => $mainUser->id,
            ]);

            for ($j = 0; $j < 10; $j++) {
                Task::create([
                    'text' => 'Task ' . ($i * 10 + $j),
                    'project_id' => $project->id,
                    'is_completed' => rand(0, 1) == 1,
                ]);
            }
        }


    }
}
