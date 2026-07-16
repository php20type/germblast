@extends('admin.includes.layout')

@section('title', 'Training Tests')

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
                                <h3 class="mb-1">TRAINING TESTS</h3>
                                <p class="text-muted mb-0">Manage training tests.</p>
                            </div>
                            <div class="right-part-sec">
                                <button class="btn btn-export btn-create-trigger" data-bs-toggle="modal" data-bs-target="#createModal">
                                    + ADD TEST
                                </button>
                            </div>
                        </div>

                        <!-- Table Card -->
                        <div class="px-4 pb-4">
                            <div class="table-responsive">
                                <table class="table table-hover w-100 equipment-report-table">
                                    <thead>
                                        <tr>
                                            <th style="text-align: left !important;">Test Name</th>
                                            <th style="text-align: center !important;">Category</th>
                                            <th style="text-align: center !important;">Passing %</th>
                                            <th style="text-align: center !important;">Status</th>
                                            <th class="text-end" style="width: 150px; padding-right: 35px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tests as $test)
                                            <tr>
                                                <td style="text-align: left !important; padding: 20px !important;">
                                                    <div style="font-size: 15px; color: #374151; margin-bottom: 5px; font-weight: 600;">
                                                        {{ $test->name }}
                                                    </div>
                                                    <div style="font-size: 13px; color: #6b7280; margin-bottom: 5px;">
                                                        {{ $test->description ?? '-' }}
                                                    </div>
                                                </td>
                                                <td style="text-align: center !important;">
                                                    {{ $test->category->name ?? '-' }}
                                                </td>
                                                <td style="text-align: center !important;">
                                                    {{ $test->passing_percentage }}%
                                                </td>
                                                <td style="text-align: center !important;">
                                                    {{ $test->status }}
                                                </td>
                                                <td style="text-align: right !important; padding: 20px !important; padding-right: 35px !important;">
                                                    <div class="d-flex justify-content-end align-items-center gap-3">
                                                        <a href="#" class="text-action btn-edit" 
                                                           data-id="{{ $test->id }}"
                                                           data-category_id="{{ $test->category_id }}"
                                                           data-name="{{ $test->name }}"
                                                           data-description="{{ $test->description }}"
                                                           data-video_url="{{ $test->video_url }}"
                                                           data-passing_percentage="{{ $test->passing_percentage }}"

                                                           data-status="{{ $test->status }}"
                                                           style="font-size: 16px;" 
                                                           data-bs-toggle="modal" 
                                                           data-bs-target="#createModal">
                                                            <i class="fa-solid fa-gear"></i>
                                                        </a>
                                                        <form action="{{ route('admin.training-tests.destroy', $test->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-link text-danger p-0 border-0 btn-delete" style="font-size: 16px;">
                                                                <i class="fa-solid fa-trash"></i>
                                                            </button>
                                                        </form>
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
                <h1 class="modal-title" id="createModalLabel">Create New Test</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createForm" class="company-form" action="{{ route('admin.training-tests.store') }}" method="POST">
                    @csrf
                    <div class="row mx-0">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Category</label>
                                <span class="text-danger">*</span>
                                <select class="form-select" name="category_id" id="formCategory" required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Name</label>
                                <span class="text-danger">*</span>
                                <input type="text" class="form-control" name="name" id="formName" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" id="formDescription" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Video URL</label>
                                <input type="url" class="form-control" name="video_url" id="formVideoUrl" placeholder="e.g. https://player.vimeo.com/video/...">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Passing Percentage</label>
                                <input type="number" class="form-control" name="passing_percentage" id="formPassing" value="80" min="0" max="100">
                            </div>
                        </div>

                        <div class="col-lg-12">
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
            $('#createModalLabel').text('Create New Test');
            $('#createForm')[0].reset();
            $('#createForm').attr('action', '{{ route('admin.training-tests.store') }}');
        });

        $(document).on('click', '.btn-edit', function() {
            let id = $(this).data('id');
            $('#createModalLabel').text('Edit Test');
            $('#formCategory').val($(this).data('category_id'));
            $('#formName').val($(this).data('name'));
            $('#formDescription').val($(this).data('description'));
            $('#formVideoUrl').val($(this).data('video_url'));
            $('#formPassing').val($(this).data('passing_percentage'));

            $('#formStatus').val($(this).data('status'));
            
            $('#createForm').attr('action', '{{ url('admin/training-tests/update') }}/' + id);
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

        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            let form = $(this).closest('form');
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to delete this test?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: form.attr('action'),
                        method: 'POST',
                        data: form.serialize(),
                        success: function(response) {
                            if(response.success) {
                                toastr.success(response.message);
                                setTimeout(() => window.location.reload(), 1000);
                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function(xhr) {
                            toastr.error(xhr.responseJSON?.message || 'Something went wrong.');
                        }
                    });
                }
            });
        });
    });
</script>
@endpush
