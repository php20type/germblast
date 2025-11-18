@extends('admin.includes.layout')

@section('title', 'Equipment Evaluation')

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
                                <h1 class="display-6 mb-2 fw-bold">Equipment Evaluation</h1>
                                <p class="text-muted">Record survey results on this page</p>
                            </div>
                        </div>

                        {{-- utilities and drains photos --}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="section-card">
                                    <div class="section-header">
                                        <div>
                                            <h3 class="section-title">Utilities and Drains</h3>
                                            <p class="section-subtitle">Upload Photos of the electrical connections, water connections and drain area for Wash.
                                                <br>
                                                Describe (in detail) where the utilities can be found.
                                            </p>
                                        </div>
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-success ">
                                                Add
                                            </button>
                                        </div>
                                    </div>


                                    <form id="district_numbers_form">
                                        @csrf
                                        <input type="hidden" name="lead_id" value="{{ $lead->id }}">

                                        <table class="table table-bordered align-middle">
                                            <tbody>
                                                <tr>
                                                    <th>Upload Photo</th>
                                                    <td>
                                                        <input type="file" class="form-control" name="facility_file"
                                                            value="">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Description</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="description"
                                                            value="This is the description of the photo">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                            </div>
                        </div>

                         {{-- Photos --}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="section-card">
                                    <div class="section-header">
                                        <h3 class="section-title">Uploaded Pictures</h3>
                                    </div>

                                </div>

                            </div>
                        </div>

                        {{-- wash information --}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="section-card">
                                    <div class="section-header">
                                        <h3 class="section-title">Wash Information</h3>
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-success ">
                                                Update
                                            </button>
                                        </div>
                                    </div>

                                    <form id="wash_equipment_evaluation_form">
                                        @csrf
                                        <input type="hidden" name="survey_proposal_id" value="{{ $lead->id }}">

                                        <table class="table table-bordered align-middle">
                                            <tbody>

                                                <tr>
                                                    <th>Equipment Type</th>
                                                    <th>Count</th>
                                                </tr>

                                                <tr>
                                                    <th>Non electric Gurney</th>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="non_electric_gurney" value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Wheelchair</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="wheelchair"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Transport Chair</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="transport_chair"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>IV Pole</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="iv_pole"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Food Cart</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="food_cart"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Miscellaneous Pieces to Wash</th>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="miscellaneous_pieces" value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Total Man Hours</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="wash_man_hours"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Total Man Hours Cost</th>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="wash_man_hours_cost" value="">
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </form>

                                </div>
                            </div>
                        </div>

                        {{-- Equipment Cleaning Information --}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="section-card">
                                    <div class="section-header">
                                        <h3 class="section-title">Equipment Cleaning Information</h3>
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-success ">
                                                Update
                                            </button>
                                        </div>
                                    </div>

                                    <form id="cleaning_equipment_evaluation_form">
                                        @csrf
                                        <input type="hidden" name="survey_proposal_id" value="{{ $lead->id }}">

                                        <table class="table table-bordered align-middle">
                                            <tbody>

                                                <tr>
                                                    <th>Equipment Type</th>
                                                    <th>Count</th>
                                                </tr>

                                                <tr>
                                                    <th>Anesthesia Cart</th>
                                                    <td><input type="text" class="form-control" name="anesthesia_cart">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>OR Table</th>
                                                    <td><input type="text" class="form-control" name="or_table"></td>
                                                </tr>

                                                <tr>
                                                    <th>Stainless Steel Cart</th>
                                                    <td><input type="text" class="form-control"
                                                            name="stainless_steel_cart"></td>
                                                </tr>

                                                <tr>
                                                    <th>Stainless Steel Table</th>
                                                    <td><input type="text" class="form-control"
                                                            name="stainless_steel_table"></td>
                                                </tr>

                                                <tr>
                                                    <th>Electrosurgical Device</th>
                                                    <td><input type="text" class="form-control"
                                                            name="electrosurgical_device"></td>
                                                </tr>

                                                <tr>
                                                    <th>Wall Mounted ECG/EKG Monitor</th>
                                                    <td><input type="text" class="form-control"
                                                            name="wall_mounted_monitor"></td>
                                                </tr>

                                                <tr>
                                                    <th>Vital Signs Monitor</th>
                                                    <td><input type="text" class="form-control"
                                                            name="vital_signs_monitor"></td>
                                                </tr>

                                                <tr>
                                                    <th>Vital Signs Monitor w/ECG</th>
                                                    <td><input type="text" class="form-control"
                                                            name="vital_signs_monitor_ecg"></td>
                                                </tr>

                                                <tr>
                                                    <th>DVT/SCD Device</th>
                                                    <td><input type="text" class="form-control" name="dvt_scd_device">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>CPM (Continuous Passive Motion)</th>
                                                    <td><input type="text" class="form-control" name="cpm"></td>
                                                </tr>

                                                <tr>
                                                    <th>Infusion Pump</th>
                                                    <td><input type="text" class="form-control" name="infusion_pump">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>BiPap</th>
                                                    <td><input type="text" class="form-control" name="bipap"></td>
                                                </tr>

                                                <tr>
                                                    <th>CPAP</th>
                                                    <td><input type="text" class="form-control" name="cpap"></td>
                                                </tr>

                                                <tr>
                                                    <th>Pulse Oximeter</th>
                                                    <td><input type="text" class="form-control" name="pulse_oximeter">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Hospital Bed</th>
                                                    <td><input type="text" class="form-control" name="hospital_bed">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Electric Gurney</th>
                                                    <td><input type="text" class="form-control"
                                                            name="electric_gurney"></td>
                                                </tr>

                                                <tr>
                                                    <th>Manual Gurney</th>
                                                    <td><input type="text" class="form-control" name="manual_gurney">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>PCA (Patient Controlled Anesthesia)</th>
                                                    <td><input type="text" class="form-control" name="pca"></td>
                                                </tr>

                                                <tr>
                                                    <th>COW/WOW (Computer on Wheels)</th>
                                                    <td><input type="text" class="form-control" name="cow"></td>
                                                </tr>

                                                <tr>
                                                    <th>Patient Air Warmer</th>
                                                    <td><input type="text" class="form-control"
                                                            name="patient_air_warmer"></td>
                                                </tr>

                                                <tr>
                                                    <th>Enteral Feeding Pump</th>
                                                    <td><input type="text" class="form-control"
                                                            name="enteral_feeding_pump"></td>
                                                </tr>

                                                <tr>
                                                    <th>Geri Chair</th>
                                                    <td><input type="text" class="form-control" name="geri_chair">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Electric Scale</th>
                                                    <td><input type="text" class="form-control" name="electric_scale">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Defibrillator</th>
                                                    <td><input type="text" class="form-control" name="defibrillator">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Med Cart</th>
                                                    <td><input type="text" class="form-control" name="med_cart"></td>
                                                </tr>

                                                <tr>
                                                    <th>Crash Cart</th>
                                                    <td><input type="text" class="form-control" name="crash_cart">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Bassinet</th>
                                                    <td><input type="text" class="form-control" name="bassinet"></td>
                                                </tr>

                                                <tr>
                                                    <th>Infant Incubator</th>
                                                    <td><input type="text" class="form-control"
                                                            name="infant_incubator"></td>
                                                </tr>

                                                <tr>
                                                    <th>Infant Warmer</th>
                                                    <td><input type="text" class="form-control" name="infant_warmer">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Ultrasound</th>
                                                    <td><input type="text" class="form-control" name="ultrasound">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Overbed Table</th>
                                                    <td><input type="text" class="form-control" name="overbed_table">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Portable Suction Pump</th>
                                                    <td><input type="text" class="form-control"
                                                            name="portable_suction_pump"></td>
                                                </tr>

                                                <tr>
                                                    <th>Stainless Steel Linen Cart</th>
                                                    <td><input type="text" class="form-control"
                                                            name="stainless_steel_linen_cart"></td>
                                                </tr>

                                                <tr>
                                                    <th>Stainless Steel Basin</th>
                                                    <td><input type="text" class="form-control"
                                                            name="stainless_steel_basin"></td>
                                                </tr>

                                                <tr>
                                                    <th>Radiology Vest</th>
                                                    <td><input type="text" class="form-control" name="radiology_vest">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Wall Mounted Computer</th>
                                                    <td><input type="text" class="form-control"
                                                            name="wall_mounted_computer"></td>
                                                </tr>

                                                <tr>
                                                    <th>Telemedicine Device</th>
                                                    <td><input type="text" class="form-control"
                                                            name="telemedicine_device"></td>
                                                </tr>

                                                <tr>
                                                    <th>Blower & Mattress</th>
                                                    <td><input type="text" class="form-control"
                                                            name="blower_mattress"></td>
                                                </tr>

                                                <tr>
                                                    <th>Rolling Transfer Boards</th>
                                                    <td><input type="text" class="form-control"
                                                            name="rolling_transfer_boards"></td>
                                                </tr>

                                                <tr>
                                                    <th>Glucometer</th>
                                                    <td><input type="text" class="form-control" name="glucometer">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Telemetry Monitor</th>
                                                    <td><input type="text" class="form-control"
                                                            name="telemetry_monitor"></td>
                                                </tr>

                                                <tr>
                                                    <th>Telemetry Pack</th>
                                                    <td><input type="text" class="form-control" name="telemetry_pack">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Patient Lift</th>
                                                    <td><input type="text" class="form-control" name="patient_lift">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Heat Lamp</th>
                                                    <td><input type="text" class="form-control" name="heat_lamp"></td>
                                                </tr>

                                                <tr>
                                                    <th>Treadmill</th>
                                                    <td><input type="text" class="form-control" name="treadmill"></td>
                                                </tr>

                                                <tr>
                                                    <th>Recumbant Bike</th>
                                                    <td><input type="text" class="form-control" name="recumbant_bike">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Misc. Carts/Baskets</th>
                                                    <td><input type="text" class="form-control"
                                                            name="misc_carts_baskets"></td>
                                                </tr>

                                                <tr>
                                                    <th>Total Man Hours</th>
                                                    <td><input type="text" class="form-control"
                                                            name="cleaning_man_hours"></td>
                                                </tr>

                                                <tr>
                                                    <th>Total Man Hours Cost</th>
                                                    <td><input type="text" class="form-control"
                                                            name="cleaning_man_hours_cost"></td>
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
    <script>
        $(document).ready(function() {

            $("#equipment_evaluation_form").validate({
                ignore: [],
                rules: {
                    anesthesia_cart: {
                        number: true
                    },
                    or_table: {
                        number: true
                    },
                    stainless_steel_cart: {
                        number: true
                    },
                    stainless_steel_table: {
                        number: true
                    },
                    electrosurgical_device: {
                        number: true
                    },
                    wall_mounted_monitor: {
                        number: true
                    },
                    vital_signs_monitor: {
                        number: true
                    },
                    vital_signs_monitor_ecg: {
                        number: true
                    },
                    dvt_scd_device: {
                        number: true
                    },
                    cpm: {
                        number: true
                    },
                    infusion_pump: {
                        number: true
                    },
                    bipap: {
                        number: true
                    },
                    cpap: {
                        number: true
                    },
                    pulse_oximeter: {
                        number: true
                    },
                    hospital_bed: {
                        number: true
                    },
                    electric_gurney: {
                        number: true
                    },
                    manual_gurney: {
                        number: true
                    },
                    pca: {
                        number: true
                    },
                    cow: {
                        number: true
                    },
                    patient_air_warmer: {
                        number: true
                    },
                    enteral_feeding_pump: {
                        number: true
                    },
                    geri_chair: {
                        number: true
                    },
                    electric_scale: {
                        number: true
                    },
                    defibrillator: {
                        number: true
                    },
                    med_cart: {
                        number: true
                    },
                    crash_cart: {
                        number: true
                    },
                    bassinet: {
                        number: true
                    },
                    infant_incubator: {
                        number: true
                    },
                    infant_warmer: {
                        number: true
                    },
                    ultrasound: {
                        number: true
                    },
                    overbed_table: {
                        number: true
                    },
                    portable_suction_pump: {
                        number: true
                    },
                    stainless_steel_linen_cart: {
                        number: true
                    },
                    stainless_steel_basin: {
                        number: true
                    },
                    radiology_vest: {
                        number: true
                    },
                    wall_mounted_computer: {
                        number: true
                    },
                    telemedicine_device: {
                        number: true
                    },
                    blower_mattress: {
                        number: true
                    },
                    rolling_transfer_boards: {
                        number: true
                    },
                    glucometer: {
                        number: true
                    },
                    telemetry_monitor: {
                        number: true
                    },
                    telemetry_pack: {
                        number: true
                    },
                    patient_lift: {
                        number: true
                    },
                    heat_lamp: {
                        number: true
                    },
                    treadmill: {
                        number: true
                    },
                    recumbant_bike: {
                        number: true
                    },
                    misc_carts_baskets: {
                        number: true
                    },
                    cleaning_man_hours: {
                        number: true
                    },
                    cleaning_man_hours_cost: {
                        number: true
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
                        error.insertAfter(element.parent()); // Inserts after the .input-group
                    } else {
                        error.insertAfter(element); // Default
                    }
                }
            });


            $('#equipment_evaluation_form').submit(function(e) {
                e.preventDefault();

                if (!$('#equipment_evaluation_form').valid()) {
                    return;
                }

                $.ajax({
                    url: '{{ route('admin.equipment_evaluations.store') }}',
                    method: 'POST',
                    data: $(this).serialize(),

                    success: function(response) {
                         Swal.fire({
                            icon: "success",
                            title: "Saved!",
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => location.reload());
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        toastr.error('Something went wrong while adding the evaluation.');
                    }
                });
            });


        });
    </script>
@endpush
