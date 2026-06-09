@extends('layouts.admin')

@section('title', 'Sưa skill')

@section('content')

    <div class="card-modern p-4">

        <h3 class="fw-bold mb-4">
            Cập nhật Skill
        </h3>

        <form method="POST" action="/admin/skills/{{ $skill->id }}">

            @csrf
            @method('PUT')

            <div class="mb-4">

                <label class="form-label fw-semibold">

                    Tên skill

                </label>

                <input type="text" name="name" value="{{ $skill->name }}" class="form-control rounded-4 p-3">

            </div>

            <button class="btn btn-success rounded-4 px-4">

                <i class="fa fa-save me-2"></i>

                Cập nhật

            </button>

        </form>

    </div>

@endsection
