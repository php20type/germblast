@extends('admin.includes.layout')

@section('title', 'Survey Configuration')

@push('styles')
    <style>
        /* Equipment Report Table Boxed Styling (Matched from Survey Proposal) */
        .equipment-report-table {
            border: 1px solid #e5e7eb !important;
            border-radius: 12px !important;
            border-collapse: separate !important;
            border-spacing: 0 !important;
            overflow: hidden !important;
            background: #fff !important;
            width: 100% !important;
            margin-top: 10px !important;
        }

        .equipment-report-table thead th {
            background-color: rgba(255, 184, 28, 0.4) !important;
            border-bottom: 1px solid #e5e7eb !important;
            color: #374151 !important;
            font-weight: 600 !important;
            padding: 18px 20px !important;
            border-right: 1px solid rgba(0, 0, 0, 0.05) !important;
            font-size: 14px !important;
        }

        .equipment-report-table thead th:first-child {
            border-top-left-radius: 12px !important;
        }

        .equipment-report-table thead th:last-child {
            border-top-right-radius: 12px !important;
            border-right: none !important;
        }

        .equipment-report-table tbody th {
            background-color: #fff !important;
            border-bottom: 1px solid #f3f4f6 !important;
            color: #374151 !important;
            font-weight: 600 !important;
            padding: 15px 20px !important;
            border-right: 1px solid rgba(0, 0, 0, 0.05) !important;
            font-size: 14px !important;
            text-align: left !important;
        }

        .equipment-report-table td {
            padding: 15px 20px !important;
            vertical-align: middle !important;
            border-bottom: 1px solid #f3f4f6 !important;
            border-right: 1px solid rgba(0, 0, 0, 0.05) !important;
            font-size: 14px !important;
        }

        .equipment-report-table td:last-child {
            border-right: none !important;
        }

        .equipment-report-table tbody tr:last-child td,
        .equipment-report-table tbody tr:last-child th {
            border-bottom: none !important;
        }

        .equipment-report-table tbody tr:last-child td:first-child,
        .equipment-report-table tbody tr:last-child th:first-child {
            border-bottom-left-radius: 12px !important;
        }

        .equipment-report-table tbody tr:last-child td:last-child,
        .equipment-report-table tbody tr:last-child th:last-child {
            border-bottom-right-radius: 12px !important;
        }

        /* Section Card Refinement */
        .section-card {
            background: #ffffff !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 16px !important;
            padding: 25px !important;
            margin-bottom: 25px !important;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.02) !important;
            transition: all 0.3s ease !important;
        }

        .section-card:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.04) !important;
        }

        .section-title {
            font-size: 18px !important;
            font-weight: 600 !important;
            color: #374151 !important;
            margin-bottom: 0 !important;
        }

        .section-header {
            margin-bottom: 20px !important;
        }

        /* Standardized Input Styling to match the screenshot form inputs */
        .form-control-custom {
            border: 1px solid #000 !important;
            border-radius: 0 !important;
            padding: 4px 8px !important;
            width: 150px !important;
            font-size: 14px !important;
            color: #1f2937 !important;
        }
    </style>
@endpush

@section('content')
<div class="companies-section my-4">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @include('admin.corporate-tools.sidebar')

            <!-- Main Content -->
            <div class="col-md-10 p-0">
                <div class="main-content">
                    
                    <!-- Header -->
                    <div class="heading-area-sec mb-3">
                        <div class="left-part-sec">
                            <h3 class="mb-1">
                                SURVEY MASTER CONFIGURATION <span style="font-size: 24px;">📋</span>
                            </h3>
                            <p class="text-muted mb-0">
                                Master Configuration File
                            </p>
                        </div>
                    </div>
                    
                    <div class="px-4 pb-4">
                        <div class="section-card">
                            <div class="section-header">
                                <h4 class="section-title">Survey Configuration</h4>
                            </div>

                            <div class="table-responsive">
                                <table class="equipment-report-table">
                                    <thead>
                                        <tr>
                                            <th>Room Type</th>
                                            <th style="width: 250px;">Manhours to Service</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Average Time to Travel Between Facilities in Hours (include load times)</td>
                                            <td><input type="text" class="form-control-custom" value="0.33"></td>
                                        </tr>
                                        <tr>
                                            <td>Average Miles Per Gallon</td>
                                            <td><input type="text" class="form-control-custom" value="14"></td>
                                        </tr>
                                        <tr>
                                            <td>Average Price Per Gallon</td>
                                            <td><input type="text" class="form-control-custom" value="3.00"></td>
                                        </tr>
                                        <tr>
                                            <td>Cost Ratio - Awareness</td>
                                            <td><input type="text" class="form-control-custom" value="0.1000"></td>
                                        </tr>
                                        <tr>
                                            <td>Cost Ratio - Education</td>
                                            <td><input type="text" class="form-control-custom" value="0.1000"></td>
                                        </tr>
                                        <tr>
                                            <td>Cost Ratio - Technology</td>
                                            <td><input type="text" class="form-control-custom" value="0.0150"></td>
                                        </tr>
                                        <tr>
                                            <td>Cost Ratio - Response</td>
                                            <td><input type="text" class="form-control-custom" value="0.0900"></td>
                                        </tr>
                                        <tr>
                                            <td>Cost Ratio - Sales/Account Reps</td>
                                            <td><input type="text" class="form-control-custom" value="0.1100"></td>
                                        </tr>
                                        <tr>
                                            <td>Hourly Rate</td>
                                            <td><input type="text" class="form-control-custom" value="28.75"></td>
                                        </tr>
                                        <tr>
                                            <td>High School Classrooms</td>
                                            <td><input type="text" class="form-control-custom" value="0.330"></td>
                                        </tr>
                                        <tr>
                                            <td>Middle School Classrooms</td>
                                            <td><input type="text" class="form-control-custom" value="0.330"></td>
                                        </tr>
                                        <tr>
                                            <td>Elementary Classrooms</td>
                                            <td><input type="text" class="form-control-custom" value="0.500"></td>
                                        </tr>
                                        <tr>
                                            <td>PreK-2nd Classrooms</td>
                                            <td><input type="text" class="form-control-custom" value="0.650"></td>
                                        </tr>
                                        <tr>
                                            <td>Standard (Community) Bathrooms</td>
                                            <td><input type="text" class="form-control-custom" value="0.200"></td>
                                        </tr>
                                        <tr>
                                            <td>Single Bathrooms</td>
                                            <td><input type="text" class="form-control-custom" value="0.075"></td>
                                        </tr>
                                        <tr>
                                            <td>Cafeteria & Kitchen</td>
                                            <td><input type="text" class="form-control-custom" value="1.250"></td>
                                        </tr>
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
@endsection
