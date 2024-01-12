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

        return view(
            'job.index',
            [
                'jobs' => Job::with('employer')->latest()->filter($filters)->get()
            ]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Job $job)
    {
        $this->authorize('view', $job);
        $sessionId = session()->getId();
        $counterKey = "job-post-{$job->id}-counter";
        $userkey = "job-post-{$job->id}-user";
        $users = Cache::get($userkey, []);
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

        if (!Cache::has($counterKey)) {
            Cache::forever($counterKey, 1);
        } else {
            Cache::increment($counterKey, $difference);
        }
        $counter = Cache::get($counterKey);
        return view(
            'job.show',
            [
                'job' => $job->load('employer.jobs'),
                'counter' => $counter
            ]
        );
    }
}
