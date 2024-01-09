<?php

use Tests\TestCase;
use App\Models\Employer;
use App\Models\Job;
use App\Models\User;

class JobFilterTest extends TestCase
{
    /**
     * Test filtering jobs based on criteria.
     */
    public function test_can_filter_jobs()
    {
        $user = User::factory()->create();
        $employer = Employer::factory()->create(['user_id' => $user->id]);

        $job1 = Job::factory()->create([
            'title' => 'Software Engineer',
            'location' => 'City A',
            'salary' => 80000,
            'category' => 'IT',
            'experience' => 'Entry',
            'employer_id' => $employer->id,
        ]);

        $job2 = Job::factory()->create([
            'title' => 'Marketing Specialist',
            'location' => 'City B',
            'salary' => 70000,
            'category' => 'Marketing',
            'experience' => 'Intermediate',
            'employer_id' => $employer->id,
        ]);

        $filters = [
            'category' => 'IT',
            'experience' => 'Entry',
            'min_salary' => 75000,
        ];

        $response = $this->get(route('jobs.index', $filters));

        $response->assertSee($job1->title);
        $response->assertDontSee($job2->title);
    }
}
