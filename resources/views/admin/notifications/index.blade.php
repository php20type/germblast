@extends('admin.includes.layout')

@section('title', 'Notifications')

@push('styles')
    <style>
        /* Status Pills styling */
        .status-pill {
            font-size: 11px !important;
            font-weight: 700 !important;
            padding: 4px 10px !important;
            border-radius: 20px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 4px !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
            border: 1px solid transparent !important;
        }

        .status-pill-unread {
            background-color: rgba(255, 184, 28, 0.12) !important;
            color: #ffb81c !important;
            border-color: rgba(255, 184, 28, 0.2) !important;
        }

        .status-pill-module {
            background-color: rgba(107, 114, 128, 0.12) !important;
            color: #4b5563 !important;
            border-color: rgba(107, 114, 128, 0.2) !important;
        }

        /* Section Cards */
        .section-card {
            background: #ffffff !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 16px !important;
            padding: 25px !important;
            margin-bottom: 25px !important;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.02) !important;
            transition: all 0.3s ease !important;
        }

        .section-card.unread {
            border-left: 4px solid #ffb81c !important;
        }

        .section-card:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.04) !important;
        }
        
        .mark-read-btn {
            font-size: 12px;
            padding: 4px 12px;
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
                                <h3 class="mb-1 text-uppercase">NOTIFICATIONS <span style="font-size: 24px;">🔔</span></h3>
                                <p class="text-muted mb-0">View and manage all your notifications.</p>
                            </div>
                            <div class="right-part-sec">
                                <button class="btn btn-dark" id="markAllAsReadPageBtn">Mark All as Read</button>
                            </div>
                        </div>

                        <!-- Cards Container -->
                        <div class="px-4 pb-4 text-start">
                            @if($notifications->isEmpty())
                                <div class="text-center py-5">
                                    <div class="mb-3" style="font-size: 40px;">📭</div>
                                    <h5 class="fw-semibold text-dark">No Notifications Found</h5>
                                    <p class="text-muted mb-0">You're all caught up!</p>
                                </div>
                            @else
                                @foreach($notifications as $notification)
                                    <div class="section-card mt-3 {{ $notification->is_read ? '' : 'unread' }}">
                                        <div class="d-flex justify-content-between align-items-start border-bottom pb-3 mb-3">
                                            <div class="d-flex flex-column align-items-start">
                                                <div class="mb-2 d-flex gap-2">
                                                    @if($notification->module)
                                                        <span class="status-pill status-pill-module">{{ ucfirst($notification->module) }}</span>
                                                    @endif
                                                    @if(!$notification->is_read)
                                                        <span class="status-pill status-pill-unread">NEW</span>
                                                    @endif
                                                </div>
                                                <div class="text-muted small mt-1">
                                                    Received on <span class="fw-semibold text-dark">{{ $notification->created_at->format('M j, Y h:i A') }}</span> 
                                                    ({{ $notification->created_at->diffForHumans() }})
                                                </div>
                                            </div>
                                            @if(!$notification->is_read)
                                                <button type="button" class="btn btn-outline-dark mark-read-btn" data-id="{{ $notification->id }}">
                                                    <i class="fa-solid fa-check me-1"></i> Mark Read
                                                </button>
                                            @endif
                                        </div>
                                        <div class="mb-2">
                                            <h6 class="text-uppercase text-secondary fw-bold mb-2" style="font-size: 11px; letter-spacing: 0.5px;">{{ $notification->title }}</h6>
                                            <div class="text-dark" style="font-size: 15px; color: #374151; line-height: 1.5;">
                                                {{ $notification->message }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
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
