<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Employer;
use App\Models\Job;
use App\Models\JobType;
use App\Models\Location;
use App\Models\Notification;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class JobController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LIST
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $employer = Employer::where(
            'user_id',
            Auth::id()
        )->firstOrFail();

        $jobs = Job::with([
            'category',
            'location',
            'jobType',
            'skills',
        ])
            ->where(
                'employer_id',
                $employer->id
            )
            ->latest()
            ->paginate(10);

        return view(
            'employer.jobs.index',
            compact('jobs')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $categories = Category::all();

        $locations = Location::all();

        $jobTypes = JobType::all();

        $skills = Skill::all();

        return view(
            'employer.jobs.create',
            compact(
                'categories',
                'locations',
                'jobTypes',
                'skills'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([

            'title' => 'required|max:255',

            'description' => 'required',

            'requirements' => 'required',

            'salary_min' => 'required|numeric',

            'salary_max' => 'required|numeric|gte:salary_min',

            'category_id' => 'required|exists:categories,id',

            'location_id' => 'required|exists:locations,id',

            'job_type_id' => 'required|exists:job_types,id',

            'skills' => 'nullable|array',

            'skills.*' => 'exists:skills,id',
        ]);

        $employer = Employer::where(
            'user_id',
            Auth::id()
        )->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | CREATE JOB
        |--------------------------------------------------------------------------
        */

        $job = Job::create([

            'employer_id' => $employer->id,

            'title' => $request->title,

            'slug' => Str::slug($request->title),

            'description' => $request->description,

            'requirements' => $request->requirements,

            'salary_min' => $request->salary_min,

            'salary_max' => $request->salary_max,

            'category_id' => $request->category_id,

            'location_id' => $request->location_id,

            'job_type_id' => $request->job_type_id,

            'status' => 0,

            'expired_at' => now()->addDays(30),
        ]);
        /*
|--------------------------------------------------------------------------
| ADMIN NOTIFICATION
|--------------------------------------------------------------------------
*/

        $admins = User::where(
            'role',
            'admin'
        )->get();

        foreach ($admins as $admin) {

            Notification::create([

                'user_id' => $admin->id,

                'content' => 'Nhà tuyển dụng "'.

                    Auth::user()->name.

                    '" vừa đăng tin tuyển dụng: "'.

                    $job->title.

                    '"',
                'link' => '/admin/jobs/'.$job->id,
                'is_read' => 0,

            ]);

        }
        /*
        |--------------------------------------------------------------------------
        | SAVE SKILLS
        |--------------------------------------------------------------------------
        */

        if ($request->skills) {

            $job->skills()->sync(
                $request->skills
            );
        }

        return redirect('/employer/jobs')
            ->with(
                'success',
                'Đăng tin thành công'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(string $id)
    {
        $job = Job::with('skills')
            ->findOrFail($id);

        $categories = Category::all();

        $locations = Location::all();

        $jobTypes = JobType::all();

        $skills = Skill::all();

        return view(
            'employer.jobs.edit',
            compact(
                'job',
                'categories',
                'locations',
                'jobTypes',
                'skills'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        string $id
    ) {

        $request->validate([

            'title' => 'required|max:255',

            'description' => 'required',

            'requirements' => 'required',

            'salary_min' => 'required|numeric',

            'salary_max' => 'required|numeric|gte:salary_min',

            'category_id' => 'required|exists:categories,id',

            'location_id' => 'required|exists:locations,id',

            'job_type_id' => 'required|exists:job_types,id',

            'skills' => 'nullable|array',

            'skills.*' => 'exists:skills,id',
        ]);

        $job = Job::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | CHECK OWNER
        |--------------------------------------------------------------------------
        */

        $employer = Employer::where(
            'user_id',
            Auth::id()
        )->first();

        if (
            $job->employer_id != $employer->id
        ) {
            abort(403);
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE JOB
        |--------------------------------------------------------------------------
        */

        $job->update([

            'title' => $request->title,

            'slug' => Str::slug($request->title),

            'description' => $request->description,

            'requirements' => $request->requirements,

            'salary_min' => $request->salary_min,

            'salary_max' => $request->salary_max,

            'category_id' => $request->category_id,

            'location_id' => $request->location_id,

            'job_type_id' => $request->job_type_id,

            'status' => 0,
        ]);

        /*
        |--------------------------------------------------------------------------
        | UPDATE SKILLS
        |--------------------------------------------------------------------------
        */

        $job->skills()->sync(
            $request->skills ?? []
        );

        return redirect('/employer/jobs')
            ->with(
                'success',
                'Cập nhật thành công'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    /*
|--------------------------------------------------------------------------
| SHOW JOB DETAIL
|--------------------------------------------------------------------------
*/

    public function show($id)
    {
        $job = Job::with([
            'category',
            'location',
            'jobType',
            'employer',
        ])->findOrFail($id);

        return view(
            'employer.jobs.show',
            compact('job')
        );
    }

    public function destroy(string $id)
    {
        $job = Job::findOrFail($id);

        $job->delete();

        return back()->with(
            'success',
            'Đã xóa job'
        );
    }
}
