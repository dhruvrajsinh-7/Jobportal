<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class JobRestoreController extends Controller
{
    //
    public function restore(Job $job)
    {
        $my_job = Job::withTrashed()->findOrFail($job->id);
        // dd($my_job);
        $this->authorize('restore', $my_job);
        $my_job->restore();
        return redirect()->route('my-jobs.index')->with('success', 'Job restored successfully.');
    }
}
