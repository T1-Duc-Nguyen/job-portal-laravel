<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use App\Models\JobType;
use App\Models\Location;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // HOME PAGE
    public function index()
    {
        $jobs = Job::with([
            'employer',
            'location',
            'category',
            'jobType',
        ])
            ->where('status', 1)
            ->latest()
            ->take(8)
            ->get();

        $categories = Category::all();

        return view(
            'home',
            compact(
                'jobs',
                'categories'
            )
        );
    }

    // JOB LIST
    public function jobs(Request $request)
    {
        $query = Job::with([
            'employer',
            'location',
            'category',
            'jobType',
        ])
            ->where('status', 1);

        // SEARCH
        if ($request->keyword) {

            $query->where(
                'title',
                'like',
                '%'.$request->keyword.'%'
            );
        }

        // CATEGORY
        if ($request->category_id) {

            $query->where(
                'category_id',
                $request->category_id
            );
        }

        // LOCATION
        if ($request->location_id) {

            $query->where(
                'location_id',
                $request->location_id
            );
        }

        // JOB TYPE
        if ($request->job_type_id) {

            $query->where(
                'job_type_id',
                $request->job_type_id
            );
        }

        $jobs = $query
            ->latest()
            ->paginate(8);

        $categories = Category::all();
        $locations = Location::all();
        $jobTypes = JobType::all();

        return view(
            'jobs.index',
            compact(
                'jobs',
                'categories',
                'locations',
                'jobTypes'
            )
        );
    }

    // DETAIL
    public function detail($slug)
    {
        $job = Job::with([
            'employer',
            'location',
            'category',
            'jobType',
        ])
            ->where('slug', $slug)
            ->firstOrFail();

        // TĂNG VIEW
        $job->increment('views');

        return view(
            'jobs.detail',
            compact('job')
        );
    }
}
