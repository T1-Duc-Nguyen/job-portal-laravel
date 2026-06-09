<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\SavedJob;
use Illuminate\Support\Facades\Auth;

class SavedJobController extends Controller
{
    // SAVE JOB
    public function save($id)
    {
        $candidate = Candidate::where('user_id', Auth::id())->first();

        $exists = SavedJob::where('candidate_id', $candidate->id)
            ->where('job_id', $id)
            ->first();

        if (! $exists) {

            SavedJob::create([

                'candidate_id' => $candidate->id,

                'job_id' => $id,

                'created_at' => now(),

            ]);
        }

        return back()->with('success', 'Đã lưu việc làm');
    }

    // UNSAVE
    public function unsave($id)
    {
        $candidate = Candidate::where('user_id', Auth::id())->first();

        SavedJob::where('candidate_id', $candidate->id)
            ->where('job_id', $id)
            ->delete();

        return back()->with('success', 'Đã bỏ lưu');
    }

    // LIST SAVED JOBS
    public function index()
    {
        $candidate = Candidate::where(
            'user_id',
            Auth::id()
        )->first();

        $savedJobs = SavedJob::with([
            'job.employer',
            'job.location',
            'job.jobType',
        ])
            ->where(
                'candidate_id',
                $candidate->id
            )
            ->latest('id')
            ->paginate(10);

        return view(
            'candidate.saved-jobs.index',
            compact('savedJobs')
        );
    }
}
