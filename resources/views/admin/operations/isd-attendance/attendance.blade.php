@extends('admin.includes.layout')

@section('title', 'ISD Attendance Records - ' . $selectedCampus['name'])

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        /* Equipment Report Table Boxed Styling (Matching Exception and Training Reports) */
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
                        <div class="heading-area-sec mb-3">
                            <div class="left-part-sec">
                                <h3 class="mb-1">ISD ATTENDANCE</h3>
                                <p class="text-muted mb-0">
                                    Weekly attendance history for <strong>{{ $selectedCampus['name'] }}</strong> ({{ $selectedSchool['name'] }}).
                                </p>
                            </div>
                            <div class="right-part-sec d-flex align-items-center">
                                <a href="{{ route('admin.isd-attendance.index', ['school_id' => $selectedSchool['id']]) }}" class="btn btn-outline-secondary me-2">
                                    ⬅ Return to All Campuses
                                </a>
                                <button class="btn btn-export" data-bs-toggle="modal" data-bs-target="#AddAttendance">
                                    + ADD ATTENDANCE
                                </button>
                            </div>
                        </div>

                        <!-- Success Alert -->
                        @if(session('success'))
                            <div class="px-4 mt-2">
                                <div class="alert alert-success alert-dismissible fade show border-0 rounded-3" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                        @endif

                        <!-- Table Card Container -->
                        <div class="px-4 pb-4">
                            <div class="table-responsive">
                                <table class="table equipment-report-table mb-0">
                                    <thead>
                                        <tr>
                                            <th>School Year</th>
                                            <th>Week</th>
                                            <th>ADA</th>
                                            <th>PIA</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($attendanceRecords as $record)
                                            <tr>
                                                <td><strong>{{ $record['school_year'] }}</strong></td>
                                                <td>Week {{ $record['week'] }}</td>
                                                <td>
                                                    <span class="badge bg-light text-dark border px-2 py-1" style="font-size: 13px;">
                                                        {{ number_format($record['ada'], 2) }}%
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-light text-dark border px-2 py-1" style="font-size: 13px;">
                                                        {{ number_format($record['pia'], 2) }}%
                                                    </span>
                                                </td>
                                                <td class="text-end">
                                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#EditAttendance{{ $record['id'] }}">
                                                        Edit
                                                    </button>
                                                </td>
                                            </tr>

                                            <!-- Edit Attendance Modal Start -->
                                            <div class="modal fade" id="EditAttendance{{ $record['id'] }}" tabindex="-1" aria-labelledby="editAttendanceLabel{{ $record['id'] }}" aria-hidden="true">
                                                <div class="modal-dialog modal-fullscreen">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title" id="editAttendanceLabel{{ $record['id'] }}">Edit Attendance Record</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('admin.isd-attendance.update', $record['id']) }}" method="POST" id="edit-attendance-form-{{ $record['id'] }}">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="row mx-0">
                                                                    <div class="col-lg-12">
                                                                        <div class="form-group">
                                                                            <label class="form-label">School Year</label>
                                                                            <input type="text" class="form-control bg-light" value="{{ $record['school_year'] }}" readonly disabled />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-12">
                                                                        <div class="form-group">
                                                                            <label class="form-label">Week</label>
                                                                            <input type="text" class="form-control bg-light" value="Week {{ $record['week'] }}" readonly disabled />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-12">
                                                                        <div class="form-group">
                                                                            <label class="form-label">ADA (%)</label>
                                                                            <span class="text-danger">*</span>
                                                                            <input type="number" step="0.01" name="ada" class="form-control" value="{{ number_format($record['ada'], 2) }}" min="0" max="100" required />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-12">
                                                                        <div class="form-group">
                                                                            <label class="form-label">PIA (%)</label>
                                                                            <span class="text-danger">*</span>
                                                                            <input type="number" step="0.01" name="pia" class="form-control" value="{{ number_format($record['pia'], 2) }}" min="0" max="100" required />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer d-flex justify-content-between">
                                                                    <button type="button" class="btn btn-danger" id="delete-attendance-btn-{{ $record['id'] }}">
                                                                        Delete
                                                                    </button>
                                                                    <div>
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                                                    </div>
                                                                </div>
                                                            </form>

                                                            <form id="deleteForm{{ $record['id'] }}" action="{{ route('admin.isd-attendance.destroy', $record['id']) }}" method="POST" class="d-none">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Edit Attendance Modal End -->

                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-5 text-muted">
                                                    No attendance records found for {{ $selectedCampus['name'] }}. Click <strong>+ ADD ATTENDANCE</strong> to add a new record.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Attendance Modal Start -->
<div class="modal fade" id="AddAttendance" tabindex="-1" aria-labelledby="addAttendanceLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="addAttendanceLabel">Add Attendance Record</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.isd-attendance.store') }}" method="POST" id="add-attendance-form">
                    @csrf
                    <input type="hidden" name="campus_id" value="{{ $selectedCampus['id'] }}">
                    <div class="row mx-0">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">School Year</label>
                                <span class="text-danger">*</span>
                                <select name="school_year" class="form-select" required>
                                    <option value="2023 - 2024" selected>2023 - 2024</option>
                                    <option value="2024 - 2025">2024 - 2025</option>
                                    <option value="2025 - 2026">2025 - 2026</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Week</label>
                                <span class="text-danger">*</span>
                                <input type="number" name="week" placeholder="e.g. 1" min="1" max="52" class="form-control" required />
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">ADA (%)</label>
                                <span class="text-danger">*</span>
                                <input type="number" step="0.01" name="ada" placeholder="e.g. 96.50" min="0" max="100" class="form-control" required />
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">PIA (%)</label>
                                <span class="text-danger">*</span>
                                <input type="number" step="0.01" name="pia" placeholder="e.g. 94.20" min="0" max="100" class="form-control" required />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Add Attendance Modal End -->

@push('scripts')
<script>
    $(document).ready(function() {
        // Validation settings to replicate Dashboard behavior
        const validationConfig = {
            ignore: [],
            errorElement: 'span',
            errorClass: 'invalid-feedback d-block',
            highlight: function(element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
            },
            errorPlacement: function(error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            }
        };

        // --- Add Attendance Form ---
        $("#add-attendance-form").validate($.extend(true, {}, validationConfig, {
            rules: {
                school_year: { required: true },
                week: { required: true, number: true, min: 1, max: 52 },
                ada: { required: true, number: true, min: 0, max: 100 },
                pia: { required: true, number: true, min: 0, max: 100 }
            },
            messages: {
                school_year: { required: "Please select School Year." },
                week: { required: "Please enter week number.", min: "Week must be at least 1.", max: "Week must be at most 52." },
                ada: { required: "Please enter ADA (%).", min: "ADA cannot be negative.", max: "ADA cannot exceed 100." },
                pia: { required: "Please enter PIA (%).", min: "PIA cannot be negative.", max: "PIA cannot exceed 100." }
            }
        }));

        $('#add-attendance-form').submit(function(e) {
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
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => location.reload());
                },
                error: function(xhr) {
                    $submitBtn.prop('disabled', false).text('Save changes');
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON?.message || 'Something went wrong while creating the attendance record.'
                    });
                }
            });
        });

        // --- Attendance Loop Actions (Edit and Delete) ---
        @foreach($attendanceRecords as $record)
            // Validate Edit Attendance Form
            $("#edit-attendance-form-{{ $record['id'] }}").validate($.extend(true, {}, validationConfig, {
                rules: {
                    ada: { required: true, number: true, min: 0, max: 100 },
                    pia: { required: true, number: true, min: 0, max: 100 }
                },
                messages: {
                    ada: { required: "Please enter ADA (%).", min: "ADA cannot be negative.", max: "ADA cannot exceed 100." },
                    pia: { required: "Please enter PIA (%).", min: "PIA cannot be negative.", max: "PIA cannot exceed 100." }
                }
            }));

            // Submit Edit Attendance Form
            $("#edit-attendance-form-{{ $record['id'] }}").submit(function(e) {
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
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => location.reload());
                    },
                    error: function(xhr) {
                        $submitBtn.prop('disabled', false).text('Save changes');
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message || 'Something went wrong while updating the attendance record.'
                        });
                    }
                });
            });

            // Delete Attendance Action
            $("#delete-attendance-btn-{{ $record['id'] }}").click(function(e) {
                e.preventDefault();
                const $form = $('#deleteForm{{ $record['id'] }}');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: $form.attr('action'),
                            method: 'POST',
                            data: $form.serialize(),
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 2000
                                }).then(() => location.reload());
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: xhr.responseJSON?.message || 'Something went wrong while deleting.'
                                });
                            }
                        });
                    }
                });
            });
        @endforeach
    });
</script>
@endpush

@endsection
