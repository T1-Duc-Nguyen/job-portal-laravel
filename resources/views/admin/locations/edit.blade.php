@extends('layouts.admin')
@section('title', 'Sửa địa điểm')
@section('content')

    <div class="card">

        <div class="card-header">

            <h3>

                Cập nhật địa điểm

            </h3>

        </div>


        <form method="POST" action="/admin/locations/{{ $location->id }}">

            @csrf
            @method('PUT')

            <div class="card-body">

                <div class="form-group">

                    <label>Tên địa điểm</label>

                    <input type="text" name="name" class="form-control" value="{{ $location->name }}">

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
