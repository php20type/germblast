@extends('admin.includes.layout')

@section('title', 'Action Plan Overview')

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

        /* Modern Soft Tabs Styling */
        .navbar-tabs .nav-tabs {
            border-bottom: none !important;
        }

        .navbar-tabs .nav-link {
            border: none !important;
            color: #6b7280 !important;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 13px;
            padding: 12px 20px 20px 20px !important;
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

        .navbar-tabs .badge {
            background-color: #6b7280 !important;
            font-weight: 500;
            padding: 4px 8px;
            font-size: 11px;
            vertical-align: middle;
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
                                    <h3 class="mb-1 text-uppercase">ACTION PLAN OVERVIEW</h3>
                                    <p class="text-muted mb-0">Overview of active action plans and their corresponding strategies.</p>
                                </div>
                                <div class="right-part-sec">
                                    <button class="btn btn-export" data-bs-toggle="modal" data-bs-target="#AddActionPlanModal">+ NEW ACTION PLAN</button>
                                </div>
                            </div>

                            <div class="px-4 pb-0 text-start">
                                <div class="navbar-tabs pt-3">
                                    <nav class="nav nav-tabs mb-0 w-100 nav-fill" id="actionPlanTabs" role="tablist">
                                        <button class="nav-link active" id="unresolved-tab" data-bs-toggle="tab" data-bs-target="#unresolved" type="button" role="tab">Unresolved <span class="badge bg-secondary text-white rounded-pill ms-1">{{ count($unresolvedActionPlans) }}</span></button>
                                        <button class="nav-link" id="resolved-tab" data-bs-toggle="tab" data-bs-target="#resolved" type="button" role="tab">Resolved <span class="badge bg-secondary text-white rounded-pill ms-1">{{ count($resolvedActionPlans) }}</span></button>
                                    </nav>
                                </div>
                                <hr class="mb-4 mt-0" style="opacity: 0.1;">

                                <div class="tab-content" id="actionPlanTabsContent">
                                    <!-- Unresolved Issues Tab -->
                                    <div class="tab-pane fade show active" id="unresolved" role="tabpanel">
                                        @forelse ($unresolvedActionPlans as $plan)
                                            <div class="section-card">
                                                <div class="d-flex justify-content-between align-items-start border-bottom pb-3 mb-3">
                                                    <div>
                                                        <h4 class="mb-2" style="font-size: 18px; font-weight: 600; color: #111827;">Concern Area: {{ $plan->concern_area }}</h4>
                                                        <div class="text-muted small">
                                                            Added by <span class="fw-semibold text-dark">{{ $plan->user->name ?? 'System' }}</span>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <form action="{{ route('admin.operations.action-plan.resolve', $plan->id) }}" method="POST" class="resolve-action-plan-form">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-outline-success py-2 px-3" style="border-radius: 8px;">Mark as Resolved</button>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <h6 class="text-uppercase text-secondary fw-bold mb-2" style="font-size: 11px; letter-spacing: 0.5px;">Section</h6>
                                                    <div class="text-dark" style="font-size: 16px; color: #374151;">
                                                        <span class="text-secondary text-decoration-underline">{{ $plan->section }}</span>
                                                    </div>
                                                </div>
                                                <div class="mb-2">
                                                    <h6 class="text-uppercase text-secondary fw-bold mb-2" style="font-size: 11px; letter-spacing: 0.5px;">Notes</h6>
                                                    <div class="text-dark" style="font-size: 16px; color: #374151; line-height: 1.5;">
                                                        {{ $plan->notes }}
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="text-center py-4 text-muted">No unresolved action plans found.</div>
                                        @endforelse
                                    </div>

                                    <!-- Resolved Issues Tab -->
                                    <div class="tab-pane fade" id="resolved" role="tabpanel">
                                        @forelse ($resolvedActionPlans as $plan)
                                            <div class="section-card">
                                                <div class="d-flex justify-content-between align-items-start border-bottom pb-3 mb-3">
                                                    <div>
                                                        <h4 class="mb-2" style="font-size: 18px; font-weight: 600; color: #111827;">Concern Area: {{ $plan->concern_area }}</h4>
                                                        <div class="text-muted small">
                                                            Added by <span class="fw-semibold text-dark">{{ $plan->user->name ?? 'System' }}</span>
                                                            <span class="mx-2">|</span>
                                                            Resolved by <span class="fw-semibold text-dark">{{ $plan->resolver->name ?? 'System' }}</span> on <span class="fw-semibold text-dark">{{ \Carbon\Carbon::parse($plan->resolved_at)->format('m-d-y') }}</span>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <span class="badge bg-success px-3 py-2 rounded-pill"><i class="fas fa-check me-1"></i> RESOLVED</span>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <h6 class="text-uppercase text-secondary fw-bold mb-2" style="font-size: 11px; letter-spacing: 0.5px;">Section</h6>
                                                    <div class="text-dark" style="font-size: 16px; color: #374151;">
                                                        <span class="text-secondary text-decoration-underline">{{ $plan->section }}</span>
                                                    </div>
                                                </div>
                                                <div class="mb-2">
                                                    <h6 class="text-uppercase text-secondary fw-bold mb-2" style="font-size: 11px; letter-spacing: 0.5px;">Notes</h6>
                                                    <div class="text-dark" style="font-size: 16x; color: #374151; line-height: 1.5;">
                                                        {{ $plan->notes }}
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="text-center py-4 text-muted">No resolved action plans found.</div>
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

    <!-- Add Action Plan Modal Start -->
    <div class="modal fade" id="AddActionPlanModal" tabindex="-1" aria-labelledby="addActionPlanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="addActionPlanModalLabel">Add Action Plan Overview</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.operations.action-plan.store') }}" method="POST" class="company-form" id="add-action-plan-form">
                        @csrf
                        <div class="row mx-0">
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label class="form-label fw-semibold" style="color: #374151;">Concern Area</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="concern_area" placeholder="E.g. Photocatalytic Oxidation" class="form-control" required />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label class="form-label fw-semibold" style="color: #374151;">Section / Clinic</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="section" placeholder="E.g. Section:11 -(South Plains Veterinary Clinic)" class="form-control" required />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label class="form-label fw-semibold" style="color: #374151;">Notes</label>
                                    <span class="text-danger">*</span>
                                    <textarea name="notes" rows="4" placeholder="Add some notes about this action plan..." class="form-control" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer px-0 pb-0 mt-4">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Action Plan Modal End -->

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Validation for Add Action Plan Form
        $("#add-action-plan-form").validate({
            rules: {
                concern_area: { required: true },
                section: { required: true },
                notes: { required: true }
            },
            messages: {
                concern_area: { required: "Please enter a Concern Area." },
                section: { required: "Please enter a Section / Clinic." },
                notes: { required: "Please enter notes." }
            },
            errorElement: 'span',
            errorClass: 'invalid-feedback d-block',
            highlight: function(element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
            }
        });

        // AJAX Submission for Add Action Plan
        $('#add-action-plan-form').submit(function(e) {
            e.preventDefault();
            const $form = $(this);
            const $submitBtn = $form.find('button[type="submit"]');

            if (!$form.valid()) return;

            $.ajax({
                url: $form.attr('action'),
                method: 'POST',
                data: $form.serialize(),
                beforeSend: function() {
                    $submitBtn.prop('disabled', true).text('Saving...');
                },
                success: function() {
                    toastr.success('Action Plan created successfully!');
                    $form[0].reset();
                    $('#AddActionPlanModal').modal('hide');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                },
                error: function(xhr) {
                    toastr.error('Something went wrong while creating the action plan.');
                    $submitBtn.prop('disabled', false).text('Save changes');
                }
            });
        });

        // AJAX Submission for Mark as Resolved
        $(document).on('submit', '.resolve-action-plan-form', function(e) {
            e.preventDefault();
            const $form = $(this);
            const $submitBtn = $form.find('button[type="submit"]');

            $.ajax({
                url: $form.attr('action'),
                method: 'POST',
                data: $form.serialize(),
                beforeSend: function() {
                    $submitBtn.prop('disabled', true).text('Resolving...');
                },
                success: function() {
                    toastr.success('Action Plan resolved successfully!');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                },
                error: function() {
                    toastr.error('Something went wrong.');
                    $submitBtn.prop('disabled', false).text('Mark as Resolved');
                }
            });
        });
    });
</script>
@endpush
