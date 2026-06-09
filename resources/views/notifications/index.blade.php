@extends('layouts.app')

@section('content')

<style>

    /* =========================
        NOTIFICATION PAGE
    ========================= */

    .notification-card{

        transition:0.25s;
        border-radius:20px;

    }

    .notification-card:hover{

        transform:translateY(-2px);
        box-shadow:0 8px 25px rgba(15,23,42,.06);

    }

    /* CHƯA ĐỌC */

    .notification-unread{

        background:#f8fbff;
        border:1px solid #dbeafe !important;

    }

    .notification-unread .notification-text{

        color:#0f172a;
        font-weight:700;

    }

    .notification-unread .notification-time{

        color:#2563eb;
        font-weight:600;

    }

    /* ĐÃ ĐỌC */

    .notification-read{

        background:#fff;
        border:1px solid #e2e8f0 !important;

    }

    .notification-read .notification-text{

        color:#94a3b8;
        font-weight:500;

    }

    .notification-read .notification-time{

        color:#0f172a;
        font-weight:500;

    }

    .notification-link{

        text-decoration:none;
        display:block;

    }

</style>

<div class="container py-4">

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body p-4">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <h3 class="fw-bold mb-0">

                    Thông báo của bạn

                </h3>

                <span class="badge bg-primary rounded-pill px-3 py-2">

                    {{ $notifications->total() }} thông báo

                </span>

            </div>

            @forelse($notifications as $notification)

                <a href="{{ $notification->link ?? '#' }}"
                   class="notification-link"
                   onclick="
                        fetch('/notifications/{{ $notification->id }}/read', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        });
                ">

                    <div class="
                        notification-card
                        p-3
                        mb-3
                        border
                        {{ $notification->is_read ? 'notification-read' : 'notification-unread' }}
                    ">

                        <div class="d-flex justify-content-between align-items-start gap-3">

                            {{-- LEFT --}}
                            <div class="flex-grow-1">

                                <div class="notification-text mb-2">

                                    {{ $notification->content }}

                                </div>

                                <small class="notification-time">

                                    <i class="fa fa-clock me-1"></i>

                                    {{ $notification->created_at
                                        ? $notification->created_at->diffForHumans()
                                        : 'Vừa xong'
                                    }}

                                </small>

                            </div>

                            {{-- RIGHT --}}
                            @if(!$notification->is_read)

                                <div>

                                    <span class="badge bg-primary rounded-pill">

                                        Mới

                                    </span>

                                </div>

                            @endif

                        </div>

                    </div>

                </a>

            @empty

                <div class="text-center py-5">

                    <i class="fa fa-bell-slash mb-3 text-secondary"
                       style="font-size:60px;"></i>

                    <h5>

                        Chưa có thông báo

                    </h5>

                </div>

            @endforelse
            <div class="card-footer bg-white border-0 px-4 py-4">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                <div class="text-muted small">

                    Hiển thị
                    <strong>{{ $notifications->firstItem() }}</strong>
                    -
                    <strong>{{ $notifications->lastItem() }}</strong>

                    trong tổng số
                    <strong>{{ $notifications->total() }}</strong>
                    thông báo

                </div>

                <div>

                    {{ $notifications->onEachSide(1)->links('pagination::bootstrap-5') }}

                </div>

            </div>

        </div>
            

        </div>

    </div>

</div>

@endsection