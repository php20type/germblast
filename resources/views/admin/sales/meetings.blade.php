@extends('admin.includes.layout')

@section('title', 'Schedule Meeting')

@section('content')
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">

                {{-- Sidebar --}}
                @include('admin.sales.sidebar')

                {{-- Main Content --}}
                <div class="col-md-10 p-0">
                    <div class="sales-dashboard">
                        {{-- HEADER --}}
                        <div class="dashboard-header section-card d-flex justify-content-between align-items-center">
                            <div class="container-fluid px-0">
                                <h1 class="display-6 mb-2 fw-bold">Schedule New Meeting</h1>
                                <p class="text-muted">Schedule and manage internal or client meetings</p>
                            </div>

                            <div>
                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#AddMeeting">
                                    Add New Meeting
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- ============================= --}}
                    {{-- MEETING TIMELINE CONTAINER --}}
                    {{-- ============================= --}}
                    <div class="timeline-container">
                        <div class="timeline position-relative" id="meetingTimeline">

                            {{-- ===== MEETING 1: ZOOM — PENDING ===== --}}
                            <div class="timeline-item" style="border: none;">
                                <div class="timeline-content">

                                    <div class="timeline-header">
                                        <div class="timestamp">
                                            10:00 AM on Jan 15, 2025
                                        </div>
                                    </div>

                                    <div class="timeline-body">
                                        <div class="row align-items-center">

                                            <div class="col-8">
                                                <p class="mb-0">
                                                    <span class="fw-semibold">Client Demo Call</span>
                                                    <span class="text-muted"> (Zoom)</span>
                                                </p>

                                            </div>

                                            <div class="col-4 text-end">
                                                <a href="#" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="#" class="btn btn-sm btn-outline-warning">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                <button class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="mt-2 text-muted">
                                            <i class="fas fa-file-alt text-warning me-1"></i>
                                            Discuss onboarding, pricing, and proposal review.
                                        </div>

                                    </div>
                                </div>
                            </div>

                            {{-- ===== MEETING 2: LIVE — COMPLETED ===== --}}
                            <div class="timeline-item">
                                <div class="timeline-content">

                                    <div class="timeline-header">
                                        <div class="timestamp">
                                            02:30 PM on Jan 10, 2025
                                        </div>
                                    </div>

                                    <div class="timeline-body">
                                        <div class="row align-items-center">

                                            <div class="col-8">
                                                <p class="mb-0">
                                                    <span class="fw-semibold">Office Strategy Meeting</span>
                                                    <span class="text-muted"> (Live)</span>
                                                </p>
                                            </div>

                                            <div class="col-4 text-end">
                                                <a href="#" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="#" class="btn btn-sm btn-outline-warning">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                <button class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="mt-2 text-muted">
                                            <i class="fas fa-file-alt text-warning me-1"></i>
                                            Internal team roadmap planning and Q1 execution review.
                                        </div>

                                    </div>
                                </div>
                            </div>

                            {{-- ===== MEETING 3: LIVE — CANCELLED ===== --}}
                            <div class="timeline-item">
                                <div class="timeline-content">

                                    <div class="timeline-header">
                                        <div class="timestamp">
                                            09:00 AM on Jan 08, 2025
                                        </div>
                                    </div>

                                    <div class="timeline-body">
                                        <div class="row align-items-center">

                                            <div class="col-8">
                                                <p class="mb-0">
                                                    <span class="fw-semibold">Client Site Visit</span>
                                                    <span class="text-muted"> (Live)</span>
                                                </p>

                                            </div>

                                            <div class="col-4 text-end">
                                                <a href="#" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="#" class="btn btn-sm btn-outline-warning">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                <button class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="mt-2 text-muted">
                                            <i class="fas fa-file-alt text-warning me-1"></i>
                                            Meeting cancelled due to unexpected scheduling conflict.
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

    <div class="modal fade" id="AddMeeting" tabindex="-1" aria-labelledby="meetingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">

                <div class="modal-header">
                    <h1 class="modal-title" id="meetingModalLabel">Schedule a Meeting</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('admin.sales.store.meeting') }}" method="POST" class="meeting-form"
                        id="add-meeting-form">
                        @csrf

                        <div class="row mx-0">

                            {{-- Meeting Name --}}
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Meeting Name</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="name" placeholder="Enter meeting name"
                                        class="form-control" />
                                </div>
                            </div>

                            {{-- Duration --}}
                            <div class="col-lg-12 mt-2">
                                <div class="form-group">
                                    <label class="form-label">Duration</label>
                                    <span class="text-danger">*</span>
                                    <select name="duration" class="form-select">
                                        <option value="">Choose...</option>
                                        <option value="5">5 Minutes</option>
                                        <option value="10">10 Minutes</option>
                                        <option value="15">15 Minutes</option>
                                        <option value="20">20 Minutes</option>
                                        <option value="25">25 Minutes</option>
                                        <option value="30">30 Minutes</option>
                                        <option value="45">45 Minutes</option>
                                        <option value="60">1 Hour</option>
                                        <option value="75">1.25 Hours</option>
                                        <option value="90">1.5 Hours</option>
                                        <option value="120">2 Hours</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Date --}}
                            <div class="col-lg-12 mt-2">
                                <div class="form-group">
                                    <label class="form-label">Meeting Date</label>
                                    <input type="date" name="day" class="form-control" />
                                </div>
                            </div>

                            {{-- Start Time --}}
                            <div class="col-lg-6 mt-2">
                                <div class="form-group">
                                    <label class="form-label">Start Time</label>
                                    <input type="time" name="start_time" class="form-control" />
                                </div>
                            </div>

                            {{-- End Time --}}
                            <div class="col-lg-6 mt-2">
                                <div class="form-group">
                                    <label class="form-label">End Time</label>
                                    <input type="time" name="end_time" class="form-control" />
                                </div>
                            </div>

                            {{-- Meeting Type --}}
                            <div class="col-lg-12 mt-2">
                                <div class="form-group">
                                    <label class="form-label">Meeting Type</label>
                                    <select name="meeting_type" class="form-select">
                                        <option value="">Choose...</option>
                                        <option value="zoom">Zoom Meeting</option>
                                        <option value="live">Live (In-Person)</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Location --}}
                            <div class="col-lg-12 mt-2">
                                <div class="form-group">
                                    <label class="form-label">Location</label>
                                    <input type="text" name="location" class="form-control"
                                        placeholder="Office, Site, Google Meet, Zoom URL etc..." />
                                </div>
                            </div>

                            {{-- Activity Type --}}
                            <div class="col-lg-12 mt-2">
                                <div class="form-group">
                                    <label class="form-label">Activity Type</label>
                                    <input type="text" name="activity_type" class="form-control"
                                        placeholder="Sales Call, Demo, Review, Support etc..." />
                                </div>
                            </div>

                            {{-- Description --}}
                            <div class="col-lg-12 mt-2">
                                <div class="form-group">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" rows="4" class="form-control" placeholder="Meeting purpose, agenda, notes..."></textarea>
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer mt-4">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                            <button type="submit" class="btn btn-primary">Save Meeting</button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>

@endsection


@push('scripts')
    <script>
        $(document).ready(function() {

            /** FORM VALIDATION **/
            $("#create-meeting-form").validate({
                ignore: [],
                rules: {
                    name: {
                        required: true
                    },
                    duration: {
                        required: true,
                        number: true
                    },
                    day: {
                        required: true,
                        date: true
                    },
                    start_time: {
                        required: true
                    },
                    end_time: {
                        required: true
                    },
                    location: {
                        required: true
                    },
                    meeting_type: {
                        required: true
                    },
                    activity_type: {
                        required: true
                    },
                },
                errorElement: 'span',
                errorClass: 'invalid-feedback d-block',
                highlight: function(el) {
                    $(el).addClass('is-invalid');
                },
                unhighlight: function(el) {
                    $(el).removeClass('is-invalid');
                }
            });

        });
    </script>
@endpush
