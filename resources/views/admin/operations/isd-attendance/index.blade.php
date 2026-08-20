@extends('admin.includes.layout')

@section('title', 'ISD Attendance')

@push('styles')
    <style>
        .campus-item-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 20px 24px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            text-decoration: none;
            color: #1f2937;
            transition: all 0.2s ease;
        }

        .campus-item-card:hover {
            border-color: #FFB81C;
            background-color: rgba(255, 184, 28, 0.06);
            transform: translateY(-2px);
            color: #1f2937;
        }

        .campus-item-card h6 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
        }

        .campus-actions {
            z-index: 10;
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
                                <p class="text-muted mb-0">Select a School District and Campus to view and manage weekly attendance records.</p>
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

                        <!-- Content Body -->
                        <div class="px-4 pb-4">
                            <!-- Filter Section: School Selector -->
                            <div class="card border-0 shadow-sm rounded-3 p-4 mb-4" style="background: #ffffff; border: 1px solid #e5e7eb;">
                                <form method="GET" action="{{ route('admin.isd-attendance.index') }}" id="schoolForm">
                                    <div class="row align-items-center">
                                        <div class="col-md-7 d-flex align-items-end">
                                            <div class="flex-grow-1 me-2">
                                                <label for="school_select" class="form-label font-weight-bold mb-2" style="font-size: 14px; font-weight: 600; color: #374151;">
                                                    Select School District:
                                                </label>
                                                <select name="school_id" id="school_select" class="form-select form-select-lg" onchange="document.getElementById('schoolForm').submit();" style="border-radius: 8px; font-size: 14px; border-color: #d1d5db;">
                                                    <option value="">-- Select School District --</option>
                                                    @foreach($schools as $school)
                                                        <option value="{{ $school['id'] }}" {{ $selectedSchoolId == $school['id'] ? 'selected' : '' }}>
                                                            {{ $school['name'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div>
                                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#AddSchool" style="white-space: nowrap;">
                                                    + Add School
                                                </button>
                                            </div>
                                        </div>
                                        @if($selectedSchool)
                                            <div class="col-md-5 text-md-end mt-3 mt-md-0 d-flex align-items-center justify-content-md-end">
                                                <span class="badge bg-light text-dark px-3 py-2 border me-2" style="font-size: 14px;">
                                                    Selected District: <strong>{{ $selectedSchool['name'] }}</strong>
                                                </span>
                                                <button type="button" class="btn btn-sm btn-outline-secondary me-1" data-bs-toggle="modal" data-bs-target="#EditSchool{{ $selectedSchool['id'] }}">Edit</button>
                                            </div>
                                        @endif
                                    </div>
                                </form>
                            </div>

                            <!-- Campus Listing -->
                            @if(!$selectedSchoolId)
                                <div class="card border-0 shadow-sm rounded-3 p-5 text-center my-3" style="background: #ffffff; border: 1px solid #e5e7eb;">
                                    <div class="mb-3" style="font-size: 48px;">🏫</div>
                                    <h5 style="font-weight: 600; color: #374151;">No Campuses Found.</h5>
                                    <p class="text-muted mb-0">Please select a School District from the dropdown above to view its campuses.</p>
                                </div>
                            @else
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div>
                                        <h5 style="font-weight: 600; color: #374151; margin: 0;">
                                            Campuses for {{ $selectedSchool['name'] }}
                                        </h5>
                                        <span class="text-muted" style="font-size: 14px;">Click any campus to manage attendance</span>
                                    </div>
                                    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#AddCampus">
                                        + Add Campus
                                    </button>
                                </div>

                                <div class="row">
                                    @forelse($campuses as $campus)
                                        <div class="col-md-6 col-lg-4">
                                            <div class="campus-item-card position-relative">
                                                <a href="{{ route('admin.isd-attendance.campus', $campus['id']) }}" class="text-decoration-none text-dark flex-grow-1" style="z-index: 1;">
                                                    <div>
                                                        <h6>{{ $campus['name'] }}</h6>
                                                        <small class="text-muted">Weekly Attendance Records</small>
                                                    </div>
                                                </a>
                                                <div class="d-flex align-items-center campus-actions" style="z-index: 10;">
                                                    <button type="button" class="btn btn-sm btn-light border text-muted" data-bs-toggle="modal" data-bs-target="#EditCampus{{ $campus['id'] }}" title="Edit Campus" style="padding: 4px 8px;">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Edit Campus Modal -->
                                        <div class="modal fade" id="EditCampus{{ $campus['id'] }}" tabindex="-1" aria-labelledby="editCampusLabel{{ $campus['id'] }}" aria-hidden="true">
                                            <div class="modal-dialog modal-fullscreen">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title" id="editCampusLabel{{ $campus['id'] }}">Edit Campus</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('admin.isd-attendance.campus.update', $campus['id']) }}" method="POST" id="edit-campus-form-{{ $campus['id'] }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="row mx-0">
                                                                <div class="col-lg-12">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Campus Name</label>
                                                                        <span class="text-danger">*</span>
                                                                        <input type="text" name="name" class="form-control" value="{{ $campus['name'] }}" required />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer d-flex justify-content-between px-0">
                                                                <button type="button" class="btn btn-danger" id="delete-campus-btn-{{ $campus['id'] }}">
                                                                    Delete
                                                                </button>
                                                                <div>
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                        <form id="deleteCampusForm{{ $campus['id'] }}" action="{{ route('admin.isd-attendance.campus.destroy', $campus['id']) }}" method="POST" class="d-none">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-12">
                                            <div class="card p-4 text-center">
                                                <p class="text-muted mb-0">No campuses found for this district.</p>
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add School Modal -->
<div class="modal fade" id="AddSchool" tabindex="-1" aria-labelledby="addSchoolLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="addSchoolLabel">Add School District</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.isd-attendance.school.store') }}" method="POST" id="add-school-form">
                    @csrf
                    <div class="row mx-0">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">School District Name</label>
                                <span class="text-danger">*</span>
                                <input type="text" name="name" class="form-control" placeholder="e.g. Abernathy ISD" required />
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

@if($selectedSchool)
<!-- Edit School Modal -->
<div class="modal fade" id="EditSchool{{ $selectedSchool['id'] }}" tabindex="-1" aria-labelledby="editSchoolLabel{{ $selectedSchool['id'] }}" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="editSchoolLabel{{ $selectedSchool['id'] }}">Edit School District</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.isd-attendance.school.update', $selectedSchool['id']) }}" method="POST" id="edit-school-form">
                    @csrf
                    @method('PUT')
                    <div class="row mx-0">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">School District Name</label>
                                <span class="text-danger">*</span>
                                <input type="text" name="name" class="form-control" value="{{ $selectedSchool['name'] }}" required />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between px-0">
                        <button type="button" class="btn btn-danger" id="delete-school-btn">
                            Delete
                        </button>
                        <div>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </form>
                <form id="deleteSchoolForm{{ $selectedSchool['id'] }}" action="{{ route('admin.isd-attendance.school.destroy', $selectedSchool['id']) }}" method="POST" class="d-none">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Campus Modal -->
<div class="modal fade" id="AddCampus" tabindex="-1" aria-labelledby="addCampusLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="addCampusLabel">Add Campus</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.isd-attendance.campus.store') }}" method="POST" id="add-campus-form">
                    @csrf
                    <input type="hidden" name="isd_school_id" value="{{ $selectedSchool['id'] }}">
                    <div class="row mx-0">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Campus Name</label>
                                <span class="text-danger">*</span>
                                <input type="text" name="name" class="form-control" placeholder="e.g. Elementary School" required />
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
@endif

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

        // --- Add School Form ---
        $("#add-school-form").validate($.extend(true, {}, validationConfig, {
            rules: {
                name: { required: true }
            },
            messages: {
                name: { required: "Please enter School District name." }
            }
        }));

        $('#add-school-form').submit(function(e) {
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
                    toastr.success(response.message || 'School District created successfully.');
                    setTimeout(() => location.reload(), 1500);
                },
                error: function(xhr) {
                    $submitBtn.prop('disabled', false).text('Save changes');
                    if (xhr.status === 422 && xhr.responseJSON?.errors) {
                        $.each(xhr.responseJSON.errors, function(field, messages) {
                            messages.forEach(function(message) { toastr.error(message); });
                        });
                    } else {
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong while creating the school district.');
                    }
                }
            });
        });

        // --- Add Campus Form ---
        $("#add-campus-form").validate($.extend(true, {}, validationConfig, {
            rules: {
                name: { required: true }
            },
            messages: {
                name: { required: "Please enter Campus name." }
            }
        }));

        $('#add-campus-form').submit(function(e) {
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
                    toastr.success(response.message || 'Campus created successfully.');
                    setTimeout(() => location.reload(), 1500);
                },
                error: function(xhr) {
                    $submitBtn.prop('disabled', false).text('Save changes');
                    if (xhr.status === 422 && xhr.responseJSON?.errors) {
                        $.each(xhr.responseJSON.errors, function(field, messages) {
                            messages.forEach(function(message) { toastr.error(message); });
                        });
                    } else {
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong while creating the campus.');
                    }
                }
            });
        });

        @if($selectedSchool)
        // --- Edit School Form ---
        $("#edit-school-form").validate($.extend(true, {}, validationConfig, {
            rules: {
                name: { required: true }
            },
            messages: {
                name: { required: "Please enter School District name." }
            }
        }));

        $('#edit-school-form').submit(function(e) {
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
                    toastr.success(response.message || 'School District updated successfully.');
                    setTimeout(() => location.reload(), 1500);
                },
                error: function(xhr) {
                    $submitBtn.prop('disabled', false).text('Save changes');
                    if (xhr.status === 422 && xhr.responseJSON?.errors) {
                        $.each(xhr.responseJSON.errors, function(field, messages) {
                            messages.forEach(function(message) { toastr.error(message); });
                        });
                    } else {
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong while updating the school district.');
                    }
                }
            });
        });

        // --- Delete School ---
        $('#delete-school-btn').click(function(e) {
            e.preventDefault();
            const $form = $('#deleteSchoolForm{{ $selectedSchool['id'] }}');
            Swal.fire({
                title: 'Are you sure?',
                text: "This will also delete all its campuses and attendance records. You won't be able to revert this!",
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
                            toastr.success(response.message || 'School District deleted successfully.');
                            setTimeout(() => window.location.href = "{{ route('admin.isd-attendance.index') }}", 1500);
                        },
                        error: function(xhr) {
                            toastr.error(xhr.responseJSON?.message || 'Something went wrong while deleting.');
                        }
                    });
                }
            });
        });
        @endif

        // --- Campus Loop Actions (Edit and Delete) ---
        @if($selectedSchool)
            @foreach($campuses as $campus)
                // Validate Edit Campus Form
                $("#edit-campus-form-{{ $campus['id'] }}").validate($.extend(true, {}, validationConfig, {
                    rules: {
                        name: { required: true }
                    },
                    messages: {
                        name: { required: "Please enter Campus name." }
                    }
                }));

                // Submit Edit Campus Form
                $("#edit-campus-form-{{ $campus['id'] }}").submit(function(e) {
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
                            toastr.success(response.message || 'Campus updated successfully.');
                            setTimeout(() => location.reload(), 1500);
                        },
                        error: function(xhr) {
                            $submitBtn.prop('disabled', false).text('Save changes');
                            if (xhr.status === 422 && xhr.responseJSON?.errors) {
                                $.each(xhr.responseJSON.errors, function(field, messages) {
                                    messages.forEach(function(message) { toastr.error(message); });
                                });
                            } else {
                                toastr.error(xhr.responseJSON?.message || 'Something went wrong while updating the campus.');
                            }
                        }
                    });
                });

                // Delete Campus Action
                $("#delete-campus-btn-{{ $campus['id'] }}").click(function(e) {
                    e.preventDefault();
                    const $form = $('#deleteCampusForm{{ $campus['id'] }}');
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
                                    toastr.success(response.message || 'Campus deleted successfully.');
                                    setTimeout(() => location.reload(), 1500);
                                },
                                error: function(xhr) {
                                    toastr.error(xhr.responseJSON?.message || 'Something went wrong while deleting.');
                                }
                            });
                        }
                    });
                });
            @endforeach
        @endif
    });
</script>
@endpush

@endsection
