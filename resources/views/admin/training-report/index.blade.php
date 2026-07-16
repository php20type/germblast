@extends('admin.includes.layout')

@section('title', 'Training Report')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
    /* Equipment Report Table Boxed Styling from EQ */
    .equipment-report-table {
        border: 1px solid #e5e7eb !important;
        border-radius: 12px !important;
        border-collapse: separate !important;
        border-spacing: 0 !important;
        overflow: hidden !important;
        background: #fff !important;
        width: 100% !important;
        margin-top: 10px !important;
    }

    .equipment-report-table thead th {
        background-color: rgba(255, 184, 28, 0.4) !important;
        border-bottom: 1px solid #e5e7eb !important;
        color: #374151 !important;
        font-weight: 600 !important;
        padding: 18px 20px !important;
        border-right: 1px solid rgba(0, 0, 0, 0.05) !important;
        font-size: 14px !important;
    }

    .equipment-report-table thead th:first-child {
        border-top-left-radius: 12px !important;
    }

    .equipment-report-table thead th:last-child {
        border-top-right-radius: 12px !important;
        border-right: none !important;
    }

    .equipment-report-table td {
        padding: 15px 20px !important;
        vertical-align: middle !important;
        border-bottom: 1px solid #f3f4f6 !important;
        border-right: 1px solid rgba(0, 0, 0, 0.05) !important;
        font-size: 14px !important;
    }

    .equipment-report-table td:last-child {
        border-right: none !important;
    }

    .equipment-report-table tbody tr:last-child td {
        border-bottom: none !important;
    }

    .equipment-report-table tbody tr:last-child td:first-child {
        border-bottom-left-radius: 12px !important;
    }

    .equipment-report-table tbody tr:last-child td:last-child {
        border-bottom-right-radius: 12px !important;
    }
    
    .status-badge {
        padding: 5px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
        margin-bottom: 5px;
        text-transform: uppercase;
    }
    .status-passed {
        background-color: #d1e7dd;
        color: #0f5132;
    }
    .status-failed {
        background-color: #f8d7da;
        color: #842029;
    }
    .status-not-started {
        background-color: #e2e3e5;
        color: #41464b;
    }
    .attempt-item {
        font-size: 11px;
        padding: 4px 6px;
        border-radius: 4px;
        margin-bottom: 4px;
        border: 1px solid #e5e7eb;
        background: #f8f9fa;
    }
    .attempt-item.passed {
        background: #f0fdf4;
        border-color: #bbf7d0;
        color: #166534;
    }
    .attempt-item.failed {
        background: #fef2f2;
        border-color: #fecaca;
        color: #991b1b;
    }
</style>
@endpush

@section('content')
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                @include('admin.operations.sidebar')

                <!-- Main Content -->
                <div class="col-md-10 p-0">
                    <div class="main-content">

                        <!-- Header -->
                        <div class="heading-area-sec mb-3">
                            <div class="left-part-sec">
                                <h3 class="mb-1">Training Employee Report</h3>
                                <p class="text-muted mb-0">Track and analyze employee training progress across all tests.</p>
                            </div>
                        </div>
                        
                        <!-- Table Container (Directly like EQ) -->
                        <div class="px-4 pb-4">
                            <div class="table-responsive">
                                <table id="trainingReportTable" class="table table-hover w-100 equipment-report-table mb-0">
                                    <thead>
                                        <tr>
                                            <th style="width: 100px;">Profile</th>
                                            <th style="min-width: 200px;">Employee</th>
                                            @foreach($tests as $test)
                                                <th style="min-width: 200px; text-align: center;">
                                                    <div class="text-dark">{{ $test->name }}</div>
                                                    @if($test->passing_percentage)
                                                    <div style="font-size: 11px; color: #495057; font-weight: normal; margin-top: 4px;">
                                                        Req. Pass: {{ $test->passing_percentage }}%
                                                    </div>
                                                    @endif
                                                </th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($employees as $employee)
                                            <tr>
                                                <td>
                                                    @if($employee->profile_image)
                                                        <img src="{{ asset('storage/' . $employee->profile_image) }}" alt="profile" style="width:60px; height:60px; object-fit:cover; border-radius:50%;">
                                                    @else
                                                        <img src="{{ asset('img/home/default-profile.png') }}" alt="profile" style="width:60px; height:60px; object-fit:cover; border-radius:50%;">
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="fw-semibold text-dark">{{ $employee->name }}</span>
                                                    <div class="small text-muted" style="font-size: 12px;">{{ $employee->email }}</div>
                                                    <div style="font-size: 11px; color: #6c757d; margin-top: 2px;">{{ ucfirst($employee->role) }}</div>
                                                </td>
                                                
                                                @foreach($tests as $test)
                                                    @php
                                                        $cell = $matrix[$employee->id][$test->id];
                                                        $attempts = $cell['attempts'];
                                                    @endphp
                                                    <td style="text-align: center;">
                                                        @if($cell['status'] == 'Passed')
                                                            <span class="status-badge status-passed">PASSED</span>
                                                        @elseif($cell['status'] == 'Failed')
                                                            <span class="status-badge status-failed">FAILED</span>
                                                        @else
                                                            <span class="status-badge status-not-started">NOT STARTED</span>
                                                        @endif
                                                        
                                                        @if($attempts && $attempts->count() > 0)
                                                            <div class="mt-2 text-start d-flex flex-column gap-1">
                                                                @foreach($attempts as $attempt)
                                                                    @if($attempt->status == 'Passed')
                                                                        <a href="{{ route('admin.employee-training.certificate', $attempt->id) }}" target="_blank" class="text-decoration-none attempt-item d-flex justify-content-between align-items-center {{ strtolower($attempt->status) }}">
                                                                            <span><span class="fw-bold">Att {{ $attempt->attempt_number }}:</span> {{ round($attempt->score, 1) }}%</span>
                                                                            <span style="font-size: 10px;">{{ \Carbon\Carbon::parse($attempt->submitted_at)->format('m/d/y') }}</span>
                                                                        </a>
                                                                    @else
                                                                        <div class="attempt-item d-flex justify-content-between align-items-center {{ strtolower($attempt->status) }}">
                                                                            <span><span class="fw-bold">Att {{ $attempt->attempt_number }}:</span> {{ round($attempt->score, 1) }}%</span>
                                                                            <span style="font-size: 10px;">{{ \Carbon\Carbon::parse($attempt->submitted_at)->format('m/d/y') }}</span>
                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function () {
            // Initialize DataTable
            $('#trainingReportTable').DataTable({
                pageLength: 10,
                ordering: false,
                dom: '<"d-flex justify-content-between align-items-center mb-3"l f>r<"table-responsive"t><"d-flex justify-content-between align-items-center mt-3"i p>',
                language: {
                    search: '',
                    searchPlaceholder: 'Search...',
                    lengthMenu: 'Show _MENU_ entries',
                    info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                    paginate: { previous: 'Previous', next: 'Next' }
                }
            });
        });
    </script>
@endpush
