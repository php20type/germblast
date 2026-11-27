@extends('admin.includes.layout')

@section('title', 'Resource Library')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/corporate-tools.css') }}?v={{ filemtime(public_path('css/corporate-tools.css')) }}">
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
                    
                    <!-- Header -->
                    <div class="heading-area-sec mb-4">
                        <div class="left-part-sec">
                            <h3 class="mb-1">RESOURCE LIBRARY</h3>
                            <p class="text-muted mb-0">This page displays SOPs and other learning resources.</p>
                        </div>
                    </div>
                    
                    <div class="px-4 pb-4">
                        
                        <!-- Resources for Processes -->
                        <div class="resource-card">
                            <div class="card-header">
                                <h5>Resources for Processes</h5>
                            </div>
                            <div class="card-body">
                                <ul class="resource-list">
                                    <li><a href="{{ asset('resource-documents/processes-how-to-build-documentation.pdf') }}" class="resource-link" target="_blank">How to Build Process Documentation</a></li>
                                    <li><a href="{{ asset('resource-documents/processes-documentation-template.docx') }}" class="resource-link" target="_blank">Process Documentation Template</a></li>
                                </ul>
                            </div>
                        </div>

                        <!-- HR Resources -->
                        <div class="resource-card">
                            <div class="card-header">
                                <h5>HR Resources</h5>
                            </div>
                            <div class="card-body">
                                <ul class="resource-list">
                                    <li><a href="{{ asset('resource-documents/hr-preparing-critical-feedback.pdf') }}" class="resource-link" target="_blank">Preparing to Give Critical Feedback</a></li>
                                    <li><a href="{{ asset('resource-documents/hr-job-analysis.docx') }}" class="resource-link" target="_blank">Job Analysis</a></li>
                                    <li><a href="{{ asset('resource-documents/hr-anatomy-of-job-description.pdf') }}" class="resource-link" target="_blank">The Anatomy of a Job Description</a></li>
                                    <li><a href="{{ asset('resource-documents/hr-employee-profile-sheet.pdf') }}" class="resource-link" target="_blank">Employee Profile Sheet</a></li>
                                </ul>
                            </div>
                        </div>

                        <!-- Resources For Corporate Activites -->
                        <div class="resource-card">
                            <div class="card-header">
                                <h5>Resources For Corporate Activites</h5>
                            </div>
                            <div class="card-body">
                                <ul class="resource-list">
                                    <li><a href="{{ asset('resource-documents/corporate-1-on-1-check-in-guide.docx') }}" class="resource-link" target="_blank">1 on 1 Check-in Meeting Guide</a></li>
                                    <li><a href="{{ asset('resource-documents/corporate-new-positions-meeting-guide.pdf') }}" class="resource-link" target="_blank">A Guide for Discussing New Positions in a Team Meeting</a></li>
                                </ul>
                            </div>
                        </div>

                        <!-- E-O-S Guides -->
                        <div class="resource-card">
                            <div class="card-header">
                                <h5>E-O-S Guides</h5>
                            </div>
                            <div class="card-body">
                                <ul class="resource-list">
                                    <li><a href="{{ asset('resource-documents/eos-tools-model.pdf') }}" class="resource-link" target="_blank">EOS Tools Model</a></li>
                                    <li><a href="{{ asset('resource-documents/eos-get-want-capacity-guide.pdf') }}" class="resource-link" target="_blank">Get It. Want It. Capacity Guide</a></li>
                                    <li><a href="{{ asset('resource-documents/eos-lma-checklist.pdf') }}" class="resource-link" target="_blank">Leadership, Management, Accountability Checklist</a></li>
                                    <li><a href="{{ asset('resource-documents/eos-clarity-break.pdf') }}" class="resource-link" target="_blank">Clarity Break</a></li>
                                    <li><a href="{{ asset('resource-documents/eos-kolbe-profile.pdf') }}" class="resource-link" target="_blank">Kolbe Profile</a></li>
                                    <li><a href="{{ asset('resource-documents/eos-meeting-pulse-example.pdf') }}" class="resource-link" target="_blank">Meeting Pulse Example</a></li>
                                    <li><a href="{{ asset('resource-documents/eos-meeting-example.pdf') }}" class="resource-link" target="_blank">Meeting Example</a></li>
                                    <li><a href="{{ asset('resource-documents/eos-3-step-process-documenter.pdf') }}" class="resource-link" target="_blank">The 3-Step Process Documenter</a></li>
                                    <li><a href="{{ asset('resource-documents/eos-issues-solving-track.pdf') }}" class="resource-link" target="_blank">The Issues Solving Track</a></li>
                                </ul>
                            </div>
                        </div>

                        <!-- Miscellaneous -->
                        <div class="resource-card">
                            <div class="card-header">
                                <h5>Miscellaneous</h5>
                            </div>
                            <div class="card-body">
                                <ul class="resource-list">
                                    <li><a href="{{ asset('resource-documents/misc-gmail-signature.pdf') }}" class="resource-link" target="_blank">Gmail Signature</a></li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
