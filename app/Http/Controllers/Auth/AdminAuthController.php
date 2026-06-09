<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LOGIN VIEW
    |--------------------------------------------------------------------------
    */

    public function showLogin()
    {
        return view('admin.auth.login');
    }

    /*
    |--------------------------------------------------------------------------
    | LOGIN
    |--------------------------------------------------------------------------
    */

    public function login(Request $request)
    {
        $request->validate([

            'email' => 'required|email',

            'password' => 'required',

        ]);

        $credentials = [

            'email' => $request->email,

            'password' => $request->password,

            'role' => 0,

        ];

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            return redirect('/admin');

        }

        return back()->withErrors([

            'email' => 'Tài khoản admin không đúng',

        ]);

    }

    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    public function logout()
    {
        Auth::logout();

        return redirect('/admin/login');
    }
}
