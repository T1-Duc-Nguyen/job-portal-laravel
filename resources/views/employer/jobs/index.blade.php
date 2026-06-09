@extends('layouts.employer')
@section('title', 'Danh sách việc làm')
@section('content')

    <div class="card">

        <div class="card-header">

            <h3 class="card-title">

                Danh sách việc làm

            </h3>


            <div class="card-tools">

                <a href="/employer/jobs/create" class="btn btn-primary btn-sm">

                    <i class="fa fa-plus"></i>
                    Đăng tin

                </a>

            </div>

        </div>


        <div class="card-body">

            @if (session('success'))
                <div class="alert alert-success">

                    {{ session('success') }}

                </div>
            @endif


            <table class="table table-bordered">

                <thead class="table-dark">

                    <tr>

                        <th>Job</th>

                        <th>Status</th>

                        <th>Salary</th>

                        <th width="180">Action</th>

                    </tr>

                </thead>


                <tbody>

                    @foreach ($jobs as $job)
                        <tr>

                            <td>

                                <b>{{ $job->title }}</b>

                            </td>


                            <td>

                                @if ($job->status == 0)
                                    <span class="badge bg-warning">

                                        Pending

                                    </span>
                                @elseif($job->status == 1)
                                    <span class="badge bg-success">

                                        Approved

                                    </span>
                                @else
                                    <span class="badge bg-danger" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="{{ $job->reject_reason ?? 'Không có lý do' }}">

                                        Rejected

                                    </span>
                                @endif

                            </td>


                            <td>

                                {{ number_format($job->salary_min) }}
                                -
                                {{ number_format($job->salary_max) }}

                            </td>


                            <td>
                                <div class="d-flex gap-2">

                                    {{-- SHOW --}}
                                    <a href="/employer/jobs/{{ $job->id }}"
                                        class="btn btn-sm btn-info text-white rounded-3" title="Xem chi tiết">

                                        <i class="fa fa-eye"></i>

                                    </a>

                                    {{-- EDIT --}}
                                    <a href="/employer/jobs/{{ $job->id }}/edit"
                                        class="btn btn-sm btn-warning rounded-3" title="Chỉnh sửa">

                                        <i class="fa fa-pen"></i>

                                    </a>

                                    {{-- DELETE --}}
                                    <form action="/employer/jobs/{{ $job->id }}" method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-sm btn-danger rounded-3"
                                            onclick="return confirm('Xóa tin tuyển dụng này?')" title="Xóa">

                                            <i class="fa fa-trash"></i>

                                        </button>

                                    </form>

                                </div>
                            </td>

                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center flex-wrap mt-4">

        <div class="text-muted small">

            Hiển thị
            <strong>{{ $jobs->firstItem() }}</strong>
            -
            <strong>{{ $jobs->lastItem() }}</strong>

            trong tổng số
            <strong>{{ $jobs->total() }}</strong>
            việc làm

        </div>

        <div>

            {{ $jobs->onEachSide(1)->links('pagination::bootstrap-5') }}

        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            var tooltipTriggerList = [].slice.call(
                document.querySelectorAll(
                    '[data-bs-toggle="tooltip"]'
                )
            );

            tooltipTriggerList.map(function(tooltipTriggerEl) {

                return new bootstrap.Tooltip(
                    tooltipTriggerEl
                );

            });

        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
