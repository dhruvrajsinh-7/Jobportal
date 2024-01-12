<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class JobRestoreController extends Controller
{
    //
    public function restore(Job $myJob)
    {
        $job = Job::withTrashed()->findOrFail($myJob->id);
        dd($job);
        $this->authorize('restore', $job);
        $job->restore();
        return redirect()->route('my-jobs.index')->with('success', 'Job restored successfully.');
    }
}
