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
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* IE and Edge */
        }
        
        .navbar-tabs .nav-tabs::-webkit-scrollbar {
            display: none; /* Chrome, Safari, Opera */
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
                                    <p class="text-muted mb-0">{{ $slot->serviceOrder->service->lead->company->name ?? 'Service Order' }}</p>
                                    @if($slot->is_audit_finalized)
                                        <p id="audit-finalized-indicator" class="text-danger mb-0 mt-1"><i class="fas fa-lock me-1"></i> Audit has been finalized</p>
                                    @endif
                                </div>
                                <div class="right-part-sec d-flex gap-2 align-items-center">
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
                                            <div class="accordion-body bg-white" style="font-size: 13px;">
                                                <h6 class="fw-bold mb-2 text-dark" style="font-size: 15px;">{{ $slot->serviceOrder->service->lead->company->name ?? 'N/A' }}</h6>
                                                <p class="text-muted mb-1">
                                                    <strong>Order No:</strong> {{ $slot->serviceOrder->order_no ?? 'N/A' }}
                                                </p>
                                                <div class="text-muted mb-1">
                                                    @if($slot->facilities->count() > 0)
                                                        @foreach($slot->facilities as $f)
                                                            <div class="mb-1">
                                                                <i class="fas fa-building me-1"></i> <strong class="text-dark">{{ $f->companyLocation->location_name ?? 'Unknown Facility' }}</strong> - {{ $f->companyLocation->full_address ?? 'No address available' }}
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <div class="mb-1">
                                                            <i class="fas fa-building me-1"></i> No facilities assigned
                                                        </div>
                                                    @endif
                                                </div>
                                                <p class="text-muted mb-0">
                                                    <i class="far fa-calendar-alt me-2"></i> {{ \Carbon\Carbon::parse($slot->scheduled_start_time)->format('m/d/y h:i a') }} - {{ $slot->office->name ?? 'N/A' }}
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
                                            <div class="accordion-body bg-white" style="font-size: 13px;">
                                                <div class="mb-4 p-3 rounded" style="background-color: #f8f9fa; border: 1px solid #e9ecef;">
                                                    <div class="mb-2 text-dark">
                                                        <strong class="text-dark">Office:</strong> {{ $slot->office->name ?? 'N/A' }}
                                                    </div>
                                                    <div class="mb-2 text-dark">
                                                        <strong class="text-dark">Schedule:</strong> {{ $slot->scheduled_start_time ? \Carbon\Carbon::parse($slot->scheduled_start_time)->format('Y-m-d H:i:s') : 'N/A' }} — {{ $slot->scheduled_end_time ? \Carbon\Carbon::parse($slot->scheduled_end_time)->format('Y-m-d H:i:s') : 'N/A' }}
                                                    </div>
                                                    <div class="mb-2 text-dark">
                                                        <strong class="text-dark">Arrival Time:</strong> {{ $slot->scheduled_arrival_time ?? 'N/A' }}
                                                    </div>
                                                </div>

                                                <div class="p-3 rounded" style="background-color: #f8f9fa; border: 1px solid #e9ecef;">
                                                    <h6 class="fw-bold text-dark mb-3" style="font-size: 15px;">Assigned Team</h6>
                                                    @if($slot->staff && $slot->staff->count() > 0)
                                                        <ul class="list-unstyled mb-0" style="line-height: 2;">
                                                            @foreach($slot->staff as $staff)
                                                                <li>
                                                                    <i class="fas fa-user text-muted me-2"></i>
                                                                    <span class="text-dark fw-medium">{{ $staff->user->name ?? 'N/A' }}</span>
                                                                    @if($staff->is_leader)
                                                                        <span class="badge ms-2 rounded-pill" style="background-color: #FFB81C; color: #002855; font-size: 0.65rem; text-transform: uppercase; padding: 0.4em 0.8em; letter-spacing: 0.5px;">LEADER</span>
                                                                    @endif
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <p class="text-muted mb-0">No staff assigned.</p>
                                                    @endif
                                                </div>
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
                                                <div class="audit-action-container">
                                                    @if(!$slot->is_audit_finalized)
                                                        <form action="{{ route('admin.operations.audits.finalize', $slot->id) }}" method="POST" class="form-finalize-audit">
                                                            @csrf
                                                            <button type="submit" class="btn btn-export">
                                                                Finalize This Audit
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form action="{{ route('admin.operations.audits.reopen', $slot->id) }}" method="POST" class="form-reopen-audit">
                                                            @csrf
                                                            <button type="submit" class="btn btn-export">
                                                                Re-open Audit
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tabs Section -->
                                <div class="navbar-tabs mb-0" style="border-radius: 8px 8px 0 0; overflow: hidden;">
                                    <nav class="nav nav-tabs mb-0 w-100 nav-fill" role="tablist">
                                        <button class="nav-link active" id="mission-tab" data-bs-toggle="tab" data-bs-target="#mission" type="button" role="tab">GermBlast Mission and Purpose</button>
                                        <button class="nav-link" id="pre-service-tab" data-bs-toggle="tab" data-bs-target="#pre_service" type="button" role="tab">Pre-Service Section</button>
                                        <button class="nav-link" id="service-tab" data-bs-toggle="tab" data-bs-target="#service" type="button" role="tab">Service Section</button>
                                        <button class="nav-link" id="safety-tab" data-bs-toggle="tab" data-bs-target="#safety" type="button" role="tab">Safety Section</button>
                                        <button class="nav-link" id="post-service-tab" data-bs-toggle="tab" data-bs-target="#post_service" type="button" role="tab">Post-Service Section</button>
                                        <button class="nav-link" id="photos-tab" data-bs-toggle="tab" data-bs-target="#photos" type="button" role="tab">Photos</button>
                                    </nav>
                                </div>
                                
                                <hr class="mb-4 mt-0" style="opacity: 0.1;">

                                <div class="section-card">
                                    <div class="tab-content" id="auditTabContent">
                                        @php
                                            $tabGroups = [
                                                'mission' => [1, 2],
                                                'pre_service' => [3, 4, 5, 6, 7, 8, 9],
                                                'service' => [10, 11, 12],
                                                'safety' => [13, 14],
                                                'post_service' => [15, 16, 17],
                                                'photos' => [18],
                                            ];
                                        @endphp

                                        @foreach($tabGroups as $tabId => $allowedSections)
                                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $tabId }}" role="tabpanel">
                                                <div class="p-3">
                                                    @foreach($sections as $section)
                                                        @if(in_array($section->sort_order, $allowedSections))
                                                            <div class="group-header">{{ $section->sort_order }} - {{ $section->name }}</div>
                                                            
                                                            @foreach($section->questions as $question)
                                                                <div class="question-header d-flex justify-content-between align-items-center">
                                                                    <div>
                                                                        {{ $question->question_number !== 'photo_uploads' ? $question->question_number . ' - ' : '' }}{{ $question->question }}
                                                                    </div>
                                                                    @if(!$slot->is_audit_finalized)
                                                                        <div>
                                                                            @if($question->question_type == 'standard')
                                                                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="openStandardModal({{ $question->id }}, '{{ addslashes($question->question) }}')">
                                                                                    <i class="far fa-edit"></i> Add Record
                                                                                </button>
                                                                            @else
                                                                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="openPhotoModal({{ $question->id }}, '{{ addslashes($question->question) }}')">
                                                                                    <i class="fas fa-camera"></i> Add Photo
                                                                                </button>
                                                                            @endif
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                
                                                                <div class="table-responsive mb-4">
                                                                    <table class="table equipment-report-table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Time</th>
                                                                                <th>Employee</th>
                                                                                @if($question->question_type == 'standard')
                                                                                    <th>Notes</th>
                                                                                    <th>Score</th>
                                                                                @else
                                                                                    <th>Photo</th>
                                                                                @endif
                                                                                <th>Auditor</th>
                                                                                @if(!$slot->is_audit_finalized)
                                                                                    <th class="text-center">Action</th>
                                                                                @endif
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="tbody-question-{{ $question->id }}">
                                                                            @forelse($question->submissions as $submission)
                                                                                <tr id="submission-row-{{ $submission->id }}">
                                                                                    <td>{{ $submission->created_at->format('m/d/y h:i a') }}</td>
                                                                                    <td>{{ $submission->employee ? $submission->employee->name : 'Team' }}</td>
                                                                                    @if($question->question_type == 'standard')
                                                                                        <td class="{{ $submission->notes ? '' : 'text-muted' }}">{{ $submission->notes ?? 'N/A' }}</td>
                                                                                        <td>
                                                                                            <span class="fw-bold text-dark">{{ $submission->score }}</span>
                                                                                        </td>
                                                                                    @else
                                                                                        <td>
                                                                                            @if($submission->photo_path)
                                                                                                <a href="{{ Storage::url($submission->photo_path) }}" target="_blank">View Photo</a>
                                                                                            @else
                                                                                                N/A
                                                                                            @endif
                                                                                        </td>
                                                                                    @endif
                                                                                    <td>{{ $submission->creator ? $submission->creator->name : 'N/A' }}</td>
                                                                                    @if(!$slot->is_audit_finalized)
                                                                                        <td class="text-center">
                                                                                            <button type="button" class="btn btn-sm btn-link text-primary p-0" onclick="openEditModal({{ $submission->id }}, '{{ addslashes($question->question) }}', '{{ $question->question_type }}', {{ json_encode($submission) }})">
                                                                                                <i class="far fa-edit"></i>
                                                                                            </button>
                                                                                        </td>
                                                                                    @endif
                                                                                </tr>
                                                                            @empty
                                                                                <tr class="empty-row">
                                                                                    <td colspan="{{ $question->question_type == 'standard' ? (!$slot->is_audit_finalized ? 6 : 5) : (!$slot->is_audit_finalized ? 5 : 4) }}" class="text-center text-muted">No records added yet.</td>
                                                                                </tr>
                                                                            @endforelse
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Standard Question Modal -->
    <div class="modal fade" id="standardModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="exampleModalLabel">Add Record</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="standardForm" class="company-form">
                        @csrf
                        <input type="hidden" name="service_order_slot_id" value="{{ $slot->id }}">
                        <input type="hidden" name="audit_question_id" id="standard_audit_question_id">
                        
                        <div class="row mx-0">
                            <div class="col-lg-12 mb-3 mt-2">
                                <h5 id="standardQuestionText" class="fw-bold text-dark"></h5>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Score (1-5)</label>
                                    <select name="score" class="form-select" required>
                                        <option value="5">5 - Excellent</option>
                                        <option value="4">4 - Good</option>
                                        <option value="3">3 - Average</option>
                                        <option value="2">2 - Poor</option>
                                        <option value="1">1 - Very Poor</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Employee</label>
                                    <select name="employee_id" class="form-select">
                                        <option value="">Whole Team</option>
                                        @foreach($slot->staff as $staff)
                                            <option value="{{ $staff->user->id }}">{{ $staff->user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Notes</label>
                                    <textarea name="notes" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Record</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Photo Question Modal -->
    <div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="exampleModalLabel2">Add Photo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="photoForm" enctype="multipart/form-data" class="company-form">
                        @csrf
                        <input type="hidden" name="service_order_slot_id" value="{{ $slot->id }}">
                        <input type="hidden" name="audit_question_id" id="photo_audit_question_id">
                        
                        <div class="row mx-0">
                            <div class="col-lg-12 mb-3 mt-2" id="photoQuestionTextContainer">
                                <h5 id="photoQuestionText" class="fw-bold text-dark"></h5>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Select Image File</label>
                                    <input type="file" name="photo" class="form-control" accept="image/*" required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Employee</label>
                                    <select name="employee_id" class="form-select">
                                        <option value="">Whole Team</option>
                                        @foreach($slot->staff as $staff)
                                            <option value="{{ $staff->user->id }}">{{ $staff->user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="btnPhotoSave">Upload Photo</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Record Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="editModalLabel">Edit Record</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" enctype="multipart/form-data" class="company-form">
                        @csrf
                        <input type="hidden" name="submission_id" id="edit_submission_id">
                        <input type="hidden" name="question_type" id="edit_question_type">
                        
                        <div class="row mx-0">
                            <div class="col-lg-12 mb-3 mt-2">
                                <h5 id="edit_question_text" class="fw-bold text-dark"></h5>
                            </div>

                            <div class="col-lg-12" id="edit_score_section">
                                <div class="form-group">
                                    <label class="form-label">Score (1-5)</label>
                                    <select name="score" id="edit_score" class="form-select">
                                        <option value="5">5 - Excellent</option>
                                        <option value="4">4 - Good</option>
                                        <option value="3">3 - Average</option>
                                        <option value="2">2 - Poor</option>
                                        <option value="1">1 - Very Poor</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12" id="edit_photo_section" style="display: none;">
                                <div class="form-group">
                                    <label class="form-label">Update Photo</label>
                                    <input type="file" name="photo" id="edit_photo" class="form-control" accept="image/*">
                                    <div class="mt-2" id="current_photo_container"></div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Employee</label>
                                    <select name="employee_id" id="edit_employee_id" class="form-select">
                                        <option value="">Whole Team</option>
                                        @foreach($slot->staff as $staff)
                                            <option value="{{ $staff->user_id }}">{{ $staff->user->name ?? 'Unknown' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12" id="edit_notes_section">
                                <div class="form-group">
                                    <label class="form-label">Notes</label>
                                    <textarea name="notes" id="edit_notes" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer d-flex justify-content-between">
                            <button type="button" class="btn btn-danger" onclick="deleteRecord()">Delete Record</button>
                            <div>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="btnEditSave">Save Changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function openStandardModal(questionId, questionText) {
        document.getElementById('standard_audit_question_id').value = questionId;
        document.getElementById('exampleModalLabel').innerText = 'Add Record';
        document.getElementById('standardQuestionText').innerText = questionText;
        document.getElementById('standardForm').reset();
        var modal = new bootstrap.Modal(document.getElementById('standardModal'));
        modal.show();
    }

    function openPhotoModal(questionId, questionText) {
        document.getElementById('photo_audit_question_id').value = questionId;
        document.getElementById('exampleModalLabel2').innerText = 'Add Photo';
        document.getElementById('photoQuestionText').innerText = questionText;
        
        if (questionText.toLowerCase() === 'photo uploads' || questionText.toLowerCase() === 'photo_uploads') {
            document.getElementById('photoQuestionTextContainer').style.display = 'none';
        } else {
            document.getElementById('photoQuestionTextContainer').style.display = 'block';
        }

        document.getElementById('photoForm').reset();
        var modal = new bootstrap.Modal(document.getElementById('photoModal'));
        modal.show();
    }

    document.getElementById('standardForm').addEventListener('submit', function(e) {
        e.preventDefault();
        submitForm(this);
    });

    document.getElementById('photoForm').addEventListener('submit', function(e) {
        e.preventDefault();
        submitForm(this, 'btnPhotoSave');
    });

    function openEditModal(submissionId, questionText, type, submission) {
        document.getElementById('edit_submission_id').value = submissionId;
        document.getElementById('edit_question_type').value = type;
        document.getElementById('edit_question_text').innerText = questionText;
        
        document.getElementById('editForm').reset();
        
        document.getElementById('edit_employee_id').value = submission.employee_id || '';
        
        if(type === 'standard') {
            document.getElementById('edit_score_section').style.display = 'block';
            document.getElementById('edit_notes_section').style.display = 'block';
            document.getElementById('edit_photo_section').style.display = 'none';
            
            document.getElementById('edit_score').value = submission.score || '';
            document.getElementById('edit_notes').value = submission.notes || '';
        } else {
            document.getElementById('edit_score_section').style.display = 'none';
            document.getElementById('edit_notes_section').style.display = 'none';
            document.getElementById('edit_photo_section').style.display = 'block';
            
            if(submission.photo_path) {
                document.getElementById('current_photo_container').innerHTML = '<a href="/storage/' + submission.photo_path + '" target="_blank" class="text-primary small">View Current Photo</a>';
            } else {
                document.getElementById('current_photo_container').innerHTML = '';
            }
        }
        
        new bootstrap.Modal(document.getElementById('editModal')).show();
    }

    function deleteRecord() {
        Swal.fire({
            title: "Are you sure?",
            text: "This action will permanently delete this record.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                let submissionId = document.getElementById('edit_submission_id').value;
                let $btn = $('#editModal .btn-danger');
                
                $.ajax({
                    url: "{{ url('admin/operations/audits/submission') }}/" + submissionId + "/delete",
                    method: 'POST',
                    data: {
                        _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    beforeSend: function() {
                        $btn.prop('disabled', true).text('Deleting...');
                    },
                    success: function(response) {
                        toastr.success(response.message || 'Record deleted successfully!');
                        bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();
                        setTimeout(() => window.location.reload(), 1500);
                    },
                    error: function() {
                        toastr.error('Something went wrong while deleting.');
                        $btn.prop('disabled', false).text('Delete');
                    }
                });
            }
        });
    }

    document.getElementById('editForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const $form = $(this);
        const $submitBtn = $('#btnEditSave');

        $.ajax({
            url: "{{ url('admin/operations/audits/submission') }}/" + document.getElementById('edit_submission_id').value + "/update",
            method: 'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,
            beforeSend: function() {
                $submitBtn.prop('disabled', true).text('Saving...');
            },
            success: function(response) {
                toastr.success(response.message || 'Record updated successfully!');
                bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();
                setTimeout(() => window.location.reload(), 1500);
            },
            error: function() {
                toastr.error('Something went wrong while saving.');
                $submitBtn.prop('disabled', false).text('Save changes');
            }
        });
    });

    $('#standardForm, #photoForm').on('submit', function(e) {
        e.preventDefault();
        const $form = $(this);
        const $submitBtn = $form.find('button[type="submit"]');
        
        $.ajax({
            url: "{{ route('admin.operations.audits.submission.store') }}",
            method: 'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,
            beforeSend: function() {
                $submitBtn.prop('disabled', true).text('Saving...');
            },
            success: function(response) {
                toastr.success(response.message || 'Record added successfully!');
                let isPhoto = $form.attr('id') === 'photoForm';
                bootstrap.Modal.getInstance(document.getElementById(isPhoto ? 'photoModal' : 'standardModal')).hide();
                setTimeout(() => window.location.reload(), 1500);
            },
            error: function() {
                toastr.error('Something went wrong while saving.');
                $submitBtn.prop('disabled', false).text('Save Record');
            }
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        // Read tab from query string and activate tab
        const urlParams = new URLSearchParams(window.location.search);
        const tabParam = urlParams.get('tab');
        
        if (tabParam) {
            var tabBtn = document.querySelector('button[data-bs-target="#' + tabParam + '"]');
            if (tabBtn) {
                var tab = new bootstrap.Tab(tabBtn);
                tab.show();
            }
        }

        // Add event listener to update query string on tab change
        var tabEls = document.querySelectorAll('button[data-bs-toggle="tab"]');
        tabEls.forEach(function(tabEl) {
            tabEl.addEventListener('shown.bs.tab', function (event) {
                var target = event.target.getAttribute('data-bs-target');
                if (target && target.startsWith('#')) {
                    const newTab = target.substring(1);
                    const newUrl = new URL(window.location);
                    newUrl.searchParams.set('tab', newTab);
                    history.replaceState(null, null, newUrl);
                }
            });
        });


        $(document).on('submit', '.form-finalize-audit', function(e) {
            e.preventDefault();
            const $form = $(this);
            const $submitBtn = $form.find('button[type="submit"]');

            $.ajax({
                url: $form.attr('action'),
                method: 'POST',
                data: $form.serialize(),
                beforeSend: function() {
                    $submitBtn.prop('disabled', true).text('Saving...');
                },
                success: function(response) {
                    toastr.success(response.message || 'Audit finalized successfully!');
                    setTimeout(() => window.location.reload(), 1500);
                },
                error: function() {
                    toastr.error('Something went wrong while finalizing.');
                    $submitBtn.prop('disabled', false).text('Finalize This Audit');
                }
            });
        });

        $(document).on('submit', '.form-reopen-audit', function(e) {
            e.preventDefault();
            const $form = $(this);
            const $submitBtn = $form.find('button[type="submit"]');

            $.ajax({
                url: $form.attr('action'),
                method: 'POST',
                data: $form.serialize(),
                beforeSend: function() {
                    $submitBtn.prop('disabled', true).text('Saving...');
                },
                success: function(response) {
                    toastr.success(response.message || 'Audit reopened successfully!');
                    setTimeout(() => window.location.reload(), 1500);
                },
                error: function() {
                    toastr.error('Something went wrong while reopening.');
                    $submitBtn.prop('disabled', false).text('Re-open Audit');
                }
            });
        });
    });
</script>
@endpush
