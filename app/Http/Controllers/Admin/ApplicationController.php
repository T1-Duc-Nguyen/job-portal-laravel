<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $applications = Application::with([
            'candidate',
            'job.employer',
            'job.location',
            'job.jobType'
        ]);

        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS
        |--------------------------------------------------------------------------
        */

        if ($request->status != '') {

            $applications->where(
                'status',
                $request->status
            );

        }

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if ($request->keyword) {

            $applications->whereHas(
                'candidate',
                function ($q) use ($request) {

                    $q->where(
                        'full_name',
                        'like',
                        '%' . $request->keyword . '%'
                    );

                }
            );

        }

        $applications = $applications
            ->latest()
            ->paginate(10);

        return view(
            'admin.applications.index',
            compact('applications')
        );
    }
}