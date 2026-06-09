@extends('layouts.admin')
@section('title', 'Thêm hình thức làm việc')
@section('content')

    <div class="card">

        <div class="card-header">

            <h3>

                Thêm hình thức làm việc

            </h3>

        </div>


        <form method="POST" action="/admin/jobtypes">

            @csrf

            <div class="card-body">

                <div class="form-group">

                    <label>Tên hình thức</label>

                    <input type="text" name="name" class="form-control">

                    @error('name')
                        <small class="text-danger">

                            {{ $message }}

                        </small>
                    @enderror

                </div>

            </div>


            <div class="card-footer">

                <button class="btn btn-primary">

                    Thêm mới

                </button>

            </div>

        </form>

    </div>

@endsection
