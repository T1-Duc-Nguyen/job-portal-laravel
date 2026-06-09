<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Employer;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // LOGIN VIEW
    public function showLogin()
    {
        return view('auth.login');
    }

    // REGISTER VIEW
    public function showRegister()
    {
        return view('auth.register');
    }

    // REGISTER
    public function register(Request $request)
    {
        $request->validate([

            'name' => 'required|max:255',

            'email' => 'required|email|unique:users,email',
            'phone' => [

                'required',
                'regex:/^[0-9]{9,12}$/',

            ],

            'password' => [

                'required',
                'min:8',
                'regex:/^(?=.*[A-Za-z])(?=.*\d).+$/',
                'confirmed',

            ],

            'role' => 'required',

        ], [

            // NAME
            'name.required' => 'Vui lòng nhập họ tên',

            // EMAIL
            'email.required' => 'Vui lòng nhập email',

            'email.email' => 'Email không hợp lệ',

            'email.unique' => 'Email này đã được đăng ký',
            // PHONE
            'phone.required' => 'Vui lòng nhập số điện thoại',

            'phone.regex' => 'Số điện thoại phải từ 9-12 số và chỉ chứa số',

            // PASSWORD
            'password.required' => 'Vui lòng nhập mật khẩu',

            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',

            'password.confirmed' => 'Xác nhận mật khẩu không đúng',

            'password.regex' => 'Mật khẩu phải có cả chữ và số',

        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'status' => 1,
        ]);

        /*
|--------------------------------------------------------------------------
| NOTIFICATION ADMIN
|--------------------------------------------------------------------------
*/

        $admins = User::where(
            'role',
            0
        )->get();

        foreach ($admins as $admin) {

            Notification::create([

                'user_id' => $admin->id,

                'content' => 'Người dùng mới "'.
                    $user->name.
                    '" vừa đăng ký tài khoản',
                'link' => '/admin/users?user_id='.$user->id,

                'is_read' => 0,

            ]);

        }
        // Candidate
        if ($user->role == 1) {

            Candidate::create([
                'user_id' => $user->id,
                'full_name' => $request->name,
            ]);
        }

        // Employer
        if ($user->role == 2) {

            Employer::create([
                'user_id' => $user->id,
                'company_name' => $request->company_name,
                'slug' => Str::slug($request->company_name).'-'.Str::random(10),
            ]);
        }

        return redirect('/login')
            ->with('status', 'Đăng ký thành công');
    }

    // LOGIN
    public function login(Request $request)
    {
        $request->validate([

            'email' => 'required|email',

            'password' => 'required',

        ]);

        $credentials = $request->only(
            'email',
            'password'
        );

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->role == 2) {

            $employer = Employer::where(
                'user_id',
                $user->id
            )->first();

            if (
                $employer &&
                !$employer->is_approved
            ) {

                Auth::logout();

                return back()->withErrors([
                    'email' =>
                    'Doanh nghiệp của bạn đang ở trạng thái Pending, vui lòng chờ Admin phê duyệt.'
                ]);
            }
        }

            // CHẶN ADMIN LOGIN USER PAGE
            if ($user->role == 0) {

                Auth::logout();

                return back()->withErrors([

                    'email' => 'Vui lòng đăng nhập tại trang admin',

                ]);

            }

            // CANDIDATE
            if ($user->role == 1) {

                return redirect('/');

            }

            // EMPLOYER
            if ($user->role == 2) {

                return redirect('/employer/dashboard');

            }

        }

        return back()->withErrors([

            'email' => 'Email hoặc mật khẩu không đúng',

        ])->withInput();
    }

    // LOGOUT
    public function logout()
    {
        Auth::logout();

        return redirect('/login');
    }
}
