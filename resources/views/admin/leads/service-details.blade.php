@extends('admin.includes.layout')

@section('title', 'Service Details')

@section('content')
    <!-- All Companies Section start  -->
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">
                <!-- Main Content -->
                <div class="col-md-12 p-0">

                    <form action="#" method="POST" class="" id="add-survey-form">
                        @csrf
                        <input type="hidden" name="lead_id" value="{{ $lead->id }}">

                        <div class="sales-dashboard">
                            <div class="dashboard-header section-card d-flex justify-content-between align-items-center">
                                <div class="container-fluid px-0">
                                    <h1 class="display-6 mb-2 fw-bold">Survey & Proposal</h1>
                                    <p class="text-muted">Record survey results on this page</p>
                                </div>

                                <div>
                                   <button type="submit" class="btn btn-success">
                                            Save
                                    </button>
                                </div>
                            </div>

                            {{-- District Numbers --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">

                                        <div class="section-header">
                                            <h3 class="section-title">District Numbers</h3>
                                        </div>

                                        <table class="table table-bordered align-middle">
                                            <tbody>
                                                <tr>
                                                    <th>Client</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="client_name"
                                                            value="{{ $surveyProposal->company->name ?? '' }}" readonly>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Date</th>
                                                    <td>
                                                        <input type="date" class="form-control" name="date"
                                                            value="{{ isset($surveyProposal->date) ? date('Y-m-d', strtotime($surveyProposal->date)) : '' }}"
                                                            {{ !$isEditable ? 'readonly' : '' }}>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Description</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="description"
                                                            value="{{ $surveyProposal->description ?? '' }}"
                                                            {{ !$isEditable ? 'readonly' : '' }}>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Enrollment</th>
                                                    <td>
                                                        <input type="number" class="form-control" name="enrollment"
                                                            value="{{ $surveyProposal->enrollment ?? 0 }}"
                                                            {{ !$isEditable ? 'readonly' : '' }}>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>WADA</th>
                                                    <td>
                                                        <input type="number" step="0.01" class="form-control"
                                                            name="wada" value="{{ $surveyProposal->wada ?? 0 }}"
                                                            {{ !$isEditable ? 'readonly' : '' }}>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>ABA</th>
                                                    <td>
                                                        <input type="number" step="0.01" class="form-control"
                                                            name="aba" value="{{ $surveyProposal->aba ?? 0 }}"
                                                            {{ !$isEditable ? 'readonly' : '' }}>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Recommended Number of Service Technicians</th>
                                                    <td>
                                                        <input type="number" class="form-control"
                                                            name="service_technicians"
                                                            value="{{ $surveyProposal->service_technicians ?? 0 }}"
                                                            {{ !$isEditable ? 'readonly' : '' }}>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Distance to Client</th>
                                                    <td>
                                                        <input type="number" class="form-control" name="distance"
                                                            value="{{ $surveyProposal->distance ?? 0 }}"
                                                            {{ !$isEditable ? 'readonly' : '' }}>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Man Hours</th>
                                                    <td>
                                                        <input type="number" class="form-control" name="man_hours"
                                                            value="{{ $surveyProposal->man_hours ?? 0 }}"
                                                            {{ !$isEditable ? 'readonly' : '' }}>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Estimate</th>
                                                    <td><span
                                                            class="fw-bold">${{ $surveyProposal->estimate ?? '0.00' }}</span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
                <!-- Main Content Ends -->

            </div>
        </div>
    </div>

    {{-- Reject Proposal Modal --}}
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">

                {{-- HEADER --}}
                <div class="modal-header">
                    <h1 class="modal-title" id="rejectModalLabel">Reject Proposal</h1>
                    <div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>

                {{-- BODY --}}
                <div class="modal-body">
                    <form id="rejectForm">

                        <div class="row mx-0">

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Reason</label><span class="text-danger">*</span>

                                    <textarea class="form-control" id="rejectComment" name="comment" rows="5" required
                                        placeholder="Please provide a reason for rejection..."></textarea>
                                </div>
                            </div>

                        </div>

                        {{-- FOOTER --}}
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Close
                            </button>

                            <button type="button" class="btn btn-danger" id="submitRejectBtn">
                                Reject Proposal
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>



@endsection

@push('scripts')

@endpush
