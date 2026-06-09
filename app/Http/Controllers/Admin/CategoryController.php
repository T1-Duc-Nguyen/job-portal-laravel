<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LIST
    |--------------------------------------------------------------------------
    */
    // LIST
    public function index(Request $request)
    {
        $query = Category::query()
            ->withCount([

                // đếm jobs
                'jobs',

                // đếm applications thông qua jobs
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

        // FILTER CÓ JOBS / CHƯA CÓ JOBS
        if ($request->has_jobs != '') {

            if ($request->has_jobs == 1) {

                $query->has('jobs');

            } else {

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

        $categories = $query
            ->paginate(10)
            ->withQueryString();

        return view(
            'admin.categories.index',
            compact('categories')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('admin.categories.create');
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {

        $request->validate([

            'name' => 'required|unique:categories,name',

        ], [

            'name.required' => 'Vui lòng nhập tên ngành nghề',

            'name.unique' => 'Ngành nghề đã tồn tại',

        ]);

        Category::create([

            'name' => $request->name,

        ]);

        return redirect('/admin/categories')

            ->with(
                'success',
                'Thêm ngành nghề thành công'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit(string $id)
    {

        $category = Category::findOrFail($id);

        return view(
            'admin.categories.edit',
            compact('category')
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

        $category = Category::findOrFail($id);

        $request->validate([

            'name' => 'required|unique:categories,name,'.$id,

        ], [

            'name.required' => 'Vui lòng nhập tên ngành nghề',

            'name.unique' => 'Tên ngành nghề đã tồn tại',

        ]);

        $category->update([

            'name' => $request->name,

        ]);

        return redirect('/admin/categories')

            ->with(
                'success',
                'Cập nhật ngành nghề thành công'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function destroy(string $id)
    {

        $category = Category::findOrFail($id);

        // Check có jobs không
        if ($category->jobs()->count() > 0) {

            return back()->with(
                'error',
                'Không thể xóa ngành nghề đã có jobs'
            );
        }

        $category->delete();

        return back()->with(
            'success',
            'Đã xóa ngành nghề'
        );
    }
}
