@extends('layouts.employer')
@section('title', 'Edit Job')
@section('content')

<div class="card">

    <div class="card-header">

        <h3>Cập nhật tin tuyển dụng</h3>

    </div>


    <form method="POST"
          action="/employer/jobs/{{ $job->id }}">

        @csrf
        @method('PUT')

        <div class="card-body">

            @if($errors->any())

                <div class="alert alert-danger">

                    @foreach($errors->all() as $error)

                        <div>{{ $error }}</div>

                    @endforeach

                </div>

            @endif


            <div class="row">

                <div class="col-md-6">

                    <div class="form-group">

                        <label>Tiêu đề</label>

                        <input type="text"
                               name="title"
                               class="form-control"
                               value="{{ $job->title }}">

                    </div>

                </div>


                <div class="col-md-3">

                    <div class="form-group">

                        <label>Lương tối thiểu</label>

                        <input type="number"
                               name="salary_min"
                               class="form-control"
                               value="{{ $job->salary_min }}">

                    </div>

                </div>


                <div class="col-md-3">

                    <div class="form-group">

                        <label>Lương tối đa</label>

                        <input type="number"
                               name="salary_max"
                               class="form-control"
                               value="{{ $job->salary_max }}">

                    </div>

                </div>

            </div>


            <div class="row">

                <div class="col-md-4">

                    <div class="form-group">

                        <label>Ngành nghề</label>

                        <select name="category_id"
                                class="form-control">

                            @foreach($categories as $category)

                                <option value="{{ $category->id }}"
                                    {{ $job->category_id == $category->id ? 'selected' : '' }}>

                                    {{ $category->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>


                <div class="col-md-4">

                    <div class="form-group">

                        <label>Địa điểm</label>

                        <select name="location_id"
                                class="form-control">

                            @foreach($locations as $location)

                                <option value="{{ $location->id }}"
                                    {{ $job->location_id == $location->id ? 'selected' : '' }}>

                                    {{ $location->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>


                <div class="col-md-4">

                    <div class="form-group">

                        <label>Hình thức</label>

                        <select name="job_type_id"
                                class="form-control">

                            @foreach($jobTypes as $jobType)

                                <option value="{{ $jobType->id }}"
                                    {{ $job->job_type_id == $jobType->id ? 'selected' : '' }}>

                                    {{ $jobType->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>

            </div>


            <div class="form-group">

                <label>Mô tả công việc</label>

                <textarea name="description"
                          rows="6"
                          class="form-control">{{ $job->description }}</textarea>

            </div>


            <div class="form-group">

                <label>Yêu cầu ứng viên</label>

                <textarea name="requirements"
                          rows="6"
                          class="form-control">{{ $job->requirements }}</textarea>

            </div>
            <div class="form-group mt-3">

    <label>Kỹ năng yêu cầu</label>

    <select name="skills[]"
            class="form-control"
            multiple>

        @foreach($skills as $skill)

            <option value="{{ $skill->id }}"
                {{ $job->skills->contains($skill->id) ? 'selected' : '' }}>

                {{ $skill->name }}

            </option>

        @endforeach

    </select>

    <small class="text-muted">
        Giữ Ctrl để chọn nhiều kỹ năng
    </small>

</div>

        </div>


        <div class="card-footer">

            <button class="btn btn-success">

                <i class="fa fa-save"></i>
                Cập nhật

            </button>


            <a href="/employer/jobs"
               class="btn btn-secondary">

                Quay lại

            </a>

        </div>

    </form>

</div>

@endsection