@extends('layouts.app')

@section('content')

<div class="container mt-5">

    <div class="card shadow border-0 rounded-4">

        <div class="card-body p-5">

            <h2 class="fw-bold mb-4">

                Upload CV AI

            </h2>

            @if(session('success'))

                <div class="alert alert-success">

                    {{ session('success') }}

                </div>

            @endif

            @if(session('error'))

                <div class="alert alert-danger">

                    {{ session('error') }}

                </div>

            @endif

            <form
                action="/candidate/cvs/store"
                method="POST"
                enctype="multipart/form-data">

                @csrf

                <div class="mb-4">

                    <label class="fw-bold mb-2">

                        Chọn file CV PDF

                    </label>

                    <input
                        type="file"
                        name="cv_file"
                        class="form-control">

                </div>

                <button class="btn btn-primary px-5">

                    Upload + AI Parse

                </button>

            </form>

        </div>

    </div>

</div>

@endsection