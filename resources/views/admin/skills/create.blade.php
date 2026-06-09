@extends('layouts.admin')

@section('title', 'Thêm skill')

@section('content')

    <div class="card-modern p-4">

        <h3 class="fw-bold mb-4">
            Thêm Skill
        </h3>

        <form method="POST" action="/admin/skills">

            @csrf

            <div class="mb-4">

                <label class="form-label fw-semibold">

                    Tên skill

                </label>

                <input type="text" name="name" class="form-control rounded-4 p-3" placeholder="VD: Laravel">

            </div>

            <button class="btn btn-primary rounded-4 px-4">

                <i class="fa fa-save me-2"></i>

                Lưu Skill

            </button>

        </form>

    </div>

@endsection
