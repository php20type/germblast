@extends('admin.includes.layout')

@section('title', 'SIT Program')

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
    .sit-tech-buttons {
        margin-top: 30px;
    }
    .btn-tech {
        background-color: #f9fafb;
        border: 1px solid #e5e7eb;
        color: #374151;
        padding: 12px 24px;
        font-size: 15px;
        margin-right: 12px;
        margin-bottom: 12px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.2s;
    }
    .btn-tech:hover {
        background-color: #f3f4f6;
        border-color: #d1d5db;
        color: #111827;
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
                                <h3 class="mb-1 text-uppercase">SIT PROGRAM</h3>
                                <p class="text-muted mb-0">Manage the Supervisor In Training probationary period and modules.</p>
                            </div>
                        </div>

                        <!-- Flash Messages -->
                        @if(session('success'))
                            <div class="px-4">
                                <div class="alert alert-success alert-dismissible fade show">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            </div>
                        @endif
                        @if($errors->any())
                            <div class="px-4">
                                <div class="alert alert-danger alert-dismissible fade show">
                                    {{ $errors->first() }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            </div>
                        @endif

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

                                <div class="sit-tech-buttons mt-4 pt-4" style="border-top: 1px solid #f3f4f6;">
                                    <p class="mb-4 fw-bold text-dark" style="font-size: 17px;">Select a technician to start the SIT program:</p>

                                    @if($modules->count() === 0)
                                        <div class="alert alert-warning">
                                            <i class="fa-solid fa-triangle-exclamation me-2"></i>
                                            No active modules are configured. Please <a href="{{ route('admin.operations.sit-modules.index') }}" class="alert-link">add modules</a> before enrolling a technician.
                                        </div>
                                    @else
                                        <div class="d-flex flex-wrap">
                                            @forelse($technicians as $tech)
                                                <!-- Trigger confirmation modal per technician -->
                                                <button type="button" class="btn btn-tech"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#ConfirmEnrollModal"
                                                    data-user-id="{{ $tech->id }}"
                                                    data-user-name="{{ $tech->name }}">
                                                    {{ $tech->name }}
                                                </button>
                                            @empty
                                                <p class="text-muted">No active technicians available for enrollment.</p>
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
    </div>
</div>

<!-- Enrollment Confirmation Modal -->
<div class="modal fade" id="ConfirmEnrollModal" tabindex="-1" aria-labelledby="confirmEnrollLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="confirmEnrollLabel">SIT Program Enrollment</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.operations.sit-program.store') }}" method="POST" class="company-form" id="enroll-form">
                    @csrf
                    <input type="hidden" name="user_id" id="enrollUserId">

                    <div class="row mx-0">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label fw-bold">Technician</label>
                                <input type="text" class="form-control" id="enrollUserName" readonly>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label fw-bold">Modules That Will Be Assigned</label>
                                <p class="text-muted mb-2" style="font-size: 13px;">The following {{ $modules->count() }} active module(s) will be attached to this technician's program in sequence:</p>
                                <ul class="list-group" style="max-width: 600px;">
                                    @foreach($modules as $module)
                                        <li class="list-group-item">
                                            <div class="d-flex align-items-center">
                                                <span class="badge bg-secondary me-2">{{ $module->order_index }}</span>
                                                <span>{{ $module->name }}</span>
                                            </div>
                                            @if($module->description)
                                                <div class="text-muted mt-1" style="font-size: 13px; padding-left: 32px;">
                                                    {{ $module->description }}
                                                </div>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        $('#ConfirmEnrollModal').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget);
            $('#enrollUserId').val(button.data('user-id'));
            $('#enrollUserName').val(button.data('user-name'));
        });

        $('#enroll-form').on('submit', function (e) {
            e.preventDefault();
            let btn = $(this).find('button[type="submit"]');

            $.ajax({
                url: '{{ route("admin.operations.sit-program.store") }}',
                method: 'POST',
                data: $(this).serialize(),
                beforeSend: function () {
                    btn.prop('disabled', true).text('Enrolling...');
                },
                success: function (res) {
                    toastr.success(res.message || 'Enrollment successful!');
                    $('#ConfirmEnrollModal').modal('hide');
                    setTimeout(function() {
                        window.location.href = '{{ route("admin.operations.sit-progress.index") }}';
                    }, 1000);
                },
                error: function (xhr) {
                    let errorMessage = 'Failed to enroll technician.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    toastr.error(errorMessage);
                    btn.prop('disabled', false).text('Confirm');
                }
            });
        });
    });
</script>
@endpush
