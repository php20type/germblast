@extends('admin.includes.layout')

@section('title', 'SIT Modules')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        .cursor-pointer {
            cursor: pointer !important;
        }

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

        .badge-active {
            background-color: #d1fae5;
            color: #065f46;
            font-weight: 600;
            font-size: 12px;
            padding: 4px 10px;
            border-radius: 20px;
            display: inline-block;
        }

        .badge-inactive {
            background-color: #f3f4f6;
            color: #6b7280;
            font-weight: 600;
            font-size: 12px;
            padding: 4px 10px;
            border-radius: 20px;
            display: inline-block;
        }

        .drag-handle {
            color: #9ca3af;
            cursor: grab;
            font-size: 16px;
        }

        .drag-handle:active {
            cursor: grabbing;
        }

        /* iOS-style toggle switch */
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 44px;
            height: 24px;
        }
        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
            position: absolute;
        }
        .toggle-slider {
            position: absolute;
            inset: 0;
            background-color: #d1d5db;
            border-radius: 34px;
            cursor: pointer;
            transition: background-color 0.25s ease;
        }
        .toggle-slider::before {
            content: '';
            position: absolute;
            width: 18px;
            height: 18px;
            left: 3px;
            top: 3px;
            background: #fff;
            border-radius: 50%;
            transition: transform 0.25s ease;
            box-shadow: 0 1px 3px rgba(0,0,0,0.2);
        }
        .toggle-switch input:checked + .toggle-slider {
            background-color: #22c55e;
        }
        .toggle-switch input:checked + .toggle-slider::before {
            transform: translateX(20px);
        }
        .toggle-switch:hover .toggle-slider {
            box-shadow: 0 0 0 3px rgba(34,197,94,0.15);
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

                        <!-- Header -->
                        <div class="heading-area-sec mb-3">
                            <div class="left-part-sec">
                                <h3 class="mb-1">SIT Modules</h3>
                                <p class="text-muted mb-0">Manage the training curriculum modules for the SIT Program.</p>
                            </div>
                            <div class="right-part">
                                <button class="btn btn-export" data-bs-toggle="modal" data-bs-target="#AddModuleModal">
                                    <i class="fa-solid fa-plus"></i> Add Module
                                </button>
                            </div>
                        </div>

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

                        <!-- Table Container -->
                        <div class="px-4 pb-4">
                            <div class="table-responsive">
                                <table id="sitModulesTable" class="table table-hover w-100 equipment-report-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 50px;"></th>
                                            <th style="width: 60px;">#</th>
                                            <th>Module Name</th>
                                            <th>Description</th>
                                            <th style="width: 100px;">Status</th>
                                            <th class="text-center" style="width: 80px;">Active</th>
                                            <th class="text-center" style="width: 140px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="sortableModules">
                                        @forelse($modules as $module)
                                            <tr class="module-row cursor-pointer" data-id="{{ $module->id }}">
                                                <td>
                                                    <span class="drag-handle"><i class="fa-solid fa-grip-vertical"></i></span>
                                                </td>
                                                <td class="fw-semibold text-muted">{{ $module->order_index }}</td>
                                                <td class="fw-semibold text-dark">{{ $module->name }}</td>
                                                <td class="text-muted">{{ $module->description ?: '—' }}</td>
                                                <td>
                                                    @if($module->is_active)
                                                        <span class="badge-active">Active</span>
                                                    @else
                                                        <span class="badge-inactive">Inactive</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <label class="toggle-switch" style="cursor:pointer;margin:0;" title="{{ $module->is_active ? 'Click to Deactivate' : 'Click to Activate' }}">
                                                        <input type="checkbox" class="toggle-active-btn" data-id="{{ $module->id }}" {{ $module->is_active ? 'checked' : '' }} style="display:none;">
                                                        <span class="toggle-slider"></span>
                                                    </label>
                                                </td>
                                                <td class="text-center">
                                                    <button class="btn btn-sm btn-outline-dark me-1 edit-module-btn"
                                                        style="border-radius: 6px; padding: 6px 14px;"
                                                        data-id="{{ $module->id }}"
                                                        data-name="{{ $module->name }}"
                                                        data-description="{{ $module->description }}">
                                                        Edit
                                                    </button>

                                                    <button class="btn btn-sm btn-outline-danger delete-module-btn"
                                                        style="border-radius: 6px; padding: 6px 14px;"
                                                        data-id="{{ $module->id }}">
                                                        Delete
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

    <!-- Add Module Modal -->
    <div class="modal fade" id="AddModuleModal" tabindex="-1" aria-labelledby="addModuleLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="addModuleLabel">Add a Module</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="add-module-form" class="company-form">
                        @csrf
                        <div class="row mx-0">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Module Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" placeholder="e.g. Module 1: Orientation">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" rows="4" class="form-control" placeholder="Optional description of what this module covers..."></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="saveAddBtn">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Module Modal -->
    <div class="modal fade" id="EditModuleModal" tabindex="-1" aria-labelledby="editModuleLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="editModuleLabel">Edit Module</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editModuleForm" method="POST" class="company-form">
                        @csrf
                        @method('PUT')
                        <div class="row mx-0">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Module Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="edit_module_name" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" id="edit_module_description" rows="4" class="form-control" placeholder="Optional description of what this module covers..."></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="saveModuleBtn">Save changes</button>
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
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            // Setup CSRF for all AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            // Initialize DataTable
            const table = $('#sitModulesTable').DataTable({
                pageLength: 10,
                ordering: false,
                dom: '<"d-flex justify-content-between align-items-center mb-3"l f>r<"table-responsive"t><"d-flex justify-content-between align-items-center mt-3"i p>',
                language: {
                    search: '',
                    searchPlaceholder: 'Search...',
                    lengthMenu: 'Show _MENU_ entries',
                    info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                    paginate: { previous: 'Previous', next: 'Next' },
                    emptyTable: 'No modules have been created yet.'
                }
            });

            // Edit Button Clicked
            $(document).on('click', '.edit-module-btn', function () {
                const id          = $(this).data('id');
                const name        = $(this).data('name');
                const description = $(this).data('description');

                $('#edit_module_name').val(name);
                $('#edit_module_description').val(description);
                $('#editModuleForm').attr('data-id', id);

                // Reset validation
                let validator = $('#editModuleForm').validate();
                if(validator) validator.resetForm();
                $('#editModuleForm').find('.is-invalid').removeClass('is-invalid');

                $('#EditModuleModal').modal('show');
            });

            // Validation Setup
            const validationRules = {
                rules: { name: { required: true } },
                messages: { name: { required: "Please enter the module name." } },
                errorElement: 'span',
                errorClass: 'invalid-feedback d-block',
                highlight: function(element) { $(element).addClass('is-invalid'); },
                unhighlight: function(element) { $(element).removeClass('is-invalid'); }
            };

            $('#add-module-form').validate(validationRules);
            $('#editModuleForm').validate(validationRules);

            // AJAX Create
            $('#add-module-form').on('submit', function (e) {
                e.preventDefault();
                if (!$(this).valid()) return;

                let btn = $('#saveAddBtn');
                $.ajax({
                    url: '{{ route("admin.operations.sit-modules.store") }}',
                    method: 'POST',
                    data: $(this).serialize(),
                    beforeSend: function () { btn.prop('disabled', true).text('Saving...'); },
                    success: function (res) {
                        toastr.success(res.message || 'Module created successfully!');
                        setTimeout(() => location.reload(), 1000);
                    },
                    error: function (xhr) {
                        toastr.error('Failed to create module.');
                        btn.prop('disabled', false).text('Save changes');
                    }
                });
            });

            // AJAX Update
            $('#editModuleForm').on('submit', function (e) {
                e.preventDefault();
                if (!$(this).valid()) return;

                let id = $(this).attr('data-id');
                let btn = $('#saveModuleBtn');
                $.ajax({
                    url: '/admin/operations/sit-modules/' + id,
                    method: 'PUT',
                    data: $(this).serialize(),
                    beforeSend: function () { btn.prop('disabled', true).text('Saving...'); },
                    success: function (res) {
                        toastr.success(res.message || 'Module updated successfully!');
                        setTimeout(() => location.reload(), 1000);
                    },
                    error: function (xhr) {
                        toastr.error('Failed to update module.');
                        btn.prop('disabled', false).text('Save changes');
                    }
                });
            });

            // AJAX Toggle Active
            $(document).on('change', '.toggle-active-btn', function () {
                let id = $(this).data('id');
                $.ajax({
                    url: '/admin/operations/sit-modules/' + id + '/toggle',
                    method: 'POST',
                    success: function (res) {
                        toastr.success(res.message || 'Status updated.');
                        setTimeout(() => location.reload(), 800);
                    },
                    error: function (xhr) {
                        toastr.error('Failed to update status.');
                    }
                });
            });

            // AJAX Delete with Swal
            $(document).on('click', '.delete-module-btn', function () {
                let id = $(this).data('id');

                Swal.fire({
                    title: "Are you sure?",
                    text: "Delete this module? If it has program history it will be deactivated instead.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete",
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/admin/operations/sit-modules/' + id,
                            method: 'DELETE',
                            success: function (response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: response.message || 'Module deleted successfully.',
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                                setTimeout(() => location.reload(), 2000);
                            },
                            error: function (xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'Failed to delete the module.',
                                    showConfirmButton: true
                                });
                            }
                        });
                    }
                });
            });

            // Drag-to-reorder with SortableJS
            const tbody = document.getElementById('sortableModules');
            if (tbody) {
                Sortable.create(tbody, {
                    handle: '.drag-handle',
                    animation: 150,
                    onEnd: function () {
                        const order = [...tbody.querySelectorAll('tr.module-row')].map(row => row.dataset.id);
                        fetch('{{ route('admin.operations.sit-modules.reorder') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ order })
                        }).then(res => res.json()).then(data => {
                            if (data.success) {
                                // Update # column in real time
                                tbody.querySelectorAll('tr.module-row').forEach((row, idx) => {
                                    row.querySelectorAll('td')[1].textContent = idx + 1;
                                });
                            }
                        });
                    }
                });
            }
        });
    </script>
@endpush
