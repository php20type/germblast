@extends('admin.includes.layout')

@section('title', 'Edit Employee')


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

                    <form action="{{ route('admin.employee.update', $employee->id) }}"
                        method="POST"
                        id="employee-edit-form"
                        enctype="multipart/form-data">
                        @csrf

                            {{-- HEADER --}}
                            <div class="heading-area-sec mb-3">
                                <div class="left-part-sec">
                                    <h3 class="mb-1">Edit Employee</h3>
                                    <p class="text-muted mb-0">Update employee details and role</p>
                                </div>
                                <div class="right-part-sec">
                                    <a href="{{ route('admin.employee.index') }}" class="btn btn-outline-dark">
                                        <i class="fa-solid fa-arrow-left me-1"></i> Back to Employees
                                    </a>
                                    <button type="submit" class="btn btn-success">
                                        Update Employee
                                    </button>
                                </div>
                            </div>

                            {{-- BASIC INFORMATION --}}
                            <div class="px-4 pb-2">
                                <div class="section-card">
                                        <div class="section-header">
                                            <h3 class="section-title">Basic Information</h3>
                                        </div>

                                        <div class="profile-card my-3">
                                           <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Profile
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        {{-- <div class="preview">
                                                            <img id="img-preview-profile"
                                                                src="{{ $employee->profile_image ? asset('storage/' . $employee->profile_image) : asset('img/home/default-profile.png') }}"
                                                                alt="profile images" />

                                                            <div class="text-upload ms-3">
                                                                <label for="profile-input" class="btn btn-theme">Upload Photo</label>
                                                                <p>Allowed JPG, GIF or PNG.</p>
                                                                <input accept="image/*" type="file" id="profile-input" name="profile_image"
                                                                    class="d-none" />
                                                            </div>
                                                        </div> --}}
                                                        <div class="preview">
                                                            <img id="img-preview-profile"
                                                                src="{{ $employee->profile_image ? asset('storage/' . $employee->profile_image) : asset('img/home/default-profile.png') }}"
                                                                alt="profile images" />

                                                            <div class="text-upload ms-3">
                                                                <label for="profile-input" class="btn btn-theme">Upload Photo</label>
                                                                <p>Allowed JPG, GIF or PNG.</p>
                                                                <input accept="image/*" type="file" id="profile-input" name="profile_image" class="d-none" />

                                                                {{-- Hidden flag sent when user wants to remove photo --}}
                                                                <input type="hidden" name="remove_profile_image" id="remove-profile-image" value="0">

                                                                @if($employee->profile_image)
                                                                    <button type="button" class="btn btn-danger btn-sm mt-1" id="remove-photo-btn">
                                                                        <i class="fas fa-trash me-1"></i> Remove Photo
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row g-3">

                                            <div class="col-md-6">
                                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                                <input type="text" name="name" class="form-control"
                                                    value="{{ old('name', $employee->name) }}" required>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                                <input type="email" name="email" class="form-control"
                                                    value="{{ old('email', $employee->email) }}" required>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Password</label>
                                                <div class="input-group">
                                                    <input type="password" name="password" id="password" class="form-control">
                                                    <button type="button" class="btn btn-outline-secondary toggle-password" data-target="password">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Confirm Password</label>
                                                <div class="input-group">
                                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                                                    <button type="button" class="btn btn-outline-secondary toggle-password" data-target="password_confirmation">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Role <span class="text-danger">*</span></label>
                                                <select name="role" class="form-select" required>
                                                    <option value="">Select Role</option>
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->name }}"
                                                            {{ old('role', $employee->role) === $role->name ? 'selected' : '' }}>
                                                            {{ strtoupper(str_replace('_', ' ', $role->name)) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Staff Type <span class="text-danger">*</span></label>
                                                <select name="staff_type" class="form-select" required>
                                                    <option value="">Select Staff Type</option>
                                                    <option value="leader" {{ old('staff_type', $employee->staff_type) === 'leader' ? 'selected' : '' }}>Leader</option>
                                                    <option value="technician" {{ old('staff_type', $employee->staff_type) === 'technician' ? 'selected' : '' }}>Technician</option>
                                                    <option value="corporate" {{ old('staff_type', $employee->staff_type) === 'corporate' ? 'selected' : '' }}>Corporate</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Territory <span class="text-danger">*</span></label>
                                                <select name="territory_id" class="form-select" required>
                                                    <option value="">Select Territory</option>
                                                    @foreach ($territories as $territory)
                                                        <option value="{{ $territory->id }}"
                                                            {{ old('territory_id', $employee->territory_id) == $territory->id ? 'selected' : '' }}>
                                                            {{ $territory->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Employee Type <span class="text-danger">*</span></label>
                                                <select name="employee_type" class="form-select">
                                                    <option value="1" {{ old('employee_type', $employee->employee_type) == 1 ? 'selected' : '' }}>Full Time</option>
                                                    <option value="0" {{ old('employee_type', $employee->employee_type) == 0 ? 'selected' : '' }}>Part Time</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Active <span class="text-danger">*</span></label>
                                                <select name="active" class="form-select">
                                                    <option value="1" {{ old('active', $employee->active) == 1 ? 'selected' : '' }}>Yes</option>
                                                    <option value="0" {{ old('active', $employee->active) == 0 ? 'selected' : '' }}>No</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Schedulable <span class="text-danger">*</span></label>
                                                <select name="schedulable" class="form-select">
                                                    <option value="1" {{ old('schedulable', $employee->schedulable) == 1 ? 'selected' : '' }}>Yes</option>
                                                    <option value="0" {{ old('schedulable', $employee->schedulable) == 0 ? 'selected' : '' }}>No</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Cell Phone <span class="text-danger">*</span></label>
                                                <input type="text" name="cell_phone" class="form-control"
                                                    value="{{ old('cell_phone', $employee->cell_phone) }}">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Hourly Rate <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text">$</span>
                                                    <input type="text" name="hourly_rate" class="form-control"
                                                        value="{{ old('hourly_rate', $employee->hourly_rate) }}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Overtime Hourly Rate <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text">$</span>
                                                    <input type="text" name="overtime_rate" class="form-control"
                                                        value="{{ old('overtime_rate', $employee->overtime_rate) }}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Training Level <span class="text-danger">*</span></label>
                                                <select name="training_level" class="form-select">
                                                    <option value="Trainee" {{ old('training_level', $employee->training_level) == 'Trainee' ? 'selected' : '' }}>Trainee</option>
                                                    <option value="Level I" {{ old('training_level', $employee->training_level) == 'Level I' ? 'selected' : '' }}>Level I</option>
                                                    <option value="Level II" {{ old('training_level', $employee->training_level) == 'Level II' ? 'selected' : '' }}>Level II</option>
                                                    <option value="Level III" {{ old('training_level', $employee->training_level) == 'Level III' ? 'selected' : '' }}>Level III</option>
                                                    <option value="Level IV" {{ old('training_level', $employee->training_level) == 'Level IV' ? 'selected' : '' }}>Level IV</option>
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            {{-- SPECIAL CERTIFICATIONS --}}
                            <div class="px-4 pb-2">
                                <div class="section-card">
                                        <div class="section-header">
                                            <h3 class="section-title">Special Certifications</h3>
                                        </div>

                                        <div class="row g-3">

                                            <div class="col-md-6">
                                                <label class="form-label">Biological Response Team <span class="text-danger">*</span></label>
                                                <select name="biological_response_team" class="form-select">
                                                    <option value="1" {{ old('biological_response_team', $employee->biological_response_team) == 1 ? 'selected' : '' }}>Yes</option>
                                                    <option value="0" {{ old('biological_response_team', $employee->biological_response_team) == 0 ? 'selected' : '' }}>No</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Healthcare Team <span class="text-danger">*</span></label>
                                                <select name="healthcare_team" class="form-select">
                                                    <option value="1" {{ old('healthcare_team', $employee->healthcare_team) == 1 ? 'selected' : '' }}>Yes</option>
                                                    <option value="0" {{ old('healthcare_team', $employee->healthcare_team) == 0 ? 'selected' : '' }}>No</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Driver Trained <span class="text-danger">*</span></label>
                                                <select name="driver_trained" class="form-select">
                                                    <option value="1" {{ old('driver_trained', $employee->driver_trained) == 1 ? 'selected' : '' }}>Yes</option>
                                                    <option value="0" {{ old('driver_trained', $employee->driver_trained) == 0 ? 'selected' : '' }}>No</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Floor Certified <span class="text-danger">*</span></label>
                                                <select name="floor_certified" class="form-select">
                                                    <option value="1" {{ old('floor_certified', $employee->floor_certified) == 1 ? 'selected' : '' }}>Yes</option>
                                                    <option value="0" {{ old('floor_certified', $employee->floor_certified) == 0 ? 'selected' : '' }}>No</option>
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                    </form>

                    {{-- MASK FIT TEST FORM (Separate form) --}}
                    <form id="mask-fit-form" method="POST" action="{{ route('admin.employee.mask-fit-test.store', $employee->id) }}">
                        @csrf

                            <div class="px-4 pb-2">
                                <div class="section-card">
                                        <div class="section-header">
                                            <h3 class="section-title">Add a Mask Fit Test Record</h3>
                                        </div>

                                        <table class="table table-bordered align-middle">
                                            <tbody>

                                                <tr>
                                                    <th>Date of Fit Test</th>
                                                    <td>
                                                        <input type="date"
                                                            name="fit_test_date"
                                                            class="form-control"
                                                            value="{{ date('Y-m-d') }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Mask Type/Size</th>
                                                    <td>
                                                        <select name="mask_type_id" class="form-select">
                                                            <option value="">Select Mask</option>
                                                            @foreach($maskTypes as $type)
                                                                <option value="{{ $type->id }}">
                                                                    {{ $type->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th colspan="2" class="text-end">
                                                        <button type="submit" id="add-mask-fit" class="btn btn-success">
                                                            Add Fit Test
                                                        </button>
                                                    </th>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                    </form>

                    {{-- MASK FIT TEST RECORDS LISTING --}}
                    <div class="px-4 pb-2">
                        <div class="section-card">
                                <div class="section-header d-flex justify-content-between align-items-center">
                                    <h3 class="section-title">Mask Fit Test Records</h3>
                                    <span class="text-muted" id="mask-fit-count">{{ $maskFitTestRecords->count() }} Record(s) Found</span>
                                </div>

                                <div class="table-responsive">
                                    <div class="table-container p-0">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Date of Fit Test</th>
                                                    <th>Mask Type / Size</th>
                                                    <th>Date Added</th>
                                                </tr>
                                            </thead>
                                            <tbody id="mask-fit-records-body">
                                                @forelse($maskFitTestRecords as $index => $record)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($record->fit_test_date)->format('d F Y') }}</td>
                                                        <td>
                                                            @if($record->maskType)
                                                                <span class="badge bg-info">{{ $record->maskType->name }}</span>
                                                            @else
                                                                <span class="text-muted">N/A</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ \Carbon\Carbon::parse($record->created_at)->format('d F Y') }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center">No mask fit test records found</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                    {{-- DRIVER LOG FORM --}}
                    <form id="driver-log-form" method="POST" action="{{ route('admin.employee.driver-log.store', $employee->id) }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-12">
                            <div class="section-card">
                                    <div class="section-header">
                                        <h3 class="section-title">Add Driver Log</h3>
                                    </div>

                                    <table class="table table-bordered align-middle">
                                        <tbody>

                                            <tr>
                                                <th>Item</th>
                                                <td>
                                                    <select name="driver_log_item_id" class="form-select">
                                                        <option value="">Select Item</option>
                                                        @foreach($driverLogItems as $item)
                                                            <option value="{{ $item->id }}">
                                                                {{ $item->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>Date</th>
                                                <td>
                                                    <input type="date" name="log_date" class="form-control" value="{{ date('Y-m-d') }}">
                                                </td>
                                            </tr>

                                            <tr>
                                                <th colspan="2" class="text-end">
                                                    <button type="submit" class="btn btn-success">Add Log</button>
                                                </th>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                                </div>
                            </div>
                    </form>


                    {{-- DRIVER LOG LISTING --}}
                    <div class="row">
                        <div class="col-md-12">
                        <div class="section-card">
                                <div class="section-header d-flex justify-content-between">
                                    <h3 class="section-title">Driver Logs</h3>
                                    <span class="text-muted">{{ $driverLogs->count() }} Record(s)</span>
                                </div>

                                <div class="table-responsive">
                                    <div class="table-container p-0">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Item</th>
                                                    <th>Date</th>
                                                    <th>Points</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($driverLogs as $index => $log)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $log->item->name ?? 'N/A' }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($log->log_date)->format('d F Y') }}</td>
                                                        <td>{{ $log->item->points ?? '-' }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center">No driver logs found</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                    </div>
                                </div>
                            </div>


                    {{-- DRIVER SUSPENSION FORM --}}
                    <form id="driver-suspension-form" method="POST" action="{{ route('admin.employee.driver-suspension.store', $employee->id) }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-12">
                            <div class="section-card">
                                    <div class="section-header">
                                        <h3 class="section-title">Add Driver Suspension</h3>
                                    </div>

                                    <table class="table table-bordered align-middle">
                                        <tbody>

                                            <tr>
                                                <th>Suspended Until</th>
                                                <td>
                                                    <input type="date" name="suspended_until" class="form-control">
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>Notes</th>
                                                <td>
                                                    <textarea name="notes" class="form-control"></textarea>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th colspan="2" class="text-end">
                                                    <button type="submit" class="btn btn-danger">Add Suspension</button>
                                                </th>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                                </div>
                            </div>
                    </form>


                    {{-- DRIVER SUSPENSION LISTING FORM --}}
                    <div class="row">
                        <div class="col-md-12">
                        <div class="section-card">
                                <div class="section-header d-flex justify-content-between">
                                    <h3 class="section-title">Driver Suspension Records</h3>
                                    <span class="text-muted">{{ $driverSuspensions->count() }} Record(s)</span>
                                </div>

                                <div class="table-responsive">
                                    <div class="table-container p-0">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Suspended Until</th>
                                                    <th>Notes</th>
                                                    <th>Created At</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($driverSuspensions as $index => $suspension)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>
                                                            {{ $suspension->suspended_until
                                                                ? \Carbon\Carbon::parse($suspension->suspended_until)->format('d F Y')
                                                                : 'N/A' }}
                                                        </td>
                                                        <td>{{ $suspension->notes ?? '-' }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($suspension->created_at)->format('d F Y') }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center">No suspension records found</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- AVAILABILITY RECORDS LISTING --}}
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="section-card">
                                <div class="section-header d-flex justify-content-between align-items-center">
                                    <h3 class="section-title">List of Availability Records</h3>
                                    <button type="button" class="btn btn-primary" id="btn-new-availability">
                                        New Availability
                                    </button>
                                </div>

                                <div class="table-responsive">
                                    <div class="table-container p-0">
                                        <table class="table table-hover align-middle">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Timeframe</th>
                                                    <th>Avg Hours</th>
                                                    <th>Max Hours</th>
                                                    <th>Monday</th>
                                                    <th>Tuesday</th>
                                                    <th>Wednesday</th>
                                                    <th>Thursday</th>
                                                    <th>Friday</th>
                                                    <th>Saturday</th>
                                                    <th>Sunday</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($employee->availabilities as $availability)
                                                    <tr>
                                                        <td>{{ $availability->id }}</td>
                                                        <td>{{ $availability->start_date ? \Carbon\Carbon::parse($availability->start_date)->format('m/d/y') : '' }} - {{ $availability->end_date ? \Carbon\Carbon::parse($availability->end_date)->format('m/d/y') : '' }}</td>
                                                        <td>{{ $availability->avg_hours }}</td>
                                                        <td>{{ $availability->max_hours }}</td>
                                                        <td>{{ $availability->mon_start }} - {{ $availability->mon_end }}</td>
                                                        <td>{{ $availability->tue_start }} - {{ $availability->tue_end }}</td>
                                                        <td>{{ $availability->wed_start }} - {{ $availability->wed_end }}</td>
                                                        <td>{{ $availability->thu_start }} - {{ $availability->thu_end }}</td>
                                                        <td>{{ $availability->fri_start }} - {{ $availability->fri_end }}</td>
                                                        <td>{{ $availability->sat_start }} - {{ $availability->sat_end }}</td>
                                                        <td>{{ $availability->sun_start }} - {{ $availability->sun_end }}</td>
                                                        <td>
                                                            <button type="button" class="btn btn-sm btn-outline-primary edit-availability-link" data-id="{{ $availability->id }}" data-data="{{ json_encode($availability) }}" title="Edit Availability">
                                                                <i class="fa-solid fa-pencil"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="12" class="text-center">No availability records found</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- AVAILABILITY MODAL --}}
                    <div class="modal fade" id="availabilityModal" tabindex="-1" aria-labelledby="availabilityModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-fullscreen">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title" id="availabilityModalLabel">Update Availability</h1>
                                    <div>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                </div>
                                <div class="modal-body ps-0">
                                    <form class="company-form" id="availability-form" method="POST" action="">
                                        @csrf
                                        <input type="hidden" name="availability_id" id="availability_id">

                                        <div class="row mx-0">
                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Start Date</label>
                                                    <span class="text-danger">*</span>
                                                    <input type="date" name="start_date" id="avail_start_date" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">End Date</label>
                                                    <span class="text-danger">*</span>
                                                    <input type="date" name="end_date" id="avail_end_date" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mx-0 mt-3">
                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Avg Hours/Week</label>
                                                    <span class="text-danger">*</span>
                                                    <input type="number" name="avg_hours" id="avail_avg_hours" class="form-control" required min="0">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Max Hours/Week</label>
                                                    <span class="text-danger">*</span>
                                                    <input type="number" name="max_hours" id="avail_max_hours" class="form-control" required min="0">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mx-0 mt-4">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-label d-block mb-2 fw-bold text-uppercase">Daily Availability Timeframes</label>
                                                    <small class="text-muted d-block mb-3"><strong>IMPORTANT</strong> Format for times should be hour:minute am/pm. 9:15 am or 6:00 pm. No other text can be present.</small>
                                                    
                                                    @php
                                                        $days = [
                                                            'mon' => 'Monday',
                                                            'tue' => 'Tuesday',
                                                            'wed' => 'Wednesday',
                                                            'thu' => 'Thursday',
                                                            'fri' => 'Friday',
                                                            'sat' => 'Saturday',
                                                            'sun' => 'Sunday'
                                                        ];
                                                    @endphp
                                                    
                                                    <div class="table-responsive mt-2">
                                                        <table class="table align-middle">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width: 30%;">Day</th>
                                                                    <th>Start Time</th>
                                                                    <th>End Time</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($days as $key => $dayName)
                                                                    <tr>
                                                                        <td class="fw-semibold">{{ $dayName }}</td>
                                                                        <td>
                                                                            <input type="time" name="{{ $key }}_start" id="avail_{{ $key }}_start" class="form-control text-center" style="max-width: 180px;" required value="00:00">
                                                                        </td>
                                                                        <td>
                                                                            <input type="time" name="{{ $key }}_end" id="avail_{{ $key }}_end" class="form-control text-center" style="max-width: 180px;" required value="23:59">
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer mt-4">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-success" id="btn-save-availability">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TRAINING RECORDS LISTING --}}
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="section-card">
                                <div class="section-header d-flex justify-content-between align-items-center">
                                    <h3 class="section-title">Training Tests Status</h3>
                                </div>

                                <div class="px-4 pb-4">
                                    @foreach($categories as $category)
                                        @if($category->tests->count() > 0)
                                            <h5 class="mt-4 mb-3 fw-bold text-dark border-bottom pb-2">{{ $category->name }}</h5>
                                            
                                            <div class="table-responsive">
                                                <table class="table table-hover w-100 equipment-report-table">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 40%;">Training/Test Name</th>
                                                                <th style="width: 40%;">Test History</th>
                                                                <th style="width: 20%; text-align: center;">Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($category->tests as $test)
                                                                @php
                                                                    $testAttempts = $userAttempts->where('training_test_id', $test->id);
                                                                    $passed = $testAttempts->where('status', 'Passed')->count() > 0;
                                                                    $attemptsUsed = $testAttempts->count();
                                                                @endphp
                                                                <tr>
                                                                    <td>
                                                                        <div class="fw-semibold text-dark">
                                                                            {{ $test->name }}
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        @if($attemptsUsed > 0)
                                                                            <div class="d-flex flex-column gap-2 mt-1 mb-2">
                                                                                @foreach($testAttempts as $attempt)
                                                                                    @if($attempt->status == 'Passed')
                                                                                        <a href="{{ route('admin.employee-training.certificate', $attempt->id) }}" target="_blank" class="d-flex align-items-center justify-content-between px-3 py-2 w-100 text-decoration-none transition-all" style="max-width: 280px; background: #f0fdf4; border-radius: 6px; border: 1px solid #bbf7d0;">
                                                                                <div class="d-flex flex-column">
                                                                                    <span style="font-size: 13px;" class="text-success fw-bold">Attempt {{ $attempt->attempt_number }}</span>
                                                                                    <span class="fw-normal text-muted" style="font-size: 11px;">{{ \Carbon\Carbon::parse($attempt->submitted_at)->format('m/d/Y') }}</span>
                                                                                </div>
                                                                                <div class="d-flex flex-column text-end">
                                                                                    <span style="font-size: 13px;" class="fw-bold text-success">{{ round($attempt->score, 1) }}%</span>
                                                                                    <span style="font-size: 11px;" class="fw-bold text-success">{{ $attempt->status }}</span>
                                                                                </div>
                                                                                        </a>
                                                                                    @else
                                                                                        <div class="d-flex align-items-center justify-content-between px-3 py-2 w-100" style="max-width: 280px; background: #f9fafb; border-radius: 6px; border: 1px solid #e5e7eb;">
                                                                                <div class="d-flex flex-column">
                                                                                    <span style="font-size: 13px;" class="text-muted fw-bold">Attempt {{ $attempt->attempt_number }}</span>
                                                                                    <span class="fw-normal text-muted" style="font-size: 11px;">{{ \Carbon\Carbon::parse($attempt->submitted_at)->format('m/d/Y') }}</span>
                                                                                </div>
                                                                                <div class="d-flex flex-column text-end">
                                                                                    <span style="font-size: 13px;" class="fw-bold text-danger">{{ round($attempt->score, 1) }}%</span>
                                                                                    <span style="font-size: 11px;" class="fw-bold text-danger">{{ $attempt->status }}</span>
                                                                                </div>
                                                                                        </div>
                                                                                    @endif
                                                                                @endforeach
                                                                            </div>
                                                                        @else
                                                                            <span class="text-muted fst-italic">Not Attempted</span>
                                                                        @endif
                                                                    </td>
                                                                    <td style="text-align: center;">
                                                                        @if($passed)
                                                                            <span class="badge bg-success"><i class="fa-solid fa-check-circle me-1"></i> Passed</span>
                                                                        @elseif($attemptsUsed > 0)
                                                                            <span class="badge bg-danger"><i class="fa-solid fa-times-circle me-1"></i> Failed</span>
                                                                        @else
                                                                            <span class="badge bg-secondary"><i class="fa-solid fa-clock me-1"></i> Pending</span>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                            </div>
                                        @endif
                                    @endforeach
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

@push('scripts')
<script>
    /* ===============================
       Toggle Password Visibility
    =============================== */
    document.querySelectorAll('.toggle-password').forEach(btn => {
        btn.addEventListener('click', function () {
            const input = document.getElementById(this.dataset.target);
            const icon  = this.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });
    });

    document.getElementById('profile-input').addEventListener('change', function () {
        if (this.files && this.files[0]) {
            document.getElementById('img-preview-profile').src = URL.createObjectURL(this.files[0]);
        }
    });

    /* ===============================
       Employee Form Validation
    =============================== */
    $("#employee-edit-form").validate({
        ignore: [],

        rules: {
            name: { required: true, minlength: 2 },
            email: { required: true, email: true },
            password: { minlength: 8 },
            password_confirmation: { equalTo: "#password" },
            role: { required: true },
            staff_type: { required: true },
            territory_id: { required: true },

            active: { required: true },
            schedulable: { required: true },
            employee_type: { required: true },

            cell_phone: { required: true, digits: true, minlength: 10, maxlength: 10 },

            hourly_rate: { required: true, number: true, min: 0 },
            overtime_rate: { required: true, number: true, min: 0 },

            training_level: { required: true },

            biological_response_team: { required: true },
            healthcare_team: { required: true },
            driver_trained: { required: true },
            floor_certified: { required: true }
        },

        messages: {
            name: "Employee name is required.",
            email: "Valid email address is required.",
            password: { minlength: "Password must be at least 8 characters." },
            password_confirmation: { equalTo: "Passwords do not match." },
            role: "Please select a role.",
            staff_type: "Please select a type.",
            territory_id: "Please select a territory.",

            active: "Please select active status.",
            schedulable: "Please select schedulable status.",
            employee_type: "Please select employee type.",

            cell_phone: {
                required: "Cell phone is required.",
                digits: "Only numbers allowed.",
                minlength: "Must be 10 digits.",
                maxlength: "Must be 10 digits."
            },

            hourly_rate: {
                required: "Hourly rate is required.",
                number: "Enter a valid number.",
                min: "Must be greater than or equal to 0."
            },

            overtime_rate: {
                required: "Overtime hourly rate is required.",
                number: "Enter a valid number.",
                min: "Must be greater than or equal to 0."
            },

            training_level: "Please select training level.",

            biological_response_team: "Please select an option.",
            healthcare_team: "Please select an option.",
            driver_trained: "Please select an option.",
            floor_certified: "Please select an option."

        },

        errorElement: 'span',
        errorClass: 'invalid-feedback d-block',
        highlight: function (element) {
            $(element).addClass('is-invalid');
        },

        unhighlight: function (element) {
            $(element).removeClass('is-invalid');
        },

        errorPlacement: function (error, element) {
            if (element.closest('.input-group').length) {
                error.insertAfter(element.closest('.input-group'));
            } else {
                error.insertAfter(element);
            }
        }
    });

    /* ===============================
       Auto-fill Overtime Rate
    =============================== */
    $('input[name="hourly_rate"]').on('input', function() {
        let hourlyRate = parseFloat($(this).val());
        if (!isNaN(hourlyRate) && hourlyRate >= 0) {
            let overtimeRate = (hourlyRate * 1.5).toFixed(2);
            $('input[name="overtime_rate"]').val(overtimeRate);
        } else {
            $('input[name="overtime_rate"]').val('');
        }
    });

    /* ===============================
       Employee AJAX Submission
    =============================== */
    $('#employee-edit-form').on('submit', function (e) {
        e.preventDefault();

        let form = $(this);

        if (!form.valid()) return;

        let formData = new FormData(this);

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,

            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Updated',
                    text: response.message || 'Employee updated successfully.',
                    showConfirmButton: false,
                    timer: 2000
                }).then(() => {
                    location.reload();
                });
            },

            error: function (xhr) {
                if (xhr.status === 422 && xhr.responseJSON?.errors) {
                    $.each(xhr.responseJSON.errors, function (field, messages) {
                        messages.forEach(msg => toastr.error(msg));
                    });
                    return;
                }

                toastr.error(
                    xhr.responseJSON?.message ||
                    'Something went wrong while updating employee.'
                );
            }
        });
    });

    /* ===============================
       Mask Fit Test AJAX Submission
    =============================== */
    $('#mask-fit-form').on('submit', function (e) {
        e.preventDefault();

        let form = $(this);
        let fitTestDate = form.find('[name="fit_test_date"]').val();
        let maskTypeId  = form.find('[name="mask_type_id"]').val();

        if (!fitTestDate) {
            toastr.error('Please select a date for the fit test.');
            return;
        }
        if (!maskTypeId) {
            toastr.error('Please select a mask type.');
            return;
        }

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),

            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Added',
                    text: response.message || 'Mask fit test record added successfully.',
                    showConfirmButton: false,
                    timer: 2000
                }).then(() => {
                    location.reload();
                });
            },

            error: function (xhr) {
                if (xhr.status === 422 && xhr.responseJSON?.errors) {
                    $.each(xhr.responseJSON.errors, function (field, messages) {
                        messages.forEach(msg => toastr.error(msg));
                    });
                    return;
                }

                toastr.error(
                    xhr.responseJSON?.message ||
                    'Something went wrong while adding mask fit test record.'
                );
            }
        });
    });

    /* ===============================
       Driver Log AJAX Submission
    =============================== */
    $('#driver-log-form').on('submit', function (e) {
        e.preventDefault();

        let form = $(this);
        let itemId = form.find('[name="driver_log_item_id"]').val();
        let logDate = form.find('[name="log_date"]').val();

        if (!itemId) {
            toastr.error('Please select a log item.');
            return;
        }

        if (!logDate) {
            toastr.error('Please select a date.');
            return;
        }

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),

            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Added',
                    text: response.message || 'Driver log added successfully.',
                    showConfirmButton: false,
                    timer: 2000
                }).then(() => {
                    location.reload();
                });
            },

            error: function (xhr) {
                if (xhr.status === 422 && xhr.responseJSON?.errors) {
                    $.each(xhr.responseJSON.errors, function (field, messages) {
                        messages.forEach(msg => toastr.error(msg));
                    });
                    return;
                }

                toastr.error(
                    xhr.responseJSON?.message ||
                    'Something went wrong while adding driver log.'
                );
            }
        });
    });

    /* ===============================
       Driver Suspension Record AJAX Submission
    =============================== */
    $('#driver-suspension-form').on('submit', function (e) {
        e.preventDefault();

        let form = $(this);
        let suspendedUntil = form.find('[name="suspended_until"]').val();

        if (!suspendedUntil) {
            toastr.error('Please select suspension date.');
            return;
        }

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),

            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Added',
                    text: response.message || 'Driver suspension added successfully.',
                    showConfirmButton: false,
                    timer: 2000
                }).then(() => {
                    location.reload();
                });
            },

            error: function (xhr) {
                if (xhr.status === 422 && xhr.responseJSON?.errors) {
                    $.each(xhr.responseJSON.errors, function (field, messages) {
                        messages.forEach(msg => toastr.error(msg));
                    });
                    return;
                }

                toastr.error(
                    xhr.responseJSON?.message ||
                    'Something went wrong while adding suspension.'
                );
            }
        });
    });

    // Remove photo button
    $('#remove-photo-btn').on('click', function () {
        // Reset preview to default
        $('#img-preview-profile').attr('src', '{{ asset('img/home/default-profile.png') }}');
        // Clear the file input
        $('#profile-input').val('');
        // Set the hidden flag
        $('#remove-profile-image').val('1');
        // Hide the remove button
        $(this).hide();
    });

    // If user picks a new photo, cancel the remove flag
    $('#profile-input').on('change', function () {
        if (this.files && this.files[0]) {
            $('#img-preview-profile').attr('src', URL.createObjectURL(this.files[0]));
            $('#remove-profile-image').val('0');
            $('#remove-photo-btn').show();
        }
    });

    /* ===============================
       Availability Modal Handlers
    =============================== */
    const availabilityModal = new bootstrap.Modal(document.getElementById('availabilityModal'));

    $('#btn-new-availability').on('click', function () {
        $('#availabilityModalLabel').text('New Availability');
        $('#availability-form')[0].reset();
        $('#availability_id').val('');
        // set default dates
        const todayStr = new Date().toISOString().split('T')[0];
        $('#avail_start_date').val(todayStr);
        $('#avail_end_date').val(todayStr);
        $('#avail_avg_hours').val('0');
        $('#avail_max_hours').val('0');
        // set default times
        ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'].forEach(day => {
            $(`#avail_${day}_start`).val('00:00');
            $(`#avail_${day}_end`).val('23:59');
        });
        $('#btn-save-availability').text('Create');
        $('#availability-form').attr('action', "{{ route('admin.employee.availability.store', $employee->id) }}");
        availabilityModal.show();
    });

    $(document).on('click', '.edit-availability-link', function () {
        const data = $(this).data('data');
        $('#availabilityModalLabel').text('Update Availability');
        $('#availability-form')[0].reset();
        $('#availability_id').val(data.id);
        
        // Parse dates
        const startDate = data.start_date ? data.start_date.split('T')[0] : '';
        const endDate = data.end_date ? data.end_date.split('T')[0] : '';
        
        $('#avail_start_date').val(startDate);
        $('#avail_end_date').val(endDate);
        $('#avail_avg_hours').val(data.avg_hours);
        $('#avail_max_hours').val(data.max_hours);
        
        ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'].forEach(day => {
            $(`#avail_${day}_start`).val(data[`${day}_start`]);
            $(`#avail_${day}_end`).val(data[`${day}_end`]);
        });
        
        $('#btn-save-availability').text('Update');
        $('#availability-form').attr('action', "{{ route('admin.employee.availability.store', $employee->id) }}");
        availabilityModal.show();
    });

    $("#availability-form").validate({  
        rules: {
            start_date: { required: true, date: true },
            end_date: { required: true, date: true },
            avg_hours: { required: true, number: true, min: 0 },
            max_hours: { required: true, number: true, min: 0 },
            mon_start: { required: true }, mon_end: { required: true },
            tue_start: { required: true }, tue_end: { required: true },
            wed_start: { required: true }, wed_end: { required: true },
            thu_start: { required: true }, thu_end: { required: true },
            fri_start: { required: true }, fri_end: { required: true },
            sat_start: { required: true }, sat_end: { required: true },
            sun_start: { required: true }, sun_end: { required: true }
        },
        messages: {
            start_date: "Please select a start date.",
            end_date: "Please select a valid end date.",
            avg_hours: "Enter average hours.",
            max_hours: "Enter max hours."
        },
        submitHandler: function(form, event) {
            event.preventDefault();
            const $form = $(form);
            
            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: $form.serialize(),
                success: function (response) {
                    availabilityModal.hide();
                    Swal.fire({
                        icon: 'success',
                        title: 'Saved',
                        text: response.message || 'Availability record saved successfully.',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function (xhr) {
                    if (xhr.status === 422 && xhr.responseJSON?.errors) {
                        $.each(xhr.responseJSON.errors, function (field, messages) {
                            messages.forEach(msg => toastr.error(msg));
                        });
                        return;
                    }
                    toastr.error(xhr.responseJSON?.message || 'Something went wrong while saving availability.');
                }
            });
        }
    });

</script>
@endpush
