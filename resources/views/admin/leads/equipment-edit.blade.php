@extends('admin.includes.layout')

@section('title', 'Equipment Evaluation')

@section('content')
    <!-- All Companies Section start  -->
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">
                <!-- Main Content -->
                <div class="col-md-12 p-0">

                    <form action="{{ route('admin.survey.proposal.equipment.update', $equipment->id) }}" method="POST"
                        id="update-equipment-form" enctype="multipart/form-data">

                        @csrf
                        <input type="hidden" name="equipment_id" value="{{ $equipment->id }}">

                        <div class="sales-dashboard">
                            <div class="dashboard-header section-card d-flex justify-content-between align-items-center">
                                <div class="container-fluid px-0">
                                    <h1 class="display-6 mb-2 fw-bold">Equipment Evaluation</h1>
                                    <p class="text-muted">Record survey results on this page</p>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-success">
                                        Save Evaluations
                                    </button>
                                </div>
                            </div>

                            {{-- Name --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header">
                                            <h3 class="section-title">Create Equipment Evaluation</h3>
                                        </div>

                                        <table class="table table-bordered align-middle">
                                            <tbody>

                                                <tr>
                                                    <th>Name</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="name"
                                                            placeholder="Enter name" value="{{ $equipment->name ?? ' ' }}">
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>

                                    </div>

                                </div>
                            </div>

                            {{-- utilities and drains photos --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header">
                                            <div>
                                                <h3 class="section-title">Utilities and Drains</h3>
                                                <p class="section-subtitle">Upload Photos of the electrical connections,
                                                    water connections and drain area for Wash.
                                                    <br>
                                                    Describe (in detail) where the utilities can be found.
                                                </p>
                                            </div>
                                            <div class="text-end">
                                            </div>
                                        </div>


                                        <table class="table table-bordered align-middle">
                                            <tbody>
                                                <tr>
                                                    <th>Upload Photo</th>
                                                    <td>
                                                        <input type="file" class="form-control" name="utility_file"
                                                            id="utility_file">
                                                        {{-- Preview Box --}}
                                                        <div id="utility-preview" class="mt-2" style="display: none;">
                                                            <img src="" class="img-fluid rounded"
                                                                style="width: 90px; height: 90px; object-fit: cover; border: 1px solid #ccc;">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Description</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="description">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            {{-- Uploaded Pictures List --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header">
                                            <h3 class="section-title">Uploaded Pictures</h3>
                                        </div>

                                        <div class="row">
                                            @forelse ($equipmentImages as $img)
                                                <div class="col-md-3 mb-3">
                                                    <div class="p-3 border rounded">

                                                        <div class="preview row align-items-center">

                                                            {{-- LEFT: Image --}}
                                                            <div class="img-upload col-4 text-center">
                                                                @if (in_array(strtolower(pathinfo($img->file_path, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                                                    <img src="{{ asset('storage/' . $img->file_path) }}"
                                                                        alt="{{ $img->file_name }}"
                                                                        class="img-fluid rounded"
                                                                        style="width: 70px; height: 70px; object-fit: cover;">
                                                                @else
                                                                    <i class="fa-regular fa-file fs-1 text-secondary"></i>
                                                                @endif
                                                            </div>

                                                            {{-- MIDDLE: File Name + Size --}}
                                                            <div class="text-upload col-6">
                                                                <a href="{{ asset('storage/' . $img->file_path) }}"
                                                                    download>
                                                                    <p class="mb-1 fw-semibold">{{ $img->file_name }}</p>
                                                                    <p class="text-muted mb-0 small">
                                                                        {{ number_format(Storage::disk('public')->size($img->file_path) / 1024, 2) }}
                                                                        KB
                                                                    </p>
                                                                </a>
                                                            </div>

                                                            {{-- RIGHT: Delete --}}
                                                            <div class="col-2 text-end">
                                                                <button type="button"
                                                                    class="btn btn-sm btn-outline-danger delete-equipment-image-btn"
                                                                    data-id="{{ $img->id }}" title="Delete file">
                                                                    <i class="fa-solid fa-xmark"></i>
                                                                </button>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                            @empty
                                                <div class="col-md-12">
                                                    <p class="text-muted">No pictures uploaded yet.</p>
                                                </div>
                                            @endforelse
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
                                            </div>
                                        </div>

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
                                                            name="non_electric_gurney"
                                                            value="{{ $equipment->non_electric_gurney ?? '0' }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Wheelchair</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="wheelchair"
                                                            value="{{ $equipment->wheelchair ?? '0' }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Transport Chair</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="transport_chair"
                                                            value="{{ $equipment->transport_chair ?? '0' }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>IV Pole</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="iv_pole"
                                                            value="{{ $equipment->iv_pole ?? '0' }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Food Cart</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="food_cart"
                                                            value="{{ $equipment->food_cart ?? '0' }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Miscellaneous Pieces to Wash</th>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="miscellaneous_pieces"
                                                            value="{{ $equipment->miscellaneous_pieces ?? '0' }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Total Man Hours</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="wash_man_hours"
                                                            value="{{ $equipment->wash_man_hours ?? '0' }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Total Man Hours Cost</th>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="wash_man_hours_cost"
                                                            value="{{ $equipment->wash_man_hours_cost ?? '0' }}">
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>

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
                                            </div>
                                        </div>

                                        <table class="table table-bordered align-middle">
                                            <tbody>

                                                <tr>
                                                    <th>Equipment Type</th>
                                                    <th>Count</th>
                                                </tr>

                                                <tr>
                                                    <th>Anesthesia Cart</th>
                                                    <td><input type="text" class="form-control" name="anesthesia_cart"
                                                            value="{{ $equipment->anesthesia_cart ?? '0' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>OR Table</th>
                                                    <td><input type="text" class="form-control" name="or_table"
                                                            value="{{ $equipment->or_table ?? '0' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Stainless Steel Cart</th>
                                                    <td><input type="text" class="form-control"
                                                            name="stainless_steel_cart"
                                                            value="{{ $equipment->stainless_steel_cart ?? '0' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Stainless Steel Table</th>
                                                    <td><input type="text" class="form-control"
                                                            name="stainless_steel_table"
                                                            value="{{ $equipment->stainless_steel_table ?? '0' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Electrosurgical Device</th>
                                                    <td><input type="text" class="form-control"
                                                            name="electrosurgical_device"
                                                            value="{{ $equipment->electrosurgical_device ?? '0' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Wall Mounted ECG/EKG Monitor</th>
                                                    <td><input type="text" class="form-control"
                                                            name="wall_mounted_monitor"
                                                            value="{{ $equipment->wall_mounted_monitor ?? '0' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Vital Signs Monitor</th>
                                                    <td><input type="text" class="form-control"
                                                            name="vital_signs_monitor"
                                                            value="{{ $equipment->vital_signs_monitor ?? '0' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Vital Signs Monitor w/ECG</th>
                                                    <td><input type="text" class="form-control"
                                                            name="vital_signs_monitor_ecg"
                                                            value="{{ $equipment->vital_signs_monitor_ecg ?? '0' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>DVT/SCD Device</th>
                                                    <td><input type="text" class="form-control" name="dvt_scd_device"
                                                            value="{{ $equipment->dvt_scd_device ?? '0' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>CPM (Continuous Passive Motion)</th>
                                                    <td><input type="text" class="form-control" name="cpm"
                                                            value="{{ $equipment->cpm ?? '0' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Infusion Pump</th>
                                                    <td><input type="text" class="form-control" name="infusion_pump"
                                                            value="{{ $equipment->infusion_pump ?? '0' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>BiPap</th>
                                                    <td><input type="text" class="form-control" name="bipap"
                                                            value="{{ $equipment->bipap ?? '0' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>CPAP</th>
                                                    <td><input type="text" class="form-control" name="cpap"
                                                            value="{{ $equipment->cpap ?? '0' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Pulse Oximeter</th>
                                                    <td><input type="text" class="form-control" name="pulse_oximeter"
                                                            value="{{ $equipment->pulse_oximeter ?? '0' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Hospital Bed</th>
                                                    <td><input type="text" class="form-control" name="hospital_bed"
                                                            value="{{ $equipment->hospital_bed ?? '0' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Electric Gurney</th>
                                                    <td><input type="text" class="form-control" name="electric_gurney"
                                                            value="{{ $equipment->electric_gurney ?? '0' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Manual Gurney</th>
                                                    <td><input type="text" class="form-control" name="manual_gurney"
                                                            value="{{ $equipment->manual_gurney ?? '0' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>PCA (Patient Controlled Anesthesia)</th>
                                                    <td><input type="text" class="form-control" name="pca"
                                                            value="{{ $equipment->pca ?? '0' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>COW/WOW (Computer on Wheels)</th>
                                                    <td><input type="text" class="form-control" name="cow"
                                                            value="{{ $equipment->cow ?? '0' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Patient Air Warmer</th>
                                                    <td><input type="text" class="form-control"
                                                            name="patient_air_warmer"
                                                            value="{{ $equipment->patient_air_warmer ?? '0' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Enteral Feeding Pump</th>
                                                    <td><input type="text" class="form-control"
                                                            name="enteral_feeding_pump"
                                                            value="{{ $equipment->enteral_feeding_pump ?? '0' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Geri Chair</th>
                                                    <td><input type="text" class="form-control" name="geri_chair"
                                                            value="{{ $equipment->geri_chair ?? '0' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Electric Scale</th>
                                                    <td><input type="text" class="form-control" name="electric_scale"
                                                            value="{{ $equipment->electric_scale ?? '0' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Defibrillator</th>
                                                    <td><input type="text" class="form-control" name="defibrillator"
                                                            value="{{ $equipment->defibrillator ?? '0' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Med Cart</th>
                                                    <td><input type="text" class="form-control" name="med_cart"
                                                            value="{{ $equipment->med_cart ?? '0' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Crash Cart</th>
                                                    <td><input type="text" class="form-control" name="crash_cart"
                                                            value="{{ $equipment->crash_cart ?? '0' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Bassinet</th>
                                                    <td><input type="text" class="form-control" name="bassinet"
                                                            value="{{ $equipment->bassinet ?? '0' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Infant Incubator</th>
                                                    <td><input type="text" class="form-control"
                                                            name="infant_incubator"
                                                            value="{{ $equipment->infant_incubator ?? '0' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Infant Warmer</th>
                                                    <td><input type="text" class="form-control" name="infant_warmer"
                                                            value="{{ $equipment->infant_warmer ?? '0' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Ultrasound</th>
                                                    <td><input type="text" class="form-control" name="ultrasound"
                                                            value="{{ $equipment->ultrasound ?? '0' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Overbed Table</th>
                                                    <td><input type="text" class="form-control" name="overbed_table"
                                                            value="{{ $equipment->overbed_table ?? '0' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Portable Suction Pump</th>
                                                    <td><input type="text" class="form-control"
                                                            name="portable_suction_pump"
                                                            value="{{ $equipment->portable_suction_pump ?? '0' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Stainless Steel Linen Cart</th>
                                                    <td><input type="text" class="form-control"
                                                            name="stainless_steel_linen_cart"
                                                            value="{{ $equipment->stainless_steel_linen_cart ?? '0' }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Stainless Steel Basin</th>
                                                    <td><input type="text" class="form-control"
                                                            name="stainless_steel_basin"
                                                            value="{{ $equipment->stainless_steel_basin ?? '0' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Radiology Vest</th>
                                                    <td><input type="text" class="form-control" name="radiology_vest"
                                                            value="{{ $equipment->radiology_vest ?? '0' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Wall Mounted Computer</th>
                                                    <td><input type="text" class="form-control"
                                                            name="wall_mounted_computer"
                                                            value="{{ $equipment->wall_mounted_computer ?? '0' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Telemedicine Device</th>
                                                    <td><input type="text" class="form-control"
                                                            name="telemedicine_device"
                                                            value="{{ $equipment->telemedicine_device ?? '0' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Blower & Mattress</th>
                                                    <td><input type="text" class="form-control" name="blower_mattress"
                                                            value="{{ $equipment->blower_mattress ?? '0' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Rolling Transfer Boards</th>
                                                    <td><input type="text" class="form-control"
                                                            name="rolling_transfer_boards"
                                                            value="{{ $equipment->rolling_transfer_boards ?? '0' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Glucometer</th>
                                                    <td><input type="text" class="form-control" name="glucometer"
                                                            value="{{ $equipment->glucometer ?? '0' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Telemetry Monitor</th>
                                                    <td><input type="text" class="form-control"
                                                            name="telemetry_monitor"
                                                            value="{{ $equipment->telemetry_monitor ?? '0' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Telemetry Pack</th>
                                                    <td><input type="text" class="form-control" name="telemetry_pack"
                                                            value="{{ $equipment->telemetry_pack ?? '0' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Patient Lift</th>
                                                    <td><input type="text" class="form-control" name="patient_lift"
                                                            value="{{ $equipment->patient_lift ?? '0' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Heat Lamp</th>
                                                    <td><input type="text" class="form-control" name="heat_lamp"
                                                            value="{{ $equipment->heat_lamp ?? '0' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Treadmill</th>
                                                    <td><input type="text" class="form-control" name="treadmill"
                                                            value="{{ $equipment->treadmill ?? '0' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Recumbant Bike</th>
                                                    <td><input type="text" class="form-control" name="recumbant_bike"
                                                            value="{{ $equipment->recumbant_bike ?? '0' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Misc. Carts/Baskets</th>
                                                    <td><input type="text" class="form-control"
                                                            name="misc_carts_baskets"
                                                            value="{{ $equipment->misc_carts_baskets ?? '0' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Total Man Hours</th>
                                                    <td><input type="text" class="form-control"
                                                            name="cleaning_man_hours"
                                                            value="{{ $equipment->cleaning_man_hours ?? '0' }}"></td>
                                                </tr>

                                                <tr>
                                                    <th>Total Man Hours Cost</th>
                                                    <td><input type="text" class="form-control"
                                                            name="cleaning_man_hours_cost"
                                                            value="{{ $equipment->cleaning_man_hours_cost ?? '0' }}"></td>
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
        $(document).ready(function() {

            $("#update-equipment-form").validate({
                ignore: [],
                rules: {
                    name: {
                        required: true,
                    },
                    non_electric_gurney: {
                        required: true,
                        number: true
                    },
                    wheelchair: {
                        required: true,
                        number: true
                    },
                    transport_chair: {
                        required: true,
                        number: true
                    },
                    iv_pole: {
                        required: true,
                        number: true
                    },
                    food_cart: {
                        required: true,
                        number: true
                    },
                    miscellaneous_pieces: {
                        required: true,
                        number: true
                    },
                    wash_man_hours: {
                        required: true,
                        number: true
                    },
                    wash_man_hours_cost: {
                        required: true,
                        number: true
                    },
                    anesthesia_cart: {
                        required: true,
                        number: true
                    },
                    or_table: {
                        required: true,
                        number: true
                    },
                    stainless_steel_cart: {
                        required: true,
                        number: true
                    },
                    stainless_steel_table: {
                        required: true,
                        number: true
                    },
                    electrosurgical_device: {
                        required: true,
                        number: true
                    },
                    wall_mounted_monitor: {
                        required: true,
                        number: true
                    },
                    vital_signs_monitor: {
                        required: true,
                        number: true
                    },
                    vital_signs_monitor_ecg: {
                        required: true,
                        number: true
                    },
                    dvt_scd_device: {
                        required: true,
                        number: true
                    },
                    cpm: {
                        required: true,
                        number: true
                    },
                    infusion_pump: {
                        required: true,
                        number: true
                    },
                    bipap: {
                        required: true,
                        number: true
                    },
                    cpap: {
                        required: true,
                        number: true
                    },
                    pulse_oximeter: {
                        required: true,
                        number: true
                    },
                    hospital_bed: {
                        required: true,
                        number: true
                    },
                    electric_gurney: {
                        required: true,
                        number: true
                    },
                    manual_gurney: {
                        required: true,
                        number: true
                    },
                    pca: {
                        required: true,
                        number: true
                    },
                    cow: {
                        required: true,
                        number: true
                    },
                    patient_air_warmer: {
                        required: true,
                        number: true
                    },
                    enteral_feeding_pump: {
                        required: true,
                        number: true
                    },
                    geri_chair: {
                        required: true,
                        number: true
                    },
                    electric_scale: {
                        required: true,
                        number: true
                    },
                    defibrillator: {
                        required: true,
                        number: true
                    },
                    med_cart: {
                        required: true,
                        number: true
                    },
                    crash_cart: {
                        required: true,
                        number: true
                    },
                    bassinet: {
                        required: true,
                        number: true
                    },
                    infant_incubator: {
                        required: true,
                        number: true
                    },
                    infant_warmer: {
                        required: true,
                        number: true
                    },
                    ultrasound: {
                        required: true,
                        number: true
                    },
                    overbed_table: {
                        required: true,
                        number: true
                    },
                    portable_suction_pump: {
                        required: true,
                        number: true
                    },
                    stainless_steel_linen_cart: {
                        required: true,
                        number: true
                    },
                    stainless_steel_basin: {
                        required: true,
                        number: true
                    },
                    radiology_vest: {
                        required: true,
                        number: true
                    },
                    wall_mounted_computer: {
                        required: true,
                        number: true
                    },
                    telemedicine_device: {
                        required: true,
                        number: true
                    },
                    blower_mattress: {
                        required: true,
                        number: true
                    },
                    rolling_transfer_boards: {
                        required: true,
                        number: true
                    },
                    glucometer: {
                        required: true,
                        number: true
                    },
                    telemetry_monitor: {
                        required: true,
                        number: true
                    },
                    telemetry_pack: {
                        required: true,
                        number: true
                    },
                    patient_lift: {
                        required: true,
                        number: true
                    },
                    heat_lamp: {
                        required: true,
                        number: true
                    },
                    treadmill: {
                        required: true,
                        number: true
                    },
                    recumbant_bike: {
                        required: true,
                        number: true
                    },
                    misc_carts_baskets: {
                        required: true,
                        number: true
                    },
                    cleaning_man_hours: {
                        required: true,
                        number: true
                    },
                    cleaning_man_hours_cost: {
                        required: true,
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


            $('#update-equipment-form').submit(function(e) {
                e.preventDefault(); // stop normal submit

                let formData = new FormData(this);

                $.ajax({
                    url: '{{ route('admin.survey.proposal.equipment.update', $equipment->id) }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,

                    success: function(res) {
                        Swal.fire({
                            icon: "success",
                            title: "Updated!",
                            text: res.message ||
                                "Equipment evaluation updated successfully!",
                            showConfirmButton: false,
                            timer: 2000
                        });

                        setTimeout(() => location.reload(), 2000);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        toastr.error('Something went wrong while updating the evaluation.');
                    }
                });
            });



        });

        document.addEventListener("DOMContentLoaded", function() {

            // Reusable preview function
            function setupPreview(inputId, previewId) {
                let input = document.getElementById(inputId);
                let previewContainer = document.getElementById(previewId);

                if (!input || !previewContainer) return; // Element doesn't exist, stop script

                let previewImage = previewContainer.querySelector('img');

                input.addEventListener('change', function(event) {
                    if (event.target.files && event.target.files[0]) {

                        let reader = new FileReader();

                        reader.onload = function(e) {
                            previewImage.src = e.target.result;
                            previewContainer.style.display = 'block';
                        };

                        reader.readAsDataURL(event.target.files[0]);
                    }
                });
            }

            // Attach previews
            setupPreview('utility_file', 'utility-preview');
        });
    </script>
@endpush
