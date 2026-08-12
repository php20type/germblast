@extends('admin.includes.layout')

@section('title', 'Audit Details')

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

        .section-header {
            border-bottom: 1px solid #f3f4f6 !important;
            padding-bottom: 15px !important;
            margin-bottom: 20px !important;
        }
        
        /* Navbar Tabs Refinement */
        .navbar-tabs {
            background-color: transparent;
        }

        .navbar-tabs .nav-tabs {
            border-bottom: none !important;
            flex-wrap: nowrap;
        }

        .navbar-tabs .nav-link {
            border: none !important;
            color: #6b7280 !important;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 13px;
            padding: 12px 20px 20px 20px !important;
            white-space: nowrap !important;
            background: transparent !important;
            position: relative;
            transition: all 0.2s ease;
        }

        .navbar-tabs .nav-link.active {
            color: #111827 !important;
            background-color: #fff8e8 !important;
            border-radius: 10px 10px 0 0;
        }

        .navbar-tabs .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background-color: #ffb400;
        }
        
        .question-header {
            font-size: 15px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 10px;
            margin-top: 30px;
        }
        .group-header {
            font-size: 18px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 20px;
            margin-top: 40px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e5e7eb;
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
                            <div class="heading-area-sec mb-4">
                                <div class="left-part-sec">
                                    <h3 class="mb-1 text-uppercase">Audit Details</h3>
<p class="text-danger fw-bold mb-0" style="font-size: 13px;">(This is a static page, it's a work in progress)</p>
                                    <p class="text-muted mb-0">UTMB WIC Office - Livingston</p>
                                </div>
                                <div class="right-part-sec">
                                    <a href="{{ route('admin.operations.audits') }}" class="btn btn-outline-dark">
                                        <i class="fas fa-arrow-left me-1"></i> BACK
                                    </a>
                                </div>
                            </div>

                            <div class="px-4 pb-4">
                                
                                <!-- Accordion Sections -->
                                <div class="accordion mb-4 shadow-sm" id="auditAccordion" style="border-radius: 12px; overflow: hidden; border: 1px solid #e5e7eb;">
                                    <div class="accordion-item" style="border: none; border-bottom: 1px solid #e5e7eb;">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button collapsed fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="background-color: #f9fafb;">
                                                Client Information
                                            </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#auditAccordion">
                                            <div class="accordion-body bg-white">
                                                <h5 class="fw-bold mb-2">UTMB WIC Office - Livingston</h5>
                                                <p class="text-muted mb-0">
                                                    <i class="far fa-calendar-alt me-2"></i> 03/22/23 03:30 pm - Livingston WIC and Admin 410 East Church Street Suite C Livingston, TX 77351
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item" style="border: none; border-bottom: 1px solid #e5e7eb;">
                                        <h2 class="accordion-header" id="headingTwo">
                                            <button class="accordion-button collapsed fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" style="background-color: #f9fafb;">
                                                Service Times and Teams
                                            </button>
                                        </h2>
                                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#auditAccordion">
                                            <div class="accordion-body bg-white">
                                                <p class="text-muted mb-0">No data available.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item" style="border: none;">
                                        <h2 class="accordion-header" id="headingThree">
                                            <button class="accordion-button collapsed fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" style="background-color: #f9fafb;">
                                                Actions
                                            </button>
                                        </h2>
                                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#auditAccordion">
                                            <div class="accordion-body bg-white">
                                                <p class="text-muted mb-0">No pending actions.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tabs Section -->
                                <div class="navbar-tabs mb-0" style="border-radius: 8px 8px 0 0; overflow: hidden;">
                                    <nav class="nav nav-tabs mb-0 w-100 nav-fill" role="tablist">
                                        <button class="nav-link active" id="mission-tab" data-bs-toggle="tab" data-bs-target="#mission" type="button" role="tab">GermBlast Mission and Purpose</button>
                                        <button class="nav-link" type="button" role="tab">Pre-Service Section</button>
                                        <button class="nav-link" type="button" role="tab">Service Section</button>
                                        <button class="nav-link" type="button" role="tab">Safety Section</button>
                                        <button class="nav-link" type="button" role="tab">Post-Service Section</button>
                                        <button class="nav-link" type="button" role="tab">Photos</button>
                                    </nav>
                                </div>
                                
                                <hr class="mb-4 mt-0" style="opacity: 0.1;">

                                <div class="section-card">
                                    <div class="tab-content" id="auditTabContent">
                                        <div class="tab-pane fade show active" id="mission" role="tabpanel">
                                            
                                            <!-- Group 1 -->
                                            <div class="group-header">1 - Supervisor/Team Leads</div>
                                            
                                            <div class="question-header">
                                                1.3 - Are they providing effective leadership and leading by example? 
                                                <i class="far fa-edit text-primary ms-2 cursor-pointer"></i>
                                            </div>
                                            <div class="table-responsive mb-4">
                                                <table class="table equipment-report-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Time</th>
                                                            <th>Employee</th>
                                                            <th>Notes</th>
                                                            <th>Score</th>
                                                            <th>Auditor</th>
                                                            <th class="text-center">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>03/25/23 10:29 pm</td>
                                                            <td>Joanna Tyler</td>
                                                            <td class="text-muted">N/A</td>
                                                            <td><span class="badge bg-secondary">4</span></td>
                                                            <td>Mark Sunderman</td>
                                                            <td class="text-center"><i class="far fa-edit text-primary cursor-pointer"></i></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="question-header">
                                                1.4 - Are they exhibiting a high level of professionalism, and communicating well with client and team? 
                                                <i class="far fa-edit text-primary ms-2 cursor-pointer"></i>
                                            </div>
                                            <div class="table-responsive mb-4">
                                                <table class="table equipment-report-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Time</th>
                                                            <th>Employee</th>
                                                            <th>Notes</th>
                                                            <th>Score</th>
                                                            <th>Auditor</th>
                                                            <th class="text-center">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>03/25/23 10:30 pm</td>
                                                            <td>Joanna Tyler</td>
                                                            <td class="text-muted">N/A</td>
                                                            <td><span class="badge bg-secondary">4</span></td>
                                                            <td>Mark Sunderman</td>
                                                            <td class="text-center"><i class="far fa-edit text-primary cursor-pointer"></i></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="question-header">
                                                1.6 - Do they have a positive attitude? 
                                                <i class="far fa-edit text-primary ms-2 cursor-pointer"></i>
                                            </div>
                                            <div class="table-responsive mb-4">
                                                <table class="table equipment-report-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Time</th>
                                                            <th>Employee</th>
                                                            <th>Notes</th>
                                                            <th>Score</th>
                                                            <th>Auditor</th>
                                                            <th class="text-center">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>03/25/23 10:30 pm</td>
                                                            <td>Joanna Tyler</td>
                                                            <td class="text-muted">N/A</td>
                                                            <td><span class="badge bg-success">5</span></td>
                                                            <td>Mark Sunderman</td>
                                                            <td class="text-center"><i class="far fa-edit text-primary cursor-pointer"></i></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="question-header">
                                                1.9 - Are they doing quality checks? 
                                                <i class="far fa-edit text-primary ms-2 cursor-pointer"></i>
                                            </div>
                                            <div class="table-responsive mb-4">
                                                <table class="table equipment-report-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Time</th>
                                                            <th>Employee</th>
                                                            <th>Notes</th>
                                                            <th>Score</th>
                                                            <th>Auditor</th>
                                                            <th class="text-center">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>03/25/23 10:30 pm</td>
                                                            <td>Team</td>
                                                            <td class="text-muted">N/A</td>
                                                            <td><span class="badge bg-secondary">4</span></td>
                                                            <td>Mark Sunderman</td>
                                                            <td class="text-center"><i class="far fa-edit text-primary cursor-pointer"></i></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="question-header">
                                                1.10 - Are they holding their team accountable/enforcing protocols? 
                                                <i class="far fa-edit text-primary ms-2 cursor-pointer"></i>
                                            </div>
                                            <div class="table-responsive mb-4">
                                                <table class="table equipment-report-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Time</th>
                                                            <th>Employee</th>
                                                            <th>Notes</th>
                                                            <th>Score</th>
                                                            <th>Auditor</th>
                                                            <th class="text-center">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>03/25/23 10:31 pm</td>
                                                            <td>Team</td>
                                                            <td class="text-danger fw-bold">PPE was not worn when mixing chemicals.</td>
                                                            <td><span class="badge bg-danger">3</span></td>
                                                            <td>Mark Sunderman</td>
                                                            <td class="text-center"><i class="far fa-edit text-primary cursor-pointer"></i></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <!-- Group 2 -->
                                            <div class="group-header">2 - Service Techs</div>

                                            <div class="question-header">
                                                2.3 - Are they communicating well with their team? 
                                                <i class="far fa-edit text-primary ms-2 cursor-pointer"></i>
                                            </div>
                                            <div class="table-responsive mb-4">
                                                <table class="table equipment-report-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Time</th>
                                                            <th>Employee</th>
                                                            <th>Notes</th>
                                                            <th>Score</th>
                                                            <th>Auditor</th>
                                                            <th class="text-center">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>03/25/23 10:32 pm</td>
                                                            <td>Joanna Tyler</td>
                                                            <td class="text-muted">N/A</td>
                                                            <td><span class="badge bg-secondary">4</span></td>
                                                            <td>Mark Sunderman</td>
                                                            <td class="text-center"><i class="far fa-edit text-primary cursor-pointer"></i></td>
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
        </div>
    </div>
@endsection

