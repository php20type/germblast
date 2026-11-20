@extends('admin.includes.layout')

@section('title', 'Survey Configuration')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/corporate-tools.css') }}?v={{ filemtime(public_path('css/corporate-tools.css')) }}">
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
    $('.update-config-form').each(function() {
        const $form = $(this);

        // Validation matching Add Company pattern
        $form.validate({
            ignore: [],
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

        // Add rules to inputs
        $form.find('input[type="text"]').each(function() {
            $(this).rules('add', {
                required: true,
                number: true,
                min: 0,
                messages: {
                    required: "Please enter a value.",
                    number: "Must be a valid number.",
                    min: "Value must be 0 or greater."
                }
            });
        });

        // Submit form matching Add Company pattern
        $form.submit(function(e) {
            e.preventDefault();

            const $submitBtn = $form.find('button[type="submit"]');

            if (!$form.valid()) return;

            const route = $form.data('route');

            $.ajax({
                url: route,
                method: 'POST',
                data: $form.serialize(),

                beforeSend: function() {
                    $submitBtn.prop('disabled', true).text('Updating...');
                },

                success: function(response) {
                    toastr.success(response.message || 'Updated successfully! Redirecting...');
                    $submitBtn.prop('disabled', false).text('Update');

                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                },

                error: function(xhr) {
                    toastr.error(xhr.responseJSON?.message || 'Something went wrong while updating.');
                    $submitBtn.prop('disabled', false).text('Update');
                }
            });
        });
    });
});
</script>
@endpush
