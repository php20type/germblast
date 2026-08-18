@extends('admin.includes.layout')

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
            font-size: 14px !important;
        }

        .equipment-report-table thead th:first-child {
            border-top-left-radius: 12px !important;
        }

        .equipment-report-table thead th:last-child {
            border-top-right-radius: 12px !important;
            border-right: none !important;
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

        .score-options label {
            margin-right: 10px;
            cursor: pointer;
            font-weight: 500;
        }
        .score-options input[type="radio"] {
            margin-top: 0;
            vertical-align: middle;
        }
        .section-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            padding: 20px;
            margin-bottom: 20px;
        }
        .section-header {
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #374151;
            margin: 0;
        }
        .form-control {
            border-radius: 6px;
        }
        .instructions-text {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 20px;
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

                        <form id="evaluation-form" action="{{ route('admin.operations.evaluations.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="target_user_id" value="{{ $targetUser->id }}">

                            <!-- Header -->
                            <div class="heading-area-sec mb-3">
                                <div class="left-part-sec">
                                    <h3 class="mb-1 text-uppercase">
                                        @if($roleName === 'technician')
                                            Supervisor in Training Evaluation
                                        @elseif($roleName === 'supervisor')
                                            Supervisor Evaluation
                                        @elseif($roleName === 'operations_manager')
                                            Operations Manager Evaluation
                                        @else
                                            {{ str_replace('_', ' ', $roleName) }} Evaluation
                                        @endif
                                    </h3>
                                    <p class="text-muted mb-0">Evaluate performance and complete scoring.</p>
                                    <p class="text-danger fw-bold mt-2 mb-0">NOTE: This module is a work in progress and is for testing purposes only.</p>
                                </div>
                                <div class="right-part-sec d-flex align-items-center gap-2">
                                    <a href="{{ route('admin.operations.evaluations') }}" class="btn btn-outline-dark">Cancel</a>
                                </div>
                            </div>

                            <div class="px-4 pb-4">
                                <div class="section-card">
                                    <div class="section-header">
                                        <h3 class="section-title">
                                            @if($roleName === 'technician')
                                                Technician to Evaluate - {{ $targetUser->name }}
                                            @else
                                                Evaluate - {{ $targetUser->name }}
                                            @endif
                                        </h3>
                                    </div>
                                    
                                    <p class="instructions-text">
                                        In keeping with GermBlast's goal to continuously improve, we are asking for you to complete this evaluation on this {{ str_replace('_', ' ', $roleName) }} to determine their performance. Please leave any additional comments at the end. Thank you!
                                    </p>

                                    <div class="mb-4">
                                        <h5 class="fw-bold mb-2">Rating Scale</h5>
                                        <ul class="text-muted" style="list-style-type: disc; padding-left: 20px;">
                                            <li><strong class="text-dark">Needs Improvement 0-70</strong></li>
                                            <li><strong class="text-dark">Meets Expectations 71-115</strong></li>
                                            <li><strong class="text-dark">Exceeds Expectations 116-165</strong></li>
                                        </ul>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table equipment-report-table">
                                            <thead>
                                                <tr>
                                                    <th style="width: 70%;">Question</th>
                                                    <th style="width: 30%;">Score</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($questions as $section => $sectionQuestions)
                                                    <tr class="section-header-row">
                                                        <td colspan="2" class="fw-semibold" style="background-color: rgba(255, 184, 28, 0.15) !important;">{{ $section }}</td>
                                                    </tr>
                                                    
                                                    @foreach($sectionQuestions as $q)
                                                        <tr>
                                                            <td>{{ $q->question_text }}</td>
                                                            <td>
                                                                <div class="score-options">
                                                                    @for($i = 1; $i <= ($q->max_score ?? 3); $i++)
                                                                        <label>
                                                                            <input type="radio" name="scores[{{ $q->id }}]" value="{{ $i }}" {{ $i == 1 ? 'checked' : '' }} required> {{ $i }}
                                                                        </label>
                                                                    @endfor
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="section-card mt-4">
                                    <div class="section-header">
                                        <h3 class="section-title">Comments & Recommendations</h3>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <div class="form-group">
                                                <label class="fw-bold mb-2 text-dark">Remarks & Recommendations</label>
                                                <textarea name="remarks" rows="4" class="form-control bg-light"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <div class="form-group">
                                                <label class="fw-bold mb-2 text-dark">Specific Development Plan/Goals</label>
                                                <textarea name="development_plan" rows="4" class="form-control bg-light"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <div class="form-group">
                                                <label class="fw-bold mb-2 text-dark">Other Comments</label>
                                                <textarea name="other_comments" rows="4" class="form-control bg-light"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="text-end mt-3">
                                    <button type="submit" class="btn btn-export px-5 py-2">Submit Evaluation</button>
                                </div>
                            </div>
                        </form>
                        
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
        $('#evaluation-form').validate({
            errorElement: 'span',
            errorClass: 'invalid-feedback d-block',
            highlight: function(element) {
                $(element).addClass('is-invalid');
                $(element).closest('tr').addClass('table-danger');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
                $(element).closest('tr').removeClass('table-danger');
            },
            errorPlacement: function(error, element) {
                if (element.is(':radio')) {
                    error.insertAfter(element.closest('.score-options'));
                } else {
                    error.insertAfter(element);
                }
            }
        });

        $('#evaluation-form').on('submit', function(e) {
            e.preventDefault();
            
            let form = $(this);
            if (!form.valid()) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Please answer all questions before submitting.',
                });
                return;
            }

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message || 'Evaluation submitted successfully.',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        window.location.href = "{{ route('admin.operations.evaluations') }}";
                    });
                },
                error: function(xhr) {
                    let msg = 'An error occurred while submitting the evaluation.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: msg,
                    });
                }
            });
        });
    });
</script>
@endpush
