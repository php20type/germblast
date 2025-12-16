@extends('admin.includes.layout')

@section('title', 'Schedule Meeting')

@section('content')
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">

                {{-- Sidebar --}}
                @include('admin.sales.sidebar')

                {{-- Main Content --}}
                <div class="col-md-10 p-0">
                    <div class="sales-dashboard">
                        {{-- HEADER --}}
                        <div class="dashboard-header section-card d-flex justify-content-between align-items-center">
                            <div class="container-fluid px-0">
                                <h1 class="display-6 mb-2 fw-bold">Schedule New Meeting</h1>
                                <p class="text-muted">Schedule and manage internal or client meetings</p>
                            </div>

                            <div>
                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#AddMeeting">
                                    Add New Meeting
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- MEETING TIMELINE CONTAINER --}}
                    <div class="timeline-container">
                        <div class="timeline-content">

                            <div class="timeline-header">
                                <div class="timestamp">
                                    10:00 AM on Jan 15, 2025
                                </div>
                            </div>

                            <div class="timeline-body">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <p class="mb-0">
                                            <span class="fw-semibold">Client Demo Call</span>
                                            <span class="text-muted"> (Zoom)</span>
                                        </p>
                                    </div>

                                    <div class="col-4 text-end">
                                        <a href="#" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-outline-warning">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="mt-2 text-muted">
                                    <i class="fas fa-file-alt text-warning me-1"></i>
                                    Discuss onboarding, pricing, and proposal review.
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
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
                                    <select class="form-select select2" id="start_time" name="start_time" required></select>
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
                            <div class="col-lg-12 mt-2">
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

                            <button type="submit" class="btn btn-primary">Save Meeting</button>
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

            const modal = $('#AddMeeting');

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

            function populateTimeDropdowns(interval) {
                startTimeSelect.empty().append('<option value="">Select Start Time</option>');
                endTimeSelect.empty().append('<option value="">Select End Time</option>');

                if (!interval) return;

                const times = generateTimeOptions(interval);

                times.forEach(t => {
                    const option = `<option value="${t.value}">${t.label}</option>`;
                    startTimeSelect.append(option);
                    endTimeSelect.append(option);
                });

                startTimeSelect.val(null).trigger('change');
                endTimeSelect.val(null).trigger('change');
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
                    $(this).prop(
                        'disabled',
                        optionMoment.isSameOrBefore(startMoment)
                    );
                });

                if (endTimeSelect.find(':selected').prop('disabled')) {
                    endTimeSelect.val('');
                }
            }

            durationSelect.on('change', function() {
                populateTimeDropdowns(parseInt(this.value));
            });

            const defaultDuration = parseInt(durationSelect.val());
            if (defaultDuration) {
                populateTimeDropdowns(defaultDuration);
            }

            startTimeSelect.on('change', filterEndTimes);

            [startTimeSelect, endTimeSelect].forEach(select => {
                select.select2({
                    dropdownParent: modal,
                    width: '100%',
                    dropdownPosition: 'below'
                });
            });

            function isValidTimeByDuration() {
                const duration = parseInt($('select[name="duration"]').val());
                const startTime = $('select[name="start_time"]').val();
                const endTime = $('select[name="end_time"]').val();

                if (!duration || !startTime || !endTime) return true;

                const start = moment(startTime, 'HH:mm:ss');
                const end = moment(endTime, 'HH:mm:ss');

                const diffInMinutes = end.diff(start, 'minutes');

                return diffInMinutes === duration;
            }


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
                    location: {
                        required: true
                    },
                    activity_type_id: {
                        required: true
                    }
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
                    location: {
                        required: "Please enter the location"
                    },
                    activity_type_id: {
                        required: "Please select the activity type"
                    }
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

                if (!isValidTimeByDuration()) {
                    toastr.error('Please select start and end time according to the selected duration.');
                    return;
                }

                $.ajax({
                    url: "{{ route('admin.sales.store.meeting') }}",
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(res) {
                        toastr.success('Meeting Scheduled Successfully!');
                        $('#add-meeting-form')[0].reset();
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        toastr.error('Something went wrong while scheduling the meeting.');
                    }
                });
            });



        });
    </script>
@endpush
