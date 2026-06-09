<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Job;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $users = User::count();

        $jobs = Job::count();

        $applications = Application::count();

        return view('admin.dashboard', compact(
            'users',
            'jobs',
            'applications'
        ));
    }
}
