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
                                            <td><input class="form-control-custom" name="TravelBetween" id="TravelBetween" value="0.33"></td>
                                        </tr>
                                        <tr>
                                            <td>Average Miles Per Gallon</td>
                                            <td><input class="form-control-custom" name="MilesPerGallon" id="MilesPerGallon" value="14"></td>
                                        </tr>
                                        <tr>
                                            <td>Average Price Per Gallon</td>
                                            <td><input class="form-control-custom" name="PricePerGallon" id="PricePerGallon" value="3.00"></td>
                                        </tr>
                                        <tr>
                                            <td>Cost Ratio - Awareness</td>
                                            <td><input class="form-control-custom" name="AwarenessPercent" id="AwarenessPercent" value="0.1000"></td>
                                        </tr>
                                        <tr>
                                            <td>Cost Ratio - Education</td>
                                            <td><input class="form-control-custom" name="EducationPercent" id="EducationPercent" value="0.1000"></td>
                                        </tr>
                                        <tr>
                                            <td>Cost Ratio - Technology</td>
                                            <td><input class="form-control-custom" name="TechnologyPercent" id="TechnologyPercent" value="0.0150"></td>
                                        </tr>
                                        <tr>
                                            <td>Cost Ratio - Response</td>
                                            <td><input class="form-control-custom" name="ResponsePercent" id="ResponsePercent" value="0.0900"></td>
                                        </tr>
                                        <tr>
                                            <td>Cost Ratio - Sales/Account Reps</td>
                                            <td><input class="form-control-custom" name="SalesRepPercent" id="SalesRepPercent" value="0.1100"></td>
                                        </tr>
                                        <tr>
                                            <td>Hourly Rate</td>
                                            <td><input class="form-control-custom" name="HourlyRate" id="HourlyRate" value="28.75"></td>
                                        </tr>
                                        <tr>
                                            <td>High School Classrooms</td>
                                            <td><input class="form-control-custom" name="HSClass" id="HSClass" value="0.330"></td>
                                        </tr>
                                        <tr>
                                            <td>Middle School Classrooms</td>
                                            <td><input class="form-control-custom" name="MSClass" id="MSClass" value="0.330"></td>
                                        </tr>
                                        <tr>
                                            <td>Elementary Classrooms</td>
                                            <td><input class="form-control-custom" name="ElemClass" id="ElemClass" value="0.500"></td>
                                        </tr>
                                        <tr>
                                            <td>PreK-2nd Classrooms</td>
                                            <td><input class="form-control-custom" name="PreKClass" id="PreKClass" value="0.650"></td>
                                        </tr>
                                        <tr>
                                            <td>Standard (Community) Bathrooms</td>
                                            <td><input class="form-control-custom" name="StandardBathrooms" id="StandardBathrooms" value="0.200"></td>
                                        </tr>
                                        <tr>
                                            <td>Single Bathrooms</td>
                                            <td><input class="form-control-custom" name="SingleBathrooms" id="SingleBathrooms" value="0.075"></td>
                                        </tr>
                                        <tr>
                                            <td>Cafeteria &amp; Kitchen</td>
                                            <td><input class="form-control-custom" name="Cafeteria" id="Cafeteria" value="1.250"></td>
                                        </tr>
                                        <tr>
                                            <td>Library</td>
                                            <td><input class="form-control-custom" name="Library" id="Library" value="0.750"></td>
                                        </tr>
                                        <tr>
                                            <td>Offices</td>
                                            <td><input class="form-control-custom" name="Offices" id="Offices" value="0.200"></td>
                                        </tr>
                                        <tr>
                                            <td>Lounge</td>
                                            <td><input class="form-control-custom" name="lounge" id="lounge" value="0.33"></td>
                                        </tr>
                                        <tr>
                                            <td>Stairwell (manhour per flight)</td>
                                            <td><input class="form-control-custom" name="Stairwell" id="Stairwell" value="0.12"></td>
                                        </tr>
                                        <tr>
                                            <td>Hotel Guest Room w/Bathroom</td>
                                            <td><input class="form-control-custom" name="guestRoomBR" id="guestRoomBR" value="0.35"></td>
                                        </tr>
                                        <tr>
                                            <td>Laundry Room</td>
                                            <td><input class="form-control-custom" name="laundry" id="laundry" value="0.15"></td>
                                        </tr>
                                        <tr>
                                            <td>Business Center</td>
                                            <td><input class="form-control-custom" name="businessCenter" id="businessCenter" value="0.15"></td>
                                        </tr>
                                        <tr>
                                            <td>Front Desk</td>
                                            <td><input class="form-control-custom" name="frontDesk" id="frontDesk" value="0.25"></td>
                                        </tr>
                                        <tr>
                                            <td>Reception Area</td>
                                            <td><input class="form-control-custom" name="reception" id="reception" value="0.25"></td>
                                        </tr>
                                        <tr>
                                            <td>Elevator</td>
                                            <td><input class="form-control-custom" name="elevator" id="elevator" value="0.07"></td>
                                        </tr>
                                        <tr>
                                            <td>Conference Room</td>
                                            <td><input class="form-control-custom" name="conferenceRoom" id="conferenceRoom" value="0.05"></td>
                                        </tr>
                                        <tr>
                                            <td>Lobby (manhour per chair)</td>
                                            <td><input class="form-control-custom" name="lobby" id="lobby" value="0.05"></td>
                                        </tr>
                                        <tr>
                                            <td>Cubicle</td>
                                            <td><input class="form-control-custom" name="cubicle" id="cubicle" value="0.13"></td>
                                        </tr>
                                        <tr>
                                            <td>Auditorium (Chair Count)</td>
                                            <td><input class="form-control-custom" name="auditorium" id="auditorium" value="0.02"></td>
                                        </tr>
                                        <tr>
                                            <td>Server Room</td>
                                            <td><input class="form-control-custom" name="serverRoom" id="serverRoom" value="0.25"></td>
                                        </tr>
                                        <tr>
                                            <td>Gym/Activity Room</td>
                                            <td><input class="form-control-custom" name="gymActivityRoom" id="gymActivityRoom" value="1.00"></td>
                                        </tr>
                                        <tr>
                                            <td>Football Lockerroom</td>
                                            <td><input class="form-control-custom" name="FootballLockerrooms" id="FootballLockerrooms" value="1.000"></td>
                                        </tr>
                                        <tr>
                                            <td>Regular Lockerroom</td>
                                            <td><input class="form-control-custom" name="RegularLockerrooms" id="RegularLockerrooms" value="0.850"></td>
                                        </tr>
                                        <tr>
                                            <td>Weight Room</td>
                                            <td><input class="form-control-custom" name="WeightRoom" id="WeightRoom" value="1.500"></td>
                                        </tr>
                                        <tr>
                                            <td>Training Room</td>
                                            <td><input class="form-control-custom" name="TrainingRoom" id="TrainingRoom" value="0.550"></td>
                                        </tr>
                                        <tr>
                                            <td>Equipment Room</td>
                                            <td><input class="form-control-custom" name="EquipmentRoom" id="EquipmentRoom" value="0.500"></td>
                                        </tr>
                                        <tr>
                                            <td>Coach's Office</td>
                                            <td><input class="form-control-custom" name="CoachsOffice" id="CoachsOffice" value="0.150"></td>
                                        </tr>
                                        <tr>
                                            <td>Shoulder Pads</td>
                                            <td><input class="form-control-custom" name="ShoulderPads" id="ShoulderPads" value="0.035"></td>
                                        </tr>
                                        <tr>
                                            <td>Helmets</td>
                                            <td><input class="form-control-custom" name="Helmets" id="Helmets" value="0.045"></td>
                                        </tr>
                                        <tr>
                                            <td>Wrestling Mats</td>
                                            <td><input class="form-control-custom" name="WrestlingMats" id="WrestlingMats" value="0.750"></td>
                                        </tr>
                                        <tr>
                                            <td>Med Surg Rooms</td>
                                            <td><input class="form-control-custom" name="MedSurg" id="MedSurg" value="0.400"></td>
                                        </tr>
                                        <tr>
                                            <td>ICU Rooms</td>
                                            <td><input class="form-control-custom" name="ICU" id="ICU" value="0.750"></td>
                                        </tr>
                                        <tr>
                                            <td>Common Areas (count chairs)</td>
                                            <td><input class="form-control-custom" name="CommonAreas" id="CommonAreas" value="0.050"></td>
                                        </tr>
                                        <tr>
                                            <td>Radiology</td>
                                            <td><input class="form-control-custom" name="Radiology" id="Radiology" value="0.330"></td>
                                        </tr>
                                        <tr>
                                            <td>Respiratory Therapy</td>
                                            <td><input class="form-control-custom" name="RespiratoryTherapy" id="RespiratoryTherapy" value="0.280"></td>
                                        </tr>
                                        <tr>
                                            <td>Operating Room</td>
                                            <td><input class="form-control-custom" name="OperatingRoom" id="OperatingRoom" value="1.000"></td>
                                        </tr>
                                        <tr>
                                            <td>PACU beds</td>
                                            <td><input class="form-control-custom" name="PACU" id="PACU" value="0.250"></td>
                                        </tr>
                                        <tr>
                                            <td>Burn ICU Rooms</td>
                                            <td><input class="form-control-custom" name="BurnICU" id="BurnICU" value="0.900"></td>
                                        </tr>
                                        <tr>
                                            <td>Cancer Center</td>
                                            <td><input class="form-control-custom" name="CancerCenter" id="CancerCenter" value="0.330"></td>
                                        </tr>
                                        <tr>
                                            <td>Dialysis Rooms</td>
                                            <td><input class="form-control-custom" name="Dialysis" id="Dialysis" value="0.330"></td>
                                        </tr>
                                        <tr>
                                            <td>Labor and Delivery Patient Rooms</td>
                                            <td><input class="form-control-custom" name="LaborDeliveryRoom" id="LaborDeliveryRoom" value="0.500"></td>
                                        </tr>
                                        <tr>
                                            <td>Computer Lab</td>
                                            <td><input class="form-control-custom" name="ComputerLab" id="ComputerLab" value="0.500"></td>
                                        </tr>
                                        <tr>
                                            <td>Nurses Office</td>
                                            <td><input class="form-control-custom" name="NursesOffice" id="NursesOffice" value="0.250"></td>
                                        </tr>
                                        <tr>
                                            <td>Special Education Room</td>
                                            <td><input class="form-control-custom" name="SpecialEd" id="SpecialEd" value="1.000"></td>
                                        </tr>
                                        <tr>
                                            <td>Teacher's Lounge/Workroom</td>
                                            <td><input class="form-control-custom" name="TeachersLounge" id="TeachersLounge" value="0.250"></td>
                                        </tr>
                                        <tr>
                                            <td>Emergency Dept. Room</td>
                                            <td><input class="form-control-custom" name="EDRoom" id="EDRoom" value="0.400"></td>
                                        </tr>
                                        <tr>
                                            <td>Emergency Dept. Trauma Room</td>
                                            <td><input class="form-control-custom" name="EDTraumaRoom" id="EDTraumaRoom" value="0.500"></td>
                                        </tr>
                                        <tr>
                                            <td>Clinic Room</td>
                                            <td><input class="form-control-custom" name="ClinicRoom" id="ClinicRoom" value="0.250"></td>
                                        </tr>
                                        <tr>
                                            <td>Dietary</td>
                                            <td><input class="form-control-custom" name="Dietary" id="Dietary" value="1.500"></td>
                                        </tr>
                                        <tr>
                                            <td>Break Room</td>
                                            <td><input class="form-control-custom" name="Breakroom" id="Breakroom" value="0.330"></td>
                                        </tr>
                                        <tr>
                                            <td>Lab</td>
                                            <td><input class="form-control-custom" name="Lab" id="Lab" value="0.750"></td>
                                        </tr>
                                        <tr>
                                            <td>Pharmacy</td>
                                            <td><input class="form-control-custom" name="Pharmacy" id="Pharmacy" value="0.750"></td>
                                        </tr>
                                        <tr>
                                            <td>Cysto Room</td>
                                            <td><input class="form-control-custom" name="CystoRoom" id="CystoRoom" value="1.00"></td>
                                        </tr>
                                        <tr>
                                            <td>Interventional Radiology (IR) Lab</td>
                                            <td><input class="form-control-custom" name="IntRadiology" id="IntRadiology" value="1.00"></td>
                                        </tr>
                                        <tr>
                                            <td>Cath Lab</td>
                                            <td><input class="form-control-custom" name="CathLab" id="CathLab" value="1.00"></td>
                                        </tr>
                                        <tr>
                                            <td>Endoscopy Room</td>
                                            <td><input class="form-control-custom" name="EndoRoom" id="EndoRoom" value="1.00"></td>
                                        </tr>
                                        <tr>
                                            <td>Nurses Station</td>
                                            <td><input class="form-control-custom" name="NursesStation" id="NursesStation" value="0.250"></td>
                                        </tr>
                                        <tr>
                                            <td>Clinic - Procedure Rooms</td>
                                            <td><input class="form-control-custom" name="ClinProcRm" id="ClinProcRm" value="0.25"></td>
                                        </tr>
                                        <tr>
                                            <td>Clinic - Exam Room</td>
                                            <td><input class="form-control-custom" name="ClinExRm" id="ClinExRm" value="0.25"></td>
                                        </tr>
                                        <tr>
                                            <td>Clinic - Nurses Station</td>
                                            <td><input class="form-control-custom" name="ClinNS" id="ClinNS" value="0.25"></td>
                                        </tr>
                                        <tr>
                                            <td>Clinic - Office</td>
                                            <td><input class="form-control-custom" name="ClinOff" id="ClinOff" value="0.25"></td>
                                        </tr>
                                        <tr>
                                            <td>Clinic - Break Room</td>
                                            <td><input class="form-control-custom" name="ClinBreak" id="ClinBreak" value="0.25"></td>
                                        </tr>
                                        <tr>
                                            <td>Clinic - Lobby (price based on chair count)</td>
                                            <td><input class="form-control-custom" name="ClinLobby" id="ClinLobby" value="0.05"></td>
                                        </tr>
                                        <tr>
                                            <td>Physical Therapy</td>
                                            <td><input class="form-control-custom" name="PhysTher" id="PhysTher" value="1.00"></td>
                                        </tr>
                                        <tr>
                                            <td>Rehab Center</td>
                                            <td><input class="form-control-custom" name="RehabCenter" id="RehabCenter" value="0.87"></td>
                                        </tr>
                                        <tr>
                                            <td>Activity Room</td>
                                            <td><input class="form-control-custom" name="ActRoom" id="ActRoom" value="0.83"></td>
                                        </tr>
                                        <tr>
                                            <td>Residential less than 2500 sq ft</td>
                                            <td><input class="form-control-custom" name="Res2500" id="Res2500" value="349.00"></td>
                                        </tr>
                                        <tr>
                                            <td>Residential less than 3500 sq ft</td>
                                            <td><input class="form-control-custom" name="Res3500" id="Res3500" value="449.00"></td>
                                        </tr>
                                        <tr>
                                            <td>Residential less than 4500 sq ft</td>
                                            <td><input class="form-control-custom" name="Res4000" id="Res4000" value="549.00"></td>
                                        </tr>
                                        <tr>
                                            <td>Residential less than 5500 sq ft</td>
                                            <td><input class="form-control-custom" name="Res5500" id="Res5500" value="649.00"></td>
                                        </tr>
                                        <tr>
                                            <td>Anesthesia Cart</td>
                                            <td><input class="form-control-custom" name="AnesCart" id="AnesCart" value="0.12"></td>
                                        </tr>
                                        <tr>
                                            <td>OR Table</td>
                                            <td><input class="form-control-custom" name="ORTable" id="ORTable" value="0.25"></td>
                                        </tr>
                                        <tr>
                                            <td>Stainless Steel Cart</td>
                                            <td><input class="form-control-custom" name="SSCart" id="SSCart" value="0.15"></td>
                                        </tr>
                                        <tr>
                                            <td>Stainless Steel Table</td>
                                            <td><input class="form-control-custom" name="SSTable" id="SSTable" value="0.11"></td>
                                        </tr>
                                        <tr>
                                            <td>Electrosurgical Device</td>
                                            <td><input class="form-control-custom" name="ElecSurgDev" id="ElecSurgDev" value="0.12"></td>
                                        </tr>
                                        <tr>
                                            <td>ECG/EKG Monitor</td>
                                            <td><input class="form-control-custom" name="ECGMon" id="ECGMon" value="0.12"></td>
                                        </tr>
                                        <tr>
                                            <td>Vital Signs Monitor</td>
                                            <td><input class="form-control-custom" name="VSMon" id="VSMon" value="0.12"></td>
                                        </tr>
                                        <tr>
                                            <td>Vital Signs Monitor w/ECG</td>
                                            <td><input class="form-control-custom" name="VSMonECG" id="VSMonECG" value="0.12"></td>
                                        </tr>
                                        <tr>
                                            <td>DVT/SCD Device</td>
                                            <td><input class="form-control-custom" name="DVTSCD" id="DVTSCD" value="0.12"></td>
                                        </tr>
                                        <tr>
                                            <td>CPM (Continuous Passive Motion)</td>
                                            <td><input class="form-control-custom" name="CPM" id="CPM" value="0.15"></td>
                                        </tr>
                                        <tr>
                                            <td>Infusion Pump</td>
                                            <td><input class="form-control-custom" name="InfuPump" id="InfuPump" value="0.12"></td>
                                        </tr>
                                        <tr>
                                            <td>Ventilator</td>
                                            <td><input class="form-control-custom" name="Vent" id="Vent" value="0.15"></td>
                                        </tr>
                                        <tr>
                                            <td>BiPap</td>
                                            <td><input class="form-control-custom" name="BiPap" id="BiPap" value="0.12"></td>
                                        </tr>
                                        <tr>
                                            <td>CPAP</td>
                                            <td><input class="form-control-custom" name="CPAP" id="CPAP" value="0.12"></td>
                                        </tr>
                                        <tr>
                                            <td>Pulse Oximeter</td>
                                            <td><input class="form-control-custom" name="PulsOx" id="PulsOx" value="0.12"></td>
                                        </tr>
                                        <tr>
                                            <td>Hospital Bed</td>
                                            <td><input class="form-control-custom" name="HospBed" id="HospBed" value="0.25"></td>
                                        </tr>
                                        <tr>
                                            <td>Electric Gurney</td>
                                            <td><input class="form-control-custom" name="ElecGurn" id="ElecGurn" value="0.25"></td>
                                        </tr>
                                        <tr>
                                            <td>Manual Gurney w/Electric Scale</td>
                                            <td><input class="form-control-custom" name="GurnScale" id="GurnScale" value="0.30"></td>
                                        </tr>
                                        <tr>
                                            <td>PCA (Patient Controlled Anesthesia)</td>
                                            <td><input class="form-control-custom" name="PCA" id="PCA" value="0.12"></td>
                                        </tr>
                                        <tr>
                                            <td>COW/WOW (Computer on Wheels)</td>
                                            <td><input class="form-control-custom" name="COW" id="COW" value="0.12"></td>
                                        </tr>
                                        <tr>
                                            <td>Patient Air Warmer</td>
                                            <td><input class="form-control-custom" name="AirWarm" id="AirWarm" value="0.12"></td>
                                        </tr>
                                        <tr>
                                            <td>Enteral Feeding Pump</td>
                                            <td><input class="form-control-custom" name="EntFeedPump" id="EntFeedPump" value="0.12"></td>
                                        </tr>
                                        <tr>
                                            <td>Geri Chair (vinyl w/foam)</td>
                                            <td><input class="form-control-custom" name="GeriChair" id="GeriChair" value="0.17"></td>
                                        </tr>
                                        <tr>
                                            <td>Electric Scale</td>
                                            <td><input class="form-control-custom" name="ElecScale" id="ElecScale" value="0.12"></td>
                                        </tr>
                                        <tr>
                                            <td>Defibrilator</td>
                                            <td><input class="form-control-custom" name="Defib" id="Defib" value="0.12"></td>
                                        </tr>
                                        <tr>
                                            <td>Med Cart</td>
                                            <td><input class="form-control-custom" name="MedCart" id="MedCart" value="0.15"></td>
                                        </tr>
                                        <tr>
                                            <td>Crash Cart</td>
                                            <td><input class="form-control-custom" name="CrashCart" id="CrashCart" value="0.20"></td>
                                        </tr>
                                        <tr>
                                            <td>Bassinet</td>
                                            <td><input class="form-control-custom" name="Bassinet" id="Bassinet" value="0.20"></td>
                                        </tr>
                                        <tr>
                                            <td>Infant Incubator (Isolette)</td>
                                            <td><input class="form-control-custom" name="InfIncub" id="InfIncub" value="0.20"></td>
                                        </tr>
                                        <tr>
                                            <td>Infant Warmer</td>
                                            <td><input class="form-control-custom" name="InfWarm" id="InfWarm" value="0.20"></td>
                                        </tr>
                                        <tr>
                                            <td>Ultrasound</td>
                                            <td><input class="form-control-custom" name="Ultrasound" id="Ultrasound" value="0.12"></td>
                                        </tr>
                                        <tr>
                                            <td>Overbed Table</td>
                                            <td><input class="form-control-custom" name="OverTable" id="OverTable" value="0.10"></td>
                                        </tr>
                                        <tr>
                                            <td>Portable Suction Pump</td>
                                            <td><input class="form-control-custom" name="PortSucPump" id="PortSucPump" value="0.10"></td>
                                        </tr>
                                        <tr>
                                            <td>Stainless Steel Linen Cart</td>
                                            <td><input class="form-control-custom" name="SSLinenCart" id="SSLinenCart" value="0.12"></td>
                                        </tr>
                                        <tr>
                                            <td>Stainless Steel Basin</td>
                                            <td><input class="form-control-custom" name="SSBasin" id="SSBasin" value="0.12"></td>
                                        </tr>
                                        <tr>
                                            <td>Radiology Vest</td>
                                            <td><input class="form-control-custom" name="RadioVest" id="RadioVest" value="0.08"></td>
                                        </tr>
                                        <tr>
                                            <td>Wall Mounted Computer</td>
                                            <td><input class="form-control-custom" name="WallPC" id="WallPC" value="0.08"></td>
                                        </tr>
                                        <tr>
                                            <td>Telemedicine Device</td>
                                            <td><input class="form-control-custom" name="TeleMed" id="TeleMed" value="0.10"></td>
                                        </tr>
                                        <tr>
                                            <td>AirPal/Hoovermatt (Blower &amp; Mattress)</td>
                                            <td><input class="form-control-custom" name="AirPal" id="AirPal" value="0.10"></td>
                                        </tr>
                                        <tr>
                                            <td>Rolling Transfer Boards</td>
                                            <td><input class="form-control-custom" name="XferBoard" id="XferBoard" value="0.10"></td>
                                        </tr>
                                        <tr>
                                            <td>Glucometer</td>
                                            <td><input class="form-control-custom" name="Gluc" id="Gluc" value="0.08"></td>
                                        </tr>
                                        <tr>
                                            <td>Telemetry Monitor</td>
                                            <td><input class="form-control-custom" name="TeleMon" id="TeleMon" value="0.08"></td>
                                        </tr>
                                        <tr>
                                            <td>Telemetry Pack</td>
                                            <td><input class="form-control-custom" name="TelePack" id="TelePack" value="0.04"></td>
                                        </tr>
                                        <tr>
                                            <td>Patient Lift</td>
                                            <td><input class="form-control-custom" name="PTLift" id="PTLift" value="0.08"></td>
                                        </tr>
                                        <tr>
                                            <td>Heat Lamp</td>
                                            <td><input class="form-control-custom" name="HeatLamp" id="HeatLamp" value="0.08"></td>
                                        </tr>
                                        <tr>
                                            <td>Treadmill</td>
                                            <td><input class="form-control-custom" name="Treadmill" id="Treadmill" value="0.08"></td>
                                        </tr>
                                        <tr>
                                            <td>Recumbant Bike</td>
                                            <td><input class="form-control-custom" name="RecumBike" id="RecumBike" value="0.08"></td>
                                        </tr>
                                        <tr>
                                            <td>Misc. Carts/Baskets</td>
                                            <td><input class="form-control-custom" name="MiscCart" id="MiscCart" value="0.16"></td>
                                        </tr>
                                        <tr>
                                            <td>Wash - Non electric Gurneys</td>
                                            <td><input class="form-control-custom" name="washGurney" id="washGurney" value="0.50"></td>
                                        </tr>
                                        <tr>
                                            <td>Wash - Wheelchairs</td>
                                            <td><input class="form-control-custom" name="washWheelchair" id="washWheelchair" value="0.33"></td>
                                        </tr>
                                        <tr>
                                            <td>Wash - Transport Chair</td>
                                            <td><input class="form-control-custom" name="washTChair" id="washTChair" value="0.33"></td>
                                        </tr>
                                        <tr>
                                            <td>Wash - IV Pole</td>
                                            <td><input class="form-control-custom" name="washIVPole" id="washIVPole" value="0.10"></td>
                                        </tr>
                                        <tr>
                                            <td>Wash - Food Cart</td>
                                            <td><input class="form-control-custom" name="washFoodCart" id="washFoodCart" value="0.65"></td>
                                        </tr>
                                        <tr>
                                            <td>Wash - Misc. Piece</td>
                                            <td><input class="form-control-custom" name="washMisc" id="washMisc" value="0.50"></td>
                                        </tr>
                                        <tr>
                                            <td>INVENTORY - Disposable Microfiber - each</td>
                                            <td><input class="form-control-custom" name="InvDisMicrofiber" id="InvDisMicrofiber" value="10.59"></td>
                                        </tr>
                                        <tr>
                                            <td>INVENTORY - ATP Swabs - each</td>
                                            <td><input class="form-control-custom" name="InvSwab" id="InvSwab" value="1.71"></td>
                                        </tr>
                                        <tr>
                                            <td>INVENTORY - Water - gallon</td>
                                            <td><input class="form-control-custom" name="InvWater" id="InvWater" value="1.63"></td>
                                        </tr>
                                        <tr>
                                            <td>INVENTORY - Oxivir - gallon diluted (concentrate/16)</td>
                                            <td><input class="form-control-custom" name="InvOxivir" id="InvOxivir" value="1.76"></td>
                                        </tr>
                                        <tr>
                                            <td>INVENTORY - Opticide - gallon</td>
                                            <td><input class="form-control-custom" name="InvOpticide" id="InvOpticide" value="10.64"></td>
                                        </tr>
                                        <tr>
                                            <td>INVENTORY - Halomist - gallon</td>
                                            <td><input class="form-control-custom" name="InvHalomist" id="InvHalomist" value="80.00"></td>
                                        </tr>
                                        <tr>
                                            <td>INVENTORY - Gloves - box</td>
                                            <td><input class="form-control-custom" name="InvGloves" id="InvGloves" value="15.50"></td>
                                        </tr>
                                        <tr>
                                            <td>INVENTORY - Sterifab - gallon</td>
                                            <td><input class="form-control-custom" name="InvSterifab" id="InvSterifab" value="50.74"></td>
                                        </tr>
                                        <tr>
                                            <td>INVENTORY - D2 - gallon</td>
                                            <td><input class="form-control-custom" name="InvD2" id="InvD2" value="15.50"></td>
                                        </tr>
                                        <tr>
                                            <td>INVENTORY - Bioshield 75 - gallon (if Proshield, divide gallon by 8)</td>
                                            <td><input class="form-control-custom" name="InvShield" id="InvShield" value="10.07"></td>
                                        </tr>
                                        <tr>
                                            <td>Buses - Flat Price per Bus per Service</td>
                                            <td><input class="form-control-custom" name="BusPrice" id="BusPrice" value="45.00"></td>
                                        </tr>
                                        <tr>
                                            <td>Price Per Square Foot (used only in special circumstances)</td>
                                            <td><input class="form-control-custom" name="PricePerSqFt" id="PricePerSqFt" value="0.035"></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td><button type="submit" name="updateini" id="updateini" class="btn btn-primary" style="border-radius: 6px; font-weight: 500; font-size: 14px; padding: 6px 20px;">Update</button></td>
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
