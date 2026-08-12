@extends('admin.includes.layout')

@section('title', 'Audits')

@push('styles')
    <style>
        .cursor-pointer {
            cursor: pointer !important;
        }

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
                        
                        <div class="sales-dashboard">
                            <!-- Header -->
                            <div class="heading-area-sec mb-3">
                                <div class="left-part-sec">
                                    <h3 class="mb-1 text-uppercase">AUDITS</h3>
<p class="text-danger fw-bold mb-0" style="font-size: 13px;">(This is a static page, it's a work in progress)</p>
                                    <p class="text-muted mb-0">Overview of completed facility audits and their corresponding scores.</p>
                                </div>
                            </div>

                            <div class="px-4 pb-4">
                                <div class="table-responsive mt-3">
                                    <table class="table table-hover w-100 equipment-report-table">
                                        <thead>
                                            <tr>
                                                <th>Office / Facility Name</th>
                                                <th>Score</th>
                                                <th>Date of Audit</th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="fw-bold text-dark">UTMB WIC Office - Livingston</td>
                                                <td><span class="badge bg-success" style="font-size: 13px;">3.94</span></td>
                                                <td class="text-secondary">03/23</td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.operations.audits.show', 1) }}" class="btn btn-sm btn-outline-primary py-1 px-3 fw-bold" style="border-radius: 6px; font-size: 12px;">
                                                        Go To Audit <i class="fas fa-arrow-right ms-1"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold text-dark">UTMB WIC Office - Pearland</td>
                                                <td><span class="badge bg-warning text-dark" style="font-size: 13px;">3.46</span></td>
                                                <td class="text-secondary">03/23</td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.operations.audits.show', 1) }}" class="btn btn-sm btn-outline-primary py-1 px-3 fw-bold" style="border-radius: 6px; font-size: 12px;">
                                                        Go To Audit <i class="fas fa-arrow-right ms-1"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold text-dark">Primrose School of Plano at Preston Meadow</td>
                                                <td><span class="badge bg-info text-dark" style="font-size: 13px;">3.67</span></td>
                                                <td class="text-secondary">01/23</td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.operations.audits.show', 1) }}" class="btn btn-sm btn-outline-primary py-1 px-3 fw-bold" style="border-radius: 6px; font-size: 12px;">
                                                        Go To Audit <i class="fas fa-arrow-right ms-1"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold text-dark">Lubbock ISD</td>
                                                <td><span class="badge bg-success" style="font-size: 13px;">4.00</span></td>
                                                <td class="text-secondary">11/22</td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.operations.audits.show', 1) }}" class="btn btn-sm btn-outline-primary py-1 px-3 fw-bold" style="border-radius: 6px; font-size: 12px;">
                                                        Go To Audit <i class="fas fa-arrow-right ms-1"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold text-dark">Trinidad ISD</td>
                                                <td><span class="badge bg-success" style="font-size: 13px;">3.85</span></td>
                                                <td class="text-secondary">11/22</td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.operations.audits.show', 1) }}" class="btn btn-sm btn-outline-primary py-1 px-3 fw-bold" style="border-radius: 6px; font-size: 12px;">
                                                        Go To Audit <i class="fas fa-arrow-right ms-1"></i>
                                                    </a>
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
@endsection

