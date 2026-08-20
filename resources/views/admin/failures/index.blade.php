@extends('admin.includes.layout')

@section('title', 'Business Failures')

@push('styles')
    <style>
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

        /* Fullscreen form styling */
        .company-form .form-group {
            margin-bottom: 20px;
        }
        .company-form .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
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
                        <div class="heading-area-sec border-bottom-0 pb-0">
                            <div class="left-part-sec">
                                <h3 class="mb-2" style="font-size: 26px; font-weight: 500;">BUSINESS FAILURES <span style="font-size: 24px;">⚠️</span></h3>
                                <p class="text-muted mb-0" style="font-size: 16px;">Track failures, investigate root causes, log corrective actions and record findings.</p>
                            </div>
                            @can('business_failures.add')
                            <div class="right-part-sec">
                                <button class="btn btn-export" data-bs-toggle="modal" data-bs-target="#createFeedbackModal">
                                    + ADD NEW FEEDBACK
                                </button>
                            </div>
                            @endcan
                        </div>

                        <hr class="mx-4 my-4" style="opacity: 0.1;">

                        <!-- Business Failures Section Cards -->
                        <div class="px-4 pb-4">
                            @forelse($failures as $failure)
                                <div class="section-card">
                                    <div class="d-flex justify-content-between align-items-start border-bottom pb-3 mb-3">
                                        <div>
                                            <h4 class="mb-1" style="font-size: 18px; font-weight: 600; color: #111827;">
                                                {{ $failure->title }}
                                            </h4>
                                            <div class="text-muted small">
                                                Opened on {{ $failure->record_opened_date ? $failure->record_opened_date->format('M j, Y') : 'N/A' }} 
                                                by <span class="fw-semibold text-dark">{{ $failure->creator->name ?? 'System' }}</span>
                                            </div>
                                        </div>
                                        <div>
                                            @can('business_failures.add')
                                            <button type="button" class="btn btn-outline-dark edit-failure-btn me-2"
                                                    data-id="{{ $failure->id }}"
                                                    data-title="{{ $failure->title }}"
                                                    data-description="{{ $failure->description }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <button type="button" class="btn btn-outline-dark add-doc-btn"
                                                    data-id="{{ $failure->id }}"
                                                    data-title="{{ $failure->title }}">
                                                + Documentation
                                            </button>
                                            @endcan
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <h6 class="text-uppercase text-secondary fw-bold mb-2" style="font-size: 11px; letter-spacing: 0.5px;">Failure Description / Initial Report</h6>
                                        <div class="text-dark" style="font-size: 14px; color: #374151;">
                                            {{ $failure->description }}
                                        </div>
                                    </div>

                                    @if($failure->documentations->isNotEmpty())
                                        <div class="mt-3">
                                            <h6 class="text-uppercase text-secondary fw-bold mb-3" style="font-size: 11px; letter-spacing: 0.5px;">Documentation & Investigation History</h6>
                                            <div class="border rounded-3 overflow-hidden bg-light">
                                                @foreach($failure->documentations->sortBy('created_at') as $doc)
                                                    <div class="d-flex justify-content-between align-items-start p-3 border-bottom last-border-0 bg-white">
                                                        <div class="d-flex align-items-start">
                                                            <span class="me-3" style="background-color: #ffb400; color: white; width: 32px; height: 32px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 600;">
                                                                {{ strtoupper(substr($doc->user->name ?? 'SY', 0, 2)) }}
                                                            </span>
                                                            <div>
                                                                <span class="fw-bold text-dark" style="font-size: 13.5px;">{{ $doc->user->name ?? 'System' }}</span>
                                                                <div class="text-muted mt-1" style="font-size: 13px; white-space: pre-wrap; line-height: 1.4; color: #4b5563;">{{ $doc->notes }}</div>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <span class="text-muted me-3" style="font-size: 11.5px; white-space: nowrap;">
                                                                {{ $doc->created_at->format('M j, Y g:i A') }}
                                                            </span>
                                                            @can('business_failures.add')
                                                            <button type="button" class="btn btn-sm btn-link text-secondary p-0 edit-doc-btn"
                                                                    data-id="{{ $doc->id }}"
                                                                    data-notes="{{ $doc->notes }}"
                                                                    title="Edit Documentation">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <div class="text-muted small mt-2">
                                            <i class="fas fa-info-circle me-1"></i> No documentation updates recorded yet.
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div class="section-card text-center text-muted py-5">
                                    <i class="fas fa-check-circle text-success mb-3" style="font-size: 48px;"></i>
                                    <h5>No Business Failures Logged</h5>
                                    <p class="mb-0">Everything is running smoothly!</p>
                                </div>
                            @endforelse
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Feedback Fullscreen Modal -->
<div class="modal fade" id="createFeedbackModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="exampleModalLabel">New Business Failure</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createFeedbackForm" action="{{ route('admin.failures.store') }}" method="POST" class="company-form">
                    @csrf
                    <div class="row mx-0">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Client</label>
                                <span class="text-danger">*</span>
                                <input type="text" class="form-control" name="title" placeholder="e.g. Acme Corp" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Description</label>
                                <span class="text-danger">*</span>
                                <textarea class="form-control" name="description" rows="5" placeholder="Describe the failure and initial report..." required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Documentation Modal -->
<div class="modal fade" id="addDocModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="exampleModalLabel">Add documentation</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addDocForm" action="" method="POST" class="company-form">
                @csrf
                <div class="modal-body">
                    <div class="row mx-0">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Identify root cause and solutions to prevent recurrence when possible <span class="text-danger">*</span></label>
                                
                                <textarea class="form-control" name="notes" id="docNotes" rows="5" placeholder="Describe root cause and solutions..." required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="addDocSubmitBtn">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Feedback Fullscreen Modal -->
<div class="modal fade" id="editFeedbackModal" tabindex="-1" aria-labelledby="editFeedbackModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="editFeedbackModalLabel">Edit Business Failure</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editFeedbackForm" action="" method="POST" class="company-form">
                    @csrf
                    <div class="row mx-0">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Client</label>
                                <span class="text-danger">*</span>
                                <input type="text" class="form-control" name="title" id="editFailureTitle" placeholder="e.g. Acme Corp" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Description</label>
                                <span class="text-danger">*</span>
                                <textarea class="form-control" name="description" id="editFailureDescription" rows="5" placeholder="Describe the failure and initial report..." required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="editFeedbackSubmitBtn">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Documentation Modal -->
<div class="modal fade" id="editDocModal" tabindex="-1" aria-labelledby="editDocModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="editDocModalLabel">Edit documentation</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editDocForm" action="" method="POST" class="company-form">
                @csrf
                <div class="modal-body">
                    <div class="row mx-0">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Identify root cause and solutions to prevent recurrence when possible <span class="text-danger">*</span></label>
                                
                                <textarea class="form-control" name="notes" id="editDocNotes" rows="5" placeholder="Describe root cause and solutions..." required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="editDocSubmitBtn">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            const validationConfig = {
                ignore: [],
                errorElement: 'span',
                errorClass: 'invalid-feedback d-block',
                highlight: function(element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                }
            };

            $('#createFeedbackForm').validate($.extend(true, {}, validationConfig, {
                rules: {
                    title: { required: true },
                    description: { required: true }
                },
                messages: {
                    title: "Client name is required.",
                    description: "Description is required."
                }
            }));

            // Create Feedback AJAX Submission
            $('#createFeedbackForm').on('submit', function(e) {
                e.preventDefault();
                const form = $(this);
                if (!form.valid()) return;
                const submitBtn = form.find('button[type="submit"]');

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    beforeSend: function() {
                        submitBtn.prop('disabled', true).text('Submitting...');
                    },
                    success: function(response) {
                        toastr.success(response.message || 'Feedback saved successfully!');
                        $('#createFeedbackModal').modal('hide');
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    },
                    error: function(xhr) {
                        if (xhr.status === 422 && xhr.responseJSON?.errors) {
                            $.each(xhr.responseJSON.errors, function(field, messages) {
                                messages.forEach(function(message) { toastr.error(message); });
                            });
                        } else {
                            toastr.error(xhr.responseJSON?.message || 'Something went wrong.');
                        }
                        submitBtn.prop('disabled', false).text('Submit');
                    }
                });
            });

            // Edit Feedback AJAX Submission
            $('#editFeedbackForm').validate($.extend(true, {}, validationConfig, {
                rules: {
                    title: { required: true },
                    description: { required: true }
                },
                messages: {
                    title: "Client name is required.",
                    description: "Description is required."
                }
            }));

            $(document).on('click', '.edit-failure-btn', function() {
                const id = $(this).data('id');
                const title = $(this).data('title');
                const description = $(this).data('description');

                let actionUrl = "{{ route('admin.failures.update', ':id') }}";
                actionUrl = actionUrl.replace(':id', id);
                $('#editFeedbackForm').attr('action', actionUrl);
                
                $('#editFailureTitle').val(title);
                $('#editFailureDescription').val(description);
                
                const validator = $('#editFeedbackForm').validate();
                if(validator) validator.resetForm();
                $('#editFeedbackForm').find('.is-invalid').removeClass('is-invalid');

                $('#editFeedbackModal').modal('show');
            });

            $('#editFeedbackForm').on('submit', function(e) {
                e.preventDefault();
                const form = $(this);
                if (!form.valid()) return;
                const submitBtn = $('#editFeedbackSubmitBtn');

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    beforeSend: function() {
                        submitBtn.prop('disabled', true).text('Saving...');
                    },
                    success: function(response) {
                        toastr.success(response.message || 'Feedback updated successfully!');
                        $('#editFeedbackModal').modal('hide');
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    },
                    error: function(xhr) {
                        if (xhr.status === 422 && xhr.responseJSON?.errors) {
                            $.each(xhr.responseJSON.errors, function(field, messages) {
                                messages.forEach(function(message) { toastr.error(message); });
                            });
                        } else {
                            toastr.error(xhr.responseJSON?.message || 'Something went wrong.');
                        }
                        submitBtn.prop('disabled', false).text('Save Changes');
                    }
                });
            });

            // Open Add Documentation Modal
            $(document).on('click', '.add-doc-btn', function() {
                const id = $(this).data('id');
                const title = $(this).data('title');

                $('#docFailureTitle').text(title);
                
                let actionUrl = "{{ route('admin.failures.documentation.store', ':id') }}";
                actionUrl = actionUrl.replace(':id', id);
                $('#addDocForm').attr('action', actionUrl);
                
                $('#docNotes').val('');
                
                // reset validation state
                const validator = $('#addDocForm').validate();
                if(validator) validator.resetForm();
                $('#addDocForm').find('.is-invalid').removeClass('is-invalid');

                $('#addDocModal').modal('show');
            });

            $('#addDocForm').validate($.extend(true, {}, validationConfig, {
                rules: {
                    notes: { required: true }
                },
                messages: {
                    notes: "Documentation notes are required."
                }
            }));

            // Add Documentation AJAX Submission
            $('#addDocForm').on('submit', function(e) {
                e.preventDefault();
                const form = $(this);
                if (!form.valid()) return;
                const submitBtn = $('#addDocSubmitBtn');

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    beforeSend: function() {
                        submitBtn.prop('disabled', true).text('Submitting...');
                    },
                    success: function(response) {
                        toastr.success(response.message || 'Documentation added successfully!');
                        $('#addDocModal').modal('hide');
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    },
                    error: function(xhr) {
                        if (xhr.status === 422 && xhr.responseJSON?.errors) {
                            $.each(xhr.responseJSON.errors, function(field, messages) {
                                messages.forEach(function(message) { toastr.error(message); });
                            });
                        } else {
                            toastr.error(xhr.responseJSON?.message || 'Something went wrong.');
                        }
                        submitBtn.prop('disabled', false).text('Submit');
                    }
                });
            });

            // Edit Documentation Logic
            $('#editDocForm').validate($.extend(true, {}, validationConfig, {
                rules: {
                    notes: { required: true }
                },
                messages: {
                    notes: "Documentation notes are required."
                }
            }));

            $(document).on('click', '.edit-doc-btn', function() {
                const id = $(this).data('id');
                const notes = $(this).data('notes');

                let actionUrl = "{{ route('admin.failures.documentation.update', ':id') }}";
                actionUrl = actionUrl.replace(':id', id);
                $('#editDocForm').attr('action', actionUrl);
                
                $('#editDocNotes').val(notes);
                
                const validator = $('#editDocForm').validate();
                if(validator) validator.resetForm();
                $('#editDocForm').find('.is-invalid').removeClass('is-invalid');

                $('#editDocModal').modal('show');
            });

            $('#editDocForm').on('submit', function(e) {
                e.preventDefault();
                const form = $(this);
                if (!form.valid()) return;
                const submitBtn = $('#editDocSubmitBtn');

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    beforeSend: function() {
                        submitBtn.prop('disabled', true).text('Saving...');
                    },
                    success: function(response) {
                        toastr.success(response.message || 'Documentation updated successfully!');
                        $('#editDocModal').modal('hide');
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    },
                    error: function(xhr) {
                        if (xhr.status === 422 && xhr.responseJSON?.errors) {
                            $.each(xhr.responseJSON.errors, function(field, messages) {
                                messages.forEach(function(message) { toastr.error(message); });
                            });
                        } else {
                            toastr.error(xhr.responseJSON?.message || 'Something went wrong.');
                        }
                        submitBtn.prop('disabled', false).text('Save Changes');
                    }
                });
            });
        });
    </script>
@endpush
