@extends('admin.includes.layout')

@section('title', 'Core Value Praise Submissions')

@section('content')
    <div class="companies-section my-4">
        <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @include('admin.hr.sidebar')

            <!-- Main Content -->
            <div class="col-md-10 p-0">
                <div class="main-content">
                    <div class="sales-dashboard">

                        {{-- Header --}}
                        <div class="heading-area-sec mb-3">
                            <div class="left-part-sec">
                                <h3 class="mb-1">Core Value Praise Submissions</h3>
                                <p class="text-muted mb-0">
                                    Review praise submissions and core values recognition.
                                </p>
                            </div>
                            <div class="right-part-sec">
                                <a href="{{ route('admin.hr.praise.create') }}" class="btn btn-export">+ Submit Praise</a>
                            </div>
                        </div>

                            @if(session('success'))
                                <div class="px-4">
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                </div>
                            @endif

                            {{-- Timeline --}}
                            <div class="px-4 pb-4 company-details-section">
                                <div class="section-card">

                                    <div class="timeline-container">
                                        <div class="timeline position-relative">

                                            @forelse($praises as $praise)
                                                <div class="timeline-item">
                                                    <div class="timeline-icon">
                                                        <i class="fas fa-angle-double-right"></i>
                                                    </div>
                                                    <div class="timeline-content">
                                                        <div class="timeline-header d-flex justify-content-between align-items-center">
                                                            <div class="timestamp text-muted small">
                                                                {{ $praise->created_at->format('g:i A \o\n M j, Y') }}
                                                            </div>
                                                            <span class="badge bg-info text-white">{{ $praise->core_value }}</span>
                                                        </div>
                                                        <div class="timeline-body mt-2">
                                                            <div class="activity-details">
                                                                <div class="activity-description">
                                                                    <div class="mb-2" style="font-size: 15px;">
                                                                        <strong class="text-dark">{{ $praise->sender->name ?? 'Unknown' }}</strong> 
                                                                        praised 
                                                                        <strong class="text-primary">{{ $praise->recipient_name }}</strong>
                                                                    </div>
                                                                    <div class="text-muted" style="white-space: pre-line;">
                                                                        {{ $praise->reason }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="text-center py-4">
                                                    <h6>NO PRAISES YET</h6>
                                                    <p class="text-muted mb-0">No core value praise has been submitted yet.</p>
                                                </div>
                                            @endforelse

                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
