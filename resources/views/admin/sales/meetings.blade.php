@extends('admin.includes.layout')

@section('title', 'Schedule Meeting')

@section('content')
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                @include('admin.sales.sidebar')

                <!-- Main Content -->
                <div class="col-md-10 p-0">
                    <div class="main-content">
                        <!-- Header -->
                        <div class="heading-area-sec">
                            <div class="left-part-sec">
                                <h3 class="mb-1">Schedule New Meeting <i class="fas fa-thumbtack pinned-icon"></i></h3>
                                <p class="text-muted mb-0">Schedule and manage internal or client meetings</p>
                            </div>
                            <div class="right-part">
                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#AddMeeting">
                                    Add New Meeting
                                </button>
                            </div>
                        </div>

                        <!-- Filter Section -->
                        <div class="filter-section">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center position-relative">
                                        <div class="search-form">
                                            {{-- <input type="search" class="form-control" placeholder="" aria-label="Search"
                                                id="company-search"> --}}
                                            <input type="search" class="form-control" id="meeting-search"
                                                placeholder="Search meeting name">
                                        </div>
                                        {{-- <span class="company-count">Meetings Found</span> --}}
                                        <span class="company-count">{{ $meetingsCount }} Meetings Found</span>
                                    </div>
                                </div>
                                <div class="col-md-6 ">
                                    <div class="d-flex align-items-center justify-content-end dropdown">
                                        <div class="me-2">
                                            {{-- <select class="form-select" aria-label="Default select example"
                                                name="company_type_id">
                                                <option value="">Meeting Type</option>
                                                <option value="zoom">Zoom</option>
                                                <option value="live">Live</option>
                                            </select> --}}
                                            <select class="form-select" id="meeting-type" name="meeting_type">
                                                <option value="">Meeting Type</option>
                                                <option value="zoom">Zoom</option>
                                                <option value="live">Live</option>
                                            </select>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="table-responsive">
                            <div class="table-container mt-3">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="checkbox-cell">
                                                <input type="checkbox" class="form-check-input" id="selectAll">
                                            </th>
                                            <th>Meeting Name</th>
                                            <th>Type</th>
                                            <th>Date & Time</th>
                                            <th>Duration</th>
                                            <th>Activity Type</th>
                                            <th>Status</th>
                                            <th>Location / Link</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($meetings as $meeting)
                                            <tr>
                                                {{-- Checkbox --}}
                                                <td class="checkbox-cell">
                                                    <input type="checkbox" class="form-check-input row-checkbox"
                                                        data-id="{{ $meeting->id }}">
                                                </td>

                                                {{-- Meeting Name --}}
                                                <td>
                                                    <strong>{{ $meeting->name }}</strong>
                                                </td>

                                                {{-- Type --}}
                                                <td>
                                                    @if ($meeting->meeting_type === 'zoom')
                                                        <span class="badge bg-primary">Zoom</span>
                                                    @else
                                                        <span class="badge bg-success">Live</span>
                                                    @endif
                                                </td>

                                                {{-- Date & Time --}}
                                                <td>
                                                    {{ \Carbon\Carbon::parse($meeting->date)->format('d M Y') }}<br>
                                                    <small class="text-muted">
                                                        {{ \Carbon\Carbon::parse($meeting->start_time)->format('h:i A') }}
                                                        –
                                                        {{ \Carbon\Carbon::parse($meeting->end_time)->format('h:i A') }}
                                                    </small>
                                                </td>

                                                {{-- Duration --}}
                                                <td>
                                                    {{ $meeting->duration }} mins
                                                </td>

                                                {{-- Activity Type --}}
                                                <td>
                                                    {{ $meeting->activityType->type ?? '-' }}
                                                </td>

                                                {{-- Status --}}
                                                <td>
                                                    @php
                                                        $status = $meeting->zoom->status ?? $meeting->status;
                                                    @endphp

                                                    <span class="badge bg-secondary">
                                                        {{ ucfirst($status) }}
                                                    </span>
                                                </td>

                                                {{-- Location / Join Link --}}
                                                <td>
                                                    @if ($meeting->meeting_type === 'zoom' && $meeting->zoom?->join_url)
                                                        <a href="{{ $meeting->zoom->join_url }}" target="_blank"
                                                            class="btn btn-sm btn-outline-primary">
                                                            Join Zoom
                                                        </a>
                                                    @else
                                                        {{ $meeting->location }}
                                                    @endif
                                                </td>

                                                {{-- Actions --}}
                                                <td>
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-primary edit-meeting"
                                                        data-id="{{ $meeting->id }}">
                                                        <i class="fa fa-edit"></i>
                                                    </button>

                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger delete-meeting"
                                                        data-id="{{ $meeting->id }}">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center text-muted">
                                                    No meetings scheduled.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>

                                </table>
                            </div>
                        </div>

                        <!-- Action Bar -->
                        <div class="action-bar" id="actionBar">
                            <div class="d-flex align-items-center justify-content-center">
                                <span class="me-3"><strong id="selectedCount">1</strong> Selected</span>
                                <button class="btn btn-delete btn-action">DELETE</button>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
            <!-- All Companies Section End  -->

        </div>

    </div>

    <div class="modal fade" id="AddMeeting" tabindex="-1" aria-labelledby="meetingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">

                <div class="modal-header">
                    <h1 class="modal-title" id="meetingModalLabel">Schedule a Meeting</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('admin.sales.store.meeting') }}" method="POST" class="meeting-form"
                        id="add-meeting-form">
                        @csrf

                        <div class="row mx-0">

                            {{-- Meeting Name --}}
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Meeting Name</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="name" placeholder="Enter meeting name"
                                        class="form-control" />
                                </div>
                            </div>

                            {{-- Duration --}}
                            <div class="col-lg-12 mt-2">
                                <div class="form-group">
                                    <label class="form-label">Duration</label>
                                    <span class="text-danger">*</span>
                                    <select name="duration" class="form-select">
                                        <option value="">Choose...</option>
                                        <option value="5">5 Minutes</option>
                                        <option value="10">10 Minutes</option>
                                        <option value="15">15 Minutes</option>
                                        <option value="20">20 Minutes</option>
                                        <option value="25">25 Minutes</option>
                                        <option value="30" selected>30 Minutes</option>
                                        <option value="45">45 Minutes</option>
                                        <option value="60">1 Hour</option>
                                        <option value="75">1.25 Hours</option>
                                        <option value="90">1.5 Hours</option>
                                        <option value="120">2 Hours</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Date --}}
                            <div class="col-lg-12 mt-2">
                                <div class="form-group">
                                    <label class="form-label">Meeting Date</label>
                                    <input type="text" name="meeting_date" placeholder="" class="form-control"
                                        id="meeting_date" />
                                </div>
                            </div>

                            {{-- Start Time --}}
                            <div class="col-lg-6 mt-2">
                                <div class="form-group">
                                    <label class="form-label">Start Time</label>
                                    <select class="form-select select2" id="start_time" name="start_time"
                                        required></select>
                                </div>
                            </div>

                            {{-- End Time --}}
                            <div class="col-lg-6 mt-2">
                                <div class="form-group">
                                    <label class="form-label">End Time</label>
                                    <select class="form-select select2" id="end_time" name="end_time" required></select>
                                </div>
                            </div>

                            {{-- Meeting Type --}}
                            <div class="col-lg-12 mt-2">
                                <div class="form-group">
                                    <label class="form-label">Meeting Type</label>
                                    <select name="meeting_type" class="form-select">
                                        <option value="">Choose...</option>
                                        <option value="zoom">Zoom Meeting</option>
                                        <option value="live">Live (In-Person)</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Location --}}
                            <div class="col-lg-12 mt-2" id="locationField">
                                <div class="form-group">
                                    <label class="form-label">Location</label>
                                    <input type="text" name="location" class="form-control"
                                        placeholder="Office, Site, Google Meet, Zoom URL etc..." />
                                </div>
                            </div>

                            {{-- Activity Type --}}
                            <div class="col-lg-12 mt-2">
                                <div class="form-group">
                                    <label class="form-label">Activity Type</label>
                                    <select class="form-select mt-2" name="activity_type_id">
                                        <option selected>Choose...</option>
                                        @foreach ($activity_types as $activity_type)
                                            <option value="{{ $activity_type->id }}">
                                                {{ $activity_type->type }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Description --}}
                            <div class="col-lg-12 mt-2">
                                <div class="form-group">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" rows="4" class="form-control" placeholder="Meeting purpose, agenda, notes..."></textarea>
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer mt-4">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                            <button type="submit" class="btn btn-primary" id="submitMeetingBtn">Save Meeting</button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="EditMeeting" tabindex="-1" aria-labelledby="editMeetingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">

                <div class="modal-header">
                    <h1 class="modal-title" id="editMeetingModalLabel">Edit Meeting</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form action="" method="POST" class="meeting-form" id="edit-meeting-form">
                        @csrf

                        <div class="row mx-0">

                            {{-- Meeting Name --}}
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Meeting Name</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="name" placeholder="Enter meeting name"
                                        class="form-control" />
                                </div>
                            </div>

                            {{-- Duration --}}
                            <div class="col-lg-12 mt-2">
                                <div class="form-group">
                                    <label class="form-label">Duration</label>
                                    <span class="text-danger">*</span>
                                    <select name="duration" class="form-select">
                                        <option value="">Choose...</option>
                                        <option value="5">5 Minutes</option>
                                        <option value="10">10 Minutes</option>
                                        <option value="15">15 Minutes</option>
                                        <option value="20">20 Minutes</option>
                                        <option value="25">25 Minutes</option>
                                        <option value="30" selected>30 Minutes</option>
                                        <option value="45">45 Minutes</option>
                                        <option value="60">1 Hour</option>
                                        <option value="75">1.25 Hours</option>
                                        <option value="90">1.5 Hours</option>
                                        <option value="120">2 Hours</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Date --}}
                            <div class="col-lg-12 mt-2">
                                <div class="form-group">
                                    <label class="form-label">Meeting Date</label>
                                    <input type="text" name="meeting_date" id="edit_meeting_date"
                                        class="form-control edit-meeting-date" />
                                </div>
                            </div>

                            {{-- Start Time --}}
                            <div class="col-lg-6 mt-2">
                                <div class="form-group">
                                    <label class="form-label">Start Time</label>
                                    <select class="form-select select2 edit-start-time" name="start_time"
                                        required></select>
                                </div>
                            </div>

                            {{-- End Time --}}
                            <div class="col-lg-6 mt-2">
                                <div class="form-group">
                                    <label class="form-label">End Time</label>
                                    <select class="form-select select2 edit-end-time" name="end_time" required></select>
                                </div>
                            </div>

                            {{-- Meeting Type --}}
                            <div class="col-lg-12 mt-2">
                                <div class="form-group">
                                    <label class="form-label">Meeting Type</label>
                                    <select name="meeting_type" class="form-select">
                                        <option value="">Choose...</option>
                                        <option value="zoom">Zoom Meeting</option>
                                        <option value="live">Live (In-Person)</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Location --}}
                            <div class="col-lg-12 mt-2 edit-location-field">
                                <div class="form-group">
                                    <label class="form-label">Location</label>
                                    <input type="text" name="location" class="form-control"
                                        placeholder="Office, Site, Google Meet, Zoom URL etc..." />
                                </div>
                            </div>

                            {{-- Activity Type --}}
                            <div class="col-lg-12 mt-2">
                                <div class="form-group">
                                    <label class="form-label">Activity Type</label>
                                    <select class="form-select mt-2" name="activity_type_id">
                                        <option value="">Choose...</option>
                                        @foreach ($activity_types as $activity_type)
                                            <option value="{{ $activity_type->id }}">
                                                {{ $activity_type->type }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Description --}}
                            <div class="col-lg-12 mt-2">
                                <div class="form-group">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" rows="4" class="form-control" placeholder="Meeting purpose, agenda, notes..."></textarea>
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer mt-4">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Close
                            </button>

                            <button type="submit" class="btn btn-primary" id="updateMeetingBtn">
                                Update Meeting
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>



@endsection


@push('scripts')
    <script>
        function initMeetingTimeControls(modalSelector) {

            const modal = $(modalSelector);

            const startTimeSelect = modal.find('select[name="start_time"]');
            const endTimeSelect = modal.find('select[name="end_time"]');
            const durationSelect = modal.find('select[name="duration"]');

            function generateTimeOptions(interval) {
                const times = [];
                let time = moment().startOf('day');
                const end = moment().endOf('day');

                while (time.isSameOrBefore(end)) {
                    times.push({
                        value: time.format('HH:mm:ss'),
                        label: time.format('hh:mm A')
                    });
                    time.add(interval, 'minutes');
                }

                return times;
            }

            function populateTimeDropdowns(interval, selectedStart = null, selectedEnd = null) {

                startTimeSelect.empty().append('<option value="">Select Start Time</option>');
                endTimeSelect.empty().append('<option value="">Select End Time</option>');

                if (!interval) return;

                generateTimeOptions(interval).forEach(t => {
                    const option = `<option value="${t.value}">${t.label}</option>`;
                    startTimeSelect.append(option);
                    endTimeSelect.append(option);
                });

                if (selectedStart) {
                    startTimeSelect.val(selectedStart).trigger('change');
                }

                if (selectedEnd) {
                    endTimeSelect.val(selectedEnd).trigger('change');
                }
            }

            function filterEndTimes() {
                const startVal = startTimeSelect.val();

                if (!startVal) {
                    endTimeSelect.find('option').prop('disabled', false);
                    return;
                }

                const startMoment = moment(startVal, 'HH:mm:ss');

                endTimeSelect.find('option').each(function() {
                    const val = $(this).val();
                    if (!val) return;

                    const optionMoment = moment(val, 'HH:mm:ss');
                    $(this).prop('disabled', optionMoment.isSameOrBefore(startMoment));
                });

                if (endTimeSelect.find(':selected').prop('disabled')) {
                    endTimeSelect.val('');
                }
            }

            // Events
            durationSelect.off('change').on('change', function() {
                populateTimeDropdowns(parseInt(this.value));
            });

            startTimeSelect.off('change').on('change', filterEndTimes);

            // Init select2 (important: dropdownParent = modal)
            [startTimeSelect, endTimeSelect].forEach(select => {
                select.select2({
                    dropdownParent: modal,
                    width: '100%',
                    dropdownPosition: 'below'
                });
            });

            // Populate default duration (edit & add safe)
            const defaultDuration = parseInt(durationSelect.val());
            if (defaultDuration) {
                populateTimeDropdowns(defaultDuration);
            }

            modal.data('populateTimes', populateTimeDropdowns);
        }

        function isValidTimeByDuration(form) {
            const duration = parseInt(form.find('select[name="duration"]').val());
            const startTime = form.find('select[name="start_time"]').val();
            const endTime = form.find('select[name="end_time"]').val();

            if (!duration || !startTime || !endTime) return true;

            const start = moment(startTime, 'HH:mm:ss');
            const end = moment(endTime, 'HH:mm:ss');

            return end.diff(start, 'minutes') === duration;
        }



        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });


            flatpickr("#meeting_date", {
                dateFormat: "Y-m-d",
                minDate: "today",
                time_24hr: false
            });

            flatpickr("#edit_meeting_date", {
                dateFormat: "Y-m-d",
                minDate: "today",
                time_24hr: false
            });


            initMeetingTimeControls('#AddMeeting');
            initMeetingTimeControls('#EditMeeting');


            function fetchMeetings() {
                let search = $('#meeting-search').val();
                let meeting_type = $('#meeting-type').val();

                $.ajax({
                    url: "{{ route('admin.sales.schedule.meeting') }}",
                    method: "GET",
                    data: {
                        search: search,
                        meeting_type: meeting_type
                    },
                    success: function(response) {
                        $('table tbody').html(response.table);
                        $('.company-count').text(response.count + ' Meetings Found');
                    }
                });
            }

            $('#meeting-search').on('keyup', fetchMeetings);
            $('#meeting-type').on('change', fetchMeetings);

            $("#add-meeting-form").validate({
                ignore: [],
                rules: {
                    name: {
                        required: true
                    },
                    duration: {
                        required: true
                    },
                    meeting_date: {
                        required: true,
                        date: true
                    },
                    start_time: {
                        required: true
                    },
                    end_time: {
                        required: true
                    },
                    meeting_type: {
                        required: true
                    },
                    activity_type_id: {
                        required: true
                    },
                    description: {
                        required: true
                    },
                },
                messages: {
                    name: {
                        required: "Please enter the name"
                    },
                    duration: {
                        required: "Please select the duration"
                    },
                    meeting_date: {
                        required: "Please select the date",
                    },
                    start_time: {
                        required: "Please select the start time"
                    },
                    end_time: {
                        required: "Please select the end time"
                    },
                    meeting_type: {
                        required: "Please select the meeting type"
                    },
                    activity_type_id: {
                        required: "Please select the activity type"
                    },
                    description: {
                        required: "Please enter the description"
                    },
                },
                errorElement: 'span',
                errorClass: 'invalid-feedback d-block',
                highlight: function(el) {
                    $(el).addClass('is-invalid');
                },
                unhighlight: function(el) {
                    $(el).removeClass('is-invalid');
                }
            });

            $('#add-meeting-form').submit(function(e) {
                e.preventDefault();

                if (!$('#add-meeting-form').valid()) {
                    return;
                }

                if (!isValidTimeByDuration($('#add-meeting-form'))) {
                    toastr.error('Please select start and end time according to the selected duration.');
                    return;
                }

                const $btn = $('#submitMeetingBtn');
                $btn.prop('disabled', true).text('Saving...');

                $.ajax({
                    url: "{{ route('admin.sales.store.meeting') }}",
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(res) {
                        toastr.success('Meeting Scheduled Successfully!');
                        $('#add-meeting-form')[0].reset();
                        setTimeout(() => location.reload(), 1500);
                    },
                    error: function(xhr) {
                        toastr.error('Something went wrong.');
                        $btn.prop('disabled', false).text('Save Meeting');
                    }
                });
            });


            $(document).on('click', '.delete-meeting, .btn-delete', function() {

                let ids = [];

                // Case 1: Single row delete button
                if ($(this).hasClass('delete-meeting')) {
                    ids.push($(this).data('id'));
                }

                // Case 2: Bulk delete button
                if ($(this).hasClass('btn-delete')) {
                    ids = $('.row-checkbox:checked').map(function() {
                        return $(this).data('id');
                    }).get();

                    if (ids.length === 0) {
                        toastr.warning('Please select at least one meeting.');
                        return;
                    }
                }

                Swal.fire({
                    title: "Are you sure?",
                    text: ids.length > 1 ?
                        "This will permanently delete the selected meetings." :
                        "This meeting will be permanently deleted.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    confirmButtonText: "Yes, delete",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('admin.sales.meetings.delete') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                ids: ids
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                });

                                setTimeout(() => location.reload(), 1500);
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    xhr.responseJSON?.message ||
                                    'Failed to delete meeting(s).',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });



            $(document).on('click', '.edit-meeting', function() {

                const meetingId = $(this).data('id');

                $.get(`/admin/meeting/${meetingId}`, function(data) {

                    const modal = $('#EditMeeting');
                    const form = $('#edit-meeting-form');

                    form.data('id', meetingId);

                    form.find('input[name="name"]').val(data.name);
                    form.find('select[name="duration"]').val(data.duration);
                    form.find('input[name="meeting_date"]').val(data.date);
                    form.find('select[name="meeting_type"]').val(data.meeting_type).trigger(
                        'change');
                    form.find('input[name="location"]').val(data.location);
                    form.find('select[name="activity_type_id"]').val(data.activity_type_id).trigger(
                        'change');
                    form.find('textarea[name="description"]').val(data.description);

                    const populateTimes = modal.data('populateTimes');
                    populateTimes(
                        parseInt(data.duration),
                        data.start_time,
                        data.end_time
                    );

                    modal.modal('show');
                });
            });


            $("#edit-meeting-form").validate({
                ignore: [],
                rules: {
                    name: {
                        required: true
                    },
                    duration: {
                        required: true
                    },
                    meeting_date: {
                        required: true,
                        date: true
                    },
                    start_time: {
                        required: true
                    },
                    end_time: {
                        required: true
                    },
                    meeting_type: {
                        required: true
                    },
                    activity_type_id: {
                        required: true
                    },
                    description: {
                        required: true
                    },
                },
                messages: {
                    name: {
                        required: "Please enter the name"
                    },
                    duration: {
                        required: "Please select the duration"
                    },
                    meeting_date: {
                        required: "Please select the date",
                    },
                    start_time: {
                        required: "Please select the start time"
                    },
                    end_time: {
                        required: "Please select the end time"
                    },
                    meeting_type: {
                        required: "Please select the meeting type"
                    },
                    activity_type_id: {
                        required: "Please select the activity type"
                    },
                    description: {
                        required: "Please enter the description"
                    },
                },
                errorElement: 'span',
                errorClass: 'invalid-feedback d-block',
                highlight: function(el) {
                    $(el).addClass('is-invalid');
                },
                unhighlight: function(el) {
                    $(el).removeClass('is-invalid');
                }
            });


            $('#edit-meeting-form').submit(function(e) {
                e.preventDefault();

                if (!$('#edit-meeting-form').valid()) {
                    return;
                }

                if (!isValidTimeByDuration($('#edit-meeting-form'))) {
                    toastr.error('Please select start and end time according to the selected duration.');
                    return;
                }

                const meetingId = $(this).data('id');
                const $btn = $('#updateMeetingBtn');
                $btn.prop('disabled', true).text('Updating...');

                $.ajax({
                    url: `/admin/meeting/${meetingId}/update`,
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(res) {
                        toastr.success('Meeting Updated Successfully!');
                        $('#edit-meeting-form')[0].reset();
                        setTimeout(() => location.reload(), 1500);
                    },
                    error: function(xhr) {
                        toastr.error('Something went wrong.');
                        $btn.prop('disabled', false).text('Update Meeting');
                    }
                });
            });


        });
    </script>
@endpush
