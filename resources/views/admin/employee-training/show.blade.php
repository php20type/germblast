@extends('admin.includes.layout')

@section('title', 'Training Quiz - ' . $test->name)

@push('styles')
    <style>
        /* Reusing system styles instead of custom ones */
        </style>
@endpush

@section('content')
<div class="companies-section my-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 p-0">
                <div class="main-content">
                    <div class="sales-dashboard px-4 pt-4 pb-2">
                        
                        <!-- Header -->
                        <div class="heading-area-sec mb-4">
                            <div class="left-part-sec">
                                <h3 class="mb-1">{{ strtoupper($test->name) }}</h3>
                                <p class="text-muted mb-0">
                                    <span class="badge bg-warning text-dark me-1">{{ $test->category->name ?? 'Uncategorized' }}</span>
                                    @if($test->description) {{ $test->description }} @else Complete the training questions below. @endif
                                    @if($attemptsUsed > 0)
                                        <br><span class="badge bg-info mt-2">Previous Attempts: {{ $attemptsUsed }}</span>
                                    @endif
                                </p>
                            </div>
                            <div class="right-part-sec d-flex gap-2">
                                <a href="{{ route('admin.employee-training.index') }}" class="btn btn-outline-secondary d-flex align-items-center">
                                    <i class="fa-solid fa-arrow-left me-1"></i> Back to Training List
                                </a>
                            </div>
                        </div>

                        @if($test->video_url)
                            <div class="card bg-white mb-4 shadow-sm border-0 mx-auto" style="border-radius: 12px; overflow: hidden; max-width: 900px;">
                                <div class="card-body p-0">
                                    <div class="ratio ratio-16x9" style="background: #000;">
                                        <iframe src="{{ $test->video_url }}" title="Training Video" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen style="border: none; width: 100%; height: 100%;"></iframe>
                                    </div>
                                </div>
                            </div>
                        @endif
    
            <form id="submitTestForm" action="{{ route('admin.employee-training.submit', $test->id) }}" method="POST">
                @csrf

            @if($test->questions->count() == 0)
                <div class="alert alert-warning">
                    This test does not have any questions assigned yet.
                </div>
            @else
                @foreach($test->questions as $index => $question)
                    <div class="card bg-white mb-4" style="border-radius: 12px; border: 1px solid #e5e7eb !important; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-3 d-flex align-items-start" style="font-size: 16px; color: #1f2937;">
                                <span class="badge me-3 mt-1" style="background-color: #ffb81c; min-width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-size: 13px;">
                                    {{ $index + 1 }}
                                </span>
                                <div style="line-height: 1.5;">
                                    {{ $question->question }} <span class="text-danger">*</span>
                                </div>
                            </h6>

                        <div class="ps-5 ms-1">
                            @if($question->question_type == 'True/False')
                                <select name="answers[{{ $question->id }}]" class="form-select w-50" required>
                                    <option value="">Select your answer...</option>
                                    <option value="True">True</option>
                                    <option value="False">False</option>
                                </select>
                            
                            @elseif($question->question_type == 'Single Choice')
                                @php
                                    $options = is_string($question->options) ? json_decode($question->options, true) : $question->options;
                                @endphp
                                <select name="answers[{{ $question->id }}]" class="form-select w-50" required>
                                    <option value="">Select your answer...</option>
                                    @if(is_array($options))
                                        @foreach($options as $option)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            
                            @elseif($question->question_type == 'Multiple Choice')
                                @php
                                    $options = is_string($question->options) ? json_decode($question->options, true) : $question->options;
                                @endphp
                                @if(is_array($options))
                                    @foreach($options as $optIndex => $option)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="answers[{{ $question->id }}][]" value="{{ $option }}" id="q{{ $question->id }}_opt{{ $optIndex }}">
                                            <label class="form-check-label" for="q{{ $question->id }}_opt{{ $optIndex }}">
                                                {{ $option }}
                                            </label>
                                        </div>
                                    @endforeach
                                @endif
                                <small class="text-muted d-block mt-2"><i class="fa-solid fa-circle-info me-1"></i> Select all that apply (check at least one)</small>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="text-center mt-5 mb-5">
                    <button type="submit" class="btn btn-primary px-5 fw-bold shadow-sm" style="padding-top: 12px; padding-bottom: 12px; border-radius: 8px; min-width: 250px;">
                        SUBMIT TEST
                    </button>
                </div>
            @endif
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
        $('#submitTestForm').on('submit', function(e) {
            e.preventDefault();
            const form = $(this);
            const submitBtn = form.find('button[type="submit"]');

            if (!form[0].checkValidity()) {
                form[0].reportValidity();
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to submit your test answers? You cannot undo this action.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, submit test!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: form.attr('action'),
                        method: 'POST',
                        data: form.serialize(),
                        beforeSend: function() {
                            submitBtn.prop('disabled', true).text('Submitting...');
                        },
                        success: function(response) {
                            if(response.success) {
                                toastr.success(response.message);
                                setTimeout(() => window.location.href = response.redirect_url, 1500);
                            } else {
                                toastr.error(response.message);
                                submitBtn.prop('disabled', false).text('SUBMIT TEST');
                            }
                        },
                        error: function(xhr) {
                            let msg = xhr.responseJSON?.message || 'Something went wrong.';
                            toastr.error(msg);
                            submitBtn.prop('disabled', false).text('SUBMIT TEST');
                        }
                    });
                }
            });
        });
    });
</script>
@endpush
