@extends('layouts.admin')
@section('title', 'Sửa hình thức làm việc')
@section('content')

    <div class="card">

        <div class="card-header">

            <h3>

                Cập nhật hình thức làm việc

            </h3>

        </div>


        <form method="POST" action="/admin/jobtypes/{{ $jobType->id }}">

            @csrf
            @method('PUT')

            <div class="card-body">

                <div class="form-group">

                    <label>Tên hình thức</label>

                    <input type="text" name="name" class="form-control" value="{{ $jobType->name }}">

                </div>

            </div>


            <div class="card-footer">

                <button class="btn btn-success">

                    Cập nhật

                </button>

            </div>

        </form>

    </div>

@endsection
