@extends('admin.includes.layout')

@section('title', 'Scores for ' . $user->name)

@push('styles')
    <style>
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

        /* Modern Soft Tabs Styling */
        .navbar-tabs .nav-tabs {
            border-bottom: none !important;
        }

        .navbar-tabs .nav-link {
            border: none !important;
            color: #6b7280 !important;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 13px;
            padding: 12px 20px 20px 20px !important;
            background: transparent !important;
            position: relative;
            transition: all 0.2s ease;
        }

        .navbar-tabs .nav-link.active {
            color: #111827 !important;
            background-color: #fff8e8 !important;
            border-radius: 10px 10px 0 0;
        }

        .navbar-tabs .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background-color: #ffb400;
        }

        .navbar-tabs .badge {
            background-color: #6b7280 !important;
            font-weight: 500;
            padding: 4px 8px;
            font-size: 11px;
            vertical-align: middle;
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
                        <div class="heading-area-sec mb-3 d-flex justify-content-between align-items-center">
                            <div class="left-part-sec">
                                <h3 class="mb-1 text-uppercase">Scores for {{ $user->name }}</h3>
                                <p class="text-muted mb-0">Detailed breakdown of evaluation scores.</p>
                                <p class="text-danger fw-bold mt-2 mb-0">NOTE: This module is a work in progress and is for testing purposes only.</p>
                            </div>
                            <div>
                                <a href="{{ route('admin.operations.evaluations') }}" class="btn btn-outline-dark"><i class="fas fa-arrow-left"></i> Back to Evaluations</a>
                            </div>
                        </div>
                        
                        <div class="px-4 pb-4">
                            @if($evaluations->isEmpty())
                                <div class="text-center py-5 text-muted">
                                    No evaluation records found for this user.
                                </div>
                            @else
                                <div class="navbar-tabs pt-3">
                                    <nav class="nav nav-tabs mb-0 w-100" id="evaluationTabs" role="tablist">
                                        @foreach($evaluations as $index => $evaluation)
                                            <button class="nav-link {{ $index === 0 ? 'active' : '' }}" 
                                                    id="eval-tab-{{ $evaluation->id }}" 
                                                    data-bs-toggle="tab" 
                                                    data-bs-target="#eval-content-{{ $evaluation->id }}" 
                                                    type="button" role="tab" 
                                                    aria-controls="eval-content-{{ $evaluation->id }}" 
                                                    aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                                                @if($roleName === 'technician' || $roleName === 'training_supervisor')
                                                    Attempt {{ $evaluation->attempt_number }} ({{ $evaluation->completed_at ? $evaluation->completed_at->format('M d, Y') : 'N/A' }})
                                                @else
                                                    Evaluation {{ $index + 1 }} ({{ $evaluation->completed_at ? $evaluation->completed_at->format('M d, Y') : 'N/A' }})
                                                @endif
                                            </button>
                                        @endforeach
                                    </nav>
                                </div>
                                <hr class="mb-4 mt-0" style="opacity: 0.1;">

                                <!-- Tab panes -->
                                <div class="tab-content" id="evaluationTabsContent">
                                    @foreach($evaluations as $index => $evaluation)
                                        <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" 
                                             id="eval-content-{{ $evaluation->id }}" 
                                             role="tabpanel" 
                                             aria-labelledby="eval-tab-{{ $evaluation->id }}">
                                            
                                            <div class="table-responsive mt-3">
                                                <table class="table equipment-report-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Question</th>
                                                            <th>Score</th>
                                                            <th>Evaluator</th>
                                                        </tr>
                                                    </thead>
                                                    @php
                                                        $groupedScores = $evaluation->scores->groupBy(function($score) {
                                                            return $score->question ? $score->question->section : 'General';
                                                        });
                                                    @endphp
                                                    <tbody>
                                                        @forelse($groupedScores as $section => $sectionScores)
                                                            <tr class="section-header-row">
                                                                <td colspan="3" class="fw-semibold text-dark" style="background-color: rgba(255, 184, 28, 0.15) !important;">{{ $section }}</td>
                                                            </tr>
                                                            @foreach($sectionScores as $score)
                                                            <tr>
                                                                <td>{{ $score->question ? $score->question->question_text : 'N/A' }}</td>
                                                                <td class="fw-bold">{{ $score->score }} / {{ $score->max_score ?? 3 }}</td>
                                                                <td>{{ $score->evaluatorUser ? $score->evaluatorUser->name : 'N/A' }}</td>
                                                            </tr>
                                                            @endforeach
                                                        @empty
                                                        <tr>
                                                            <td colspan="3" class="text-center py-4 text-muted">No scores recorded for this evaluation.</td>
                                                        </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="section-card mt-4" style="background: #fff; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); padding: 20px;">
                                                <h4 class="mb-3" style="color: #495057;">Comments & Recommendations</h4>
                                                
                                                <div class="row">
                                                    <div class="col-md-12 mb-3">
                                                        <h6 class="fw-bold text-muted mb-1">Remarks & Recommendations</h6>
                                                        <div class="p-3 bg-light rounded border" style="min-height: 110px;">{{ $evaluation->remarks ?: 'No remarks provided.' }}</div>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <h6 class="fw-bold text-muted mb-1">Specific Development Plan/Goals</h6>
                                                        <div class="p-3 bg-light rounded border" style="min-height: 110px;">{{ $evaluation->development_plan ?: 'No development plan provided.' }}</div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <h6 class="fw-bold text-muted mb-1">Other Comments</h6>
                                                        <div class="p-3 bg-light rounded border" style="min-height: 110px;">{{ $evaluation->other_comments ?: 'No other comments provided.' }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
