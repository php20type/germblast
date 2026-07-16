@extends('admin.includes.layout')

@section('title', 'My Training')

@push('styles')
    <style>
        .equipment-report-table {
            border-collapse: separate !important;
            border-spacing: 0 !important;
            border: 1px solid #f3f4f6 !important;
            border-radius: 12px !important;
            overflow: hidden !important;
            background: #fff !important;
            width: 100% !important;
            margin-top: 10px !important;
        }

        .equipment-report-table thead th {
            background-color: rgba(255, 184, 28, 0.4) !important;
            color: #374151 !important;
            font-weight: 600 !important;
            padding: 18px 20px !important;
            border-right: 1px solid rgba(0, 0, 0, 0.05) !important;
            font-size: 14px !important;
        }

        .equipment-report-table tbody td {
            padding: 15px 20px !important;
            vertical-align: middle !important;
            border-bottom: 1px solid #f3f4f6 !important;
            border-right: 1px solid rgba(0, 0, 0, 0.05) !important;
            font-size: 14px !important;
        }

        .category-header {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 12px 20px;
            margin-top: 30px;
            margin-bottom: 15px;
            border-left: 4px solid #ffb81c;
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
                    <div class="sales-dashboard">

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show mx-4 mt-3" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        
                        <!-- Header -->
                        <div class="heading-area-sec mb-3">
                            <div class="left-part-sec">
                                <h3 class="mb-1">MY TRAINING</h3>
                                <p class="text-muted mb-0">Complete your assigned training tests.</p>
                            </div>
                        </div>

                        <div class="px-4 pb-4">
                            @foreach($categories as $category)
                                @if($category->tests->count() > 0)
                                    <div class="category-header shadow-sm">
                                        <h5 class="mb-0 fw-bold text-dark">{{ $category->name }}</h5>
                                    </div>
                                    
                                    <div class="table-responsive">
                                        <table class="table table-hover w-100 equipment-report-table">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: left !important; width: 40%;">Training/Test Name</th>
                                                    <th style="text-align: center !important; width: 35%;">Test History</th>
                                                    <th style="text-align: center !important; width: 25%;">Due Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($category->tests as $test)
                                                    @php
                                                        $testAttempts = $userAttempts->where('training_test_id', $test->id);
                                                        $passed = $testAttempts->where('status', 'Passed')->count() > 0;
                                                        $attemptsUsed = $testAttempts->count();
                                                    @endphp
                                                    <tr>
                                                        <td style="text-align: left !important; padding: 20px !important;">
                                                            <div style="font-size: 15px; color: #374151; font-weight: 600;">
                                                                {{ $test->name }}
                                                            </div>
                                                            @if($test->description)
                                                                <div style="font-size: 13px; color: #6b7280; margin-top: 4px;">
                                                                    {{ $test->description }}
                                                                </div>
                                                            @endif
                                                        </td>
                                                        <td style="text-align: center !important; color: #6b7280; vertical-align: middle;">
                                                            @if($attemptsUsed > 0)
                                                                <div class="d-flex flex-column gap-2 align-items-center mt-2 mb-3">
                                                                    @foreach($testAttempts as $attempt)
                                                                        @if($attempt->status == 'Passed')
                                                                            <a href="{{ route('admin.employee-training.certificate', $attempt->id) }}" target="_blank" class="d-flex align-items-center justify-content-between px-3 py-2 w-100 text-decoration-none transition-all" style="max-width: 280px; background: #f0fdf4; border-radius: 6px; border: 1px solid #bbf7d0;">
                                                                                <div class="d-flex flex-column">
                                                                                    <span style="font-size: 13px;" class="text-success fw-bold">Attempt {{ $attempt->attempt_number }}</span>
                                                                                    <span class="fw-normal text-muted" style="font-size: 11px;">{{ \Carbon\Carbon::parse($attempt->submitted_at)->format('m/d/Y') }}</span>
                                                                                </div>
                                                                                <div class="d-flex flex-column text-end">
                                                                                    <span style="font-size: 13px;" class="fw-bold text-success">{{ round($attempt->score, 1) }}%</span>
                                                                                    <span style="font-size: 11px;" class="fw-bold text-success">{{ $attempt->status }}</span>
                                                                                </div>
                                                                            </a>
                                                                        @else
                                                                            <div class="d-flex align-items-center justify-content-between px-3 py-2 w-100" style="max-width: 280px; background: #f9fafb; border-radius: 6px; border: 1px solid #e5e7eb;">
                                                                                <div class="d-flex flex-column">
                                                                                    <span style="font-size: 13px;" class="text-muted fw-bold">Attempt {{ $attempt->attempt_number }}</span>
                                                                                    <span class="fw-normal text-muted" style="font-size: 11px;">{{ \Carbon\Carbon::parse($attempt->submitted_at)->format('m/d/Y') }}</span>
                                                                                </div>
                                                                                <div class="d-flex flex-column text-end">
                                                                                    <span style="font-size: 13px;" class="fw-bold text-danger">{{ round($attempt->score, 1) }}%</span>
                                                                                    <span style="font-size: 11px;" class="fw-bold text-danger">{{ $attempt->status }}</span>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                                <small class="text-muted">Total Attempts: {{ $attemptsUsed }}</small>
                                                            @else
                                                                <span class="text-muted fst-italic">Not Attempted</span>
                                                            @endif
                                                        </td>
                                                        <td style="text-align: center !important; padding: 20px !important; vertical-align: middle;">
                                                            @if($passed)
                                                                <span class="text-success fw-bold d-block mb-1"><i class="fa-solid fa-check-circle me-1"></i> Completed</span>
                                                                <a href="{{ route('admin.employee-training.show', $test->id) }}" class="btn btn-sm btn-outline-primary px-3 shadow-sm" style="border-radius: 8px; font-size: 13px;">
                                                                    Retake Test
                                                                </a>
                                                            @else
                                                                <a href="{{ route('admin.employee-training.show', $test->id) }}" class="btn btn-sm btn-primary px-4 fw-bold shadow-sm" style="border-radius: 8px;">
                                                                    {{ $attemptsUsed > 0 ? 'Retry Now' : 'Due Now' }}
                                                                </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            @endforeach

                            @if($categories->sum(function($cat) { return $cat->tests->count(); }) === 0)
                                <div class="alert alert-info mt-4">
                                    No active training tests available at the moment.
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
