@extends('admin.includes.layout')

@section('title', 'Notifications')

@push('styles')
    <style>
        /* Modern Notification Cards Grid */
        .notification-card {
            background: #ffffff !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 16px !important;
            padding: 24px !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            position: relative;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.01) !important;
        }

        .notification-card.unread {
            background-color: #f8f9fa !important;
            border-left: 4px solid #ffb81c !important;
        }

        .notification-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.05) !important;
            border-color: rgba(255, 184, 28, 0.4) !important;
        }

        .notification-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: #ffb81c;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .notification-card:hover::before {
            opacity: 1;
        }

        .notification-badge-circle {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: rgba(255, 184, 28, 0.12);
            color: #ffb81c;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
            transition: all 0.3s ease;
        }

        .notification-card:hover .notification-badge-circle {
            background: #ffb81c;
            color: #ffffff;
            transform: scale(1.05);
        }

        .mark-read-btn {
            white-space: nowrap;
        }
    </style>
@endpush

@section('content')
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">
                <!-- Main Content -->
                <div class="col-md-12 p-0">
                    <div class="main-content">
                        <!-- Header -->
                        <div class="heading-area-sec mb-3">
                            <div class="left-part-sec">
                                <h3 class="mb-1">Notifications 🔔</h3>
                                <p class="text-muted mb-0">View and manage all your notifications.</p>
                            </div>
                            <div class="right-part-sec">
                                <button class="btn btn-dark" id="markAllAsReadPageBtn">Mark All as Read</button>
                            </div>
                        </div>

                        <!-- Cards Container -->
                        <div class="px-4 pb-4">
                            @if($notifications->isEmpty())
                                <div class="section-card text-center py-5">
                                    <div class="mb-3" style="font-size: 40px;">🔔</div>
                                    <h5 class="fw-semibold text-dark">No Notifications Found</h5>
                                    <p class="text-muted mb-0">You're all caught up!</p>
                                </div>
                            @else
                                <div class="row mx-0">
                                    @foreach($notifications as $notification)
                                        <div class="col-12 mb-4 px-2">
                                            <div class="notification-card h-100 d-flex flex-column {{ $notification->is_read ? '' : 'unread' }}">
                                                
                                                <div class="d-flex align-items-start justify-content-between mb-3">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="notification-badge-circle">
                                                            <i class="fa-solid fa-bell"></i>
                                                        </div>
                                                        <div>
                                                            <h4 class="mb-1 fw-bold text-dark" style="font-size: 16px; line-height: 1.3;">
                                                                {{ $notification->title }}
                                                                @if(!$notification->is_read)
                                                                    <span class="badge bg-primary ms-2" style="font-size: 10px;">New</span>
                                                                @endif
                                                            </h4>
                                                            <span class="text-muted" style="font-size: 12px;">
                                                                {{ $notification->created_at->format('M j, Y h:i A') }} ({{ $notification->created_at->diffForHumans() }})
                                                            </span>
                                                        </div>
                                                    </div>
                                                    @if(!$notification->is_read)
                                                        <button type="button" class="btn btn-sm btn-outline-dark mark-read-btn" data-id="{{ $notification->id }}">Mark Read</button>
                                                    @endif
                                                </div>

                                                <div class="notification-description text-muted flex-grow-1" style="font-size: 16px; line-height: 1.6;">
                                                    {{ $notification->message }}
                                                </div>
                                                
                                                @if($notification->module)
                                                    <div class="mt-3 pt-3 border-top d-flex align-items-center gap-2" style="border-color: #f3f4f6 !important;">
                                                        <div>
                                                            <span class="badge bg-secondary">{{ ucfirst($notification->module) }}</span>
                                                        </div>
                                                    </div>
                                                @endif

                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            // Mark Read Button
            $('.mark-read-btn').on('click', function () {
                let btn = $(this);
                let id = btn.data('id');

                $.ajax({
                    url: "/admin/notifications/" + id + "/mark-read",
                    type: "POST",
                    data: { _token: "{{ csrf_token() }}" },
                    success: function (res) {
                        if (res.success) {
                            toastr.success(res.message);
                            setTimeout(() => { location.reload(); }, 500);
                        }
                    },
                    error: function () {
                        toastr.error('An error occurred.');
                    }
                });
            });

            // Mark All Read Button
            $('#markAllAsReadPageBtn').on('click', function () {
                $.ajax({
                    url: "{{ route('admin.notifications.mark-all-read') }}",
                    type: "POST",
                    data: { _token: "{{ csrf_token() }}" },
                    success: function (res) {
                        if (res.success) {
                            toastr.success(res.message);
                            setTimeout(() => { location.reload(); }, 500);
                        }
                    },
                    error: function () {
                        toastr.error('An error occurred.');
                    }
                });
            });
        });
    </script>
@endpush
