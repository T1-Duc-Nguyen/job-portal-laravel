<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    /*
    |-------------------------------------------------------
    | LIST
    |-------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = Skill::query()
            ->withCount([
                'jobs',
                'candidates',
            ]);

        // search
        if ($request->keyword) {

            $query->where(
                'name',
                'like',
                '%'.$request->keyword.'%'
            );
        }

        // filter
        if ($request->type == 'jobs') {

            $query->has('jobs');

        } elseif ($request->type == 'candidates') {

            $query->has('candidates');
        }

        // sort
        if ($request->sort == 'jobs') {

            $query->orderByDesc('jobs_count');

        } elseif ($request->sort == 'candidates') {

            $query->orderByDesc('candidates_count');

        } else {

            $query->latest();
        }

        $skills = $query
            ->paginate(10)
            ->withQueryString();

        return view(
            'admin.skills.index',
            compact('skills')
        );
    }

    /*
    |-------------------------------------------------------
    | CREATE
    |-------------------------------------------------------
    */

    public function create()
    {
        return view(
            'admin.skills.create'
        );
    }

    /*
    |-------------------------------------------------------
    | STORE
    |-------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([

            'name' => 'required|unique:skills,name',

        ]);

        Skill::create([

            'name' => $request->name,

        ]);

        return redirect('/admin/skills')
            ->with(
                'success',
                'Thêm skill thành công'
            );
    }

    /*
    |-------------------------------------------------------
    | EDIT
    |-------------------------------------------------------
    */

    public function edit($id)
    {
        $skill = Skill::findOrFail($id);

        return view(
            'admin.skills.edit',
            compact('skill')
        );
    }

    /*
    |-------------------------------------------------------
    | UPDATE
    |-------------------------------------------------------
    */

    public function update(
        Request $request,
        $id
    ) {

        $skill = Skill::findOrFail($id);

        $request->validate([

            'name' => 'required|unique:skills,name,'.$skill->id,

        ]);

        $skill->update([

            'name' => $request->name,

        ]);

        return redirect('/admin/skills')
            ->with(
                'success',
                'Cập nhật skill thành công'
            );
    }

    /*
    |-------------------------------------------------------
    | DELETE
    |-------------------------------------------------------
    */

    public function destroy($id)
    {
        $skill = Skill::findOrFail($id);

        $skill->delete();

        return back()->with(
            'success',
            'Đã xóa skill'
        );
    }
}
