@extends('layouts.admin')
@section('title', 'Thêm người dùng')
@section('content')

    <div class="card">

        <div class="card-header">
            <h3>Thêm User</h3>
        </div>


        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif


            <form method="POST" action="/admin/users">

                @csrf

                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control">
                </div>


                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control">
                </div>


                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control">
                </div>


                <div class="mb-3">
                    <label>Role</label>

                    <select name="role" class="form-control">
                        <option value="0">Admin</option>
                        <option value="1">Candidate</option>
                        <option value="2">Employer</option>
                    </select>
                </div>


                <div class="mb-3">
                    <label>Status</label>

                    <select name="status" class="form-control">
                        <option value="1">Active</option>
                        <option value="0">Blocked</option>
                    </select>
                </div>


                <button class="btn btn-primary">
                    Save User
                </button>

            </form>

        </div>

    </div>

@endsection
