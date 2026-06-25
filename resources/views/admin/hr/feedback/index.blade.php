@extends('admin.includes.layout')

@section('title', 'Feedback Submissions')

@section('content')
    <div class="companies-section my-4">
        <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @include('admin.hr.sidebar')

            <!-- Main Content -->
            <div class="col-md-10 p-0">
                <div class="main-content">
                    <div class="sales-dashboard">

                        {{-- Header --}}
                        <div class="heading-area-sec mb-3">
                            <div class="left-part-sec">
                                <h3 class="mb-1">FEEDBACK SUBMISSIONS</h3>
                                <p class="text-muted mb-0">
                                    Review anonymous employee feedback.
                                </p>
                            </div>
                            <div class="right-part-sec">
                                <a href="{{ route('admin.hr.feedback.create') }}" class="btn btn-export">+ Submit
                                    Feedback</a>
                            </div>
                        </div>

                            {{-- Timeline --}}
                            <div class="px-4 pb-4 company-details-section">
                                <div class="section-card">

                                    <div class="timeline-container">
                                        <div class="timeline position-relative">

                                            @forelse($feedbacks as $fb)
                                                <div class="timeline-item">
                                                    <div class="timeline-icon">
                                                        <i class="fas fa-angle-double-right"></i>
                                                    </div>
                                                    <div class="timeline-content">
                                                        <div class="timeline-header">
                                                            <div class="timestamp">
                                                                {{ $fb->created_at->format('g:i A \o\n M j, Y') }}
                                                            </div>
                                                        </div>
                                                        <div class="timeline-body">
                                                            <div class="activity-details mt-2">
                                                                <div class="activity-description">
                                                                    <div class="text-muted">
                                                                        {{ $fb->description }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="text-center">
                                                    <h6>NO FEEDBACK YET</h6>
                                                    <p class="text-muted mb-0">No anonymous feedback has been submitted yet.</p>
                                                </div>
                                            @endforelse

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