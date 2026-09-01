@extends('admin.includes.layout')

@section('title', 'Anonymous Feedback')

@push('styles')
<style>

    .btn-submit-feedback {
        background: #ffb81c;
        color: #fff;
        font-weight: 700;
        font-size: 14px;
        padding: 10px 32px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background .15s;
    }
    .btn-submit-feedback:hover { background: #e5a500; }
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
                        <div class="heading-area-sec mb-3">
                            <div class="left-part-sec">
                                <h3 class="mb-1">ANONYMOUS FEEDBACK</h3>
                                <p class="text-muted mb-0">
                                    Your identity is completely protected. Share your honest thoughts.
                                </p>
                            </div>
                            @can('anonymous_feedback.view')
                            <div class="right-part-sec">
                                <a href="{{ route('admin.hr.feedback.index') }}" class="btn btn-export">View Submissions</a>
                            </div>
                            @endcan
                        </div>

                        <div class="px-4 pb-4">

                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            {{-- Form --}}
                            <form id="feedbackForm" method="POST" action="{{ route('admin.hr.feedback.store') }}">
                                @csrf
                                <div class="section-card">
                                    <div class="section-title">Write Your Feedback <span class="text-danger">*</span></div>
                                    <textarea
                                        name="description"
                                        id="description"
                                        class="feedback-area @error('description') is-invalid @enderror"
                                        placeholder="Type your anonymous feedback here..."
                                        required>{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="text-danger mt-1" style="font-size: 13px;">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div>
                                    <button type="submit" class="btn-submit-feedback" id="submitBtn">Submit Feedback</button>
                                </div>
                            </form>

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
$(document).ready(function () {
    /* ===============================
       Validation & AJAX Submission
    =============================== */
    $('#feedbackForm').validate({
        rules: {
            description: "required"
        },
        messages: {
            description: "Please enter your feedback."
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
            error.insertAfter(element);
        }
    });

    $('#feedbackForm').on('submit', function (e) {
        e.preventDefault();
        const $form = $(this);
        const $btn  = $('#submitBtn');

        if (!$form.valid()) {
            return;
        }

        $.ajax({
            url: $form.attr('action'),
            method: 'POST',
            data: $form.serialize(),
            beforeSend: function () { 
                $btn.prop('disabled', true).text('Submitting...'); 
            },
            success: function (res) {
                toastr.success(res.message || 'Feedback submitted successfully!');
                $form[0].reset();
                $btn.prop('disabled', false).text('Submit Feedback');
            },
            error: function (xhr) {
                if (xhr.status === 422 && xhr.responseJSON?.errors) {
                    $.each(xhr.responseJSON.errors, function(field, messages) {
                        messages.forEach(function(message) {
                            toastr.error(message);
                        });
                    });
                } else {
                    toastr.error(xhr.responseJSON?.message || 'Something went wrong while submitting.');
                }
                $btn.prop('disabled', false).text('Submit Feedback');
            }
        });
    });
});
</script>
@endpush
