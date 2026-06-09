<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employer;
use Illuminate\Http\Request;

class EmployerController extends Controller
{
    // LIST
    public function index(Request $request)
    {
        $query = Employer::with('user');

        // SEARCH
        if ($request->keyword) {

            $query->where(function ($q) use ($request) {

                $q->where('company_name', 'like', '%'.$request->keyword.'%')
                    ->orWhere('industry', 'like', '%'.$request->keyword.'%');

            });
        }

        // FILTER STATUS
        if ($request->status != '') {

            $query->where(
                'is_approved',
                $request->status
            );
        }

        $employers = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'admin.employers.index',
            compact('employers')
        );
    }

    // SHOW
    public function show(string $id)
    {
        $employer = Employer::with([
            'user',
            'jobs',
        ])->findOrFail($id);

        return view(
            'admin.employers.show',
            compact('employer')
        );
    }

    // APPROVE
    public function approve($id)
    {
        $employer = Employer::findOrFail($id);

        $employer->update([
            'is_approved' => 1,
        ]);

        return back()->with(
            'success',
            'Đã duyệt doanh nghiệp'
        );
    }

    // REJECT
    public function reject($id)
    {
        $employer = Employer::findOrFail($id);

        $employer->update([
            'is_approved' => 0,
        ]);

        return back()->with(
            'success',
            'Đã từ chối doanh nghiệp'
        );
    }

    // DELETE
    public function destroy(string $id)
    {
        $employer = Employer::findOrFail($id);

        $employer->delete();

        return back()->with(
            'success',
            'Đã xóa doanh nghiệp'
        );
    }
}
