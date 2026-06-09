<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Employer;
use Illuminate\Http\Request;

class CompanyControllerr extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LIST COMPANIES
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {

        $query = Employer::query()
            ->where('is_approved', 1)
            ->withCount('jobs');

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if ($request->keyword) {

            $query->where(
                'company_name',
                'like',
                '%'.$request->keyword.'%'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | SORT
        |--------------------------------------------------------------------------
        */

        if ($request->sort == 'jobs') {

            $query->orderByDesc('jobs_count');

        } else {

            $query->latest();

        }

        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */

        $companies = $query
            ->paginate(9)
            ->withQueryString();

        return view(
            'candidate.companies.index',
            compact('companies')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | COMPANY DETAIL
    |--------------------------------------------------------------------------
    */

    public function show($slug)
    {

        $company = Employer::where(
            'slug',
            $slug
        )->firstOrFail();

        return view(
            'candidate.companies.show',
            compact('company')
        );
    }
}
