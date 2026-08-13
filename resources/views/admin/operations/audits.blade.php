@extends('admin.includes.layout')

@section('title', 'Audits')

@push('styles')
    <style>
        .cursor-pointer {
            cursor: pointer !important;
        }

        /* Section Cards from Business Failures */
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
                @include('admin.operations.sidebar')

                <!-- Main Content -->
                <div class="col-md-10 p-0">
                    <div class="main-content">
                        
                        <div class="sales-dashboard">
                            <!-- Header -->
                            <div class="heading-area-sec mb-3">
                                <div class="left-part-sec">
                                    <h3 class="mb-1 text-uppercase">AUDITS</h3>
                                    <p class="text-muted mb-0">Overview of completed facility audits and their corresponding scores.</p>
                                </div>
                            </div>

                            <div class="px-4 pb-4">
                                <div class="mt-3">
                                    @forelse($audits as $audit)
                                        <div class="section-card">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: #111827;">{{ $audit->serviceOrder->service->lead->company->name ?? 'testing' }}</h4>
                                                    <div class="text-muted small mb-3">Score 3.94</div>
                                                    <a href="{{ route('admin.operations.audits.show', $audit->id) }}" class="btn btn-sm btn-outline-warning py-2 px-4" style="border-radius: 6px; font-size: 13px;">
                                                        Go To Audit
                                                    </a>
                                                </div>
                                                <div class="text-muted small mt-1">
                                                    Date of Audit {{ \Carbon\Carbon::parse($audit->scheduled_start_time)->format('m/d') }}
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center py-4 text-muted">No finalized audits found.</div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

