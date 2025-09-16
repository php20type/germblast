@extends('admin.includes.layout')

@section('title', 'Tags')

@section('content')


    <main class="app-wrapper">
        <!-- All Companies Section start  -->
        <div class="profile-section my-4">
            <div class="container-fluid">
                <div class="row">
                    <!-- Sidebar -->
                    @include('admin.settings.sidebar')

                    <!-- Main Content -->
                    <div class="col-md-10 p-0">
                        <div class="activity-type-content">
                            <div class="heading-area-sec">
                                <div class="left-part-sec">
                                    <h3 class="mb-1 fw-bold">Tags</h3>
                                    <p class="text-muted mb-0">Create tags to organize companies, people, and leads
                                        into groups.</p>
                                </div>
                                <hr>
                            </div>
                            <div class="main-container">
                                <div class="row">
                                    <!-- Sidebar -->
                                    <div class="col-md-3">
                                        <div class="sidebar-section">
                                            <h6 class="sidebar-title mt-3 mb-2 fw-bold">Tags</h6>
                                            <ul class="nav nav-pills flex-column" id="sidebar-tabs" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link active sidebar-item" id="all-fields-tab"
                                                        data-bs-toggle="pill" data-tag-type="lead"
                                                        data-bs-target="#lead-fields" type="button" role="tab"
                                                        aria-controls="all-fields" aria-selected="true">
                                                        Lead <span class="sidebar-count"> {{ $leadcount }} <i
                                                                class="fa-regular fa-chevron-right"></i></span>

                                                    </button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link sidebar-item" id="archived-fields-tab"
                                                        data-bs-toggle="pill" data-bs-target="#company-fields"
                                                        data-tag-type="company" type="button" role="tab"
                                                        aria-controls="archived-fields" aria-selected="false">
                                                        Company
                                                        <span class="sidebar-count">{{ $companycount }} <i
                                                                class="fa-regular fa-chevron-right"></i></span>
                                                    </button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link sidebar-item" id="person-fields-tab"
                                                        data-bs-toggle="pill" data-bs-target="#person-fields" type="button"
                                                        data-tag-type="people" role="tab" aria-controls="person-fields"
                                                        aria-selected="false">
                                                        Person
                                                        <span class="sidebar-count">{{ $personcount }} <i
                                                                class="fa-regular fa-chevron-right"></i></span>
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>

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

                                    <!-- Content Area -->
                                    <div class="col-md-9 content-area">
                                        <!-- Tab Content -->
                                        <div class="tab-content" id="sidebar-tabContent">
                                            <div class="tab-pane fade show active" id="lead-fields" role="tabpanel"
                                                aria-labelledby="all-fields-tab">

                                                <div class="table-container">
                                                    <div class="d-flex justify-content-between align-items-center my-3">
                                                        <h6 class="fw-bold mb-0">Tag ({{ $leadcount }})</h6>
                                                        {{-- <a href="#" class="btn-add-activity">Add Tag</a> --}}
                                                        <a href="javascript:void(0);" class="btn-add-activity" onclick="addTag(1)">Add Lead Tag</a>


                                                    </div>

                                                    <div class="table-responsive">
                                                        <table class="table activity-table">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">Tag</th>
                                                                    <th scope="col">Color</th>
                                                                    <th scope="col">Count</th>
                                                                    <th scope="col">Created by</th>
                                                                    <th scope="col">Last used</th>
                                                                    <th scope="col">Created time</th>
                                                                    <th scope="col" class="text-end">Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($leadtags as $leadtag)

                                                                <tr>
                                                                    <td>
                                                                        {{ $leadtag->name }}
                                                                    </td>
                                                                    <td>
                                                                        <div class="color-swatch-picker">
                                                                            <div class="color-swatch"
                                                                                style="background-color: {{ $leadtag->color }};">
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>40- static</td>
                                                                    <td class="text-danger">{{ $leadtag->user->name }}</td>
                                                                    <td>September 21st, 2022</td>
                                                                    <td>{{ \Carbon\Carbon::parse($leadtag->created_at)->format('F jS, Y') }}</td>
                                                                    <td class="text-end">
                                                                        <a class="text-dark" href="javascript:void(0)"
                                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                                                        </a>
                                                                        <ul class="dropdown-menu dropdown-menu-end"
                                                                            style="">
                                                                            <li>
                                                                                <button class="dropdown-item"
                                                                                    type="button"
                                                                                    onclick="viewReport('Cloned Lead')">
                                                                                    <i class="fa-solid fa-chart-bar"></i>
                                                                                    View report
                                                                                </button>
                                                                            </li>

                                                                            <li>
                                                                                <hr class="dropdown-divider">
                                                                            </li>
                                                                            <li>
                                                                                <button class="dropdown-item text-danger"
                                                                                    type="button"
                                                                                    onclick="deleteItem('Cloned Lead')">
                                                                                    <i class="fa-solid fa-trash"></i>
                                                                                    Delete
                                                                                </button>
                                                                            </li>
                                                                        </ul>
                                                                    </td>
                                                                </tr>
                                                                @endforeach

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="company-fields" role="tabpanel"
                                                aria-labelledby="archived-fields-tab">

                                                <div class="table-container">
                                                    <div class="d-flex justify-content-between align-items-center my-3">
                                                        <h6 class="fw-bold mb-0">Tag ({{ $companycount }})</h6>
                                                        {{-- <a href="#" class="btn-add-activity">Add Tag</a> --}}
                                                        <a href="javascript:void(0);" class="btn-add-activity"
                                                            data-tag-id="2" onclick="addTag(2)">Add Company Tag</a>

                                                    </div>
                                                    <div class="table-responsive">
                                                        <table class="table activity-table">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">Tag</th>
                                                                    <th scope="col">Color</th>
                                                                    <th scope="col">Count</th>
                                                                    <th scope="col">Created by</th>
                                                                    <th scope="col">Last used</th>
                                                                    <th scope="col">Created time</th>
                                                                    <th scope="col" class="text-end">Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                               @foreach ($companytags as $companytag)

                                                                <tr>
                                                                    <td>
                                                                        {{ $companytag->name }}
                                                                    </td>
                                                                    <td>
                                                                        <div class="color-swatch-picker">
                                                                            <div class="color-swatch"
                                                                                style="background-color: {{ $companytag->color }};">
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>40- static</td>
                                                                    <td class="text-danger">{{ $companytag->user->name }}</td>
                                                                    <td>September 21st, 2022</td>
                                                                    <td>{{ \Carbon\Carbon::parse($companytag->created_at)->format('F jS, Y') }}</td>
                                                                    <td class="text-end">
                                                                        <a class="text-dark" href="javascript:void(0)"
                                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                                                        </a>
                                                                        <ul class="dropdown-menu dropdown-menu-end"
                                                                            style="">
                                                                            <li>
                                                                                <button class="dropdown-item"
                                                                                    type="button"
                                                                                    onclick="viewReport('Cloned Lead')">
                                                                                    <i class="fa-solid fa-chart-bar"></i>
                                                                                    View report
                                                                                </button>
                                                                            </li>

                                                                            <li>
                                                                                <hr class="dropdown-divider">
                                                                            </li>
                                                                            <li>
                                                                                <button class="dropdown-item text-danger"
                                                                                    type="button"
                                                                                    onclick="deleteItem('Cloned Lead')">
                                                                                    <i class="fa-solid fa-trash"></i>
                                                                                    Delete
                                                                                </button>
                                                                            </li>
                                                                        </ul>
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="person-fields" role="tabpanel"
                                                aria-labelledby="person-fields-tab">

                                                <div class="table-container">
                                                    <div class="d-flex justify-content-between align-items-center my-3">
                                                        <h6 class="fw-bold mb-0">Tag ({{ $personcount }})</h6>
                                                        {{-- <a href="#" class="btn-add-activity">Add Tag</a> --}}
                                                        <a href="javascript:void(0);" class="btn-add-activity"
                                                            data-tag-id="3" onclick="addTag(3)">Add Person Tag</a>
                                                    </div>
                                                    <table class="table activity-table">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Tag</th>
                                                                <th scope="col">Color</th>
                                                                <th scope="col">Count</th>
                                                                <th scope="col">Created by</th>
                                                                <th scope="col">Last used</th>
                                                                <th scope="col">Created time</th>
                                                                <th scope="col" class="text-end">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                             @foreach ($persontags as $persontag)

                                                                <tr>
                                                                    <td>
                                                                        {{ $persontag->name }}
                                                                    </td>
                                                                    <td>
                                                                        <div class="color-swatch-picker">
                                                                            <div class="color-swatch"
                                                                                style="background-color: {{ $persontag->color }};">
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>40- static</td>
                                                                    <td class="text-danger">{{ $persontag->user->name }}</td>
                                                                    <td>September 21st, 2022</td>
                                                                    <td>{{ \Carbon\Carbon::parse($persontag->created_at)->format('F jS, Y') }}</td>
                                                                    <td class="text-end">
                                                                        <a class="text-dark" href="javascript:void(0)"
                                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                                                        </a>
                                                                        <ul class="dropdown-menu dropdown-menu-end"
                                                                            style="">
                                                                            <li>
                                                                                <button class="dropdown-item"
                                                                                    type="button"
                                                                                    onclick="viewReport('Cloned Lead')">
                                                                                    <i class="fa-solid fa-chart-bar"></i>
                                                                                    View report
                                                                                </button>
                                                                            </li>

                                                                            <li>
                                                                                <hr class="dropdown-divider">
                                                                            </li>
                                                                            <li>
                                                                                <button class="dropdown-item text-danger"
                                                                                    type="button"
                                                                                    onclick="deleteItem('Cloned Lead')">
                                                                                    <i class="fa-solid fa-trash"></i>
                                                                                    Delete
                                                                                </button>
                                                                            </li>
                                                                        </ul>
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
                                    <label class="form-label">Name</label>
                                    <input type="text" placeholder="" name="name" class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Color</label>
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
                    alert('Tag added successfully!');
                    $('#add_tag').modal('hide');
                    console.log(response);
                    location.reload();

                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseText);
                    toastr.error('Something went wrong while adding new tag.');
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
