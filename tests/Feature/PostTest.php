<?php

use Tests\TestCase;
use App\Models\Employer;
use App\Models\Job;
use App\Models\User;

class PostTest extends TestCase
{

    public function test_can_create_job()
    {
        $user = User::factory()->create();

        $employer = Employer::factory()->create(['user_id' => $user->id]);

        $jobData = [
            'title' => 'Software Engineer',
            'description' => 'Job description goes here.',
            'salary' => 80000,
            'location' => 'Example City',
            'category' => 'IT',
            'experience' => 'Entry',
            'employer_id' => $employer->id,
        ];

        $job = Job::create($jobData);

        $this->assertDatabaseHas('jobs', $jobData);
        $this->assertInstanceOf(Job::class, $job);
    }

    public function test_can_retrieve_job()
    {
        $user = User::factory()->create();

        $employer = Employer::factory()->create(['user_id' => $user->id]);

        $jobData = [
            'title' => 'Software Engineer',
            'description' => 'Job description goes here.',
            'salary' => 80000,
            'location' => 'Example City',
            'category' => 'IT',
            'experience' => 'Entry',
            'employer_id' => $employer->id,
        ];

        $job = Job::create($jobData);

        $retrievedJob = Job::find($job->id);
        $this->assertEquals($job->id, $retrievedJob->id);
        $this->assertEquals($job->title, $retrievedJob->title);
    }
}
