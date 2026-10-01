@extends('admin.includes.layout')

@section('title', 'Outstanding Nominations Management')

@push('styles')
<style>
    .section-card {
        background: #fff;
        border: 1px solid #f0f0f0;
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 24px;
    }

    .section-title {
        font-size: 16px;
        font-weight: 700;
        color: #374151;
        text-transform: uppercase;
        letter-spacing: .5px;
        margin-bottom: 5px;
    }

    .survey-title {
        font-size: 16px;
        font-weight: 600;
        color: #4b5563;
        margin-top: 24px;
        margin-bottom: 12px;
    }
    
    .office-title {
        color: #6b7280;
        font-size: 14px;
        margin-bottom: 12px;
    }

    .no-votes {
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 20px;
        font-style: italic;
    }

    .results-container {
        padding-left: 20px;
        margin-top: 20px;
    }

    /* Override table styling to match the rest of the HR module */
    .equipment-report-table th {
        background-color: #f9fafb !important;
        color: #374151 !important;
        font-weight: 600 !important;
        font-size: 13px !important;
        border-bottom: 1px solid #e5e7eb !important;
        padding: 12px !important;
    }

    .equipment-report-table td {
        font-size: 13px !important;
        color: #4b5563 !important;
        vertical-align: middle !important;
        padding: 12px !important;
        border-bottom: 1px solid #f3f4f6 !important;
    }
</style>
@endpush

@section('content')
<div class="companies-section my-4">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @include('admin.hr.sidebar')

            <!-- Main Content -->
            <div class="col-md-10 p-0">
                <div class="main-content">
                    <div class="sales-dashboard">

                        {{-- Header --}}
                        <div class="heading-area-sec mb-4">
                            <div class="left-part-sec">
                                <h3 class="mb-1 text-uppercase">OUTSTANDING AWARDS / NOMINATIONS</h3>
                                <p class="text-muted mb-0">
                                    Manage outstanding technician, team member, and management nominations.
                                </p>
                            </div>
                        </div>

                        {{-- Section 1: Technician --}}
                        <div class="px-4 pb-2">
                            <div class="section-card">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <div class="section-title">Outstanding Technician of the Quarter Management</div>
                                        <p class="text-muted mb-0" style="font-size: 14px;">Results from Previous Voting Sessions (last 3)</p>
                                    </div>
                                    <button class="btn btn-export">Initiate a New Vote</button>
                                </div>

                                <div class="results-container">
                                    <div class="survey-title">Voting Results for Survey from 9/2026</div>
                                    
                                    <div class="office-title">Nominations (in order of votes) for the Lubbock, TX office.</div>
                                    <div class="no-votes">No votes on this one.</div>
                                    
                                    <div class="office-title">Nominations (in order of votes) for the Austin, TX office.</div>
                                    <div class="no-votes">No votes on this one.</div>
                                    
                                    <div class="office-title">Nominations (in order of votes) for the El Paso, TX office.</div>
                                    <div class="no-votes">No votes on this one.</div>
                                    
                                    <div class="office-title">Nominations (in order of votes) for the Dallas, TX office.</div>
                                    <div class="no-votes">No votes on this one.</div>

                                    <div class="office-title">Nominations (in order of votes) for the Houston, TX office.</div>
                                    <div class="no-votes">No votes on this one.</div>

                                    <div class="office-title">Nominations (in order of votes) for the Central America office.</div>
                                    <div class="no-votes">No votes on this one.</div>
                                    
                                    <div class="office-title">Nominations (in order of votes) for the Fort Myers, FL office.</div>
                                    <div class="no-votes">No votes on this one.</div>

                                    <div class="office-title">Nominations (in order of votes) for the Anytown, USA office.</div>
                                    <div class="no-votes">No votes on this one.</div>

                                    <div class="survey-title mt-4">Voting Results for Survey from 12/2021</div>
                                    <div class="office-title">Nominations (in order of votes) for the Lubbock, TX office.</div>
                                    <div class="table-responsive">
                                        <table class="table w-100 equipment-report-table mb-4">
                                            <thead>
                                                <tr>
                                                    <th>Technician</th>
                                                    <th style="width: 150px;">Votes</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><strong>John Smith</strong></td>
                                                    <td>2</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Section 2: Warehouse --}}
                        <div class="px-4 pb-2">
                            <div class="section-card">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <div class="section-title">Outstanding Warehouse Team Member of the Quarter Management</div>
                                        <p class="text-muted mb-0" style="font-size: 14px;">Results from Previous Voting Sessions (last 3)</p>
                                    </div>
                                    <button class="btn btn-export">Initiate a New Vote</button>
                                </div>

                                <div class="results-container">
                                    <div class="survey-title">Voting Results for Survey from 12/2021</div>
                                    
                                    <div class="office-title">Nominations (in order of votes) for the Lubbock, TX office.</div>
                                    <div class="table-responsive">
                                        <table class="table w-100 equipment-report-table mb-4">
                                            <thead>
                                                <tr>
                                                    <th>Warehouse Technician</th>
                                                    <th style="width: 150px;">Votes</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr><td><strong>Riley Loya</strong></td><td>4</td></tr>
                                                <tr><td><strong>Irby Munoz</strong></td><td>2</td></tr>
                                                <tr><td><strong>Cody Thurman</strong></td><td>1</td></tr>
                                                <tr><td><strong>Larry Chavez</strong></td><td>1</td></tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="office-title">Nominations (in order of votes) for the Austin, TX office.</div>
                                    <div class="table-responsive">
                                        <table class="table w-100 equipment-report-table mb-4">
                                            <thead>
                                                <tr>
                                                    <th>Warehouse Technician</th>
                                                    <th style="width: 150px;">Votes</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr><td><strong>Bradley Kozumplik</strong></td><td>1</td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <div class="office-title">Nominations (in order of votes) for the El Paso, TX office.</div>
                                    <div class="table-responsive">
                                        <table class="table w-100 equipment-report-table mb-4">
                                            <thead>
                                                <tr>
                                                    <th>Warehouse Technician</th>
                                                    <th style="width: 150px;">Votes</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr><td><strong>Jorge Cruz</strong></td><td>5</td></tr>
                                                <tr><td><strong>Bobby Marc Quezada</strong></td><td>4</td></tr>
                                                <tr><td><strong>Zachary Saucedo</strong></td><td>2</td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Section 3: Supervisor --}}
                        <div class="px-4 pb-2">
                            <div class="section-card">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <div class="section-title">Outstanding Supervisor Nomination System Management</div>
                                        <p class="text-muted mb-0" style="font-size: 14px;">Results from Previous Nomination Sessions (last 1)</p>
                                    </div>
                                    <button class="btn btn-export">Initiate a New Vote</button>
                                </div>

                                <div class="results-container">
                                    <div class="survey-title">Nomination Results for Survey from 12/2021</div>
                                    
                                    <div class="office-title">Supervisor Nominations (in order of votes) for the Lubbock, TX office.</div>
                                    <div class="table-responsive">
                                        <table class="table w-100 equipment-report-table mb-4">
                                            <thead>
                                                <tr>
                                                    <th style="width: 150px;">Supervisor</th>
                                                    <th>Nominations</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="align-top"><strong>Justice<br>Delgado</strong></td>
                                                    <td>
                                                        <div class="mb-1 text-muted">6 nominations</div>
                                                        <div>Jacob Porter - </div>
                                                        <div>Jordan Olivas - </div>
                                                        <div>Thomas Cantu - </div>
                                                        <div>Justice Delgado - </div>
                                                        <div>Greg Garcia - </div>
                                                        <div>Cody Thurman - He always strives to do a thorough job. He communicates and handles issues during services well.</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="align-top"><strong>Jacob Backus</strong></td>
                                                    <td>
                                                        <div class="mb-1 text-muted">5 nominations</div>
                                                        <div>Joel Guerrero - </div>
                                                        <div>Jessica Yates - </div>
                                                        <div>Riley Loya - </div>
                                                        <div>Irby Munoz - </div>
                                                        <div>Josie Warner - </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <div class="office-title">Supervisor Nominations (in order of votes) for the Austin, TX office.</div>
                                    <div class="table-responsive">
                                        <table class="table w-100 equipment-report-table mb-4">
                                            <thead>
                                                <tr>
                                                    <th style="width: 150px;">Supervisor</th>
                                                    <th>Nominations</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="align-top"><strong>Courtney Leath</strong></td>
                                                    <td>
                                                        <div class="mb-1 text-muted">4 nominations</div>
                                                        <div>Benigno Avalos - </div>
                                                        <div>Joshua Chavarria - Truly believes in the Germblast mission!</div>
                                                        <div>Monica Scott - </div>
                                                        <div>Jon Albrecht - Very supporting. Gives good guidance.</div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="office-title">Supervisor Nominations (in order of votes) for the El Paso, TX office.</div>
                                    <div class="no-votes">No votes on this one.</div>
                                </div>
                            </div>
                        </div>

                        {{-- Section 4: Operations Manager --}}
                        <div class="px-4 pb-4">
                            <div class="section-card">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <div class="section-title">Outstanding Operations Manager Nomination System Management</div>
                                        <p class="text-muted mb-0" style="font-size: 14px;">Results from Previous Nomination Sessions (last 1)</p>
                                    </div>
                                    <button class="btn btn-export">Initiate a New Vote</button>
                                </div>

                                <div class="results-container">
                                    <div class="survey-title">Nomination Results for Survey from 12/2021</div>
                                    
                                    <div class="office-title">Supervisor Nominations (in order of votes) for the Lubbock, TX office.</div>
                                    <div class="table-responsive">
                                        <table class="table w-100 equipment-report-table mb-4">
                                            <thead>
                                                <tr>
                                                    <th style="width: 150px;">OM</th>
                                                    <th>Nominations</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="align-top"><strong>Jacob Porter</strong></td>
                                                    <td>
                                                        <div class="mb-1 text-muted">8 nominations</div>
                                                        <div>Jordan Olivas - </div>
                                                        <div>Jacob Backus - Lead by example. Always listens to what I have to say</div>
                                                        <div>Greg Garcia - </div>
                                                        <div>Jessica Yates - </div>
                                                        <div>Colin Veazey - </div>
                                                        <div>Jorge Morales - </div>
                                                        <div>Irby Munoz - </div>
                                                        <div>Cody Thurman - He is always willing to work with his co-workers. He makes himself available to talk to and easy to reach.</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="align-top"><strong>Jordan<br>Olivas</strong></td>
                                                    <td>
                                                        <div class="mb-1 text-muted">2 nominations</div>
                                                        <div>Riley Loya - </div>
                                                        <div>Josie Warner - </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <div class="office-title">Supervisor Nominations (in order of votes) for the Austin, TX office.</div>
                                    <div class="table-responsive">
                                        <table class="table w-100 equipment-report-table mb-4">
                                            <thead>
                                                <tr>
                                                    <th style="width: 150px;">OM</th>
                                                    <th>Nominations</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="align-top"><strong>Monica Scott</strong></td>
                                                    <td>
                                                        <div class="mb-1 text-muted">1 nominations</div>
                                                        <div>Joshua Chavarria - Always goes above and beyond</div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="office-title">Supervisor Nominations (in order of votes) for the El Paso, TX office.</div>
                                    <div class="table-responsive">
                                        <table class="table w-100 equipment-report-table mb-4">
                                            <thead>
                                                <tr>
                                                    <th style="width: 150px;">OM</th>
                                                    <th>Nominations</th>
                                                </tr>
                                            </thead>
                                            <tbody>
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
    </div>
</div>
@endsection
