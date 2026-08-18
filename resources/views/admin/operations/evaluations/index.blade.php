@extends('admin.includes.layout')

@section('title', 'Evaluations')

@push('styles')
    <style>
        .cursor-pointer {
            cursor: pointer !important;
        }

        /* Equipment Report Table Boxed Styling from EQ */
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
            font-size: 15px !important;
            white-space: nowrap;
        }

        .equipment-report-table thead th:first-child {
            border-top-left-radius: 12px !important;
        }

        .equipment-report-table thead th:last-child {
            border-top-right-radius: 12px !important;
            border-right: none !important;
        }

        .equipment-report-table tbody th {
            font-size: 13px !important;
            padding: 12px 20px !important;
        }

        .equipment-report-table td {
            padding: 14px 20px !important;
            vertical-align: middle !important;
            border-bottom: 1px solid #f3f4f6 !important;
            border-right: 1px solid rgba(0, 0, 0, 0.05) !important;
            font-size: 14px !important;
            color: #4b5563;
        }

        .equipment-report-table td:last-child {
            border-right: none !important;
        }

        .equipment-report-table tbody tr:last-child td {
            border-bottom: none !important;
        }

        .equipment-report-table tbody tr:last-child td:first-child {
            border-bottom-left-radius: 12px !important;
        }

        .equipment-report-table tbody tr:last-child td:last-child {
            border-bottom-right-radius: 12px !important;
        }

        .group-header-row, .group-header-row td {
            background-color: #fdf6e3 !important;
            border-bottom: 2px solid #fff !important;
        }
        
        .scores-panel {
            background-color: #eef9fb;
            border-radius: 8px;
            padding: 25px;
            margin-top: 15px;
            border: 1px solid #cceef3;
        }

        .score-user-table {
            width: 100%;
            background: transparent;
            margin-bottom: 15px;
            border-collapse: collapse;
        }

        .score-user-table td {
            padding: 10px;
            border: 1px solid #cceef3;
            text-align: center;
            font-size: 13px;
        }
        
        .score-user-table .user-name {
            font-weight: 600;
            text-align: left;
            width: 20%;
            background-color: #e3f6fa;
        }

        .score-user-table .section-header {
            font-size: 12px;
            color: #6b7280;
            border-bottom: 1px solid #cceef3;
        }

    </style>
@endpush

@section('content')
<div class="companies-section my-4">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @include('admin.operations.sidebar')

            <!-- Main Content -->
            <div class="col-md-10 p-0">
                <div class="main-content">
                    <div class="sales-dashboard">
                        <!-- Header -->
                        <div class="heading-area-sec mb-3">
                            <div class="left-part-sec">
                                <h3 class="mb-1 text-uppercase">EVALUATIONS</h3>
                                <p class="text-muted mb-0">Overview and status of all team evaluations.</p>
                                <p class="text-danger fw-bold mt-2 mb-0">NOTE: This module is a work in progress and is for testing purposes only.</p>
                            </div>
                            <div class="right-part-sec">
                                <a href="{{ route('admin.operations.evaluation_questions.index') }}" class="btn btn-export">
                                    Manage Questions
                                </a>
                            </div>
                        </div>
                        
                        <div class="px-4 pb-4">
                            
                            <!-- Notifications for Evaluations Table -->
                            <div class="table-responsive mt-3">
                                <table class="table equipment-report-table">
                                    <thead>
                                        <tr>
                                            <th colspan="5">Notifications for Evaluations</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Supervisors -->
                                        <tr class="group-header-row">
                                            <td colspan="5" class="fw-bold text-dark py-3 fs-5">Supervisors</td>
                                        </tr>
                                        <tr style="border-bottom: 2px solid #f3f4f6;">
                                            <th class="fw-bold text-muted border-0 py-2">Name</th>
                                            <th class="fw-bold text-muted border-0 py-2"></th>
                                            <th class="fw-bold text-muted border-0 py-2">Last Sent</th>
                                            <th class="fw-bold text-muted border-0 py-2">Date Evaluation sent</th>
                                            <th class="fw-bold text-muted border-0 py-2">Completed?</th>
                                        </tr>
                                        @foreach($supervisors as $user)
                                            @php
                                                $reqs = $user->evaluationRequests;
                                                $completedCount = $reqs->where('status', 'completed')->count();
                                                $totalCount = $reqs->count();
                                                $lastSent = $reqs->sortByDesc('sent_at')->first();
                                            @endphp
                                        <tr>
                                            <td class="fw-bold text-dark">{{ $user->name }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-success">Send evaluation</button>
                                                @if($reqs->where('status', 'pending')->count() > 0)
                                                    <a href="{{ route('admin.operations.evaluations.create', $user->id) }}" class="btn btn-sm btn-primary ms-1">Start evaluation</a>
                                                @endif
                                            </td>
                                            <td class="text-muted">
                                                @if($lastSent && $lastSent->sent_at) {{ $lastSent->sent_at->format('n-j-y') }} @else No evaluations<br>sent @endif
                                            </td>
                                            <td class="text-muted">
                                                @if($lastSent && $lastSent->sent_at) {{ $lastSent->sent_at->format('n-j-y') }} @else not sent @endif
                                            </td>
                                            <td class="text-info fw-bold">{{ $completedCount }} / 4</td>
                                        </tr>
                                        @endforeach

                                        <!-- Supervisors in Training -->
                                        <tr class="group-header-row">
                                            <td colspan="5" class="fw-bold text-dark py-3 fs-5">Supervisors In Training</td>
                                        </tr>
                                        <tr style="border-bottom: 2px solid #f3f4f6;">
                                            <th class="fw-bold text-muted border-0 py-2">Name</th>
                                            <th class="fw-bold text-muted border-0 py-2"></th>
                                            <th class="fw-bold text-muted border-0 py-2">Last Sent</th>
                                            <th class="fw-bold text-muted border-0 py-2">Date Evaluation sent</th>
                                            <th class="fw-bold text-muted border-0 py-2">Completed?</th>
                                        </tr>
                                        @foreach($sit as $user)
                                            @php
                                                $reqs = $user->evaluationRequests;
                                                $completedCount = $reqs->where('status', 'completed')->count();
                                                $totalCount = $reqs->count();
                                                $lastSent = $reqs->sortByDesc('sent_at')->first();
                                            @endphp
                                        <tr>
                                            <td class="fw-bold text-dark">{{ $user->name }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-success">Send evaluation</button>
                                                @if($reqs->where('status', 'pending')->count() > 0)
                                                    <a href="{{ route('admin.operations.evaluations.create', $user->id) }}" class="btn btn-sm btn-primary ms-1">Start evaluation</a>
                                                @endif
                                            </td>
                                            <td class="text-muted">
                                                @if($lastSent && $lastSent->sent_at) 
                                                    {{ $lastSent->sent_at->format('n-j-y') }} 
                                                @else 
                                                    No evaluations<br>sent 
                                                @endif
                                            </td>
                                            <td class="text-muted">
                                                @if($lastSent && $lastSent->sent_at) 
                                                    {{ $lastSent->sent_at->format('n-j-y') }} 
                                                @else 
                                                    not sent 
                                                @endif
                                            </td>
                                            <td class="text-info fw-bold">{{ $completedCount }} / 4</td>
                                        </tr>
                                        @endforeach

                                        <!-- Operation Managers -->
                                        <tr class="group-header-row">
                                            <td colspan="5" class="fw-bold text-dark py-3 fs-5">Operation Managers</td>
                                        </tr>
                                        <tr style="border-bottom: 2px solid #f3f4f6;">
                                            <th class="fw-bold text-muted border-0 py-2">Name</th>
                                            <th class="fw-bold text-muted border-0 py-2"></th>
                                            <th class="fw-bold text-muted border-0 py-2">Last Sent</th>
                                            <th class="fw-bold text-muted border-0 py-2">Date Evaluation sent</th>
                                            <th class="fw-bold text-muted border-0 py-2">Completed?</th>
                                        </tr>
                                        @foreach($operationsManagers as $user)
                                            @php
                                                $reqs = $user->evaluationRequests;
                                                $completedCount = $reqs->where('status', 'completed')->count();
                                                $totalCount = $reqs->count();
                                                $lastSent = $reqs->sortByDesc('sent_at')->first();
                                            @endphp
                                        <tr>
                                            <td class="fw-bold text-dark">{{ $user->name }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-success">Send evaluation</button>
                                                @if($reqs->where('status', 'pending')->count() > 0)
                                                    <a href="{{ route('admin.operations.evaluations.create', $user->id) }}" class="btn btn-sm btn-primary ms-1">Start evaluation</a>
                                                @endif
                                            </td>
                                            <td class="text-muted">
                                                @if($lastSent && $lastSent->sent_at) {{ $lastSent->sent_at->format('n-j-y') }} @else No evaluations<br>sent @endif
                                            </td>
                                            <td class="text-muted">
                                                @if($lastSent && $lastSent->sent_at) {{ $lastSent->sent_at->format('n-j-y') }} @else not sent @endif
                                            </td>
                                            <td class="text-info fw-bold">{{ $completedCount }} / 4</td>
                                        </tr>
                                        @endforeach

                                        <!-- Technicians -->
                                        <tr class="group-header-row">
                                            <td colspan="5" class="fw-bold text-dark py-3 fs-5">Technicians</td>
                                        </tr>
                                        <tr style="border-bottom: 2px solid #f3f4f6;">
                                            <th class="fw-bold text-muted border-0 py-2">Name</th>
                                            <th class="fw-bold text-muted border-0 py-2"></th>
                                            <th class="fw-bold text-muted border-0 py-2">Last Sent</th>
                                            <th class="fw-bold text-muted border-0 py-2">Date Evaluation sent</th>
                                            <th class="fw-bold text-muted border-0 py-2">Completed?</th>
                                        </tr>
                                        @foreach($technicians as $user)
                                            @php
                                                $reqs = $user->evaluationRequests;
                                                $completedCount = $reqs->where('status', 'completed')->count();
                                                $totalCount = $reqs->count();
                                                $lastSent = $reqs->sortByDesc('sent_at')->first();
                                            @endphp
                                        <tr>
                                            <td class="fw-bold text-dark">{{ $user->name }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-success">Send evaluation</button>
                                                @if($reqs->where('status', 'pending')->count() > 0)
                                                    <button class="btn btn-sm btn-primary ms-1">Start evaluation</button>
                                                @endif
                                            </td>
                                            <td class="text-muted">
                                                @if($lastSent && $lastSent->sent_at) {{ $lastSent->sent_at->format('n-j-y') }} @else No evaluations<br>sent @endif
                                            </td>
                                            <td class="text-muted">
                                                @if($lastSent && $lastSent->sent_at) {{ $lastSent->sent_at->format('n-j-y') }} @else not sent @endif
                                            </td>
                                            <td class="text-info fw-bold">{{ $completedCount }} / 4</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- SIT Table -->
                            <div class="table-responsive mt-5">
                                <table class="table equipment-report-table">
                                    <thead>
                                        <tr>
                                            <th>Technicians to evaluate for SIT</th>
                                            <th></th>
                                            <th>Last Attempt</th>
                                            <th>Number of attempts</th>
                                            <th>Results</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($technicians as $user)
                                            @php
                                                $attempts = $user->sitAttempts;
                                                $attemptCount = $attempts->count();
                                                $lastAttempt = $attempts->sortByDesc('completed_at')->first();
                                                $limitReached = $attemptCount >= 4;
                                            @endphp
                                        <tr>
                                            <td class="fw-bold text-dark" style="width: 25%;">{{ $user->name }}</td>
                                            <td style="width: 15%;">
                                                @if($limitReached)
                                                    <span class="text-muted" style="font-size: 13px;">no more attempts left</span>
                                                @else
                                                    <a href="{{ route('admin.operations.evaluations.create', $user->id) }}" class="btn btn-sm btn-primary">Start evaluation</a>
                                                @endif
                                            </td>
                                            <td style="width: 20%;" class="text-muted">
                                                @if($lastAttempt && $lastAttempt->completed_at) {{ $lastAttempt->completed_at->format('n-j-y') }} @else No evaluations<br>done @endif
                                            </td>
                                            <td style="width: 25%;" class="text-dark fw-bold">{{ $attemptCount }}</td>
                                            <td style="width: 15%;">
                                                @if($attemptCount > 0)
                                                    <a href="{{ route('admin.operations.evaluations.show', $user->id) }}" class="btn btn-sm btn-primary">See Results</a>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="mt-3">
                                    <button id="toggle-scores-btn" class="btn btn-warning text-white">View Scores</button>
                                </div>
                                
                                <!-- Scores Panel -->
                                <div id="scores-panel" class="scores-panel mt-4 p-4" style="display: none; background-color: #e0f8f5;">
                                    <h3 class="text-center text-muted mb-4" style="font-weight: 300;">Scores</h3>
                                    
                                    <div class="row text-center mb-5">
                                        <div class="col-md-3">
                                            <div class="fw-bold fs-6">Supervisor scores <br><span class="fw-normal text-muted" style="font-size: 13px;">(based on sections below):</span></div>
                                            <div class="mt-2 fw-bold text-success">Average - {{ $roleAverages['supervisor'] !== null ? $roleAverages['supervisor'] . '%' : 'N/A' }}</div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="fw-bold fs-6">Operation Manager scores <br><span class="fw-normal text-muted" style="font-size: 13px;">(based on sections below):</span></div>
                                            <div class="mt-2 fw-bold text-success">Average - {{ $roleAverages['operations_manager'] !== null ? $roleAverages['operations_manager'] . '%' : 'N/A' }}</div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="fw-bold fs-6">SIT scores <br><span class="fw-normal text-muted" style="font-size: 13px;">(average):</span></div>
                                            <div class="mt-2 fw-bold text-success">Average - {{ $roleAverages['sit'] !== null ? $roleAverages['sit'] . '%' : 'N/A' }}</div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="fw-bold fs-6">Technicians scores <br><span class="fw-normal text-muted" style="font-size: 13px;">(average):</span></div>
                                            <div class="mt-2 fw-bold text-success">Average - {{ $roleAverages['technician'] !== null ? $roleAverages['technician'] . '%' : 'N/A' }}</div>
                                        </div>
                                    </div>

                                    @php
                                        $rolesToDisplay = [
                                            'Supervisor' => $supervisors,
                                            'Operation Manager' => $operationsManagers,
                                            'SIT' => $sit,
                                            'Technicians' => $technicians
                                        ];
                                    @endphp

                                    @foreach($rolesToDisplay as $roleName => $users)
                                        <div class="mb-5">
                                            <div class="text-start mb-3">
                                                <p class="fw-bold mb-0 text-dark" style="font-size: 14px;">{{ $roleName }} Scores <span class="fw-normal text-muted" style="font-size: 11px;">(in order from most current to least current)</span></p>
                                                <p class="text-muted mb-0" style="font-size: 12px;">(Total score points)</p>
                                                <p class="text-muted mb-0" style="font-size: 11px;">N/A means No evaluations completed yet</p>
                                                <p class="text-muted mb-0" style="font-size: 11px;">Evaluator #<br>DATE evaluation was completed</p>
                                            </div>

                                            <table class="table score-table bg-transparent">
                                                <tbody>
                                                    @foreach($users as $user)
                                                        @if(isset($aggregatedScores[$user->id]))
                                                            @foreach($aggregatedScores[$user->id] as $evaluation)
                                                                <tr style="border-bottom: 1px solid #cce5e1;">
                                                                    @if($loop->first)
                                                                    <td style="width: 15%; padding: 15px; border-right: 1px solid #cce5e1;" rowspan="{{ count($aggregatedScores[$user->id]) }}" class="align-middle">
                                                                        <strong>{{ $user->name }}</strong><br>
                                                                        <a href="{{ route('admin.operations.evaluations.show', $user->id) }}" class="btn btn-sm btn-success mt-2" style="font-size: 11px;">View More</a>
                                                                    </td>
                                                                    @endif
                                                                    <td style="width: 15%; padding: 15px; border-right: 1px solid #f3f4f6;" class="align-middle">
                                                                        <span class="text-muted" style="font-size: 11px;">Evaluator: <strong>{{ $evaluation['evaluator'] }}</strong><br>{{ $evaluation['date'] }}</span>
                                                                    </td>
                                                                    @foreach($evaluation['sections'] as $section => $data)
                                                                        <td class="text-center align-middle" style="padding: 15px 10px;">
                                                                            <strong class="d-block mb-1">{{ $section }}</strong>
                                                                            <span class="d-block">{{ $data['total_score'] }} out of {{ $data['total_max'] }}</span>
                                                                            <span class="d-block text-muted" style="font-size: 12px;">Total: {{ $data['percentage'] }}%</span>
                                                                        </td>
                                                                    @endforeach
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                    
                                                    @if(collect($users)->filter(function($u) use($aggregatedScores) { return isset($aggregatedScores[$u->id]); })->count() === 0)
                                                        <tr><td colspan="10" class="text-muted py-3">No scores available yet.</td></tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    @endforeach

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

@push('scripts')
<script>
    document.getElementById('toggle-scores-btn').addEventListener('click', function() {
        var panel = document.getElementById('scores-panel');
        if (panel.style.display === 'none') {
            panel.style.display = 'block';
        } else {
            panel.style.display = 'none';
        }
    });
</script>
@endpush
