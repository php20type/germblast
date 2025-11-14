@extends('admin.includes.layout')

@section('title', 'Survey Facility')

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
                                <h1 class="display-6 mb-2 fw-bold">Add Facility</h1>
                                <p class="text-muted">Record survey results on this page</p>
                            </div>
                        </div>


                        {{-- Create Facility --}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="section-card">
                                    <div class="section-header">
                                        <h3 class="section-title">Create Facility</h3>
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-success ">
                                                Add Facility
                                            </button>
                                        </div>
                                    </div>

                                    <form id="district_numbers_form">
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
                                    </form>
                                </div>
                            </div>
                        </div>


                        {{-- Create Facility --}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="section-card">
                                    <div class="section-header">
                                        <h3 class="section-title">Facility Maps</h3>
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-success ">
                                                Add Maps
                                            </button>
                                        </div>
                                    </div>

                                    <form id="district_numbers_form">
                                        @csrf
                                        <input type="hidden" name="lead_id" value="{{ $lead->id }}">

                                        <table class="table table-bordered align-middle">
                                            <tbody>
                                                <tr>
                                                    <th>Map Name</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="name"
                                                            value="New york map">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Upload Photo</th>
                                                    <td>
                                                        <input type="file" class="form-control" name="facility_file"
                                                            value="">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                            </div>
                        </div>


                          {{-- Facility list --}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="section-card">
                                    <div class="section-header">
                                        <h3 class="section-title">Facility Maps List</h3>
                                    </div>

                                </div>

                            </div>
                        </div>


                        {{-- Survey Details --}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="section-card">
                                    <div class="section-header">
                                        <h3 class="section-title">Survey Details</h3>
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
                                                    <th>
                                                        Room Type
                                                    </th>
                                                    <th>
                                                        Count
                                                    </th>
                                                </tr>

                                                <tr>
                                                    <th>Square Footage</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="square footage"
                                                            value="">
                                                    </td>
                                                </tr>

                                                 <tr>
                                                    <th>Offices</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="office"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Community Bathrooms</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="community_bathrooms"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Single Bathrooms</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="single_bathrooms"
                                                            value="">
                                                    </td>
                                                </tr>


                                                <tr>
                                                    <th>Total Man Hours</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="man_hours"
                                                            value="12">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Total Man Hours Cost</th>
                                                    <td>
                                                        $0.00
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
