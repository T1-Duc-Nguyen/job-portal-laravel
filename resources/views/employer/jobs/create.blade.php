@extends('layouts.employer')
@section('title', 'Đăng tin tuyển dụng')
@section('content')

    <div class="card">

        <div class="card-header">

            <h3>Đăng tin tuyển dụng</h3>

        </div>


        <form method="POST" action="/employer/jobs">

            @csrf

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6">

                        <div class="form-group">

                            <label>Tiêu đề</label>

                            <input type="text" name="title" class="form-control">

                        </div>

                    </div>


                    <div class="col-md-3">

                        <div class="form-group">

                            <label>Lương tối thiểu</label>

                            <input type="number" name="salary_min" class="form-control">

                        </div>

                    </div>


                    <div class="col-md-3">

                        <div class="form-group">

                            <label>Lương tối đa</label>

                            <input type="number" name="salary_max" class="form-control">

                        </div>

                    </div>

                </div>


                <div class="row">

                    <div class="col-md-4">

                        <div class="form-group">

                            <label>Ngành nghề</label>

                            <select name="category_id" class="form-control">

                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">

                                        {{ $category->name }}

                                    </option>
                                @endforeach

                            </select>

                        </div>

                    </div>


                    <div class="col-md-4">

                        <div class="form-group">

                            <label>Địa điểm</label>

                            <select name="location_id" class="form-control">

                                @foreach ($locations as $location)
                                    <option value="{{ $location->id }}">

                                        {{ $location->name }}

                                    </option>
                                @endforeach

                            </select>

                        </div>

                    </div>


                    <div class="col-md-4">

                        <div class="form-group">

                            <label>Hình thức</label>

                            <select name="job_type_id" class="form-control">

                                @foreach ($jobTypes as $jobType)
                                    <option value="{{ $jobType->id }}">

                                        {{ $jobType->name }}

                                    </option>
                                @endforeach

                            </select>

                        </div>

                    </div>

                </div>


                <div class="form-group">

                    <label>Mô tả</label>

                    <textarea name="description" rows="6" class="form-control"></textarea>

                </div>


                <div class="form-group">

                    <label>Yêu cầu</label>

                    <textarea name="requirements" rows="6" class="form-control"></textarea>

                </div>
                <div class="form-group mt-3">

                    <label>Kỹ năng yêu cầu</label>

                    <select name="skills[]" class="form-control" multiple>

                        @foreach ($skills as $skill)
                            <option value="{{ $skill->id }}">

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

                <button class="btn btn-primary">

                    Đăng tin

                </button>

            </div>

        </form>

    </div>

@endsection
