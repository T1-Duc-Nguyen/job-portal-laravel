<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Employer;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;

class EmployerController extends Controller
{
    public function dashboard()
    {
        $employer = Employer::where(
            'user_id',
            Auth::id()
        )->first();

        $jobs = Job::with([
            'location',
        ])
            ->withCount('applications')
            ->where(
                'employer_id',
                $employer->id
            )
            ->latest()
            ->take(5)
            ->get();

        $totalJobs = Job::where(
            'employer_id',
            $employer->id
        )->count();

        $activeJobs = Job::where(
            'employer_id',
            $employer->id
        )
            ->where('status', 1)
            ->count();

        $totalApplications = Application::whereHas(
            'job',
            function ($query) use ($employer) {

                $query->where(
                    'employer_id',
                    $employer->id
                );

            }
        )->count();

        $approvedApplications = Application::whereHas(
            'job',
            function ($query) use ($employer) {

                $query->where(
                    'employer_id',
                    $employer->id
                );

            }
        )
            ->where('status', 2)
            ->count();

        return view(
            'employer.dashboard',
            compact(
                'jobs',
                'totalJobs',
                'activeJobs',
                'totalApplications',
                'approvedApplications'
            )
        );
    }
}
