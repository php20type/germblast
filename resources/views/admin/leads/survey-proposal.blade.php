@extends('admin.includes.layout')

@section('title', 'Survey Proposal')

@section('content')
    <!-- All Companies Section start  -->
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">
                <!-- Main Content -->
                <div class="col-md-12 p-0">

                    <form action="#" method="POST" class="" id="add-survey-form">
                        @csrf
                        <input type="hidden" name="lead_id" value="{{ $lead->id }}">

                        <div class="sales-dashboard">
                            <div class="dashboard-header section-card d-flex justify-content-between align-items-center">
                                <div class="container-fluid px-0">
                                    <h1 class="display-6 mb-2 fw-bold">Survey & Proposal</h1>
                                    <p class="text-muted">Record survey results on this page</p>
                                </div>

                                <div>
                                    <button type="submit" class="btn btn-success">
                                        Save Survey Proposal
                                    </button>
                                </div>
                            </div>

                            {{-- District Numbers --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">

                                        <div class="section-header">
                                            <h3 class="section-title">District Numbers</h3>
                                        </div>

                                        <table class="table table-bordered align-middle">
                                            <tbody>
                                                <tr>
                                                    <th>Client</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="client_name"
                                                            value="{{ $surveyProposal->client_name ?? '' }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Date</th>
                                                    <td>
                                                        <input type="date" class="form-control" name="date"
                                                            value="{{ isset($surveyProposal->date) ? date('Y-m-d', strtotime($surveyProposal->date)) : '' }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Description</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="description"
                                                            value="{{ $surveyProposal->description ?? '' }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Enrollment</th>
                                                    <td>
                                                        <input type="number" class="form-control" name="enrollment"
                                                            value="{{ $surveyProposal->enrollment ?? 0 }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>WADA</th>
                                                    <td>
                                                        <input type="number" step="0.01" class="form-control"
                                                            name="wada" value="{{ $surveyProposal->wada ?? 0 }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>ABA</th>
                                                    <td>
                                                        <input type="number" step="0.01" class="form-control"
                                                            name="aba" value="{{ $surveyProposal->aba ?? 0 }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Recommended Number of Service Technicians</th>
                                                    <td>
                                                        <input type="number" class="form-control"
                                                            name="service_technicians"
                                                            value="{{ $surveyProposal->service_technicians ?? 0 }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Distance to Client</th>
                                                    <td>
                                                        <input type="number" class="form-control" name="distance"
                                                            value="{{ $surveyProposal->distance ?? 0 }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Man Hours</th>
                                                    <td>
                                                        <input type="number" class="form-control" name="man_hours"
                                                            value="{{ $surveyProposal->man_hours ?? 0 }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Estimate</th>
                                                    <td><span
                                                            class="fw-bold">${{ $surveyProposal->estimate ?? '0.00' }}</span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>

                            {{-- Site Survey Specialist Narrative --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">

                                        <div class="section-header">
                                            <div>
                                                <h3 class="section-title">Site Survey Specialist Narrative</h3>
                                                <p class="section-subtitle">Enter your thoughts on the survey. Details are
                                                    best
                                                </p>
                                            </div>
                                        </div>

                                        <textarea class="form-control mb-2" name="specialist_narrative" rows="6" placeholder="Enter narrative here...">{{ $surveyProposal->specialist_narrative ?? '' }}</textarea>

                                        <p class="text-muted small">
                                            Last Updated By:
                                            <strong>Chance Brown</strong>
                                        </p>

                                    </div>
                                </div>
                            </div>


                            {{-- Create Facility --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header">
                                            <h3 class="section-title">Create Facility</h3>
                                            <div class="text-end">
                                                <a href="{{ route('admin.survey.proposal.facility', $surveyProposal->id) }}"
                                                    class="btn btn-success">
                                                    Add Facility
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Facility list --}}
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="section-card">
                                        <div class="section-header">
                                            <h3 class="section-title">Facility List</h3>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-bordered align-middle mb-0">
                                                <thead class="bg-light">
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Facility Type</th>
                                                        <th>Address</th>
                                                        <th>Square Footage</th>
                                                        <th>Man Hours</th>
                                                        <th>Cost</th>
                                                    </tr>
                                                </thead>

                                                <tbody>

                                                    @if ($facilities->isEmpty())
                                                        <tr>
                                                            <td colspan="6" class="text-center text-muted">No facilities
                                                                added yet.</td>
                                                        </tr>
                                                    @else
                                                        @foreach ($facilities as $facility)
                                                            <tr>
                                                                {{-- <td>{{ $facility->facility_name }}</td> --}}
                                                                <td>
                                                                    <a
                                                                        href="{{ route('admin.survey.facility.edit', $facility->id) }}">
                                                                        {{ $facility->facility_name }}
                                                                    </a>
                                                                </td>
                                                                <td>{{ $facility->facility_type }}</td>
                                                                <td>{{ $facility->address }}</td>
                                                                <td>{{ $facility->square_footage }}</td>
                                                                <td>{{ $facility->man_hours }}</td>
                                                                <td>${{ number_format($facility->man_hours_cost, 2) }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif

                                                </tbody>
                                            </table>
                                        </div>

                                    </div>

                                </div>
                            </div>


                            {{-- Create Evaluation --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header">
                                            <h3 class="section-title">Create Equipment Evaluation</h3>
                                            <div class="text-end">
                                                <a href="{{ route('admin.survey.proposal.equipment', $surveyProposal->id) }}"
                                                    class="btn btn-success">
                                                    Add Evaluation
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            {{-- Evaluation List --}}
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="section-card">
                                        <div class="section-header">
                                            <h3 class="section-title">Evaluation List</h3>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-bordered align-middle mb-0">
                                                <thead class="bg-light">
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Man Hours</th>
                                                        <th>Cost</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @if ($equipments->isEmpty())
                                                        <tr>
                                                            <td colspan="3" class="text-center text-muted">
                                                                No equipment evaluations added yet.
                                                            </td>
                                                        </tr>
                                                    @else
                                                        @foreach ($equipments as $evaluation)
                                                            <tr>
                                                                {{-- <td>{{ $evaluation->name ?? 'Evaluation' }}</td> --}}
                                                                <td>
                                                                    <a href="{{ route('admin.survey.equipment.edit', $evaluation->id) }}">
                                                                        {{ $evaluation->name }}
                                                                    </a>
                                                                </td>

                                                                <td>{{ $evaluation->cleaning_man_hours ?? 0 }}</td>
                                                                <td>${{ number_format($evaluation->cleaning_man_hours_cost ?? 0, 2) }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif

                                                </tbody>
                                            </table>
                                        </div>

                                    </div>

                                </div>
                            </div>


                            {{-- Supplemental Offer --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">

                                        <div class="section-header">
                                            <h3 class="section-title">Supplemental Offer</h3>
                                        </div>

                                        <table class="table table-bordered align-middle">
                                            <tbody>

                                                <tr>
                                                    <th>Title</th>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="supplemental_title"
                                                            value="{{ $surveyProposal->supplemental_title ?? '' }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Body</th>
                                                    <td>
                                                        <textarea name="supplemental_body" class="form-control" rows="5">{{ $surveyProposal->supplemental_body ?? '' }}</textarea>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>


                        </div>
                    </form>
                </div>
                <!-- Main Content Ends -->

            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        $("#add-survey-form").validate({
            ignore: [],
            rules: {
                client_name: {
                    required: true
                },
                date: {
                    required: true,
                    date: true
                },
                description: {
                    required: true
                },

                enrollment: {
                    required: true,
                    number: true,
                    min: 0
                },
                wada: {
                    required: true,
                    number: true,
                    min: 0
                },
                aba: {
                    required: true,
                    number: true,
                    min: 0
                },
                service_technicians: {
                    required: true,
                    number: true,
                    min: 0
                },
                distance: {
                    required: true,
                    number: true,
                    min: 0
                },
                man_hours: {
                    required: true,
                    number: true,
                    min: 0
                },

                specialist_narrative: {
                    required: true
                },

                // Supplemental fields also required
                supplemental_title: {
                    required: true
                },
                supplemental_body: {
                    required: true
                }
            },

            messages: {
                client_name: {
                    required: "Please enter client name."
                },
                date: {
                    required: "Please select a date."
                },
                description: {
                    required: "Please enter description."
                },

                enrollment: {
                    required: "Please enter enrollment."
                },
                wada: {
                    required: "Please enter WADA value."
                },
                aba: {
                    required: "Please enter ABA value."
                },
                service_technicians: {
                    required: "Please enter number of technicians."
                },
                distance: {
                    required: "Please enter distance."
                },
                man_hours: {
                    required: "Please enter man hours."
                },

                specialist_narrative: {
                    required: "Please enter the narrative."
                },

                supplemental_title: {
                    required: "Please enter supplemental title."
                },
                supplemental_body: {
                    required: "Please enter supplemental body."
                }
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
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            }
        });


        // AJAX SUBMIT
        $('#add-survey-form').submit(function(e) {
            e.preventDefault();

            if (!$('#add-survey-form').valid()) {
                return;
            }

            $.ajax({
                url: "{{ route('admin.leads.survey.proposal.store', $lead->id) }}",
                method: "POST",
                data: $(this).serialize(),

                success: function(res) {
                    Swal.fire({
                        icon: "success",
                        title: "Saved!",
                        text: res.message || "Survey Proposal Saved Successfully!",
                        showConfirmButton: false,
                        timer: 2000
                    });

                    setTimeout(() => location.reload(), 2000);
                },


                error: function(xhr) {
                    toastr.error("Something went wrong while saving the proposal.");
                    console.log(xhr.responseText);
                }
            });
        });
    </script>
@endpush
