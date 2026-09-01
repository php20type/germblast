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

                        <!-- Header -->
                        <div class="heading-area-sec mb-3">
                            <div class="left-part-sec">
                                <h3 class="mb-1 text-uppercase">CORE VALUE PRAISE <span style="font-size: 24px;">🌟</span></h3>
                                <p class="text-muted mb-0">Review praise submissions and core values recognition.</p>
                            </div>
                            <div class="right-part-sec">
                                <a href="{{ route('admin.hr.praise.create') }}" class="btn btn-export">
                                    + SUBMIT PRAISE
                                </a>
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

                        <!-- Cards Content -->
                        <div class="px-4 pb-4">
                            @if($praises->isEmpty())
                                <div class="section-card text-center py-5">
                                    <div class="mb-3" style="font-size: 40px;">🌟</div>
                                    <h5 class="fw-semibold text-dark">No Praises Found</h5>
                                    <p class="text-muted mb-0">
                                        No core value praise has been submitted yet.
                                    </p>
                                </div>
                            @else
                                <div class="row mx-0">
                                    @foreach($praises as $praise)
                                        <div class="col-12 mb-4 px-2">
                                            <div class="reward-card h-100 d-flex flex-column">
                                                
                                                <div class="d-flex align-items-start justify-content-between mb-3">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="reward-badge-circle">
                                                            🌟
                                                        </div>
                                                        <div>
                                                            <h4 class="mb-1 text-dark" style="font-size: 16px; line-height: 1.3;">
                                                                {{ strtoupper($praise->core_value) }} Praise for <span class="fw-bold">{{ $praise->recipient_name }}</span>
                                                            </h4>
                                                            <span class="text-muted" style="font-size: 12px;">
                                                                {{ $praise->created_at->format('M j, Y') }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="reward-description text-muted flex-grow-1" style="font-size: 14px; line-height: 1.6;">
                                                    {{ $praise->reason ?: 'No reason provided.' }}
                                                </div>

                                                <div class="mt-3 pt-3 border-top d-flex align-items-center gap-2" style="border-color: #f3f4f6 !important;">
                                                    <div class="avatar-circle">
                                                        {{ strtoupper(substr($praise->sender->name ?? 'U', 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <span class="fw-semibold text-dark d-block" style="font-size: 13px; line-height: 1.2;">
                                                            {{ $praise->sender->name ?? 'Unknown' }}
                                                        </span>
                                                        <span class="text-muted" style="font-size: 11px;">Submitted By</span>
                                                    </div>
                                                </div>

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
