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

                        <!-- Response Messages -->
                        <div id="response-message" class="alert d-none"></div>

                        <!-- SECTION 1: MASTER PARAMETERS -->
                        <!-- <div class="section-card">
                            <div class="section-header">
                                <h4 class="section-title">Master Survey Parameters</h4>
                            </div>

                            <form class="update-config-form" data-route="{{ route('admin.corporate-tools.survey-configuration.updateParameters') }}">
                                @csrf
                                <div class="table-responsive">
                                    <table class="equipment-report-table">
                                        <thead>
                                            <tr>
                                                <th>Parameter Name</th>
                                                <th style="width: 250px;">Value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($parameters as $key => $value)
                                            <tr>
                                                <td>{{ preg_replace('/(?<!\ )[A-Z]/', ' $0', $key) }}</td>
                                                <td><input type="text" class="form-control-custom" name="parameters[{{ $key }}]" value="{{ $value }}"></td>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td></td>
                                                <td><button type="submit" class="btn btn-primary" style="border-radius: 6px; font-weight: 500; font-size: 14px; padding: 6px 20px;">Update</button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div> -->

                        <!-- SECTION 2: SURVEY FACILITIES -->
                        <div class="section-card">
                            <div class="section-header">
                                <h4 class="section-title">Survey Facilities</h4>
                            </div>

                            <form class="update-config-form" data-route="{{ route('admin.corporate-tools.survey-configuration.updateFacilities') }}">
                                @csrf
                                <div class="table-responsive">
                                    <table class="equipment-report-table">
                                        <thead>
                                            <tr>
                                                <th>Room Type</th>
                                                <th style="width: 250px;">Manhours to Service</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($facilities as $facility)
                                            <tr>
                                                <td>{{ $facility->name }}</td>
                                                <td><input type="text" class="form-control-custom" name="facilities[{{ $facility->id }}]" value="{{ number_format($facility->hours_required, 3) }}"></td>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td></td>
                                                <td><button type="submit" class="btn btn-primary" style="border-radius: 6px; font-weight: 500; font-size: 14px; padding: 6px 20px;">Update</button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>

                        <!-- SECTION 3: SURVEY EQUIPMENT -->
                        <div class="section-card">
                            <div class="section-header">
                                <h4 class="section-title">Survey Equipment</h4>
                            </div>

                            <form class="update-config-form" data-route="{{ route('admin.corporate-tools.survey-configuration.updateEquipment') }}">
                                @csrf
                                <div class="table-responsive">
                                    <table class="equipment-report-table">
                                        <thead>
                                            <tr>
                                                <th>Equipment Name</th>
                                                <th style="width: 250px;">Manhours to Service</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($equipment as $item)
                                            <tr>
                                                <td>{{ $item->name }}</td>
                                                <td><input type="text" class="form-control-custom" name="equipment[{{ $item->id }}]" value="{{ number_format($item->hours_required, 3) }}"></td>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td></td>
                                                <td><button type="submit" class="btn btn-primary" style="border-radius: 6px; font-weight: 500; font-size: 14px; padding: 6px 20px;">Update</button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('.update-config-form').on('submit', function(e) {
        e.preventDefault();
        
        var form = $(this);
        var route = form.data('route');
        var btn = form.find('button[type="submit"]');
        var originalBtnText = btn.text();
        
        btn.prop('disabled', true).text('Updating...');
        $('#response-message').addClass('d-none').removeClass('alert-success alert-danger');

        $.ajax({
            url: route,
            type: 'POST',
            data: form.serialize(),
            success: function(response) {
                if (response.success) {
                    $('#response-message')
                        .text(response.message)
                        .addClass('alert-success')
                        .removeClass('d-none');
                }
            },
            error: function(xhr) {
                var errorMsg = 'An error occurred while updating.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                $('#response-message')
                    .text(errorMsg)
                    .addClass('alert-danger')
                    .removeClass('d-none');
            },
            complete: function() {
                btn.prop('disabled', false).text(originalBtnText);
                
                // Hide message after 3 seconds
                setTimeout(function() {
                    $('#response-message').addClass('d-none');
                }, 3000);
            }
        });
    });
});
</script>
@endpush
