<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Job;
use App\Models\User;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index', [
            'users' => User::count(),
            'jobs' => Job::count(),
            'applications' => Application::count(),
        ]);
    }
}
