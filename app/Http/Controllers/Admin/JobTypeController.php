<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobType;
use Illuminate\Http\Request;

class JobTypeController extends Controller
{
    // LIST
    public function index(Request $request)
    {
        $query = JobType::query()

            // COUNT JOBS
            ->withCount('jobs')

            // COUNT APPLICATIONS
            ->withCount([
                'jobs as applications_count' => function ($q) {

                    $q->join(
                        'applications',
                        'jobs.id',
                        '=',
                        'applications.job_id'
                    );
                },
            ]);

        // SEARCH
        if ($request->keyword) {

            $query->where(
                'name',
                'like',
                '%'.$request->keyword.'%'
            );
        }

        // FILTER HAS JOBS
        if ($request->has_jobs != null) {

            if ($request->has_jobs == '1') {

                $query->has('jobs');

            } elseif ($request->has_jobs == '0') {

                $query->doesntHave('jobs');
            }
        }

        // SORT
        if ($request->sort == 'jobs') {

            $query->orderByDesc('jobs_count');

        } elseif ($request->sort == 'applications') {

            $query->orderByDesc('applications_count');

        } else {

            $query->latest();
        }

        $jobTypes = $query
            ->paginate(10)
            ->withQueryString();

        return view(
            'admin.jobtypes.index',
            compact('jobTypes')
        );
    }

    // CREATE
    public function create()
    {
        return view('admin.jobtypes.create');
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:job_types',
        ]);

        JobType::create([
            'name' => $request->name,
        ]);

        return redirect('/admin/jobtypes')
            ->with(
                'success',
                'Thêm hình thức làm việc thành công'
            );
    }

    // EDIT
    public function edit(string $id)
    {
        $jobType = JobType::findOrFail($id);

        return view(
            'admin.jobtypes.edit',
            compact('jobType')
        );
    }

    // UPDATE
    public function update(
        Request $request,
        string $id
    ) {

        $jobType = JobType::findOrFail($id);

        $request->validate([
            'name' => 'required',
        ]);

        $jobType->update([
            'name' => $request->name,
        ]);

        return redirect('/admin/jobtypes')
            ->with(
                'success',
                'Cập nhật thành công'
            );
    }

    // DELETE
    public function destroy(string $id)
    {
        $jobType = JobType::findOrFail($id);

        $jobType->delete();

        return back()->with(
            'success',
            'Đã xóa'
        );
    }
}
