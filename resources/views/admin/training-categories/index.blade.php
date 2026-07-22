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
                                                        <a href="#" class="text-action btn-edit" 
                                                           data-id="{{ $category->id }}"
                                                           data-name="{{ $category->name }}"
                                                           data-description="{{ $category->description }}"
                                                           data-sort_order="{{ $category->sort_order }}"
                                                           data-status="{{ $category->status }}"
                                                           style="font-size: 16px;" 
                                                           data-bs-toggle="modal" 
                                                           data-bs-target="#createModal">
                                                            <i class="fa-solid fa-gear"></i>
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

<!-- Create / Edit Modal -->
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
                                <label class="form-label">Name</label>
                                <span class="text-danger">*</span>
                                <input type="text" class="form-control" name="name" id="formName" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" id="formDescription" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Sort Order</label>
                                <input type="number" class="form-control" name="sort_order" id="formSortOrder" value="0">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="status" id="formStatus">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
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
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.btn-create-trigger').on('click', function() {
            $('#createModalLabel').text('Create New Category');
            $('#createForm')[0].reset();
            $('#createForm').attr('action', '{{ route('admin.training-categories.store') }}');
        });

        $(document).on('click', '.btn-edit', function() {
            let id = $(this).data('id');
            $('#createModalLabel').text('Edit Category');
            $('#formName').val($(this).data('name'));
            $('#formDescription').val($(this).data('description'));
            $('#formSortOrder').val($(this).data('sort_order'));
            $('#formStatus').val($(this).data('status'));
            
            $('#createForm').attr('action', '{{ url('admin/training-categories/update') }}/' + id);
        });

        $('#createForm').on('submit', function(e) {
            e.preventDefault();
            const form = $(this);
            const submitBtn = form.find('button[type="submit"]');

            if (!form[0].checkValidity()) {
                form[0].reportValidity();
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
                        $('#createModal').modal('hide');
                        setTimeout(() => window.location.reload(), 1000);
                    } else {
                        toastr.error(response.message);
                        submitBtn.prop('disabled', false).text('Save changes');
                    }
                },
                error: function(xhr) {
                    let msg = xhr.responseJSON?.message || 'Something went wrong.';
                    toastr.error(msg);
                    submitBtn.prop('disabled', false).text('Save changes');
                }
            });
        });


    });
</script>
@endpush
