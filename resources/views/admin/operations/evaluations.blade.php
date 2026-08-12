@extends('admin.includes.layout')

@section('title', 'Evaluations')

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
            padding: 12px 20px !important;
            vertical-align: middle !important;
            border-bottom: 1px solid #f3f4f6 !important;
            border-right: 1px solid rgba(0, 0, 0, 0.05) !important;
            font-size: 13px !important;
            color: #4b5563;
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
                                <h3 class="mb-1 text-uppercase">EVALUATIONS</h3>
<p class="text-danger fw-bold mb-0" style="font-size: 13px;">(This is a static page, it's a work in progress)</p>
                                <p class="text-muted mb-0">Overview and status of all team evaluations.</p>
                            </div>
                        </div>
                        
                        <div class="px-4 pb-4">
                            
                            <!-- Notifications for Evaluations Table -->
                            <div class="table-responsive mt-3">
                                <table class="table equipment-report-table">
                                    <thead>
                                        <tr>
                                            <th colspan="5">Notifications for Evaluations</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Supervisors -->
                                        <tr style="background-color: #fdf6e3; border-bottom: 2px solid #fff;">
                                            <td colspan="5" class="fw-bold text-dark py-3" style="font-size: 14px;">Supervisors</td>
                                        </tr>
                                        <tr style="border-bottom: 2px solid #f3f4f6;">
                                            <th class="fw-bold text-muted border-0 py-2" style="font-size: 13px;">Name</th>
                                            <th class="fw-bold text-muted border-0 py-2" style="font-size: 13px;"></th>
                                            <th class="fw-bold text-muted border-0 py-2" style="font-size: 13px;">Last Sent</th>
                                            <th class="fw-bold text-muted border-0 py-2" style="font-size: 13px;">Date Evaluation sent</th>
                                            <th class="fw-bold text-muted border-0 py-2" style="font-size: 13px;">Completed?</th>
                                        </tr>
                                        @foreach(['Blake Mitchell', 'Gregory Cervantez', 'Jadin Reece'] as $name)
                                        <tr>
                                            <td class="fw-bold text-dark">{{ $name }}</td>
                                            <td><button class="btn btn-sm btn-success" style="font-size: 11px;">Send evaluation</button></td>
                                            <td class="text-muted" style="font-size: 11px;">No evaluations<br>sent</td>
                                            <td class="text-muted" style="font-size: 12px;">not sent</td>
                                            <td class="text-info fw-bold">0 / 0</td>
                                        </tr>
                                        @endforeach

                                        <!-- Supervisors in Training -->
                                        <tr style="background-color: #fdf6e3; border-bottom: 2px solid #fff;">
                                            <td colspan="5" class="fw-bold text-dark py-3" style="font-size: 14px;">Supervisors In Training</td>
                                        </tr>
                                        <tr style="border-bottom: 2px solid #f3f4f6;">
                                            <th class="fw-bold text-muted border-0 py-2" style="font-size: 13px;">Name</th>
                                            <th class="fw-bold text-muted border-0 py-2" style="font-size: 13px;"></th>
                                            <th class="fw-bold text-muted border-0 py-2" style="font-size: 13px;">Last Sent</th>
                                            <th class="fw-bold text-muted border-0 py-2" style="font-size: 13px;">Date Evaluation sent</th>
                                            <th class="fw-bold text-muted border-0 py-2" style="font-size: 13px;">Completed?</th>
                                        </tr>

                                        <!-- Operation Managers -->
                                        <tr style="background-color: #fdf6e3; border-bottom: 2px solid #fff;">
                                            <td colspan="5" class="fw-bold text-dark py-3" style="font-size: 14px;">Operation Managers</td>
                                        </tr>
                                        <tr style="border-bottom: 2px solid #f3f4f6;">
                                            <th class="fw-bold text-muted border-0 py-2" style="font-size: 13px;">Name</th>
                                            <th class="fw-bold text-muted border-0 py-2" style="font-size: 13px;"></th>
                                            <th class="fw-bold text-muted border-0 py-2" style="font-size: 13px;">Last Sent</th>
                                            <th class="fw-bold text-muted border-0 py-2" style="font-size: 13px;">Date Evaluation sent</th>
                                            <th class="fw-bold text-muted border-0 py-2" style="font-size: 13px;">Completed?</th>
                                        </tr>

                                        <!-- Operation Managers (Sends to ROM) -->
                                        <tr style="background-color: #fdf6e3; border-bottom: 2px solid #fff;">
                                            <td colspan="5" class="fw-bold text-dark py-3" style="font-size: 14px;">Operation Managers <span style="font-size: 12px; font-weight: normal; color: #6b7280;">(Sends evaluations to ROM)</span></td>
                                        </tr>
                                        <tr style="border-bottom: 2px solid #f3f4f6;">
                                            <th class="fw-bold text-muted border-0 py-2" style="font-size: 13px;">Name</th>
                                            <th class="fw-bold text-muted border-0 py-2" style="font-size: 13px;"></th>
                                            <th class="fw-bold text-muted border-0 py-2" style="font-size: 13px;">Last Sent</th>
                                            <th class="fw-bold text-muted border-0 py-2" style="font-size: 13px;">Date Evaluation sent</th>
                                            <th class="fw-bold text-muted border-0 py-2" style="font-size: 13px;">Completed?</th>
                                        </tr>

                                        <!-- Technicians -->
                                        <tr style="background-color: #fdf6e3; border-bottom: 2px solid #fff;">
                                            <td colspan="5" class="fw-bold text-dark py-3" style="font-size: 14px;">Technicians</td>
                                        </tr>
                                        <tr style="border-bottom: 2px solid #f3f4f6;">
                                            <th class="fw-bold text-muted border-0 py-2" style="font-size: 13px;">Name</th>
                                            <th class="fw-bold text-muted border-0 py-2" style="font-size: 13px;"></th>
                                            <th class="fw-bold text-muted border-0 py-2" style="font-size: 13px;">Last Sent</th>
                                            <th class="fw-bold text-muted border-0 py-2" style="font-size: 13px;">Date Evaluation sent</th>
                                            <th class="fw-bold text-muted border-0 py-2" style="font-size: 13px;">Completed?</th>
                                        </tr>
                                        @foreach(['Garrison Reyher', 'Ben Barbosa', 'Brady Ha', 'Paul Roessler', 'John Zamora', 'Anthony Gutierrez', 'Chris Lemon', 'Xavien Ramirez', 'Noah Baldwin', 'Kyle Kelley', 'Aiden Pettit'] as $name)
                                        <tr>
                                            <td class="fw-bold text-dark">{{ $name }}</td>
                                            <td><button class="btn btn-sm btn-success" style="font-size: 11px;">Send evaluation</button></td>
                                            <td class="text-muted" style="font-size: 11px;">No evaluations<br>sent</td>
                                            <td class="text-muted" style="font-size: 12px;">not sent</td>
                                            <td class="text-info fw-bold">0 / 0</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- SIT Table -->
                            <div class="table-responsive mt-5">
                                <table class="table equipment-report-table">
                                    <thead>
                                        <tr>
                                            <th>Technicians to evaluate for SIT</th>
                                            <th></th>
                                            <th>Last Attempt</th>
                                            <th>Number of attempts</th>
                                            <th>Results</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="width: 25%;" class="fw-bold text-dark">Garrison Reyher</td>
                                            <td style="width: 15%; font-size: 11px;" class="text-muted">no more attempts left</td>
                                            <td style="width: 20%;" class="text-muted">6-11-25</td>
                                            <td style="width: 25%;" class="text-dark fw-bold">4</td>
                                            <td style="width: 15%;"><button class="btn btn-sm btn-primary" style="font-size: 11px;">See Results</button></td>
                                        </tr>
                                        @foreach(['Ben Barbosa', 'Brady Ha', 'Paul Roessler', 'John Zamora', 'Anthony Gutierrez', 'Chris Lemon'] as $name)
                                        <tr>
                                            <td class="fw-bold text-dark">{{ $name }}</td>
                                            <td><button class="btn btn-sm btn-primary" style="font-size: 11px;">Start evaluation</button></td>
                                            <td class="text-muted" style="font-size: 11px;">No evaluations<br>done</td>
                                            <td class="text-dark fw-bold">0</td>
                                            <td class="text-muted">N/A</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="mt-3">
                                    <button class="btn btn-light btn-sm border text-muted px-4" style="background-color: #f3f4f6;">View Scores</button>
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

