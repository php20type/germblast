@extends('admin.includes.layout')

@section('title', 'Feedback Submissions')

@push('styles')
<style>
    /* Status Pills styling */
    .status-pill {
        font-size: 11px !important;
        font-weight: 700 !important;
        padding: 4px 10px !important;
        border-radius: 20px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 4px !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
        border: 1px solid transparent !important;
    }

    .status-pill-feedback {
        background-color: rgba(107, 114, 128, 0.12) !important;
        color: #4b5563 !important;
        border-color: rgba(107, 114, 128, 0.2) !important;
    }

    /* Section Cards */
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
</style>
@endpush

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

                        <!-- Header -->
                        <div class="heading-area-sec mb-3">
                            <div class="left-part-sec">
                                <h3 class="mb-1 text-uppercase">FEEDBACK SUBMISSIONS <span style="font-size: 24px;">💬</span></h3>
                                <p class="text-muted mb-0">Review anonymous employee feedback.</p>
                            </div>
                            @can('anonymous_feedback.add')
                            <div class="right-part-sec">
                                <a href="{{ route('admin.hr.feedback.create') }}" class="btn btn-export">
                                    + SUBMIT FEEDBACK
                                </a>
                            </div>
                            @endcan
                        </div>

                        <!-- Cards Content -->
                        <div class="px-4 pb-4 text-start">
                            @forelse ($feedbacks as $fb)
                                <div class="section-card mt-3">
                                    <div class="d-flex justify-content-between align-items-start border-bottom pb-3 mb-3">
                                        <div class="d-flex flex-column align-items-start">
                                            <div class="mb-2">
                                                <span class="status-pill status-pill-feedback">ANONYMOUS</span>
                                            </div>
                                            <div class="text-muted small mt-1">
                                                Submitted on <span class="fw-semibold text-dark">{{ $fb->created_at->format('M d, Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <h6 class="text-uppercase text-secondary fw-bold mb-2" style="font-size: 11px; letter-spacing: 0.5px;">Feedback</h6>
                                        <div class="text-dark" style="font-size: 15px; color: #374151; line-height: 1.5;">
                                            {{ $fb->description }}
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4 text-muted">No anonymous feedback has been submitted yet.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection