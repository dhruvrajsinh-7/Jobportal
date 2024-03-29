<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Employer;
use App\Models\User;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Cache::tags(['jobs', 'job'])->flush();
        \App\Models\User::factory()->create([
            'name' => 'dhruv',
            'email' => 'dhruv@gmail.com',
        ]);
        User::factory(300)->create();
        $users = User::all()->shuffle();
        for ($i = 0; $i < 20; $i++) {
            Employer::factory()->create([
                'user_id' => $users->pop()->id
            ]);
        }
        $employers = Employer::all();
        for ($i = 0; $i < 100; $i++) {
            Job::factory()->create([
                'employer_id' => $employers->random()->id
            ]);
        }
        foreach ($users as $user) {
            $jobs = Job::inRandomOrder()->take(rand(0, 4))->get();
            foreach ($jobs as $job) {
                JobApplication::factory()->create([
                    'job_id' => $job->id,
                    'user_id' => $user->id
                ]);
            }
        }
    }
}
