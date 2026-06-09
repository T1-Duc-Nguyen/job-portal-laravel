<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    // LIST
    public function index(Request $request)
    {
        $query = Location::query()
            ->withCount([
                'jobs',

                // Đếm tổng apply của jobs thuộc location
                'jobs as applications_count' => function ($q) {

                    $q->join(
                        'applications',
                        'jobs.id',
                        '=',
                        'applications.job_id'
                    );
                },
            ]);

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */
        if ($request->keyword) {

            $query->where(
                'name',
                'like',
                '%'.$request->keyword.'%'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER HAS JOBS
        |--------------------------------------------------------------------------
        */
        if ($request->has_jobs == '1') {

            $query->has('jobs');

        } elseif ($request->has_jobs == '0') {

            $query->doesntHave('jobs');
        }

        /*
        |--------------------------------------------------------------------------
        | SORT
        |--------------------------------------------------------------------------
        */
        if ($request->sort == 'jobs') {

            $query->orderByDesc('jobs_count');

        } elseif ($request->sort == 'applications') {

            $query->orderByDesc('applications_count');

        } else {

            $query->latest();
        }

        $locations = $query
            ->paginate(10)
            ->withQueryString();

        return view(
            'admin.locations.index',
            compact('locations')
        );
    }

    // CREATE
    public function create()
    {
        return view('admin.locations.create');
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:locations',
        ]);

        Location::create([
            'name' => $request->name,
        ]);

        return redirect('/admin/locations')
            ->with(
                'success',
                'Thêm địa điểm thành công'
            );
    }

    // EDIT
    public function edit(string $id)
    {
        $location = Location::findOrFail($id);

        return view(
            'admin.locations.edit',
            compact('location')
        );
    }

    // UPDATE
    public function update(
        Request $request,
        string $id
    ) {

        $location = Location::findOrFail($id);

        $request->validate([
            'name' => 'required',
        ]);

        $location->update([
            'name' => $request->name,
        ]);

        return redirect('/admin/locations')
            ->with(
                'success',
                'Cập nhật thành công'
            );
    }

    // DELETE
    public function destroy(string $id)
    {
        $location = Location::findOrFail($id);

        $location->delete();

        return back()->with(
            'success',
            'Đã xóa'
        );
    }
}
