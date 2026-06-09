<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Candidate;
use App\Models\CV;
use App\Models\SavedJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | MY PROFILE
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $candidate = Candidate::with('cvs')
            ->where('user_id', Auth::id())
            ->first();

        /*
        |--------------------------------------------------------------------------
        | NO PROFILE
        |--------------------------------------------------------------------------
        */

        if (! $candidate) {

            return redirect('/candidate/profile/edit')
                ->with(
                    'error',
                    'Vui lòng cập nhật hồ sơ'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | CHECK EMPTY PROFILE
        |--------------------------------------------------------------------------
        */

        $hasProfile =
            $candidate->full_name
            ||
            $candidate->phone
            ||
            $candidate->desired_position
            ||
            $candidate->skills
            ||
            $candidate->education
            ||
            $candidate->experience;

        /*
        |--------------------------------------------------------------------------
        | CHECK CV
        |--------------------------------------------------------------------------
        */

        $hasCV = $candidate->cvs->count() > 0;

        /*
        |--------------------------------------------------------------------------
        | REDIRECT EDIT
        |--------------------------------------------------------------------------
        */

        if (! $hasProfile || ! $hasCV) {

            return redirect('/candidate/profile/edit')
                ->with(
                    'error',
                    'Vui lòng upload CV và cập nhật đầy đủ hồ sơ'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | STATS
        |--------------------------------------------------------------------------
        */

        $applications = Application::where(
            'candidate_id',
            $candidate->id
        )->count();

        $savedJobs = SavedJob::where(
            'candidate_id',
            $candidate->id
        )->count();

        $cvCount = CV::where(
            'candidate_id',
            $candidate->id
        )->count();

        /*
        |--------------------------------------------------------------------------
        | EXPERIENCE JSON
        |--------------------------------------------------------------------------
        */

        $experience = [];

        if ($candidate->experience) {

            $decoded = json_decode(
                $candidate->experience,
                true
            );

            if (is_array($decoded)) {

                $experience = $decoded;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | EDUCATION JSON
        |--------------------------------------------------------------------------
        */

        $education = [];

        if ($candidate->education) {

            $decoded = json_decode(
                $candidate->education,
                true
            );

            if (is_array($decoded)) {

                $education = $decoded;
            }
        }

        return view(
            'candidate.profile.index',
            compact(
                'candidate',
                'applications',
                'savedJobs',
                'cvCount',
                'experience',
                'education'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT PROFILE
    |--------------------------------------------------------------------------
    */

    public function edit()
    {
        $candidate = Candidate::where(
            'user_id',
            Auth::id()
        )->first();

        return view(
            'candidate.profile.edit',
            compact('candidate')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE PROFILE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request)
    {
        $candidate = Candidate::where(

            'user_id',

            Auth::id()

        )->first();

        /*
        |--------------------------------------------------------------------------
        | UPLOAD AVATAR
        |--------------------------------------------------------------------------
        */

        $avatarPath = $candidate->avatar;

        if ($request->hasFile('avatar')) {

            $file = $request->file('avatar');

            $fileName =
                time().'_'.
                $file->getClientOriginalName();

            $avatarPath = $file->storeAs(
                'avatars',
                $fileName,
                'public'
            );

            $avatarPath = 'storage/'.$avatarPath;
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE DATA
        |--------------------------------------------------------------------------
        */

        $candidate->update([

            'avatar' => $avatarPath,

            'full_name' => $request->full_name,

            'phone' => $request->phone,

            'skills' => $request->skills,

            'experience' => $request->experience,

            'education' => $request->education,

            'desired_position' => $request->desired_position,

            'address' => $request->address,

            'description' => $request->description,

            'gender' => $request->gender,

            'birthday' => $request->birthday,

            'level' => $request->level,
        ]);

        return redirect(

            '/candidate/profile'

        )->with(

            'success',

            'Cập nhật hồ sơ thành công'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PASSWORD VIEW
    |--------------------------------------------------------------------------
    */

    public function password()
    {
        return view(
            'candidate.profile.password'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE PASSWORD
    |--------------------------------------------------------------------------
    */

    public function updatePassword(Request $request)
    {
        $request->validate([

            'current_password' => 'required',

            'password' => [

                'required',
                'min:8',
                'regex:/^(?=.*[A-Za-z])(?=.*\d).+$/',
                'confirmed',

            ],

        ], [

            // CURRENT PASSWORD
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại',

            // NEW PASSWORD
            'password.required' => 'Vui lòng nhập mật khẩu mới',

            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',

            'password.confirmed' => 'Xác nhận mật khẩu không khớp',

            'password.regex' => 'Mật khẩu phải có cả chữ và số',

        ]);

        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | CHECK CURRENT PASSWORD
        |--------------------------------------------------------------------------
        */

        if (
            ! Hash::check(
                $request->current_password,
                $user->password
            )
        ) {

            return back()
                ->withErrors([
                    'current_password' => 'Mật khẩu hiện tại không đúng',
                ])
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE PASSWORD
        |--------------------------------------------------------------------------
        */

        $user->update([

            'password' => Hash::make(
                $request->password
            ),

        ]);

        return back()->with(
            'success',
            'Đổi mật khẩu thành công'
        );
    }
}
