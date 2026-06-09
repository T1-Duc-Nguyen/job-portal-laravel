@extends('layouts.app')

@section('title', 'Danh sách công ty')

@section('content')

<div class="container py-5">

    {{-- HEADER --}}
    <div class="companies-header mb-5">

        <div>

            <h2 class="fw-bold mb-2">

                Danh sách công ty tuyển dụng

            </h2>

            <p class="text-muted mb-0">

                Khám phá các doanh nghiệp đang tuyển dụng trên JobConnect

            </p>

        </div>

    </div>

    {{-- SEARCH --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-body p-4">

            <form method="GET">

                <div class="row g-3">

                    <div class="col-lg-10">

                        <div class="search-box">

                            <i class="fa fa-search"></i>

                            <input type="text"
                                   name="keyword"
                                   class="form-control"
                                   placeholder="Tên công ty..."
                                   value="{{ request('keyword') }}">

                        </div>

                    </div>

                    <div class="col-lg-2">

                        <button class="btn btn-primary w-100 filter-btn">

                            Tìm kiếm

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    {{-- LIST --}}
    <div class="row">

        @forelse($companies as $company)

            <div class="col-lg-4 col-md-6 mb-4">

                <div class="company-card">

                    {{-- TOP --}}
                    <div class="d-flex align-items-center gap-3 mb-4">

                        <img
                            src="{{ $company->logo
                                ? asset($company->logo)
                                : 'https://ui-avatars.com/api/?name='.urlencode($company->company_name)
                            }}"
                            class="company-logo">

                        <div>

                            <h5 class="fw-bold mb-1">

                                {{ $company->company_name }}

                            </h5>

                            <div class="small text-muted">

                                <i class="fa fa-briefcase me-1"></i>

                                {{ $company->jobs_count }} jobs

                            </div>

                        </div>

                    </div>

                    {{-- DESC --}}
                    <p class="company-desc">

                        {{ Str::limit($company->description, 120) }}

                    </p>

                    {{-- INFO --}}
                    <div class="company-meta">

                        @if($company->website)

                            <div>

                                <i class="fa fa-globe"></i>

                                Website công ty

                            </div>

                        @endif

                        <div>

                            <i class="fa fa-calendar"></i>

                            Tham gia {{ $company->created_at->format('d/m/Y') }}

                        </div>

                    </div>

                    {{-- BUTTON --}}
                    @if($company->slug)

                        <a href="{{ route('company.show', ['slug' => $company->slug]) }}"
                        class="btn btn-primary w-100 rounded-3 mt-4">

                            Xem công ty

                        </a>

                    @endif

                </div>

            </div>

        @empty

            <div class="col-12">

                <div class="empty-box">

                    <i class="fa fa-building"></i>

                    <h4>

                        Không có công ty nào

                    </h4>

                    <p>

                        Hệ thống chưa có dữ liệu công ty

                    </p>

                </div>

            </div>

        @endforelse

    </div>

    {{-- PAGINATION --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap mt-4 gap-3">

        <div class="text-muted small">

            Hiển thị
            <strong>{{ $companies->firstItem() }}</strong>
            -
            <strong>{{ $companies->lastItem() }}</strong>

            trong tổng số
            <strong>{{ $companies->total() }}</strong>
            công ty

        </div>

        <div>

            {{ $companies->onEachSide(1)->links('pagination::bootstrap-5') }}

        </div>

    </div>

</div>

<style>

body{

    background:#f4f7fb;

}

.companies-header h2{

    font-size:36px;
    font-weight:800;

}

.search-box{

    position:relative;

}

.search-box i{

    position:absolute;
    top:18px;
    left:18px;
    color:#94a3b8;

}

.search-box input{

    height:55px;
    border-radius:18px;
    padding-left:48px;
    border:1px solid #e5e7eb;

}

.search-box input:focus{

    box-shadow:none;
    border-color:#2563eb;

}

.filter-btn{

    height:55px;
    border-radius:18px;
    font-weight:700;

}

.company-card{

    background:#fff;
    border-radius:24px;
    padding:24px;
    border:1px solid #edf2f7;
    transition:.3s;
    height:100%;

}

.company-card:hover{

    transform:translateY(-6px);
    box-shadow:0 20px 40px rgba(15,23,42,0.08);

}

.company-logo{

    width:72px;
    height:72px;
    border-radius:20px;
    object-fit:cover;
    border:1px solid #e5e7eb;

}

.company-desc{

    color:#64748b;
    line-height:1.7;
    min-height:75px;

}

.company-meta{

    display:flex;
    flex-direction:column;
    gap:10px;
    color:#64748b;
    font-size:14px;

}

.company-meta i{

    width:18px;
    color:#2563eb;

}

.empty-box{

    background:#fff;
    border-radius:24px;
    padding:70px 20px;
    text-align:center;

}

.empty-box i{

    font-size:60px;
    color:#cbd5e1;
    margin-bottom:20px;

}

.empty-box p{

    color:#94a3b8;

}

</style>

@endsection