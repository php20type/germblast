@extends('admin.includes.layout')

@section('title', 'SIT Progress')

@push('styles')
<style>
    .section-card {
        background: #fff;
        border: 1px solid #f0f0f0;
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 24px;
    }
    .sit-body {
        color: #4b5563;
        font-size: 14px;
        line-height: 1.6;
    }
    .sit-section {
        margin-bottom: 16px;
    }
    .sit-section strong {
        color: #374151;
        font-weight: 700;
    }
    .sit-empty-message {
        font-size: 22px;
        font-weight: 300;
        color: #6b7280;
    }
</style>
@endpush

@section('content')
<div class="companies-section my-4">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @include('admin.operations.sidebar')

            <div class="col-md-10 p-0">
                <div class="main-content">
                    <div class="sales-dashboard">

                        <!-- Header -->
                        <div class="heading-area-sec mb-4 px-4">
                            <div class="left-part-sec">
                                <h3 class="mb-1 text-uppercase">SIT PROGRESS</h3>
                                <p class="text-muted mb-0">Track the progress of current Supervisors In Training.</p>
                            </div>
                        </div>

                        <div class="px-4 pb-4">
                            <div class="section-card sit-body">
                                <div class="mb-4 pb-2" style="border-bottom: 1px solid #f3f4f6;">
                                    <h5 class="fw-bold text-dark mb-0" style="font-size: 16px;">PROGRAM OVERVIEW</h5>
                                </div>
                                
                                <div class="sit-section">
                                    <strong>Description:</strong> The Supervisor In Training (SIT) Program is a probationary period used for necessary training to become a GermBlast Service Supervisor. The SIT Program does not guarantee a supervisory position but is merited by the success and performance of the training program of each individual.
                                </div>
                                
                                <div class="sit-section">
                                    <strong>Duration:</strong> The Supervisor in Training Program is conducted over a 90-day period but can be extended to accommodate necessary training deemed by Service Supervisors and Operations Managers. The training program will be divided into modules that will differ in time depending on the knowledge and understanding of each SIT. Supervisors and Operations Managers will sign off in ICIMatrix when each task has been successfully completed.
                                </div>
                                
                                <div class="sit-section">
                                    <strong>Requirements:</strong> The Supervisor In Training Program requirements that will need to be met in order to begin:
                                    <ul class="mt-2 mb-0">
                                        <li>Employment for a minimum of 90 days</li>
                                        <li>Must be 21 years of age or older (MVR Requirements)</li>
                                    </ul>
                                </div>
                                
                                <div class="sit-section">
                                    <strong>Process:</strong> Once an employee has met the requirements for the SIT Training Program, the OM and SIT will begin training on the modules within ICIMatrix. Each module will need to be completed before moving onto the next. Once the SIT has successfully completed all modules, the OM will reach out to Risk Management for an audit.
                                </div>
                                
                                <div class="mt-4 pt-4" style="border-top: 1px solid #f3f4f6;">
                                    <h4 class="sit-empty-message">There is no one currently in the SIT Program for this location</h4>
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
