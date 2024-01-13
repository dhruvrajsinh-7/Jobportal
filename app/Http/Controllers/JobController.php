<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Job::class);
        $filters = request()->only(
            'search',
            'min_salary',
            'max_salary',
            'experience',
            'category'
        );
        $jobs = Cache::tags(['jobs'])->rememberForever("jobs-" . serialize($filters), function () use ($filters) {
            return Job::with('employer')->latest()->filter($filters)->get();
        });
        return view(
            'job.index',
            [
                'jobs' => $jobs,
            ]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Job $job)
    {
        $this->authorize('view', $job);
        $job = Cache::tags(['job'])->rememberForever("job-{$job->id}", function () use ($job) {
            return Job::with('employer')->find($job->id);
        });
        $sessionId = session()->getId();
        $counterKey = "job-post-{$job->id}-counter";
        $userkey = "job-post-{$job->id}-user";
        $users = Cache::tags(['job'])->get($userkey, []);
        $userupdate = [];
        $difference = 0;

        foreach ($users as $session => $lastVisit) {
            if ($lastVisit < now()->subMinute(1)) {
                $difference--;
            } else {
                $userupdate[$session] = $lastVisit;
            }
        }

        if (!array_key_exists($sessionId, $users) || now()->diffInMinutes($users[$sessionId]) >= 1) {
            $difference++;
        }
        $userupdate[$sessionId] = now();
        Cache::forever($userkey, $userupdate);

        if (!Cache::tags(['job'])->has($counterKey)) {
            Cache::tags(['job'])->forever($counterKey, 1);
        } else {
            Cache::tags(['job'])->increment($counterKey, $difference);
        }
        $counter = Cache::tags(['job'])->get($counterKey);
        return view(
            'job.show',
            [
                'job' => $job,
                'counter' => $counter
            ]
        );
    }
}
