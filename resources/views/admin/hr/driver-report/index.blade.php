@extends('admin.includes.layout')

@section('title', 'Driver Report')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
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
    </style>
@endpush

@section('content')
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 p-0">
                    <div class="main-content">
                        
                        <!-- Header -->
                        <div class="heading-area-sec border-bottom-0 pb-0">
                            <div class="left-part-sec">
                                <h3 class="mb-2" style="font-size: 26px; font-weight: 500;">DRIVER REPORT <span
                                        style="font-size: 24px;">📌</span></h3>
                                <p class="text-muted mb-0" style="font-size: 16px;">Track and analyze driver status and points across the organization.</p>
                            </div>
                        </div>

                        <hr class="mx-4 my-4" style="opacity: 0.1;">

                        @if(session('success'))
                            <div class="px-4">
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="px-4">
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            </div>
                        @endif

                        <!-- Table Container (Directly like EQ) -->
                        <div class="px-4 pb-4">
                            <div class="table-responsive">
                                <table id="driverReportTable" class="table table-hover w-100 equipment-report-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 100px;">Profile</th>
                                            <th>Driver</th>
                                            <th>Status</th>
                                            <th>Points (Last 6 Months)</th>
                                            <th class="text-center" style="width: 150px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($drivers as $driver)
                                            @php
                                                $status = $driver->driver_status ?? 'Trained Driver';
                                                $points = $driver->driver_points ?? 'N/A';
                                            @endphp
                                            <tr>
                                                <td>
                                                    <img src="{{ $driver->profile_image ? asset('storage/' . $driver->profile_image) : asset('img/home/default-profile.png') }}"
                                                         alt="profile"
                                                         style="width:60px; height:60px; object-fit:cover; border-radius:50%;">
                                                </td>
                                                <td>
                                                    @if(auth()->user()->isSuperAdmin())
                                                        <a href="{{ route('admin.employee.edit', $driver->id) }}" class="text-decoration-none text-dark fw-semibold">{{ $driver->name }}</a>
                                                    @else
                                                        <span class="fw-semibold text-dark">{{ $driver->name }}</span>
                                                    @endif
                                                    <div class="small text-muted" style="font-size: 12px;">{{ $driver->email }}</div>
                                                </td>
                                                <td>{!! nl2br(e($status)) !!}</td>
                                                <td>{!! nl2br(e($points)) !!}</td>
                                                <td class="text-center">
                                                    <button class="btn btn-sm btn-outline-dark me-2 edit-driver-btn"
                                                            style="border-radius: 6px; padding: 6px 14px;"
                                                            data-id="{{ $driver->id }}"
                                                            data-name="{{ $driver->name }}"
                                                            data-status="{{ $status }}"
                                                            data-points="{{ $points }}">
                                                        Edit
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            {{-- Handled by DataTables --}}
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

    <!-- Edit Driver Modal (Dashboard Add Company Structure) -->
    <div class="modal fade" id="editDriverModal" tabindex="-1" aria-labelledby="editDriverLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="editDriverLabel">Edit Driver Report</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editDriverForm" method="POST">
                        @csrf
                        <div class="row mx-0">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Driver Name</label>
                                    <input type="text" id="driver_name" class="form-control bg-light" readonly>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Status</label>
                                    <span class="text-danger">*</span>
                                    <textarea name="status" id="driver_status" class="form-control" required placeholder="e.g., Trained Driver, Suspended, Probation" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Points (Last 6 Months)</label>
                                    <span class="text-danger">*</span>
                                    <textarea name="points" id="driver_points" class="form-control" required placeholder="e.g., 0, 10, N/A" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="saveDriverBtn">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function () {
            // Initialize DataTable
            $('#driverReportTable').DataTable({
                pageLength: 10,
                ordering: false,
                dom: '<"d-flex justify-content-between align-items-center mb-3"l f>r<"table-responsive"t><"d-flex justify-content-between align-items-center mt-3"i p>',
                language: {
                    search: '',
                    searchPlaceholder: 'Search...',
                    lengthMenu: 'Show _MENU_ entries',
                    info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                    paginate: { previous: 'Previous', next: 'Next' }
                }
            });

            // Edit Button Clicked
            $('.edit-driver-btn').on('click', function () {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const status = $(this).data('status');
                const points = $(this).data('points');

                $('#driver_name').val(name);
                $('#driver_status').val(status);
                $('#driver_points').val(points);

                // Set action route dynamically
                $('#editDriverForm').attr('action', '/admin/hr/driver-report/' + id);

                // Show Modal
                $('#editDriverModal').modal('show');
            });

            // Form Submit (AJAX)
            $('#editDriverForm').on('submit', function (e) {
                e.preventDefault();
                const form = $(this);
                const btn = $('#saveDriverBtn');

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    beforeSend: function () {
                        btn.prop('disabled', true).text('Saving...');
                    },
                    success: function (res) {
                        toastr.success(res.message || 'Driver report updated successfully!');
                        $('#editDriverModal').modal('hide');
                        btn.prop('disabled', false).text('Save changes');
                        
                        // Reload page to reflect changes
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    },
                    error: function (xhr) {
                        const errors = xhr.responseJSON?.errors;
                        toastr.error(errors ? Object.values(errors)[0][0] : 'Something went wrong.');
                        btn.prop('disabled', false).text('Save changes');
                    }
                });
            });
        });
    </script>
@endpush
