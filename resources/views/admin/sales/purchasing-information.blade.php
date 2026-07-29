@extends('admin.includes.layout')

@section('title', 'GoodBuy / Cooperative Purchasing Information')

@push('styles')
    <style>
        .purchasing-card {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            background-color: #ffffff;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        }
        .purchasing-card .card-header {
            background-color: rgba(255, 184, 28, 0.4); /* Matches company table header pale yellow */
            border-bottom: 1px solid #e5e7eb;
            padding: 18px 24px;
            border-radius: 12px 12px 0 0 !important;
        }
        .purchasing-card .card-header h5 {
            color: #374151;
            font-size: 16px;
            font-weight: 600;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .purchasing-card .card-body {
            padding: 24px;
        }
        .section-subtitle {
            color: #6b7280;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
            margin-top: 20px;
        }
        .section-subtitle:first-child {
            margin-top: 0;
        }
        .purchasing-list {
            list-style: none;
            padding-left: 0;
            margin-bottom: 0;
        }
        .purchasing-list li {
            position: relative;
            padding-left: 16px;
            margin-bottom: 8px;
            font-size: 14px;
        }
        .purchasing-list li::before {
            content: "•";
            color: #9ca3af;
            font-weight: bold;
            position: absolute;
            left: 0;
        }
        .purchasing-list li:last-child {
            margin-bottom: 0;
        }
        .purchasing-link {
            color: #2563eb;
            text-decoration: none;
            font-weight: 500;
        }
        .purchasing-link:hover {
            text-decoration: underline;
            color: #1d4ed8;
        }
        .contract-text {
            color: #1f2937;
            font-size: 14px;
            margin-bottom: 10px;
            font-weight: 500;
        }
    </style>
@endpush

@section('content')
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                @include('admin.sales.sidebar')

                <!-- Main Content -->
                <div class="col-md-10 p-0">
                    <div class="main-content">
                        
                        <!-- Header -->
                        <div class="heading-area-sec mb-4">
                            <div class="left-part-sec">
                                <h3 class="mb-1">PURCHASING INFORMATION <span style="font-size: 24px;">📌</span></h3>
                                <p class="text-muted mb-0">GoodBuy / Cooperative Purchasing Information for Sales Representatives.</p>
                            </div>
                        </div>

                        <!-- Content Container -->
                        <div class="px-4 pb-4">
                            
                            <!-- TIPS Section -->
                            <div class="purchasing-card">
                                <div class="card-header">
                                    <h5>TIPS</h5>
                                </div>
                                <div class="card-body">
                                    <p class="contract-text mb-0">Contract # 200106 - Janitorial and Sanitation Supplies & Service</p>
                                </div>
                            </div>

                            <!-- Allied States Cooperative Section -->
                            <div class="purchasing-card">
                                <div class="card-header">
                                    <h5>Allied States Cooperative Purchasing Cooperative Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="section-subtitle">Pricing & Items</div>
                                            <ul class="purchasing-list">
                                                <li><a href="{{ asset('coop-documents/asc-catalog-price-list.pdf') }}" class="purchasing-link" target="_blank">Catalog & Price List</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="section-subtitle">ASC Letter of Award</div>
                                            <ul class="purchasing-list">
                                                <li><a href="{{ asset('coop-documents/asc-letter-of-award.pdf') }}" class="purchasing-link" target="_blank">ASC Letter</a></li>
                                                <li><a href="{{ asset('coop-documents/asc-2020-renewal.pdf') }}" class="purchasing-link" target="_blank">2020 Renewal</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="section-subtitle">Joining ASC Purchasing Cooperative</div>
                                            <ul class="purchasing-list">
                                                <li><a href="{{ asset('coop-documents/asc-membership-form.pdf') }}" class="purchasing-link" target="_blank">Form to Join ASC</a></li>
                                                <li><a href="{{ asset('coop-documents/asc-board-resolution-template.pdf') }}" class="purchasing-link" target="_blank">Board Resolution Template</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- First Choice Section -->
                            <div class="purchasing-card">
                                <div class="card-header">
                                    <h5>First Choice</h5>
                                </div>
                                <div class="card-body">
                                    <div class="section-subtitle">Files for First Choice</div>
                                    <ul class="purchasing-list">
                                        <li><a href="{{ asset('coop-documents/first-choice-conditions-of-membership.docx') }}" class="purchasing-link" target="_blank">Conditions of Membership</a></li>
                                        <li><a href="{{ asset('coop-documents/first-choice-intent-form.docx') }}" class="purchasing-link" target="_blank">Intent Form</a></li>
                                        <li><a href="{{ asset('coop-documents/first-choice-member-w9.pdf') }}" class="purchasing-link" target="_blank">Member W9</a></li>
                                        <li><a href="{{ asset('coop-documents/first-choice-new-facility-info-sheet.doc') }}" class="purchasing-link" target="_blank">New Facility Info Sheet</a></li>
                                        <li><a href="{{ asset('coop-documents/first-choice-contracted-member-list.xlsx') }}" class="purchasing-link" target="_blank">Contracted Member List</a></li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Goodbuy Purchasing Cooperative Section -->
                            <div class="purchasing-card">
                                <div class="card-header">
                                    <h5>Goodbuy Purchasing Cooperative</h5>
                                </div>
                                <div class="card-body">
                                    <p class="contract-text">Contract # 23-24 2B000 (Custodial/Janitorial: Cleaning Supplies/Equipment)</p>
                                    <p class="contract-text mb-0">Contract # 23-24 7D000 (HVAC: Heating/Ventilation/Air Conditioning Supplies/Equipment)</p>
                                </div>
                            </div>

                            <!-- Southeast Texas Purchasing Cooperative Section -->
                            <div class="purchasing-card">
                                <div class="card-header">
                                    <h5>Southeast Texas Purchasing Cooperative</h5>
                                </div>
                                <div class="card-body">
                                    <p class="contract-text mb-0">Contract # 20230403 (Disaster Restoration & Recovery Services)</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection