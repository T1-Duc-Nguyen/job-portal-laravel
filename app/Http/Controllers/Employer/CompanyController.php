<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Employer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    public function index()
    {
        $company = Employer::firstOrCreate(
            [
                'user_id' => Auth::id(),
            ],
            [
                'company_name' => Auth::user()->name,
                'slug' => Str::slug(Auth::user()->name),
            ]
        );

        return view(
            'employer.company.index',
            compact('company')
        );
    }

    public function update(Request $request)
    {
        $company = Employer::where(
            'user_id',
            Auth::id()
        )->first();

        if ($request->hasFile('logo')) {

            $logo = $request->file('logo')
                ->store('companies', 'public');

            $company->logo = 'storage/'.$logo;
        }

        if ($request->hasFile('banner')) {

            $banner = $request->file('banner')
                ->store('companies', 'public');

            $company->banner = 'storage/'.$banner;
        }

        $company->update([

            'company_name' => $request->company_name,
            'industry' => $request->industry,
            'website' => $request->website,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'description' => $request->description,
            'company_size' => $request->company_size,
            'founded_year' => $request->founded_year,
            'facebook' => $request->facebook,
            'linkedin' => $request->linkedin,

        ]);

        return back()->with(
            'success',
            'Cập nhật công ty thành công'
        );
    }

    public function show($slug)
    {
        $company = Employer::where(
            'slug',
            $slug
        )->firstOrFail();

        $jobs = $company->jobs()
            ->where('status', 1)
            ->latest()
            ->get();

        return view(
            'employer.company.show',
            compact(
                'company',
                'jobs'
            )
        );
    }
}
