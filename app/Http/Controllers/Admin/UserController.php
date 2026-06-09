<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // LIST USERS
    public function index(Request $request)
    {
        $query = User::query();

        /*
        |--------------------------------------------------------------------------
        | SEARCH KEYWORD
        |--------------------------------------------------------------------------
        */
        if ($request->user_id) {

            $query->where(
                'id',
                $request->user_id
            );
        }

        if ($request->keyword) {

            $query->where(function ($q) use ($request) {

                $q->where(
                    'name',
                    'like',
                    '%'.$request->keyword.'%'
                )
                    ->orWhere(
                        'email',
                        'like',
                        '%'.$request->keyword.'%'
                    );

            });
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER ROLE
        |--------------------------------------------------------------------------
        */

        if ($request->role !== null && $request->role !== '') {

            $query->where(
                'role',
                $request->role
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS
        |--------------------------------------------------------------------------
        */

        if ($request->status !== null && $request->status !== '') {

            $query->where(
                'status',
                $request->status
            );
        }

        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */

        $users = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'admin.users.index',
            compact('users')
        );
    }

    // CREATE FORM
    public function create()
    {
        return view('admin.users.create');
    }

    // STORE USER
    public function store(Request $request)
    {
        $request->validate([

            'name' => 'required|max:255',

            'email' => 'required|email|unique:users,email',

            'password' => 'required|min:6',

            'role' => 'required',

        ]);

        User::create([

            'name' => $request->name,

            'email' => $request->email,

            'password' => bcrypt($request->password),

            'role' => $request->role,

            'status' => $request->status,

        ]);

        return redirect('/admin/users')
            ->with('success', 'Thêm user thành công');
    }

    // EDIT FORM
    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    // UPDATE USER
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([

            'name' => 'required|max:255',

            'email' => 'required|email|unique:users,email,'.$user->id,

            'phone' => [

                'required',
                'regex:/^[0-9]{9,12}$/',

            ],

            'password' => [

                'nullable',
                'min:8',
                'regex:/^(?=.*[A-Za-z])(?=.*\d).+$/',

            ],

        ], [

            'phone.regex' => 'Số điện thoại phải từ 9-12 số',

            'password.min' => 'Mật khẩu tối thiểu 8 ký tự',

            'password.regex' => 'Mật khẩu phải có cả chữ và số',

        ]);

        $data = [

            'name' => $request->name,

            'email' => $request->email,

            'phone' => $request->phone,

            'role' => $request->role,

            'status' => $request->status,

        ];

        /*
        |------------------------------------------------------------------
        | UPDATE PASSWORD
        |------------------------------------------------------------------
        */

        if ($request->password) {

            $data['password'] = bcrypt(
                $request->password
            );

        }

        $user->update($data);

        return redirect('/admin/users')
            ->with(
                'success',
                'Cập nhật thành công'
            );
    }

    // DELETE USER
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return redirect('/admin/users')
            ->with('success', 'Xóa user thành công');
    }
}
