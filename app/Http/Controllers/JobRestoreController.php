<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class JobRestoreController extends Controller
{
    //
    public function index(Job $job)
    {
        $my_job = Job::withTrashed()->find($job->id);
        if (!$my_job) {
            return redirect()->route('my-jobs.index')->with('error', 'Job not found.');
        }
        if ($my_job->trashed() == false) {
            return redirect()->route('my-jobs.index')->with('error', 'Job is not deleted.');
        }
        // dd($my_job);
        $this->authorize('restore', $my_job);
        $my_job->restore();
        return redirect()->route('my-jobs.index')->with('success', 'Job restored successfully.');
    }
}
