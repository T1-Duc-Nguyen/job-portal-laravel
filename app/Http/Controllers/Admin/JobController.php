<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Notification;
use Illuminate\Http\Request;

class JobController extends Controller
{
    // LIST
    public function index(Request $request)
    {
        $query = Job::with([
            'employer',
            'category',
            'location',
        ]);

        // SEARCH
        if ($request->keyword) {

            $query->where(function ($q) use ($request) {

                $q->where('title', 'like', '%'.$request->keyword.'%')
                    ->orWhereHas('employer', function ($e) use ($request) {

                        $e->where(
                            'company_name',
                            'like',
                            '%'.$request->keyword.'%'
                        );
                    });
            });
        }

        // FILTER STATUS
        if ($request->status !== null && $request->status !== '') {

            $query->where(
                'status',
                $request->status
            );
        }

        $jobs = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'admin.jobs.index',
            compact('jobs')
        );
    }

    // DETAIL
    public function show(string $id)
    {
        $job = Job::with([
            'employer',
            'category',
            'location',
            'jobType',
        ])->findOrFail($id);

        return view(
            'admin.jobs.show',
            compact('job')
        );
    }

    // APPROVE
    public function approve($id)
    {
        $job = Job::findOrFail($id);

        $job->update([
            'status' => 1,
        ]);

        Notification::create([

            'user_id' => $job->employer->user_id,

            'content' => 'Tin tuyển dụng '
                .$job->title.
                ' đã được admin duyệt',

            'link' => '/employer/jobs/'.$job->id,

            'is_read' => 0,

        ]);

        return back()->with(
            'success',
            'Đã duyệt tin tuyển dụng'
        );
    }

    // REJECT
    public function reject(Request $request, $id)
    {
      
        $request->validate([

            'reject_reason' => 'required|min:5',

        ], [

            'reject_reason.required' => 'Vui lòng nhập lý do từ chối',

            'reject_reason.min' => 'Lý do tối thiểu 5 ký tự',

        ]);

        $job = Job::findOrFail($id);

        $job->update([

            'status' => 2,

            'reject_reason' => $request->reject_reason,

        ]);

        Notification::create([

            'user_id' => $job->employer->user_id,

            'content' => 'Tin tuyển dụng "'.
                $job->title.
                '" đã bị admin từ chối',

            'link' => '/employer/jobs/'.$job->id,

            'is_read' => 0,

        ]);

        return back()->with(
            'success',
            'Đã từ chối tin tuyển dụng'
        );
    }

    // DELETE
    public function destroy(string $id)
    {
        $job = Job::findOrFail($id);

        $job->delete();

        return back()->with(
            'success',
            'Đã xóa tin tuyển dụng'
        );
    }
}
