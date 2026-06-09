<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Candidate;
use Illuminate\Support\Facades\Auth;

class CandidateController extends Controller
{
    public function index()
    {
        $candidate = Candidate::with('cvs')
            ->where('user_id', Auth::id())
            ->first();

        $applications = Application::with('job')
            ->where('candidate_id', $candidate->id)
            ->get();

        return view('candidate.index', compact('candidate', 'applications'));
    }
}
