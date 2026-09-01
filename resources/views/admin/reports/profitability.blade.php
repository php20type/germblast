@extends('admin.includes.layout')

@section('title', 'Job Profitability')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>


        /* Pastel Row Colors */
        .row-green {
            background-color: #e2f0d9 !important;
        }
        .row-pink {
            background-color: #fce8e6 !important;
        }
        .row-yellow {
            background-color: #fff2cc !important;
        }

        /* Text colors */
        .text-success-custom {
            color: #2e7d32 !important;
            font-weight: 600;
        }
        .text-danger-custom {
            color: #c0392b !important;
            font-weight: 600;
        }
        .client-link {
            color: #1a73e8 !important;
            font-weight: 500;
            text-decoration: none;
        }
        .client-link:hover {
            text-decoration: underline;
        }

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
    </style>
@endpush

@section('content')

    <div class="companies-section my-4">
        <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @include('admin.corporate-tools.sidebar')

            <!-- Main Content -->
            <div class="col-md-10 p-0">
                <div class="main-content">

                        <!-- Header matching GermBlast standard layout -->
                        <div class="heading-area-sec mb-3">
                            <div class="left-part-sec">
                                <h3 class="mb-1">Profitability This Month <span style="font-size: 24px;">📈</span></h3>
                                <p class="text-muted mb-0">Last Updated: {{ now()->format('m/d/y') }}</p>
                            </div>
                        </div>

                        <!-- Restyled Header Filter Control Bar (Matching All Schedules exactly) -->
                        <div class="filter-section py-3 px-4 mx-4 my-3 rounded-3 border bg-white"
                            style="border-color: #e5e7eb !important;">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">

                                <!-- Left Side: Current Range Header -->
                                <div>
                                    <h4 class="mb-0 fw-bold text-dark" style="font-size: 18px;">
                                        Month of: {{ $date->format('F Y') }}
                                    </h4>
                                </div>

                                <!-- Right Side: Unified Navigation Segment Control -->
                                <div class="d-flex align-items-center gap-1 bg-light p-1 rounded-3 border"
                                    style="border-color: #e5e7eb !important;">
                                    <a href="{{ route('admin.job-profitability.index', ['date' => $date->copy()->subMonth()->toDateString()]) }}" class="calendar-nav-btn" title="Previous Month">
                                        <i class="fas fa-chevron-left me-1" style="font-size: 10px;"></i> Prev Month
                                    </a>

                                    <span class="text-muted opacity-25 px-1">|</span>

                                    <a href="{{ route('admin.job-profitability.index', ['date' => now()->toDateString()]) }}" class="calendar-nav-btn {{ $date->format('Y-m') === now()->format('Y-m') ? 'btn-today' : '' }}">
                                         Current Month
                                     </a>

                                    <span class="text-muted opacity-25 px-1">|</span>

                                    <a href="{{ route('admin.job-profitability.index', ['date' => $date->copy()->addMonth()->toDateString()]) }}" class="calendar-nav-btn" title="Next Month">
                                        Next Month <i class="fas fa-chevron-right ms-1" style="font-size: 10px;"></i>
                                    </a>
                                </div>

                            </div>
                        </div>

                        <!-- DataTables Exports and Actions Row -->
                        <div class="px-4 mb-2 d-flex align-items-center justify-content-center gap-2">
                            <a href="{{ route('admin.job-profitability.pdf', ['date' => $date->toDateString()]) }}" class="btn btn-sm btn-outline-secondary px-3 py-1 fw-bold" style="border-radius: 4px;">PDF</a>
                            <a href="{{ route('admin.job-profitability.csv', ['date' => $date->toDateString()]) }}" class="btn btn-sm btn-outline-secondary px-3 py-1 fw-bold" style="border-radius: 4px;">CSV</a>
                        </div>

                        <!-- Table Container -->
                        <div class="px-4 pb-4">
                            <div class="table-responsive">
                                <table id="profitabilityTable" class="table table-hover w-100 equipment-report-table">
                                    <thead>
                                        <!-- Group headers -->
                                        <tr style="border-bottom: 2px solid #ddd;">
                                            <th colspan="3" class="text-center bg-light fw-bold text-dark border-end" style="border-color: #ddd !important; font-size: 14px;">Basic Info</th>
                                            <th colspan="4" class="text-center bg-light fw-bold text-dark border-end" style="border-color: #ddd !important; font-size: 14px;">Hours Metrics</th>
                                            <th colspan="4" class="text-center bg-light fw-bold text-dark" style="font-size: 14px;">Labor Metrics</th>
                                        </tr>
                                        <!-- Columns headers -->
                                        <tr>
                                            <th>Client</th>
                                            <th>Date</th>
                                            <th>Price</th>
                                            <th>Hours</th>
                                            <th>OT</th>
                                            <th>Budget</th>
                                            <th>Ratio</th>
                                            <th>Actual</th>
                                            <th>Budget</th>
                                            <th>Ratio</th>
                                            <th>Delta</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($records as $record)
                                            @php
                                                $isPink = $record['row_class'] === 'row-pink';
                                                $isGreen = $record['row_class'] === 'row-green';

                                                // Dynamic colors based on row state
                                                $valClass = $isPink ? 'text-danger-custom' : '';
                                                $priceClass = $isGreen ? 'text-success-custom' : ($isPink ? 'text-danger-custom' : '');
                                                $deltaClass = $isGreen ? 'text-success-custom' : ($isPink ? 'text-danger-custom' : '');
                                            @endphp
                                            <tr class="{{ $record['row_class'] }}">
                                                <td>
                                                    @can('service.fulfill_order.view')
                                                    <a href="{{ route('admin.lead.service.fulfill_order', $record['id']) }}" class="client-link">{{ $record['client'] }}</a>
                                                    @else
                                                    <span class="text-dark">{{ $record['client'] }}</span>
                                                    @endcan
                                                </td>
                                                <td class="text-dark">{{ $record['date'] }}</td>
                                                <td class="{{ $priceClass }}">{{ $record['price'] }}</td>
                                                <td class="{{ $valClass }}">{{ $record['hours'] }}</td>
                                                <td class="{{ $valClass }}">{{ $record['ot'] }}</td>
                                                <td class="{{ $valClass }}">{{ $record['budget_hours'] }}</td>
                                                <td class="{{ $valClass }}">{{ $record['ratio_hours'] }}</td>
                                                <td class="{{ $valClass }}">{{ $record['actual_labor'] }}</td>
                                                <td class="{{ $valClass }}">{{ $record['budget_labor'] }}</td>
                                                <td class="{{ $valClass }}">{{ $record['ratio_labor'] }}</td>
                                                <td class="{{ $deltaClass }}">{{ $record['delta'] }}</td>
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
            $('#profitabilityTable').DataTable({
                pageLength: 25,
                ordering: true,
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
