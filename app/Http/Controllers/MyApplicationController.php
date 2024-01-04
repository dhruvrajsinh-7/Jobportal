<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use Illuminate\Http\Request;

class MyApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view(
            'my_job_application.index',
            [
                'applications' => auth()->user()->jobApplications()
                    ->with([
                        'job' => fn ($query) => $query->withCount('jobApplications')
                            ->withAvg('jobApplications', 'expected_salary')
                            ->withTrashed(),
                        'job.employer'
                    ])
                    ->latest()->get()
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */


    /**
     * Display the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobApplication $myApplication)
    {
        $myApplication->delete();
        return redirect()->back()->with(
            'success',
            'job application removed'
        );
    }
}
