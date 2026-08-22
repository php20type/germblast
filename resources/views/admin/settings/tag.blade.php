@extends('admin.includes.layout')

@section('title', 'Tags')

@section('content')
@push('styles')
    <style>
        .cursor-pointer {
            cursor: pointer !important;
        }

        /* Boxed Table System from Equipment Management */
        .equipment-report-table {
            border-collapse: separate !important;
            border-spacing: 0 !important;
            border: 1px solid #f3f4f6 !important;
            border-radius: 12px !important;
            overflow: hidden !important;
            background: #fff !important;
        }

        .equipment-report-table thead th {
            background-color: rgba(255, 184, 28, 0.4) !important;
            color: #374151 !important;
            font-weight: 600 !important;
            padding: 18px 20px !important;
            border-right: 1px solid rgba(0, 0, 0, 0.05) !important;
            font-size: 14px !important;
            text-align: left;
            white-space: nowrap;
        }

        .equipment-report-table tbody td {
            padding: 15px 20px !important;
            vertical-align: middle !important;
            border-bottom: 1px solid #f3f4f6 !important;
            border-right: 1px solid rgba(0, 0, 0, 0.05) !important;
            font-size: 14px !important;
            text-align: left;
            white-space: nowrap;
        }

        .equipment-report-table thead th:last-child,
        .equipment-report-table tbody td:last-child {
            border-right: none !important;
        }

        .equipment-report-table tr:last-child td {
            border-bottom: none !important;
        }

        /* Standardized Action Buttons */
        .btn-outline-primary {
            color: #0d6efd !important;
            border-color: #0d6efd !important;
            background-color: transparent !important;
            font-weight: 500 !important;
            padding: 6px 16px !important;
            border-radius: 6px !important;
            transition: all 0.2s ease !important;
        }

        .btn-outline-primary:hover {
            color: #fff !important;
            background-color: #0d6efd !important;
            border-color: #0d6efd !important;
            box-shadow: 0 4px 6px rgba(13, 110, 253, 0.15) !important;
        }

        /* Modern Soft Tabs Styling */
        .navbar-tabs .nav-tabs {
            border-bottom: none !important;
        }

        .navbar-tabs .nav-link {
            border: none !important;
            color: #6b7280 !important;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 13px;
            padding: 12px 20px 20px 20px !important;
            background: transparent !important;
            position: relative;
            transition: all 0.2s ease;
        }

        .navbar-tabs .nav-link.active {
            color: #111827 !important;
            background-color: #fff8e8 !important;
            border-radius: 10px 10px 0 0;
        }

        .navbar-tabs .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background-color: #ffb400;
        }

        .navbar-tabs .badge {
            background-color: #6b7280 !important;
            font-weight: 500;
            padding: 4px 8px;
            font-size: 11px;
            vertical-align: middle;
        }

        /* Re-styled Info Box for bottom placement */
        .info-box {
            padding: 24px;
            background: #f8f9fa;
            border-radius: 12px;
            margin-top: 30px;
        }
        .info-box .info-icon {
            font-size: 16px;
            margin-bottom: 15px;
            color: #111827;
        }
        .info-box .info-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #374151;
        }
        .info-box .info-text {
            font-size: 14px;
            line-height: 22px;
            color: #6b7280;
            margin-bottom: 15px;
        }
        .info-box .info-link {
            font-size: 14px;
            color: #0d6efd;
            text-decoration: none;
            font-weight: 500;
        }
        .info-box .info-link:hover {
            text-decoration: underline;
        }
    </style>
@endpush

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
                                    <h3 class="mb-1">TAGS</h3>
                                    <p class="text-muted mb-0">Create tags to organize companies, people, and leads into groups.</p>
                                </div>
                                <hr class="d-none">
                            </div>

                            <!-- TABS -->
                            <div class="navbar-tabs px-4">
                                <nav class="nav nav-tabs mb-0 w-100 nav-fill" id="sidebar-tabs" role="tablist">
                                    <button class="nav-link active" id="all-fields-tab"
                                        data-bs-toggle="tab" data-bs-target="#lead-fields" type="button" role="tab"
                                        aria-controls="all-fields" aria-selected="true">
                                        Lead <span class="badge rounded-pill ms-1">{{ $leadcount }}</span>
                                    </button>
                                    
                                    <button class="nav-link" id="archived-fields-tab"
                                        data-bs-toggle="tab" data-bs-target="#company-fields" type="button" role="tab"
                                        aria-controls="archived-fields" aria-selected="false">
                                        Company <span class="badge rounded-pill ms-1">{{ $companycount }}</span>
                                    </button>
                                    
                                    <button class="nav-link" id="person-fields-tab"
                                        data-bs-toggle="tab" data-bs-target="#person-fields" type="button" role="tab"
                                        aria-controls="person-fields" aria-selected="false">
                                        Person <span class="badge rounded-pill ms-1">{{ $personcount }}</span>
                                    </button>
                                </nav>
                            </div>

                            <div class="px-4 pb-4 pt-3">
                                <!-- Tab Content -->
                                <div class="tab-content" id="sidebar-tabContent">
                                    
                                    <!-- Lead Fields -->
                                    <div class="tab-pane fade show active" id="lead-fields" role="tabpanel"
                                        aria-labelledby="all-fields-tab">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="mb-0 text-uppercase">TAGS ({{ $leadcount }})</h6>
                                            <a href="javascript:void(0);" class="btn btn-export" onclick="addTag(1)">Add Lead Tag</a>
                                        </div>
                                        <table class="table w-100 equipment-report-table mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Tag</th>
                                                    <th scope="col">Color</th>
                                                    <th scope="col">Count</th>
                                                    <th scope="col">Created by</th>
                                                    <th scope="col">Created time</th>
                                                    <th scope="col" class="text-end">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($leadtags as $leadtag)
                                                <tr>
                                                    <td>{{ $leadtag->name }}</td>
                                                    <td>
                                                        <div class="color-swatch-picker">
                                                            <div class="color-swatch" style="background-color: {{ $leadtag->color }};"></div>
                                                        </div>
                                                    </td>
                                                    <td>40- static</td>
                                                    <td class="text-danger">{{ $leadtag->user->name ?? 'N/A' }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($leadtag->created_at)->format('F jS, Y') }}</td>
                                                    <td class="text-end">
                                                        <a href="javascript:void(0);" class="btn btn-outline-primary btn-sm btn-edit-tag"
                                                            data-id="{{ $leadtag->id }}" data-name="{{ $leadtag->name }}"
                                                            data-color="{{ $leadtag->color }}" data-tag_id="{{ $leadtag->tag_id }}">
                                                            Edit
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Company Fields -->
                                    <div class="tab-pane fade" id="company-fields" role="tabpanel"
                                        aria-labelledby="archived-fields-tab">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="mb-0 text-uppercase">TAGS ({{ $companycount }})</h6>
                                            <a href="javascript:void(0);" class="btn btn-export" onclick="addTag(2)">Add Company Tag</a>
                                        </div>
                                        <table class="table w-100 equipment-report-table mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Tag</th>
                                                    <th scope="col">Color</th>
                                                    <th scope="col">Count</th>
                                                    <th scope="col">Created by</th>
                                                    <th scope="col">Created time</th>
                                                    <th scope="col" class="text-end">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($companytags as $companytag)
                                                <tr>
                                                    <td>{{ $companytag->name }}</td>
                                                    <td>
                                                        <div class="color-swatch-picker">
                                                            <div class="color-swatch" style="background-color: {{ $companytag->color }};"></div>
                                                        </div>
                                                    </td>
                                                    <td>40- static</td>
                                                    <td class="text-danger">{{ $companytag->user->name ?? 'N/A'}}</td>
                                                    <td>{{ \Carbon\Carbon::parse($companytag->created_at)->format('F jS, Y') }}</td>
                                                    <td class="text-end">
                                                        <a href="javascript:void(0);" class="btn btn-outline-primary btn-sm btn-edit-tag"
                                                            data-id="{{ $companytag->id }}" data-name="{{ $companytag->name }}"
                                                            data-color="{{ $companytag->color }}" data-tag_id="{{ $companytag->tag_id }}">
                                                            Edit
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Person Fields -->
                                    <div class="tab-pane fade" id="person-fields" role="tabpanel"
                                        aria-labelledby="person-fields-tab">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="mb-0 text-uppercase">TAGS ({{ $personcount }})</h6>
                                            <a href="javascript:void(0);" class="btn btn-export" onclick="addTag(3)">Add Person Tag</a>
                                        </div>
                                        <table class="table w-100 equipment-report-table mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Tag</th>
                                                    <th scope="col">Color</th>
                                                    <th scope="col">Count</th>
                                                    <th scope="col">Created by</th>
                                                    <th scope="col">Created time</th>
                                                    <th scope="col" class="text-end">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($persontags as $persontag)
                                                <tr>
                                                    <td>{{ $persontag->name }}</td>
                                                    <td>
                                                        <div class="color-swatch-picker">
                                                            <div class="color-swatch" style="background-color: {{ $persontag->color }};"></div>
                                                        </div>
                                                    </td>
                                                    <td>40- static</td>
                                                    <td class="text-danger">{{ $persontag->user->name ?? 'N/A'}}</td>
                                                    <td>{{ \Carbon\Carbon::parse($persontag->created_at)->format('F jS, Y') }}</td>
                                                    <td class="text-end">
                                                        <a href="javascript:void(0);" class="btn btn-outline-primary btn-sm btn-edit-tag"
                                                            data-id="{{ $persontag->id }}" data-name="{{ $persontag->name }}"
                                                            data-color="{{ $persontag->color }}" data-tag_id="{{ $persontag->tag_id }}">
                                                            Edit
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                </div>

                                <!-- Global Info Section Footer -->
                                <div class="info-box">
                                    <div class="info-icon">
                                        <i class="fas fa-bookmark"></i>
                                    </div>
                                    <div class="info-title">What are tags?</div>
                                    <div class="info-text">
                                        Use tags to classify and group your leads, companies, and people.
                                        Any user can add tags to an entity, and administrators can manage
                                        all tags.
                                    </div>
                                    <a href="#" class="info-link">
                                        <i class="fas fa-external-link-alt me-1"></i>
                                        Read more about tags
                                    </a>
                                </div>
                                
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- All Companies Section End  -->


    </main>

    {{-- Tag modal --}}
    <div class="modal fade" id="add_tag" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        {{-- Just remove modal-fullscreen from below class , to get a popup instead of full modal --}}
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="exampleModalLabel">Add a tag</h1>
                    <div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
                <div class="modal-body ps-0">

                    <form class="company-form" action="{{ route('admin.settings.tag.store') }}" method="post"
                        id="store_tag">
                        @csrf

                        <input type="hidden" name="tag_id" id="tag_id" value="">

                        <div class="row mx-0">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" placeholder="" name="name" class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Color <span class="text-danger">*</span></label>
                                    <input type="hidden" name="color" id="selectedColor"> {{-- Will store selected hex --}}
                                    <div class="d-flex flex-wrap gap-2 mt-2" id="colorOptions">
                                        @foreach ($colors as $color)
                                            <div class="color-circle" style="background-color: {{ $color }};"
                                                data-color="{{ $color }}">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success" id="AddTag">New Tag</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Tag Modal --}}
    <div class="modal fade" id="edit_tag" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="editModalLabel">Edit tag</h1>
                    <div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
                <div class="modal-body ps-0">
                    <form class="company-form" action="" method="post" id="update_tag_form">
                        @csrf
                        <input type="hidden" name="tag_id" id="edit_tag_id" value="">
                        
                        <div class="row mx-0">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" placeholder="" name="name" id="edit_name" class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Color <span class="text-danger">*</span></label>
                                    <input type="hidden" name="color" id="edit_selectedColor">
                                    <div class="d-flex flex-wrap gap-2 mt-2" id="editColorOptions">
                                        @foreach ($colors as $color)
                                            <div class="color-circle edit-color-circle" style="background-color: {{ $color }};"
                                                data-color="{{ $color }}">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success" id="UpdateTagBtn">Save Changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>

@endsection


@push('scripts')
    {{-- <script>
    function setTagId(el) {
        const tagId = el.getAttribute('data-tag-id');
        document.getElementById('tag_id').value = tagId;
    } --}}
    </script>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const colorOptions = document.querySelectorAll('.color-circle');
            const colorInput = document.getElementById('selectedColor');

            colorOptions.forEach(option => {
                option.addEventListener('click', function() {
                    // Remove 'selected' class from all
                    colorOptions.forEach(o => o.classList.remove('selected'));

                    // Add 'selected' class to clicked one
                    this.classList.add('selected');

                    // Set value to hidden input
                    colorInput.value = this.dataset.color;
                });
            });

            // Edit Modal Color Picker
            const editColorOptions = document.querySelectorAll('.edit-color-circle');
            const editColorInput = document.getElementById('edit_selectedColor');

            editColorOptions.forEach(option => {
                option.addEventListener('click', function() {
                    editColorOptions.forEach(o => o.classList.remove('selected'));
                    this.classList.add('selected');
                    editColorInput.value = this.dataset.color;
                });
            });
        });
    </script>

    <script>
        //   function addTag() {
        //     $('#add_tag').modal('show');
        // }
        function addTag(tagId) {
            $('#tag_id').val(tagId); // Set hidden input
            $('#add_tag').modal('show');
        }


        $("#store_tag").validate({
            ignore: [],
            rules: {
                name: {
                    required: true
                },
                color: {
                    required: true
                },
            },
            messages: {
                name: {
                    required: "Please enter the competitor name."
                },
                color: {
                    required: "Please select the color."
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


        $('#store_tag').submit(function(e) {
            e.preventDefault();

            if (!$('#store_tag').valid()) {
                return; // Stop if validation fails
            }

            $.ajax({
                url: "{{ route('admin.settings.tag.store') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    toastr.success(response.message || 'Tag added successfully!');
                    $('#add_tag').modal('hide');
                    console.log(response);
                    setTimeout(function(){ location.reload(); }, 1000);
                },
                error: function(xhr) {
                    toastr.error('Something went wrong while adding new tag.');
                }
            });
        });


        // Edit button click handler
        $(document).on('click', '.btn-edit-tag', function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var color = $(this).data('color');
            var tag_id = $(this).data('tag_id');

            $('#edit_tag_id').val(tag_id);
            $('#edit_name').val(name);
            $('#edit_selectedColor').val(color);

            // Pre-select color circle
            $('.edit-color-circle').removeClass('selected');
            $('.edit-color-circle').each(function() {
                if($(this).data('color') === color) {
                    $(this).addClass('selected');
                }
            });

            // Set form action route
            var updateUrl = "{{ route('admin.settings.tag.update', ':id') }}";
            updateUrl = updateUrl.replace(':id', id);
            $('#update_tag_form').attr('action', updateUrl);

            $('#edit_tag').modal('show');
        });

        $("#update_tag_form").validate({
            ignore: [],
            rules: {
                name: { required: true },
                color: { required: true },
            },
            messages: {
                name: { required: "Please enter the tag name." },
                color: { required: "Please select the color." },
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

        $('#update_tag_form').submit(function(e) {
            e.preventDefault();
            if (!$(this).valid()) return;

            var submitBtn = $('#UpdateTagBtn');
            var originalText = submitBtn.text();
            submitBtn.prop('disabled', true).text('Saving...');

            $.ajax({
                url: $(this).attr('action'),
                method: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    toastr.success(response.message || 'Tag updated successfully.');
                    $('#edit_tag').modal('hide');
                    setTimeout(function(){ location.reload(); }, 1000);
                },
                error: function(xhr) {
                    submitBtn.prop('disabled', false).text(originalText);
                    toastr.error('Something went wrong while updating the tag.');
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

        // Reset modals when closed
        $('#add_tag').on('hidden.bs.modal', function () {
            $('#store_tag')[0].reset();
            $('#store_tag').validate().resetForm();
            $('#store_tag').find('.is-invalid').removeClass('is-invalid');
            $('.color-circle').removeClass('selected');
            $('#selectedColor').val('');
        });

        $('#edit_tag').on('hidden.bs.modal', function () {
            $('#update_tag_form')[0].reset();
            $('#update_tag_form').validate().resetForm();
            $('#update_tag_form').find('.is-invalid').removeClass('is-invalid');
            $('.edit-color-circle').removeClass('selected');
            $('#edit_selectedColor').val('');
        });

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
