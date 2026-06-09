@extends('layouts.admin')
@section('title', 'Thêm địa điểm')
@section('content')

    <div class="card">

        <div class="card-header">

            <h3>

                Thêm địa điểm

            </h3>

        </div>


        <form method="POST" action="/admin/locations">

            @csrf

            <div class="card-body">

                <div class="form-group">

                    <label>Tên địa điểm</label>

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
