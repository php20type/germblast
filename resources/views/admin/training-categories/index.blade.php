@extends('admin.includes.layout')

@section('title', 'Training Categories')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        .equipment-report-table {
            border-collapse: separate !important;
            border-spacing: 0 !important;
            border: 1px solid #f3f4f6 !important;
            border-radius: 12px !important;
            overflow: hidden !important;
            background: #fff !important;
            width: 100% !important;
            margin-top: 10px !important;
        }

        .equipment-report-table thead th {
            background-color: rgba(255, 184, 28, 0.4) !important;
            color: #374151 !important;
            font-weight: 600 !important;
            padding: 18px 20px !important;
            border-right: 1px solid rgba(0, 0, 0, 0.05) !important;
            font-size: 14px !important;
        }

        .equipment-report-table tbody td {
            padding: 15px 20px !important;
            vertical-align: middle !important;
            border-bottom: 1px solid #f3f4f6 !important;
            border-right: 1px solid rgba(0, 0, 0, 0.05) !important;
            font-size: 14px !important;
        }

        a.text-action {
            color: #337ab7 !important;
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
                                <h3 class="mb-1">TRAINING CATEGORIES</h3>
                                <p class="text-muted mb-0">Manage training categories.</p>
                            </div>
                            @can('training.add')
                            <div class="right-part-sec">
                                <button class="btn btn-export btn-create-trigger" data-bs-toggle="modal" data-bs-target="#createModal">
                                    + ADD CATEGORY
                                </button>
                            </div>
                            @endcan
                        </div>

                        <!-- Table Card -->
                        <div class="px-4 pb-4">
                            <div class="table-responsive">
                                <table class="table table-hover w-100 equipment-report-table">
                                    <thead>
                                        <tr>
                                            <th style="text-align: left !important;">Name</th>
                                            <th style="text-align: center !important;">Sort Order</th>
                                            <th style="text-align: center !important;">Status</th>
                                            <th class="text-end" style="width: 150px; padding-right: 35px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($categories as $category)
                                            <tr>
                                                <td style="text-align: left !important; padding: 20px !important;">
                                                    <div style="font-size: 15px; color: #374151; margin-bottom: 5px; font-weight: 600;">
                                                        {{ $category->name }}
                                                    </div>
                                                    <div style="font-size: 13px; color: #6b7280; margin-bottom: 5px;">
                                                        {{ $category->description ?? '-' }}
                                                    </div>
                                                </td>
                                                <td style="text-align: center !important;">
                                                    {{ $category->sort_order }}
                                                </td>
                                                <td style="text-align: center !important;">
                                                    {{ $category->status }}
                                                </td>
                                                <td style="text-align: right !important; padding: 20px !important; padding-right: 35px !important;">
                                                    <div class="d-flex justify-content-end align-items-center gap-3">
                                                        @can('training.edit')
                                                        <a href="#" class="btn btn-outline-primary btn-edit" 
                                                           data-id="{{ $category->id }}"
                                                           data-name="{{ $category->name }}"
                                                           data-description="{{ $category->description }}"
                                                           data-sort_order="{{ $category->sort_order }}"
                                                           data-status="{{ $category->status }}"
                                                           data-bs-toggle="modal" 
                                                           data-bs-target="#editModal">
                                                            Edit
                                                        </a>
                                                        @endcan

                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
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

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="createModalLabel">Create New Category</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createForm" class="company-form" action="{{ route('admin.training-categories.store') }}" method="POST">
                    @csrf
                    <div class="row mx-0">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" id="formName" placeholder="e.g. Safety Training, Orientation" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="description" id="formDescription" rows="4" placeholder="e.g. Mandatory safety protocols for new employees..." required></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Sort Order <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="sort_order" id="formSortOrder" value="0" placeholder="e.g. 1" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select" name="status" id="formStatus" required>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="editModalLabel">Edit Category</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm" class="company-form" action="" method="POST">
                    @csrf
                    <!-- For editing in laravel normally we use PUT but the backend accepts POST as per previous setup -->
                    <div class="row mx-0">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" id="editName" placeholder="e.g. Safety Training, Orientation" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="description" id="editDescription" rows="4" placeholder="e.g. Mandatory safety protocols for new employees..." required></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Sort Order <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="sort_order" id="editSortOrder" value="0" placeholder="e.g. 1" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select" name="status" id="editStatus" required>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.btn-create-trigger').on('click', function() {
            // Optional: reset happens on modal hide now
        });

        $('#createModal').on('hidden.bs.modal', function () {
            const validator = $("#createForm").validate();
            if(validator) validator.resetForm();
            $('#createForm')[0].reset();
            $('#createForm .is-invalid').removeClass('is-invalid');
        });

        $('#editModal').on('hidden.bs.modal', function () {
            const validator = $("#editForm").validate();
            if(validator) validator.resetForm();
            $('#editForm')[0].reset();
            $('#editForm .is-invalid').removeClass('is-invalid');
        });

        $(document).on('click', '.btn-edit', function() {
            let id = $(this).data('id');
            $('#editName').val($(this).data('name'));
            $('#editDescription').val($(this).data('description'));
            $('#editSortOrder').val($(this).data('sort_order'));
            $('#editStatus').val($(this).data('status'));
            
            $('#editForm').attr('action', '{{ url('admin/training-categories/update') }}/' + id);
        });

        const validationConfig = {
            ignore: [],
            rules: {
                name: { required: true, maxlength: 255 },
                description: { required: true },
                sort_order: { required: true },
                status: { required: true }
            },
            messages: {
                name: { required: "Please enter a category name." },
                description: { required: "Please enter a description." },
                sort_order: { required: "Please enter a sort order." },
                status: { required: "Please select a status." }
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
        };

        // Initialize jQuery Validation for both forms
        $("#createForm").validate(validationConfig);
        $("#editForm").validate(validationConfig);

        function handleAjaxSubmit(e) {
            e.preventDefault();
            const form = $(this);
            const submitBtn = form.find('button[type="submit"]');
            const originalText = submitBtn.text();

            if (!form.valid()) {
                return;
            }

            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: form.serialize(),
                beforeSend: function() {
                    submitBtn.prop('disabled', true).text('Saving...');
                },
                success: function(response) {
                    if(response.success) {
                        toastr.success(response.message);
                        form.closest('.modal').modal('hide');
                        setTimeout(() => window.location.reload(), 1000);
                    } else {
                        toastr.error(response.message);
                        submitBtn.prop('disabled', false).text(originalText);
                    }
                },
                error: function(xhr) {
                    let msg = xhr.responseJSON?.message || 'Something went wrong.';
                    toastr.error(msg);
                    submitBtn.prop('disabled', false).text(originalText);
                }
            });
        }

        $('#createForm').on('submit', handleAjaxSubmit);
        $('#editForm').on('submit', handleAjaxSubmit);


    });
</script>
@endpush
