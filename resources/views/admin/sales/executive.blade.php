@extends('admin.includes.layout')

@section('title', 'Executive Sales Dashboard')

@push('styles')
    <style>
        /* Calendar Navigation Button from Vehicle Planning */
        .calendar-nav-btn {
            color: #4b5563 !important;
            font-size: 11px !important;
            font-weight: 700 !important;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 8px 16px !important;
            border-radius: 6px !important;
            transition: all 0.15s ease;
            text-decoration: none !important;
            display: inline-flex;
            align-items: center;
        }

        .calendar-nav-btn:hover {
            background-color: #f3f4f6 !important;
            color: #1f2937 !important;
        }

        .calendar-nav-btn.btn-today {
            background-color: #ffb400 !important;
            color: #ffffff !important;
            box-shadow: 0 2px 4px rgba(255, 180, 0, 0.15) !important;
        }

        .calendar-nav-btn.btn-today:hover {
            background-color: #e6a200 !important;
            color: #ffffff !important;
        }

        /* Boxed Table System from Equipment Management */
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
            text-align: center;
            white-space: nowrap;
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
            text-align: center;
            white-space: nowrap;
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

        /* Section Card Refinement */
        .section-card {
            background: #ffffff !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 16px !important;
            padding: 25px !important;
            margin-bottom: 25px !important;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.02) !important;
            transition: all 0.3s ease !important;
        }

        .section-card:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.04) !important;
        }

        .section-title {
            font-size: 18px !important;
            font-weight: 600 !important;
            color: #374151 !important;
            margin-bottom: 0 !important;
        }

        .section-subtitle {
            font-size: 13px !important;
            color: #6b7280 !important;
            margin-top: 4px !important;
            margin-bottom: 0 !important;
        }

        .section-header {
            border-bottom: 1px solid #f3f4f6 !important;
            padding-bottom: 15px !important;
            margin-bottom: 20px !important;
        }

        /* Custom Premium Status Badges & Selectors */
        .status-pill {
            font-size: 12px !important;
            font-weight: 600 !important;
            padding: 6px 14px !important;
            border-radius: 30px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 6px !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
            border: 1px solid transparent !important;
        }

        .status-pill-won {
            background-color: rgba(6, 150, 151, 0.12) !important;
            color: #069697 !important;
            border-color: rgba(6, 150, 151, 0.25) !important;
        }

        .status-pill-lost {
            background-color: rgba(234, 61, 47, 0.12) !important;
            color: #ea3d2f !important;
            border-color: rgba(234, 61, 47, 0.2) !important;
        }

        .status-pill-open {
            background-color: rgba(13, 110, 253, 0.12) !important;
            color: #0d6efd !important;
            border-color: rgba(13, 110, 253, 0.2) !important;
        }
    </style>
@endpush

@section('content')

    <!-- All Companies Section start  -->
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                @include('admin.sales.sidebar')

                <!-- Main Content -->
                <div class="col-md-10 p-0">
                    <div class="main-content">

                        <!-- Header (matching GermBlast standard index layout) -->
                        <div class="heading-area-sec px-4 pt-4 mb-3">
                            <div class="left-part-sec">
                                <h3 class="mb-1">EXECUTIVE SALES DASHBOARD <span style="font-size: 24px;">📊</span></h3>
                                <p class="text-muted mb-0">Overview of sales metrics, services, and monthly performance breakdown</p>
                            </div>
                        </div>

                        <!-- Restyled Header Filter Control Bar (Matching Vehicle Planning exactly) -->
                        <div class="filter-section py-3 px-4 mx-4 my-3 rounded-3 border bg-white"
                            style="border-color: #e5e7eb !important;">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">

                                <!-- Left Side: Current Range Header -->
                                <div>
                                    <h4 class="mb-0 fw-bold text-dark" style="font-size: 18px;">
                                        Month of: {{ $start->format('F Y') }}
                                    </h4>
                                </div>

                                <!-- Right Side: Unified Navigation Segment Control -->
                                <div class="d-flex align-items-center gap-1 bg-light p-1 rounded-3 border"
                                    style="border-color: #e5e7eb !important;">
                                    <a href="{{ route('admin.sales.executive', ['date' => $start->copy()->subMonth()->toDateString()]) }}"
                                        class="calendar-nav-btn" title="Previous Month">
                                        <i class="fas fa-chevron-left me-1" style="font-size: 10px;"></i> Prev Month
                                    </a>

                                    <span class="text-muted opacity-25 px-1">|</span>

                                    <a href="{{ route('admin.sales.executive', ['date' => now()->toDateString()]) }}"
                                         class="calendar-nav-btn {{ $start->format('Y-m') === now()->format('Y-m') ? 'btn-today' : '' }}">
                                         Current Month
                                     </a>

                                    <span class="text-muted opacity-25 px-1">|</span>

                                    <a href="{{ route('admin.sales.executive', ['date' => $start->copy()->addMonth()->toDateString()]) }}"
                                        class="calendar-nav-btn" title="Next Month">
                                        Next Month <i class="fas fa-chevron-right ms-1" style="font-size: 10px;"></i>
                                    </a>
                                </div>

                            </div>
                        </div>

                        <!-- Main Grid Content -->
                        <div class="px-4 pb-4 mt-3">

                            <!-- Services This Month Section -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header">
                                            <div>
                                                <h3 class="section-title">SERVICES THIS MONTH</h3>
                                                <p class="section-subtitle">All active services for this month</p>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="equipment-report-table">
                                                <thead>
                                                    <tr>
                                                        <th>Client</th>
                                                        <th>Status</th>
                                                        <th>Service ID</th>
                                                        <th>Service Value</th>
                                                        <th>Assignee</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($servicesThisMonth as $service)
                                                        <tr>
                                                            {{-- CLIENT --}}
                                                            <td>
                                                                @if ($service->lead?->company)
                                                                    <a href="{{ route('admin.company.show', $service->lead->company->id) }}"
                                                                        class="fw-bold text-decoration-none text-primary">
                                                                        {{ $service->lead->company->name }}
                                                                    </a>
                                                                @else
                                                                    {{ $service->lead?->name ?? 'N/A' }}
                                                                @endif
                                                            </td>

                                                            {{-- STATUS (dynamic based on lead) --}}
                                                            <td>
                                                                @php
                                                                    $status = $service->lead->lead_status ?? 'open';
                                                                    $badgeClass = match($status) {
                                                                        'won' => 'status-pill-won',
                                                                        'lost' => 'status-pill-lost',
                                                                        default => 'status-pill-open'
                                                                    };
                                                                @endphp
                                                                <span class="status-pill {{ $badgeClass }}">
                                                                    {{ ucfirst($status) }}
                                                                </span>
                                                            </td>

                                                            {{-- SERVICE ID --}}
                                                            <td class="fw-semibold text-dark">{{ $service->id }}</td>

                                                            {{-- VALUE --}}
                                                            <td class="fw-bold text-dark">
                                                                ${{ number_format($service->total_price ?? 0, 2) }}
                                                            </td>

                                                            {{-- ASSIGNEE --}}
                                                            <td class="text-secondary">
                                                                {{ $service->lead?->assignee?->name ?? 'Unassigned' }}
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="5" class="text-center text-muted py-4">
                                                                No services found for this month.
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Service Value Reports Row -->
                            <div class="row">
                                {{-- INDUSTRY --}}
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header">
                                            <div>
                                                <h3 class="section-title">SERVICE VALUE BY INDUSTRY TYPE</h3>
                                                <p class="section-subtitle">Industry breakdown</p>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="equipment-report-table">
                                                <thead>
                                                    <tr>
                                                        <th>Industry</th>
                                                        <th>Service Value</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($serviceValueByIndustry->sortDesc() as $industry => $value)
                                                        <tr>
                                                            <td class="fw-semibold text-dark">
                                                                {{ $industry && $industry !== 'Unknown' ? $industry : 'Unknown' }}
                                                            </td>
                                                            <td class="fw-bold text-dark">
                                                                ${{ number_format($value ?? 0, 2) }}
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="2" class="text-center text-muted py-4">
                                                                No data available.
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                {{-- ASSIGNEE --}}
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header">
                                            <div>
                                                <h3 class="section-title">SERVICE VALUE BY ASSIGNEE / SALES REP</h3>
                                                <p class="section-subtitle">Top assignees this month</p>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="equipment-report-table">
                                                <thead>
                                                    <tr>
                                                        <th>Assignee</th>
                                                        <th>Service Value</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($serviceValueByAssignee->sortDesc() as $assignee => $value)
                                                        <tr>
                                                            <td class="fw-semibold text-dark">
                                                                {{ $assignee ?? 'Unassigned' }}
                                                            </td>
                                                            <td class="fw-bold text-dark">
                                                                ${{ number_format($value ?? 0, 2) }}
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="2" class="text-center text-muted py-4">
                                                                No data available.
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Top 10 Clients and Contracts Won Row -->
                            <div class="row">

                                {{-- TOP CLIENTS --}}
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header">
                                            <div>
                                                <h3 class="section-title">TOP 10 CLIENTS BY SERVICE VALUE</h3>
                                                <p class="section-subtitle">Highest value clients this month</p>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="equipment-report-table">
                                                <thead>
                                                    <tr>
                                                        <th>Client</th>
                                                        <th>Total Services</th>
                                                        <th>Service Value</th>
                                                        <th>Assignee</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($topClients as $client)
                                                        <tr>
                                                            {{-- CLIENT --}}
                                                            <td class="fw-semibold text-dark">{{ $client['company'] ?? 'N/A' }}</td>

                                                            {{-- COUNT --}}
                                                            <td>{{ $client['services']->count() }}</td>

                                                            {{-- VALUE --}}
                                                            <td class="fw-bold text-dark">${{ number_format($client['total_value'] ?? 0, 2) }}</td>

                                                            {{-- ASSIGNEE --}}
                                                            <td class="text-secondary">
                                                                {{ $client['services']->first()?->lead?->assignee?->name ?? 'Unassigned' }}
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="4" class="text-center text-muted py-4">
                                                                No clients found.
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                {{-- CONTRACTS WON --}}
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header">
                                            <div>
                                                <h3 class="section-title">CONTRACTS WON THIS MONTH</h3>
                                                <p class="section-subtitle">Won contracts summary</p>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="equipment-report-table">
                                                <thead>
                                                    <tr>
                                                        <th>Client</th>
                                                        <th># of Services</th>
                                                        <th>Service Value</th>
                                                        <th>Assignee</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($contractsWon as $contract)
                                                        <tr>
                                                            <td class="fw-semibold text-dark">{{ $contract['company'] ?? 'N/A' }}</td>
                                                            <td>{{ $contract['count'] }}</td>
                                                            <td class="fw-bold text-dark">${{ number_format($contract['total_value'] ?? 0, 2) }}</td>
                                                            <td class="text-secondary">{{ $contract['assignee'] ?? 'Unassigned' }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="4" class="text-center text-muted py-4">
                                                                No contracts found.
                                                            </td>
                                                        </tr>
                                                    @endforelse

                                                    {{-- TOTAL --}}
                                                    <tr style="background-color: rgba(255, 184, 28, 0.05);">
                                                        <td colspan="4" class="text-center fw-bold text-dark" style="padding: 18px 20px !important; font-size: 15px;">
                                                            NEW CONTRACT VALUE: ${{ number_format($newContractValue ?? 0, 2) }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
        <!-- All Companies Section End  -->
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

        });

    </script>
@endpush
