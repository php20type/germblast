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

                                    <form id="district_numbers_form">
                                        @csrf
                                        <input type="hidden" name="lead_id" value="{{ $lead->id }}">

                                        <table class="table table-bordered align-middle">
                                            <tbody>

                                                <tr>
                                                    <th>Equipment Type</th>
                                                    <th>Count</th>
                                                </tr>

                                                <tr>
                                                    <th>Non electric Gurney</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="gurney"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Wheelchair</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="chair"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Transport Chair</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="chair"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>IV Pole</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="pole"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Food Cart</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="cart"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Miscellaneous Pieces to Wash</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="washing_places"
                                                            value="4">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Total Man Hours</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="hours"
                                                            value="12">
                                                    </td>
                                                </tr>

                                                 <tr>
                                                    <th>Total Man Hours Cost</th>
                                                    <td>
                                                        $10.00
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

                                    <form id="district_numbers_form">
                                        @csrf
                                        <input type="hidden" name="lead_id" value="{{ $lead->id }}">

                                        <table class="table table-bordered align-middle">
                                            <tbody>

                                                <tr>
                                                    <th>Equipment Type</th>
                                                    <th>Count</th>
                                                </tr>

                                                 <tr>
                                                    <th>Anesthesia Cart</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="anesthesia_cart"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>OR Table</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="table"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Stainless Steel Cart</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="steel_cart"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Stainless Steel Table</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="steel_table"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Electrosurgical Device</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="electrosurgical_device"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Wall Mounted ECG/EKG Monitor</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="mounted_monitor"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Vital Signs Monitor</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="vital_signs_monitor"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Vital Signs Monitor w/ECG</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="ecg"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>DVT/SCD Device</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="scd_device"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>CPM (Continuous Passive Motion)</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="cpm"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Infusion Pump</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="infusion_pump"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>BiPap</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="BiPap"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>CPAP</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="CPAP"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Pulse Oximeter</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="Pulse Oximeter"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Hospital Bed</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="Hospital Bed"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Electric Gurney</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="Electric Gurney"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Manual Gurney w/Electric Scale</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="Manual Gurney w/Electric Scale"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>PCA (Patient Controlled Anesthesia)</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="pca"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>COW/WOW (Computer on Wheels)</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="cow"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Patient Air Warmer</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="Patient Air Warmer"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Enteral Feeding Pump</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="Enteral Feeding Pump"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Geri Chair (vinyl w/foam)</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="Geri Chair (vinyl w/foam)"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Electric Scale</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="Electric Scale"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Defibrilator</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="Defibrilator"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Med Cart</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="Med Cart"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Crash Cart</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="Crash Cart"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Bassinet</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="Bassinet"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Infant Incubator (Isolette)</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="Infant Incubator (Isolette)"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Infant Incubator (Isolette)</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="Infant Incubator (Isolette)"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Infant Warmer</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="Infant Warmer"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Infant Warmer</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="Infant Warmer"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Ultrasound</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="Ultrasound"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Overbed Table</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="Overbed Table"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Portable Suction Pump</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="Portable Suction Pump"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Stainless Steel Linen Cart</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="Stainless Steel Linen Cart"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Stainless Steel Basin</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="Stainless Steel Basin"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Radiology Vest</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="Radiology Vest"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Wall Mounted Computer</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="Wall Mounted Computer"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Telemedicine Device</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="Telemedicine Device"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>AirPal/Hoovermatt (Blower & Mattress)</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="AirPal/Hoovermatt (Blower & Mattress)"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Rolling Transfer Boards</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="Rolling Transfer Boards"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Glucometer</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="Glucometer"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Telemetry Monitor</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="Telemetry Monitor"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Telemetry Pack</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="Telemetry Pack"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Patient Lift</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="Patient Lift"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Heat Lamp</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="Heat Lamp"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Treadmill</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="Treadmill"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Recumbant Bike</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="Recumbant Bike"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Misc. Carts/Baskets</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="Misc. Carts/Baskets"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Total Man Hours</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="Total Man Hours"
                                                            value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Total Man Hours Cost</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="Total Man Hours Cost"
                                                            value="">
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
