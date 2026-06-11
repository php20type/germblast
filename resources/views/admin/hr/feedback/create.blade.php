@extends('admin.includes.layout')

@section('title', 'Anonymous Feedback')

@push('styles')
<style>
    .section-card {
        background: #fff;
        border: 1px solid #f0f0f0;
        border-radius: 12px;
        padding: 28px;
        margin-bottom: 20px;
    }
    .section-title {
        font-size: 13px;
        font-weight: 700;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: .6px;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }
    textarea.feedback-area {
        resize: vertical;
        min-height: 160px;
        border-radius: 8px;
        border: 1.5px solid #e5e7eb;
        padding: 14px;
        font-size: 14px;
        width: 100%;
        outline: none;
        transition: border-color .15s;
    }
    textarea.feedback-area:focus { border-color: #ffb81c; }
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
            <div class="col-md-12 p-0">
                <div class="main-content">
                    <div class="sales-dashboard rounded-4 shadow-sm overflow-hidden">

                        {{-- Header --}}
                        <div class="heading-area-sec border-bottom-0 pb-0">
                            <div class="left-part-sec">
                                <h3 class="mb-2" style="font-size: 26px; font-weight: 500;">ANONYMOUS FEEDBACK</h3>
                                <p class="text-muted mb-0" style="font-size: 15px;">
                                    Your identity is completely protected. Share your honest thoughts.
                                </p>
                            </div>
                            @if (auth()->user()->isSuperAdmin())
                            <div class="right-part-sec">
                                <a href="{{ route('admin.hr.feedback.index') }}" class="btn btn-export">View Submissions</a>
                            </div>
                            @endif
                        </div>

                        <hr class="mx-4 my-4" style="opacity: .1;">

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
                                    <div class="section-title">Write Your Feedback</div>
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
    $('#feedbackForm').on('submit', function (e) {
        e.preventDefault();
        const $form = $(this);
        const $btn  = $('#submitBtn');

        $.ajax({
            url: $form.attr('action'),
            method: 'POST',
            data: $form.serialize(),
            beforeSend: function () { $btn.prop('disabled', true).text('Submitting...'); },
            success: function (res) {
                toastr.success(res.message || 'Feedback submitted successfully!');
                $form[0].reset();
                $btn.prop('disabled', false).text('Submit Feedback');
            },
            error: function (xhr) {
                const errors = xhr.responseJSON?.errors;
                toastr.error(errors ? Object.values(errors)[0][0] : 'Something went wrong.');
                $btn.prop('disabled', false).text('Submit Feedback');
            }
        });
    });
});
</script>
@endpush
