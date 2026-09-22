@extends('admin.includes.layout')

@section('title', 'Resource Library')

@push('styles')
    <style>
        .resource-card {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            background-color: #ffffff;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        }
        .resource-card .card-header {
            background-color: rgba(255, 184, 28, 0.4);
            border-bottom: 1px solid #e5e7eb;
            padding: 18px 24px;
            border-radius: 12px 12px 0 0 !important;
        }
        .resource-card .card-header h5 {
            color: #374151;
            font-size: 18px;
            font-weight: 600;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .resource-card .card-body {
            padding: 24px;
        }
        .resource-list {
            list-style: none;
            padding-left: 0;
            margin-bottom: 0;
        }
        .resource-list li {
            position: relative;
            padding-left: 16px;
            margin-bottom: 8px;
            font-size: 16px;
        }
        .resource-list li::before {
            content: "•";
            color: #9ca3af;
            font-weight: bold;
            position: absolute;
            left: 0;
        }
        .resource-list li:last-child {
            margin-bottom: 0;
        }
        .resource-link {
            color: #2563eb;
            text-decoration: none;
            font-weight: 500;
        }
        .resource-link:hover {
            text-decoration: underline;
            color: #1d4ed8;
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
                                    <li><a href="#" class="resource-link">How to Build Process Documentation</a></li>
                                    <li><a href="#" class="resource-link">Process Documentation Template</a></li>
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
                                    <li><a href="#" class="resource-link">Preparing to Give Critical Feedback</a></li>
                                    <li><a href="#" class="resource-link">Job Analysis</a></li>
                                    <li><a href="#" class="resource-link">The Anatomy of a Job Description</a></li>
                                    <li><a href="#" class="resource-link">Employee Profile Sheet</a></li>
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
                                    <li><a href="#" class="resource-link">1 on 1 Check-in Meeting Guide</a></li>
                                    <li><a href="#" class="resource-link">A Guide for Discussing New Positions in a Team Meeting</a></li>
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
                                    <li><a href="#" class="resource-link">EOS Tools Model</a></li>
                                    <li><a href="#" class="resource-link">Get It. Want It. Capacity Guide</a></li>
                                    <li><a href="#" class="resource-link">Leadership, Management, Accountability Checklist</a></li>
                                    <li><a href="#" class="resource-link">Clarity Break</a></li>
                                    <li><a href="#" class="resource-link">Kolbe Profile</a></li>
                                    <li><a href="#" class="resource-link">Meeting Pulse Example</a></li>
                                    <li><a href="#" class="resource-link">Meeting Example</a></li>
                                    <li><a href="#" class="resource-link">The 3-Step Process Documenter</a></li>
                                    <li><a href="#" class="resource-link">The Issues Solving Track</a></li>
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
                                    <li><a href="#" class="resource-link">Gmail Signature</a></li>
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
