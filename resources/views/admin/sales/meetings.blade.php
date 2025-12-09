@extends('admin.includes.layout')

@section('title', 'Create Meeting')

@section('content')
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">

                {{-- Sidebar --}}
                @include('admin.sales.sidebar')

                {{-- Main Content --}}
                <div class="col-md-10 p-0">
                    <form action="{{ route('admin.sales.store.meeting') }}" method="POST" id="create-meeting-form">
                        @csrf

                        <div class="sales-dashboard">
                            {{-- HEADER --}}
                            <div class="dashboard-header section-card d-flex justify-content-between align-items-center">
                                <div class="container-fluid px-0">
                                    <h1 class="display-6 mb-2 fw-bold">Schedule New Meeting</h1>
                                    <p class="text-muted">Schedule and manage internal or client meetings</p>
                                </div>

                                <div>
                                    <button type="submit" class="btn btn-success">
                                        Save Meeting
                                    </button>
                                </div>
                            </div>

                            {{-- MEETING DETAILS --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header">
                                            <h3 class="section-title">Meeting Details</h3>
                                        </div>

                                        <table class="table table-bordered align-middle">
                                            <tbody>

                                                {{-- Name --}}
                                                <tr>
                                                    <th style="width: 35%">Meeting Name</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="name" required>
                                                    </td>
                                                </tr>

                                                {{-- Duration --}}
                                                <tr>
                                                    <th>Duration (Minutes)</th>
                                                    <td>
                                                        <select class="form-control" name="duration" required>
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
                                                    </td>
                                                </tr>

                                                {{-- Day / Date --}}
                                                <tr>
                                                    <th>Meeting Date</th>
                                                    <td>
                                                        <input type="date" class="form-control" name="day" required>
                                                    </td>
                                                </tr>

                                                {{-- Start / End Time --}}
                                                <tr>
                                                    <th>Start Time</th>
                                                    <td>
                                                        <input type="time" class="form-control" name="start_time"
                                                            required>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>End Time</th>
                                                    <td>
                                                        <input type="time" class="form-control" name="end_time" required>
                                                    </td>
                                                </tr>

                                                {{-- Location --}}
                                                <tr>
                                                    <th>Location</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="location"
                                                            placeholder="Office, Google Meet Link, Zoom URL, Client Site..."
                                                            required>
                                                    </td>
                                                </tr>

                                                {{-- Meeting Type --}}
                                                <tr>
                                                    <th>Meeting Type</th>
                                                    <td>
                                                        <select class="form-control" name="meeting_type" required>
                                                            <option value="">Choose...</option>
                                                            <option value="zoom">Zoom Meeting</option>
                                                            <option value="live">Live (In-Person)</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                                {{-- Activity Type --}}
                                                <tr>
                                                    <th>Activity Type</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="activity_type"
                                                            placeholder="Sales Call, Client Review, Demo, Support..."
                                                            required>
                                                    </td>
                                                </tr>

                                                {{-- Description --}}
                                                <tr>
                                                    <th>Description</th>
                                                    <td>
                                                        <textarea name="description" class="form-control" rows="5" placeholder="Enter meeting purpose, agenda, notes..."></textarea>
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

            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        $(document).ready(function() {

            /** FORM VALIDATION **/
            $("#create-meeting-form").validate({
                ignore: [],
                rules: {
                    name: {
                        required: true
                    },
                    duration: {
                        required: true,
                        number: true
                    },
                    day: {
                        required: true,
                        date: true
                    },
                    start_time: {
                        required: true
                    },
                    end_time: {
                        required: true
                    },
                    location: {
                        required: true
                    },
                    meeting_type: {
                        required: true
                    },
                    activity_type: {
                        required: true
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

        });
    </script>
@endpush
