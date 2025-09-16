@extends('admin.includes.layout')

@section('title', 'Activity Type')

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
                        <div class="defaults-card">
                            <div class="heading-area-sec">
                                <div class="left-part-sec">
                                    <h3 class="mb-1 fw-bold">Defaults</h3>
                                </div>
                                <hr>
                            </div>
                            <div class="form-row mb-3">
                                <label for="newActivities" class="form-label">
                                    New activities
                                    <span class="info-icon" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-title="The activity type that will be selected by default when creating a new activity."><i
                                            class="fa-regular fa-circle-info"></i></span>
                                </label>
                                <select class="form-select" id="newActivities">
                                    @foreach ($activity_types as $activity_type)
                                        <option value="{{ $activity_type->id }}">
                                            <span class="activity-icon">👥</span>
                                            {{ $activity_type->type }}
                                        </option>
                                    @endforeach
                                    {{-- <option selected>
                                            <span class="activity-icon">👥</span>
                                            Sales - Initial Meeting/Prospecting
                                        </option> --}}
                                </select>
                            </div>

                            <div class="form-row mb-3">
                                <label for="schedulerMeetings" class="form-label">
                                    Scheduler meetings
                                    <span class="info-icon" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-title="The activity type that will be selected by default when creating a new scheduler meeting."><i
                                            class="fa-regular fa-circle-info"></i></span>
                                </label>
                                <select class="form-select" id="schedulerMeetings">
                                    @foreach ($activity_types as $activity_type)
                                        <option value="{{ $activity_type->id }}">
                                            <span class="activity-icon">📅</span>
                                            {{ $activity_type->type }}
                                        </option>
                                    @endforeach
                                    {{-- <option selected>
                                            <span class="activity-icon">📅</span>
                                            Sales - Renewal Contract Delivered
                                        </option> --}}
                                </select>
                            </div>

                            <div class="form-row mb-3">
                                <label for="clickToCallCalls" class="form-label">
                                    Click-to-call calls
                                    <span class="info-icon" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-title="The activity type that will be used when activities are created for click-to-call events."><i
                                            class="fa-regular fa-circle-info"></i></span>
                                </label>
                                <select class="form-select" id="clickToCallCalls">
                                    @foreach ($activity_types as $activity_type)
                                        <option value="{{ $activity_type->id }}">
                                            <span class="activity-icon">📅</span>
                                            {{ $activity_type->type }}
                                        </option>
                                    @endforeach
                                    {{-- <option selected>
                                            <span class="activity-icon">📅</span>
                                            Account Maintenance Visit
                                        </option> --}}
                                </select>
                            </div>

                            <div class="form-row mb-3">
                                <label for="clickToCallVoicemails" class="form-label">
                                    Click-to-call voicemails
                                    <span class="info-icon" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-title="The activity type that will be used when activities are created for click-to-call voicemails."><i
                                            class="fa-regular fa-circle-info"></i></span>
                                </label>
                                <select class="form-select" id="clickToCallVoicemails">
                                    @foreach ($activity_types as $activity_type)
                                        <option value="{{ $activity_type->id }}">
                                            <span class="activity-icon">📞</span>
                                            {{ $activity_type->type }}
                                        </option>
                                    @endforeach
                                    {{-- <option selected>
                                        <span class="activity-icon">📞</span>
                                        Voicemail
                                    </option> --}}
                                </select>
                            </div>

                            <div class="form-row mb-3">
                                <label for="virtualMeetings" class="form-label">
                                    Virtual meetings
                                    <span class="info-icon" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-title="The activity type that will be selected by default when logging virtual meetings."><i
                                            class="fa-regular fa-circle-info"></i></span>
                                </label>
                                <select class="form-select" id="virtualMeetings">
                                    @foreach ($activity_types as $activity_type)
                                        <option value="{{ $activity_type->id }}">
                                            <span class="activity-icon">📅</span>
                                            {{ $activity_type->type }}
                                        </option>
                                    @endforeach
                                    {{-- <option selected>
                                        <span class="activity-icon">📅</span>
                                        Account Maintenance Visit
                                    </option> --}}
                                </select>
                            </div>
                        </div>
                        <div class="activity-type-content">
                            <div class="heading-area-sec">
                                <div class="left-part-sec">
                                    <h3 class="mb-1 fw-bold">Activity types</h3>
                                    <p class="text-muted mb-0">Customize the activities that your team uses to
                                        communicate with contacts.</p>
                                </div>
                                <hr>
                            </div>

                            <div class="table-container">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-bold mb-0">ACTIVITY TYPES ({{ $totalCounts }})</h6>
                                    <a href="javascript:void(0);" class="btn-add-activity" id="toggleAddActivityType" onclick="addActivityType()">Add Activity Type</a>
                                </div>

                                <div class="table-responsive">
                                    <table class="table activity-table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Name</th>
                                                <th scope="col">Activities in the last 12 months</th>
                                                <th scope="col">Last activity time</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- <tr>
                                                <td>Phone Call</td>
                                                <td class="activity-count">690</td>
                                                <td class="last-activity">17 May 2025, 01:03</td>
                                                <td><a href="#" class="report-link">Report</a></td>
                                            </tr> --}}
                                            @foreach ($activity_types as $activity_type)
                                                <tr>
                                                    <td>{{ $activity_type->type }}</td>
                                                    <td class="activity-count">
                                                        {{ $activityCounts[$activity_type->id] ?? 0 }}</td>
                                                    <td class="last-activity">
                                                        {{ \Carbon\Carbon::parse($activity_type->created_at)->format('d M Y, H:i') }}
                                                    </td>
                                                    <td><a href="#" class="report-link">Report</a></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="info-section">
                                <div class="info-cards">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6>WHY TRACK ACTIVITY TYPES?</h6>
                                        <a href="#" class="view-quotas-link">View activity quotas</a>
                                    </div>
                                    <p>Every activity has an activity type. You can define different benchmarks
                                        per activity type, for example, a sales rep should log 15 cold calls per
                                        week and 5 follow-up calls.</p>
                                </div>
                                <div class="info-cards">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6>REPORTING ON ACTIVITY TYPES</h6>
                                        <a href="#" class="view-quotas-link">View activity quotas</a>
                                    </div>
                                    <p>The activity report helps you see what team members have been up to and
                                        how your team is performing against their quotas.</p>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- All Companies Section End  -->
    </main>

    {{-- Activity type modal --}}
    <div class="modal fade" id="add_activity_type" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="exampleModalLabel">Create Activity Type</h1>
                    <div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
                <div class="modal-body ps-0">

                    <form class="company-form" action="{{ route('admin.settings.activity_type.store') }}" method="post" id="store_activity_type">
                        @csrf


                        <div class="row mx-0">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Name</label>
                                    <input type="text" placeholder="Phone Call" name="name"
                                        class="form-control" />
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Icon</label>
                                    <input type="text" placeholder="" name="icon"
                                        class="form-control" />
                                </div>
                            </div>

                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success" id="AddActivityType">Create activity type</button>
                </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>

        function addActivityType() {
            $('#add_activity_type').modal('show');
        }

         $("#store_activity_type").validate({
            ignore: [],
            rules: {
                name: {
                    required: true
                },
                icon: {
                    required: true
                },
            },
            messages: {
                name: {
                    required: "Please enter the activity type name."
                },
                icon: {
                    required: "Please select the icon."
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


        $('#store_activity_type').submit(function(e) {
            e.preventDefault();

            if (!$('#store_activity_type').valid()) {
                return; // Stop if validation fails
            }

            $.ajax({
                url: "{{ route('admin.settings.activity_type.store') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    alert('Activity Type added successfully!');
                    $('#add_activity_type').modal('hide');
                    console.log(response);
                    location.reload();

                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseText);
                    toastr.error('Something went wrong while adding the activity type.');
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
