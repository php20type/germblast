@extends('admin.includes.layout')

@section('title', 'Industries')

@section('content')



    <main class="app-wrapper">
        <!-- All Companies Section start  -->
        <div class="companies-section my-4">
            <div class="container-fluid">
                <div class="row">
                    <!-- Sidebar -->
                    @include('admin.settings.sidebar')

                    <!-- Main Content -->
                    <div class="col-md-10 p-0">
                        <div class="main-content">
                            <div class="heading-area-sec mb-3">
                                <div class="left-part-sec">
                                    <h3 class="mb-1">INDUSTRIES <span style="font-size: 24px;">📌</span></h3>
                                    <p class="text-muted mb-0">Organize your companies by their industry.</p>
                                </div>
                                <div class="right-part-sec mt-1">
                                    <a href="javascript:void(0);" class="btn btn-export" id="toggleAddIndustry" onclick="addIndustry()">Add Industry</a>
                                </div>
                            </div>

                            <div class="px-4 pb-4">
                                <div class="mb-5">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="mb-0 text-uppercase">INDUSTRIES ({{ $totalCounts }})</h6>
                                    </div>

                                    <table class="table w-100 equipment-report-table mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col">Name</th>
                                                <th scope="col" class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($industries as $industry)
                                                <tr>
                                                    <td>{{ $industry->name }}</td>
                                                    <td class="text-end">
                                                        <a href="javascript:void(0);" 
                                                           class="btn btn-outline-primary btn-sm btn-edit-industry"
                                                           data-id="{{ $industry->id }}"
                                                           data-name="{{ $industry->name }}">
                                                            Edit
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="info-section bg-white p-4 rounded-3 border mt-4" style="border-color: #e5e7eb !important;">
                                    <div class="info-cards mb-4">
                                        <h6 class="fw-bold mb-2">WHAT IS AN INDUSTRY?</h6>
                                        <p class="text-muted mb-0">Every account can belong to a specific industry, allowing you to generate reports on leads per industry.</p>
                                    </div>
                                </div>

                            </div>
                        </div>

                </div>
            </div>
        </div>
        <!-- All Companies Section End  -->
    </main>

    {{-- Industry modal --}}
    <div class="modal fade" id="add_industry" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        {{-- Just remove modal-fullscreen from below class , to get a popup instead of full modal --}}
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="exampleModalLabel">New Industry</h1>
                    <div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
                <div class="modal-body ps-0">

                    <form class="company-form" action="{{ route('admin.settings.industry.store') }}" method="post" id="store_industry">
                        @csrf


                        <div class="row mx-0">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" placeholder="e.g. Technology" name="name"
                                        class="form-control" />
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success" id="AddIndustry">New Industry</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Industry modal --}}
    <div class="modal fade" id="edit_industry" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="editModalLabel">Edit Industry</h1>
                    <div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
                <div class="modal-body ps-0">
                    <form class="company-form" action="" method="post" id="update_industry">
                        @csrf
                        <div class="row mx-0">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" placeholder="e.g. Technology" name="name" id="editIndustryName" class="form-control" />
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="btnUpdateIndustry">Save Changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>

        function addIndustry() {
            $('#add_industry').modal('show');
        }

        // Reset form and validation on modal close
        $('#add_industry').on('hidden.bs.modal', function () {
            const validator = $("#store_industry").validate();
            if(validator) validator.resetForm();
            $('#store_industry')[0].reset();
            $('#store_industry .is-invalid').removeClass('is-invalid');
        });

         $("#store_industry").validate({
            ignore: [],
            rules: {
                name: {
                    required: true
                },
            },
            messages: {
                name: {
                    required: "Please enter the industry name."
                },
            },
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
                    error.insertAfter(element.parent()); // Inserts after the .input-group
                } else {
                    error.insertAfter(element); // Default
                }
            }
        });


        $('#store_industry').submit(function(e) {
            e.preventDefault();

            if (!$('#store_industry').valid()) {
                return; // Stop if validation fails
            }

            const btn = $('#AddIndustry');
            btn.prop('disabled', true).text('Creating...');

            $.ajax({
                url: "{{ route('admin.settings.industry.store') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    toastr.success('Industry added successfully!');
                    $('#add_industry').modal('hide');
                    setTimeout(() => location.reload(), 1000);
                },
                error: function(xhr) {
                    btn.prop('disabled', false).text('New Industry');
                    toastr.error(xhr.responseJSON?.message || 'Something went wrong while adding new industry.');
                }
            });
        });

        // Edit form reset on close
        $('#edit_industry').on('hidden.bs.modal', function () {
            const validator = $("#update_industry").validate();
            if(validator) validator.resetForm();
            $('#update_industry')[0].reset();
            $('#update_industry .is-invalid').removeClass('is-invalid');
        });

        // Edit button click
        $(document).on('click', '.btn-edit-industry', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            let name = $(this).data('name');

            $('#editIndustryName').val(name);

            $('#update_industry').attr('action', "{{ url('admin/settings/industry/update') }}/" + id);
            $('#edit_industry').modal('show');
        });

        $("#update_industry").validate({
            ignore: [],
            rules: {
                name: { required: true }
            },
            messages: {
                name: { required: "Please enter the industry name." }
            },
            errorElement: 'span',
            errorClass: 'invalid-feedback d-block',
            highlight: function(element) { $(element).addClass('is-invalid'); },
            unhighlight: function(element) { $(element).removeClass('is-invalid'); },
            errorPlacement: function(error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            }
        });

        $('#update_industry').submit(function(e) {
            e.preventDefault();

            if (!$('#update_industry').valid()) {
                return;
            }

            const btn = $('#btnUpdateIndustry');
            btn.prop('disabled', true).text('Saving...');

            $.ajax({
                url: $(this).attr('action'),
                method: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    toastr.success('Industry updated successfully!');
                    $('#edit_industry').modal('hide');
                    setTimeout(() => location.reload(), 1000);
                },
                error: function(xhr) {
                    btn.prop('disabled', false).text('Save Changes');
                    toastr.error(xhr.responseJSON?.message || 'Something went wrong while updating the industry.');
                }
            });
        });


        function toggleSettings() {
            const settingsContent = document.getElementById('settingsContent');
            const chevronIcon = document.getElementById('settingsChevron');

            if (settingsContent.classList.contains('show')) {
                settingsContent.classList.remove('show');
                chevronIcon.classList.add('rotated');
            } else {
                settingsContent.classList.add('show');
                chevronIcon.classList.remove('rotated');
            }
        }

        function toggleDropdown(section) {
            const sections = ['administration', 'sales', 'data', 'organization', 'connections'];

            // Close all other dropdowns
            sections.forEach(otherSection => {
                if (otherSection !== section) {
                    const otherContent = document.getElementById(otherSection + 'Content');
                    const otherChevron = document.getElementById(otherSection + 'Chevron');
                    otherContent.classList.remove('show');
                    otherChevron.classList.remove('rotated');
                }
            });

            // Toggle the clicked dropdown
            const dropdownContent = document.getElementById(section + 'Content');
            const chevronIcon = document.getElementById(section + 'Chevron');

            if (dropdownContent.classList.contains('show')) {
                dropdownContent.classList.remove('show');
                chevronIcon.classList.remove('rotated');
            } else {
                dropdownContent.classList.add('show');
                chevronIcon.classList.add('rotated');
            }
        }

        // Initialize Bootstrap tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endpush
