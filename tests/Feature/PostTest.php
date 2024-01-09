<?php

use Tests\TestCase;
use App\Models\Employer;
use App\Models\Job;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_can_create_job()
    {
        $user = User::factory()->create();

        // Create an employer associated with the user
        $employer = Employer::factory()->create([
            'user_id' => $user->id,
        ]);

        $jobData = [
            'title' => 'Software Engineer',
            'description' => 'Job description goes here.',
            'salary' => 80000,
            'location' => 'Example City',
            'category' => 'IT',
            'experience' => 'Entry',
            'employer_id' => $employer->id,
        ];

        // Create a job associated with the employer
        $job = Job::create($jobData);

        // Assertions
        $this->assertDatabaseHas('jobs', $jobData);
        $this->assertInstanceOf(Job::class, $job);
    }

    /**
     * Test retrieving a job.
     */
    public function test_can_retrieve_job()
    {
        $user = User::factory()->create();

        // Create an employer associated with the user
        $employer = Employer::factory()->create([
            'user_id' => $user->id,
        ]);

        $jobData = [
            'title' => 'Software Engineer',
            'description' => 'Job description goes here.',
            'salary' => 80000,
            'location' => 'Example City',
            'category' => 'IT',
            'experience' => 'Entry',
            'employer_id' => $employer->id,
        ];

        // Create a job associated with the employer
        $job = Job::create($jobData);

        // Retrieve the job and perform assertions
        $retrievedJob = Job::find($job->id);
        $this->assertEquals($job->id, $retrievedJob->id);
        $this->assertEquals($job->title, $retrievedJob->title);
    }
}
