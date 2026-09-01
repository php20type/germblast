@extends('admin.includes.layout')

@section('title', 'Core Value Praise Form')

@push('styles')
<style>

    .form-group-praise {
        margin-bottom: 24px;
    }
    .form-label-praise {
        font-size: 14px;
        font-weight: 500;
        color: #374151;
        margin-bottom: 8px;
        display: block;
    }
    .input-praise {
        border-radius: 6px;
        border: 1px solid #d1d5db;
        padding: 10px 14px;
        font-size: 14px;
        width: 100%;
        outline: none;
        transition: border-color .15s;
    }
    .input-praise:focus {
        border-color: #3b82f6;
    }

    .btn-submit-praise {
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
    .btn-submit-praise:hover { background: #e5a500; }
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
                                <h3 class="mb-1">Core Value Praise Form</h3>
                                <p class="text-muted mb-0">
                                    Please answer the following questions and submit your feedback.
                                </p>
                            </div>
                            @can('team_praise.view')
                            <div class="right-part-sec">
                                <a href="{{ route('admin.hr.praise.index') }}" class="btn btn-export">View Submissions</a>
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
                            <form id="praiseForm" method="POST" action="{{ route('admin.hr.praise.store') }}">
                                @csrf
                                <div class="section-card">
                                    
                                    <div class="form-group-praise">
                                        <label for="recipient_id" class="form-label-praise">Who do you want to praise? <span class="text-danger">*</span></label>
                                        <select 
                                            name="recipient_id" 
                                            id="recipient_id" 
                                            class="input-praise form-select @error('recipient_id') is-invalid @enderror" 
                                            required
                                        >
                                            <option value="" disabled selected>-- Select an employee --</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}" {{ old('recipient_id') == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }} ({{ $user->email }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('recipient_id')
                                            <div class="text-danger mt-1" style="font-size: 13px;">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group-praise">
                                        <label for="reason" class="form-label-praise">Tell us in as many words as you'd like what this person has done <span class="text-danger">*</span></label>
                                        <textarea
                                            name="reason"
                                            id="reason"
                                            class="feedback-area @error('reason') is-invalid @enderror"
                                            placeholder="Describe their contribution..."
                                            required>{{ old('reason') }}</textarea>
                                        @error('reason')
                                            <div class="text-danger mt-1" style="font-size: 13px;">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group-praise mb-0">
                                        <label for="core_value" class="form-label-praise">What core value did this person exemplify? <span class="text-danger">*</span></label>
                                        <select name="core_value" id="core_value" class="input-praise form-select @error('core_value') is-invalid @enderror" required>
                                            <option value="Excellence" {{ old('core_value') == 'Excellence' ? 'selected' : '' }}>Excellence</option>
                                            <option value="Extraordinary" {{ old('core_value') == 'Extraordinary' ? 'selected' : '' }}>Extraordinary</option>
                                            <option value="Growth" {{ old('core_value') == 'Growth' ? 'selected' : '' }}>Growth</option>
                                            <option value="Integrity" {{ old('core_value') == 'Integrity' ? 'selected' : '' }}>Integrity</option>
                                            <option value="Ownership" {{ old('core_value') == 'Ownership' ? 'selected' : '' }}>Ownership</option>
                                        </select>
                                        @error('core_value')
                                            <div class="text-danger mt-1" style="font-size: 13px;">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>

                                <div>
                                    <button type="submit" class="btn-submit-praise" id="submitBtn">Submit Praise</button>
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
    $('#praiseForm').validate({
        rules: {
            recipient_id: "required",
            reason: "required",
            core_value: "required"
        },
        messages: {
            recipient_id: "Please select an employee.",
            reason: "Please provide a reason for the praise.",
            core_value: "Please select a core value."
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

    $('#praiseForm').on('submit', function (e) {
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
                toastr.success(res.message || 'Praise submitted successfully!');
                setTimeout(function() {
                    window.location.href = "{{ route('admin.hr.praise.index') }}";
                }, 1000);
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
                $btn.prop('disabled', false).text('Submit Praise');
            }
        });
    });
});
</script>
@endpush
