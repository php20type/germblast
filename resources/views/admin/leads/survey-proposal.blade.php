@extends('admin.includes.layout')

@section('title', 'Survey Proposal')

@section('content')
    <!-- All Companies Section start  -->
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">
                <!-- Main Content -->
                <div class="col-md-12 p-0">
                    <div class="sales-dashboard">
                        <div class="dashboard-header section-card">
                            <div class="container-fluid">
                                <h1 class="display-6 mb-2 fw-bold">Survey & Proposal</h1>
                                <p class="text-muted">Record survey results on this page</p>
                            </div>
                        </div>

                        {{-- District Numbers --}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="section-card">
                                    <div class="section-header">
                                        <h3 class="section-title">District Numbers</h3>
                                         <div class="text-end">
                                            <button type="submit" class="btn btn-success ">
                                                Update
                                            </button>
                                        </div>
                                    </div>

                                    <form id="district_numbers_form">
                                        @csrf
                                        <input type="hidden" name="lead_id" value="{{ $lead->id }}">

                                        <table class="table table-bordered align-middle">
                                            <tbody>

                                                <tr>
                                                    <th>Client</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="description"
                                                            value="Gregory White">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Date</th>
                                                    <td>
                                                        <input type="date" class="form-control" name="date"
                                                            value="11/14/24">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Description</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="description"
                                                            value="NC - 11/24 - Tri">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Enrollment</th>
                                                    <td>
                                                        <input type="number" class="form-control" name="enrollment"
                                                            value="0">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>WADA</th>
                                                    <td>
                                                        <input type="number" class="form-control" name="wada"
                                                            value="0.00">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>ABA</th>
                                                    <td>
                                                        <input type="number" step="0.01" class="form-control"
                                                            name="aba" value="5">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Recommended Number of Service Technicians</th>
                                                    <td>
                                                        <input type="number" class="form-control" name="service_techs"
                                                            value="21">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Distance to Client</th>
                                                    <td>
                                                        <input type="number" class="form-control" name="distance"
                                                            value="0">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Number of Man Hours to Barcode Facilities</th>
                                                    <td>
                                                        <input type="number" class="form-control" name="man_hours"
                                                            value="0">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Estimate</th>
                                                    <td>
                                                        <span class="fw-bold">$29.05</span>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </form>
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
                                            <p class="section-subtitle">Enter your thoughts on the survey. Details are best
                                            </p>
                                        </div>
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-success ">
                                                Update
                                            </button>
                                        </div>
                                    </div>

                                    <form id="site_survey_narrative_form">
                                        @csrf
                                        <input type="hidden" name="lead_id" value="{{ $lead->id }}">

                                        <div class="mb-3">
                                            <textarea class="form-control" name="survey_narrative" rows="6" placeholder="Enter narrative here...">Crowley HS Athletics: 7 regular offices, 4 football locker rooms, 14 regular locker rooms, 2 weight rooms, 3 training rooms, 4 equipment rooms, 5 coach's offices</textarea>
                                        </div>

                                        <p class="text-muted small">
                                            Last Updated By:
                                            <strong>Chance Brown</strong>
                                        </p>
                                    </form>

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
                                            {{-- <button type="submit" class="btn btn-success ">
                                                Add Facility
                                            </button> --}}
                                            <a href="{{ route('admin.leads.survey.facility', $lead->id) }}" class="btn btn-success">
                                                Add Facility
                                            </a>
                                        </div>
                                    </div>

                                    {{-- <form id="district_numbers_form">
                                        @csrf
                                        <input type="hidden" name="lead_id" value="{{ $lead->id }}">

                                        <table class="table table-bordered align-middle">
                                            <tbody>

                                                <tr>
                                                    <th>Facility Name</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="name"
                                                            value="Buses">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Address</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="address"
                                                            value="New Street 223">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>City</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="city"
                                                            value="New york">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>State</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="state"
                                                            value="New york state">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Zip</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="zip"
                                                            value="798004">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Facility Type</th>
                                                    <td>
                                                        <select name="facility" id="facility" class="form-control">
                                                            <option value="hospital">Hospital</option>
                                                            <option value="clinic">Clinic</option>
                                                            <option value="elementary school">Elementary School</option>
                                                            <option value="Middle School">Middle School</option>
                                                            <option value="High School">High School</option>
                                                            <option value="High School Athletics">High School Athletics</option>
                                                            <option value="Middle School Athletics">Middle School Athletics</option>
                                                            <option value="Buses">Buses</option>
                                                            <option value="office">Office</option>
                                                            <option value="Office Building">Office Building</option>
                                                            <option value="Church">Church</option>
                                                            <option value="Daycare">Daycare</option>
                                                            <option value="Hotel">Hotel</option>
                                                            <option value="Other">Other</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </form> --}}
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
                                                <!-- Example row: Totals (matches screenshot) -->
                                                <tr>
                                                    <td>Totals</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                    <td>$0.00</td>
                                                </tr>
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
                                            {{-- <button type="submit" class="btn btn-success ">
                                                Update
                                            </button> --}}
                                            <a href="{{ route('admin.leads.survey.equipment', $lead->id) }}" class="btn btn-success">
                                                Add Evaluation
                                            </a>
                                        </div>
                                    </div>

                                    {{-- <form id="district_numbers_form">
                                        @csrf
                                        <input type="hidden" name="lead_id" value="{{ $lead->id }}">

                                        <table class="table table-bordered align-middle">
                                            <tbody>

                                                <tr>
                                                    <th>Evaluation Name</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="name"
                                                            value="Evaluation 1">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Man Hours</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="hours"
                                                            value="12">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Cost</th>
                                                    <td>
                                                       <input type="text" class="form-control" name="cost"
                                                            value="1200">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </form> --}}
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
                                                <!-- Example row: Totals (matches screenshot) -->
                                                <tr>
                                                    <td>Evaluation 1</td>
                                                    <td>12</td>
                                                    <td>$1200</td>
                                                </tr>
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
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-success ">
                                                Add Supplemental Offer
                                            </button>
                                        </div>
                                    </div>

                                    <form id="district_numbers_form">
                                        @csrf
                                        <input type="hidden" name="lead_id" value="{{ $lead->id }}">

                                        <table class="table table-bordered align-middle">
                                            <tbody>

                                                <tr>
                                                    <th>Title</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="name"
                                                            value="Evaluation 1">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Body</th>
                                                    <td>
                                                        <textarea name="" id="" class="form-control w-100" rows="5"></textarea>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </form>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                <!-- Main Content Ends -->

            </div>
        </div>
    </div>
@endsection


@push('scripts')
@endpush
