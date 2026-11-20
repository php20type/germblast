@extends('admin.includes.layout')

@section('title', 'HR Timecards')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/hr.css') }}?v={{ filemtime(public_path('css/hr.css')) }}">
@endpush

@section('content')

<div class="companies-section my-4">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @include('admin.hr.sidebar')

            <!-- Main Content -->
            <div class="col-md-10 p-0">
                <div class="main-content">

                    <!-- Header -->
                    <div class="heading-area-sec mb-3">
                        <div class="left-part-sec">
                            <h3 class="mb-1">Timecards</h3>
                            <p class="text-muted mb-0">Manage and review employee weekly time records</p>
                        </div>
                    </div>

                    <!-- Restyled Header Filter Control Bar -->
                    <div class="filter-section py-3 px-4 mx-4 my-3 rounded-3 border bg-white" style="border-color: #e5e7eb !important;">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">

                            <!-- Left Side: Current Range Header -->
                            <div>
                                <h4 class="mb-0 fw-bold text-dark" style="font-size: 18px;">
                                    Week of: {{ $start->format('M d, Y') }}
                                </h4>
                            </div>

                            <!-- Right Side: Unified Navigation Segment Control -->
                            <div class="d-flex align-items-center gap-1 bg-light p-1 rounded-3 border" style="border-color: #e5e7eb !important;">
                                <a href="{{ route('admin.hr.timecards.index', ['date' => $start->copy()->subWeek()->toDateString()]) }}" class="calendar-nav-btn" title="Previous Week">
                                    <i class="fas fa-chevron-left me-1" style="font-size: 10px;"></i> Prev Week
                                </a>

                                <span class="text-muted opacity-25 px-1">|</span>

                                <a href="{{ route('admin.hr.timecards.index', ['date' => now()->toDateString()]) }}" class="calendar-nav-btn {{ $start->toDateString() === now()->startOfWeek()->toDateString() ? 'btn-today' : '' }}">
                                    Current Week
                                </a>

                                <span class="text-muted opacity-25 px-1">|</span>

                                <a href="{{ route('admin.hr.timecards.index', ['date' => $start->copy()->addWeek()->toDateString()]) }}" class="calendar-nav-btn" title="Next Week">
                                    Next Week <i class="fas fa-chevron-right ms-1" style="font-size: 10px;"></i>
                                </a>
                            </div>

                        </div>
                    </div>

                    <!-- Main Grid Content -->
                    <div class="px-4 pb-4 mt-3">

                        {{-- EMPLOYEE SECTIONS --}}
                        @foreach ($users as $employee)

                            <div class="section-card">

                                {{-- Header --}}
                                <div class="section-header d-flex align-items-center gap-3">
                                    @if ($employee->profile_image)
                                        <img src="{{ asset('storage/' . $employee->profile_image) }}" alt="{{ $employee->name }}" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid #e5e7eb;">
                                    @else
                                        <div style="width:40px;height:40px;border-radius:50%;background:#ffb400;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:0.95rem;border:2px solid #ffb400;">
                                            {{ strtoupper(substr($employee->name, 0, 1)) }}
                                        </div>
                                    @endif

                                    <div>
                                        <h3 class="section-title mb-1">{{ $employee->name }}</h3>
                                    </div>

                                    <span class="ms-auto fw-semibold text-secondary d-flex align-items-center gap-2" style="font-size:0.9rem;">
                                        <span>{{ $employee->timecards->count() }} punch(es)</span>
                                        &bull;
                                        <span class="badge bg-light text-dark border">{{ number_format($employee->week_stats['reg_hours'], 2) }}h Reg</span>
                                        @if($employee->week_stats['ot_hours'] > 0)
                                            <span class="badge bg-warning text-dark">{{ number_format($employee->week_stats['ot_hours'], 2) }}h OT</span>
                                        @endif
                                        <span class="badge bg-primary text-white">{{ number_format($employee->week_stats['total_hours'], 2) }}h Total</span>
                                    </span>
                                </div>

                                {{-- Timecards Table or No Records --}}
                                @if ($employee->timecards->isEmpty())
                                    <div class="text-muted py-4 px-2 text-center" style="font-size: 14px; font-style: italic;">No clock activity this week.</div>
                                @else
                                    <table class="table table-hover w-100 equipment-report-table">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Customer</th>
                                                <th>Type</th>
                                                <th>In</th>
                                                <th>Out</th>
                                                <th>Hours</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($employee->timecards as $tc)
                                                <tr>
                                                    <td class="fw-semibold text-dark">{{ \Carbon\Carbon::parse($tc->work_date)->format('M d, Y') }}</td>
                                                    <td class="fw-bold text-dark">
                                                        @if($tc->company)
                                                            {{ $tc->company->name }}
                                                        @else
                                                            <span class="badge bg-danger text-white rounded-pill px-2 py-1" style="font-size: 11px;">No Jobs Associated</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-secondary">{{ $tc->clock_type_label }}</td>
                                                    <td>{{ $tc->clock_in ? \Carbon\Carbon::parse($tc->clock_in)->format('h:i A') : '-' }}</td>
                                                    <td>{{ $tc->clock_out ? \Carbon\Carbon::parse($tc->clock_out)->format('h:i A') : '-' }}</td>
                                                    <td><span class="badge bg-secondary text-white rounded-pill px-2 py-1">{{ isset($tc->calculated_hours) ? number_format($tc->calculated_hours, 2) : '-' }} hours</span></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr style="background-color: rgba(255, 184, 28, 0.05);">
                                                <td colspan="4" class="text-end fw-bold text-dark" style="padding: 15px 20px !important;">Totals</td>
                                                <td class="text-end text-muted" style="padding: 15px 20px !important;">
                                                    <small>Reg: {{ number_format($employee->week_stats['reg_hours'], 2) }} | OT: {{ number_format($employee->week_stats['ot_hours'], 2) }}</small>
                                                </td>
                                                <td class="text-start" style="padding: 15px 20px !important;">
                                                    <strong class="text-dark">{{ number_format($employee->week_stats['total_hours'], 2) }} hours</strong>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                @endif

                            </div>

                        @endforeach

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
