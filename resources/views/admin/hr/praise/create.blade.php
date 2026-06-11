@extends('admin.includes.layout')

@section('title', 'Core Value Praise Form')

@push('styles')
<style>
    .section-card {
        background: #fff;
        border: 1px solid #f0f0f0;
        border-radius: 12px;
        padding: 28px;
        margin-bottom: 20px;
    }
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
    textarea.feedback-area {
        resize: vertical;
        min-height: 160px;
        border-radius: 6px;
        border: 1px solid #d1d5db;
        padding: 14px;
        font-size: 14px;
        width: 100%;
        outline: none;
        transition: border-color .15s;
    }
    textarea.feedback-area:focus {
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
            <div class="col-md-12 p-0">
                <div class="main-content">
                    <div class="sales-dashboard">

                        {{-- Header --}}
                        <div class="heading-area-sec border-bottom-0 pb-0">
                            <div class="left-part-sec">
                                <h3 class="mb-2" style="font-size: 26px; font-weight: 500;">Core Value Praise Form</h3>
                                <p class="text-muted mb-0" style="font-size: 15px;">
                                    Please answer the following questions and submit your feedback.
                                </p>
                            </div>
                            @if (auth()->user()->isSuperAdmin())
                            <div class="right-part-sec">
                                <a href="{{ route('admin.hr.praise.index') }}" class="btn btn-export">View Submissions</a>
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
                            <form id="praiseForm" method="POST" action="{{ route('admin.hr.praise.store') }}">
                                @csrf
                                <div class="section-card">
                                    
                                    <div class="form-group-praise">
                                        <label for="recipient_name" class="form-label-praise">Who do you want to praise?</label>
                                        <input 
                                            type="text" 
                                            name="recipient_name" 
                                            id="recipient_name" 
                                            list="employee_list" 
                                            class="input-praise @error('recipient_name') is-invalid @enderror" 
                                            placeholder="Type or select the employee you want to praise..." 
                                            required 
                                            value="{{ old('recipient_name') }}"
                                            autocomplete="off"
                                        >
                                        <input type="hidden" name="recipient_id" id="recipient_id" value="{{ old('recipient_id') }}">
                                        <datalist id="employee_list">
                                            @foreach($users as $user)
                                                <option value="{{ $user->name }}" data-id="{{ $user->id }}">
                                            @endforeach
                                        </datalist>
                                        @error('recipient_name')
                                            <div class="text-danger mt-1" style="font-size: 13px;">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group-praise">
                                        <label for="reason" class="form-label-praise">Tell us in as many words as you'd like what this person has done</label>
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
                                        <label for="core_value" class="form-label-praise">What core value did this person exemplify?</label>
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
    // Sync recipient_id if user is selected from datalist
    $('#recipient_name').on('change input', function() {
        const val = $(this).val();
        const $options = $('#employee_list option');
        let matchedId = '';
        $options.each(function() {
            if ($(this).val() === val) {
                matchedId = $(this).data('id');
                return false; // break
            }
        });
        $('#recipient_id').val(matchedId);
    });

    $('#praiseForm').on('submit', function (e) {
        e.preventDefault();
        const $form = $(this);
        const $btn  = $('#submitBtn');

        $.ajax({
            url: $form.attr('action'),
            method: 'POST',
            data: $form.serialize(),
            beforeSend: function () { $btn.prop('disabled', true).text('Submitting...'); },
            success: function (res) {
                toastr.success(res.message || 'Praise submitted successfully!');
                $form[0].reset();
                $('#recipient_id').val('');
                $btn.prop('disabled', false).text('Submit Praise');
            },
            error: function (xhr) {
                const errors = xhr.responseJSON?.errors;
                toastr.error(errors ? Object.values(errors)[0][0] : 'Something went wrong.');
                $btn.prop('disabled', false).text('Submit Praise');
            }
        });
    });
});
</script>
@endpush
