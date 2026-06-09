@extends('layouts.admin')
@section('title', 'Sửa ngành nghề')
@section('content')

    <div class="card">

        <div class="card-header">

            <h3>

                Cập nhật ngành nghề

            </h3>

        </div>


        <form method="POST" action="/admin/categories/{{ $category->id }}">

            @csrf
            @method('PUT')

            <div class="card-body">

                <div class="form-group">

                    <label>Tên ngành nghề</label>

                    <input type="text" name="name" class="form-control" value="{{ $category->name }}">

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
