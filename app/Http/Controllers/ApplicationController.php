<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Application;
use App\Models\ApplicationLog;
use App\Models\Candidate;
use App\Models\CV;
use App\Models\Employer;
use App\Models\Job;
use App\Models\Notification;

class ApplicationController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | APPLY JOB
    |--------------------------------------------------------------------------
    */

    public function apply(Request $request, $jobId)
    {
        $request->validate([
            'cv_id' => 'required|exists:cvs,id'
        ]);

        $candidate = Candidate::where(
            'user_id',
            Auth::id()
        )->first();

        if (!$candidate) {

            return back()->with(
                'error',
                'Không tìm thấy hồ sơ ứng viên'
            );
        }

        // CHECK DUPLICATE
        $exists = Application::where(
            'job_id',
            $jobId
        )
            ->where(
                'candidate_id',
                $candidate->id
            )
            ->exists();

        if ($exists) {

            return back()->with(
                'error',
                'Bạn đã ứng tuyển công việc này'
            );
        }

        // CHECK CV
        $cv = CV::where(
            'candidate_id',
            $candidate->id
        )
            ->where(
                'id',
                $request->cv_id
            )
            ->first();

        if (!$cv) {

            return back()->with(
                'error',
                'CV không hợp lệ'
            );
        }

        // LẤY JOB
        $job = Job::findOrFail($jobId);

        // CREATE APPLICATION
        Application::create([

            'job_id' => $jobId,

            'candidate_id' => $candidate->id,

            'cv_id' => $cv->id,

            'status' => 0

        ]);

        // LẤY EMPLOYER
        $employer = Employer::find($job->employer_id);

        // CREATE NOTIFICATION
        Notification::create([

            'user_id' => $job->employer->user_id,

            'content' =>
            'Ứng viên '
                . Auth::user()->name .
                ' đã ứng tuyển vào job '
                . $job->title,
            'link' => '/employer/applications?candidate_id=' . $candidate->id . '&job_id=' . $jobId,

            'is_read' => 0

        ]);

        return redirect()
            ->back()
            ->with(
                'success',
                'Ứng tuyển thành công'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | CANDIDATE - MY APPLICATIONS
    |--------------------------------------------------------------------------
    */

    public function myApplications(Request $request)
    {
        $candidate = Candidate::where(
            'user_id',
            Auth::id()
        )->first();

        $applications = Application::with([
            'job.employer',
            'job.location',
            'job.jobType',
            'cv'
        ])
            ->where(
                'candidate_id',
                $candidate->id
            );

        /*
    |--------------------------------------------------------------------------
    | FILTER APPLICATION FROM NOTIFICATION
    |--------------------------------------------------------------------------
    */

        if ($request->application_id) {

            $applications->where(
                'id',
                $request->application_id
            );
        }

        /*
    |--------------------------------------------------------------------------
    | FILTER JOB
    |--------------------------------------------------------------------------
    */

        if ($request->job_id) {

            $applications->where(
                'job_id',
                $request->job_id
            );
        }

        $applications = $applications
            ->latest()
            ->paginate(10);

        return view(
            'candidate.applications.index',
            compact('applications')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | EMPLOYER - JOB APPLICATIONS
    |--------------------------------------------------------------------------
    */

    public function jobApplications(Request $request, $jobId)
    {
        $query = Application::with([
            'candidate',
            'cv',
            'job'
        ])
            ->where('job_id', $jobId);

        // FILTER STATUS
        if ($request->status != '') {

            $query->where(
                'status',
                $request->status
            );
        }

        // SEARCH
        if ($request->keyword) {

            $query->whereHas(
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

        $applications = $query
            ->latest()
            ->paginate(10);

        $job = Job::findOrFail($jobId);

        return view(
            'employer.applications.index',
            compact(
                'applications',
                'job'
            )
        );
    }


    // EMPLOYER ALL APPLICATIONS
    public function employerApplications(Request $request)
    {
        $employer = \App\Models\Employer::where(
            'user_id',
            Auth::id()
        )->first();

        $applications = Application::with([
            'candidate',
            'cv',
            'job'
        ])
            ->whereHas('job', function ($query) use ($employer) {

                $query->where(
                    'employer_id',
                    $employer->id
                );
            });

        /*
    |--------------------------------------------------------------------------
    | FILTER CANDIDATE FROM NOTIFICATION
    |--------------------------------------------------------------------------
    */

        if ($request->candidate_id) {

            $applications->where(
                'candidate_id',
                $request->candidate_id
            );
        }

        /*
    |--------------------------------------------------------------------------
    | FILTER JOB
    |--------------------------------------------------------------------------
    */

        if ($request->job_id) {

            $applications->where(
                'job_id',
                $request->job_id
            );
        }

        // FILTER STATUS
        if ($request->status != '') {

            $applications->where(
                'status',
                $request->status
            );
        }

        // SEARCH
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
            'employer.applications.index',
            compact('applications')
        );
    }
    /*
    |--------------------------------------------------------------------------
    | REVIEWING
    |--------------------------------------------------------------------------
    */

    public function reviewing($id)
    {

        $application = Application::findOrFail($id);


        $application->update([

            'status' => 1

        ]);


        ApplicationLog::create([

            'application_id' => $application->id,

            'status' => 1,

            'note' => 'Nhà tuyển dụng đang xem xét hồ sơ'

        ]);


        Notification::create([

            'user_id' =>
            $application->candidate->user_id,

            'content' =>
            'Hồ sơ của bạn đang được xem xét',

            'is_read' => 0
        ]);


        return back()->with(
            'success',
            'Đã chuyển sang trạng thái đang xem xét'
        );
    }



    /*
    |--------------------------------------------------------------------------
    | APPROVE
    |--------------------------------------------------------------------------
    */

    public function approve($id)
    {

        $application = Application::findOrFail($id);


        $application->update([

            'status' => 2

        ]);


        ApplicationLog::create([

            'application_id' => $application->id,

            'status' => 2,

            'note' => 'Nhà tuyển dụng đã chấp nhận hồ sơ'

        ]);


        Notification::create([

            'user_id' =>
            $application->candidate->user_id,

            'content' =>
            'Chúc mừng! Hồ sơ ứng tuyển vị trí ' . $application->job->title . ' đã được chấp nhận',
            'link' => '/candidate/applications?application_id=' . $application->id,

            'is_read' => 0
        ]);


        return back()->with(
            'success',
            'Đã chấp nhận ứng viên'
        );
    }



    /*
    |--------------------------------------------------------------------------
    | REJECT
    |--------------------------------------------------------------------------
    */

    public function reject(Request $request, $id)
    {
        $request->validate([

            'reject_reason' => 'required|string|max:1000'

        ]);

        $application = Application::findOrFail($id);

        $application->update([

            'status' => 3,

            'reject_reason' => $request->reject_reason

        ]);

        ApplicationLog::create([

            'application_id' => $application->id,

            'status' => 3,

            'note' => 'Nhà tuyển dụng đã từ chối hồ sơ. Lý do: '
                        . $request->reject_reason

        ]);

        Notification::create([

            'user_id' =>
            $application->candidate->user_id,

            'content' =>
            'Rất tiếc, hồ sơ ứng tuyển vị trí '
            . $application->job->title .
            ' của bạn chưa phù hợp',

            'link' =>
            '/candidate/applications?application_id='
            . $application->id,

            'is_read' => 0

        ]);

        return back()->with(
            'success',
            'Đã từ chối ứng viên'
        );
    }
}
