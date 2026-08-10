@extends('admin.includes.layout')

@section('title', 'Manage Questions: ' . $test->name)

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        .equipment-report-table {
            border-collapse: separate !important;
            border-spacing: 0 !important;
            border: 1px solid #f3f4f6 !important;
            border-radius: 12px !important;
            overflow: hidden !important;
            background: #fff !important;
            width: 100% !important;
            margin-top: 10px !important;
        }

        .equipment-report-table thead th {
            background-color: rgba(255, 184, 28, 0.4) !important;
            color: #374151 !important;
            font-weight: 600 !important;
            padding: 18px 20px !important;
            border-right: 1px solid rgba(0, 0, 0, 0.05) !important;
            font-size: 14px !important;
        }

        .equipment-report-table tbody td {
            padding: 15px 20px !important;
            vertical-align: middle !important;
            border-bottom: 1px solid #f3f4f6 !important;
            border-right: 1px solid rgba(0, 0, 0, 0.05) !important;
            font-size: 14px !important;
        }

        a.text-action {
            color: #337ab7 !important;
        }
        
        .option-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
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
                                <h3 class="mb-1">{{ strtoupper($test->name) }}</h3>
                                <p class="text-muted mb-0">Manage test questions and options.</p>
                            </div>
                            <div class="right-part-sec d-flex gap-2">
                                <a href="{{ route('admin.training-questions.index') }}" class="btn btn-outline-dark d-flex align-items-center">
                                    <i class="fa-solid fa-arrow-left me-1"></i> Back to Tests
                                </a>
                                @can('training.add')
                                <button class="btn btn-export btn-create-trigger" data-bs-toggle="modal" data-bs-target="#createModal">
                                    + ADD QUESTION
                                </button>
                                @endcan
                            </div>
                        </div>

                        <!-- Table Card -->
                        <div class="px-4 pb-4">
                            <div class="table-responsive">
                                <table class="table table-hover w-100 equipment-report-table">
                                    <thead>
                                        <tr>
                                            <th style="text-align: left !important;">Question</th>
                                            <th style="text-align: center !important;">Type</th>
                                            <th style="text-align: center !important;">Marks</th>
                                            <th style="text-align: center !important;">Order</th>
                                            <th style="text-align: center !important;">Status</th>
                                            <th class="text-end" style="width: 150px; padding-right: 35px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($questions as $q)
                                            <tr>
                                                <td style="text-align: left !important; padding: 20px !important;">
                                                    <div style="font-size: 15px; color: #374151; margin-bottom: 5px; font-weight: 600;">
                                                        {{ Str::limit($q->question, 80) }}
                                                    </div>
                                                </td>
                                                <td style="text-align: center !important;">
                                                    {{ $q->question_type }}
                                                </td>
                                                <td style="text-align: center !important;">
                                                    {{ $q->marks }}
                                                </td>
                                                <td style="text-align: center !important;">
                                                    {{ $q->sort_order }}
                                                </td>
                                                <td style="text-align: center !important;">
                                                    @if($q->status == 'Active')
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-danger">Inactive</span>
                                                    @endif
                                                </td>
                                                <td style="text-align: right !important; padding: 20px !important; padding-right: 35px !important;">
                                                    <div class="d-flex justify-content-end align-items-center gap-3">
                                                        @can('training.edit')
                                                        <a href="#" class="text-action btn-edit" 
                                                           data-id="{{ $q->id }}"
                                                           data-question="{{ $q->question }}"
                                                           data-question_type="{{ $q->question_type }}"
                                                           data-options="{{ json_encode($q->options) }}"
                                                           data-correct_answer="{{ $q->correct_answer }}"
                                                           data-marks="{{ $q->marks }}"
                                                           data-sort_order="{{ $q->sort_order }}"
                                                           data-status="{{ $q->status }}"
                                                           style="font-size: 16px;" 
                                                           data-bs-toggle="modal" 
                                                           data-bs-target="#createModal">
                                                            <i class="fa-solid fa-gear"></i>
                                                        </a>
                                                        @endcan

                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        
                                        @if($questions->isEmpty())
                                            <tr>
                                                <td colspan="6" class="text-center py-4 text-muted">No questions found for this test.</td>
                                            </tr>
                                        @endif
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

<!-- Create / Edit Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="createModalLabel">Create New Question</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createForm" class="company-form" action="{{ route('admin.training-questions.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="test_id" value="{{ $test->id }}">
                    
                    <div class="row mx-0">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Question Type</label>
                                <span class="text-danger">*</span>
                                <select class="form-select" name="question_type" id="formType" required>
                                    <option value="Single Choice">Single Choice</option>
                                    <option value="Multiple Choice">Multiple Choice</option>
                                    <option value="True/False">True/False</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Question</label>
                                <span class="text-danger">*</span>
                                <textarea class="form-control" name="question" id="formQuestion" rows="3" required></textarea>
                            </div>
                        </div>
                        
                        <div class="col-lg-12">
                            <div class="card bg-light mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="mb-0">Options & Correct Answer</h6>
                                        <button type="button" class="btn btn-sm btn-outline-primary" id="btnAddOption">+ Add Option</button>
                                    </div>
                                    <small class="text-muted d-block mb-3">Select the radio button next to the correct answer.</small>
                                    
                                    <div id="optionsContainer">
                                        <!-- Dynamic options injected here -->
                                    </div>
                                    <input type="hidden" name="correct_answer" id="formCorrectAnswer" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label">Marks</label>
                                <input type="number" class="form-control" name="marks" id="formMarks" value="1" min="1" required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label">Sort Order</label>
                                <input type="number" class="form-control" name="sort_order" id="formSortOrder" value="0" required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="status" id="formStatus">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer mt-3">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="btnSave">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        
        function renderOptions(type, options = [], correctAnswer = '') {
            let container = $('#optionsContainer');
            container.empty();
            
            if (type === 'True/False') {
                $('#btnAddOption').hide();
                let opts = ['True', 'False'];
                opts.forEach(function(opt, index) {
                    let isChecked = (correctAnswer === opt) ? 'checked' : '';
                    let html = `
                    <div class="option-row">
                        <input class="form-check-input correct-radio" type="radio" name="correct_radio" value="${opt}" ${isChecked} required>
                        <input type="text" class="form-control" name="options[]" value="${opt}" readonly>
                    </div>`;
                    container.append(html);
                });
            } else {
                $('#btnAddOption').show();
                if(options.length === 0) options = ['', '']; // Default 2 empty options
                
                options.forEach(function(opt, index) {
                    let isChecked = (correctAnswer === opt && opt !== '') ? 'checked' : '';
                    let html = `
                    <div class="option-row">
                        <input class="form-check-input correct-radio" type="radio" name="correct_radio" value="${opt}" ${isChecked} required>
                        <input type="text" class="form-control option-input" name="options[]" value="${opt}" required>
                        <button type="button" class="btn btn-sm btn-outline-danger btn-remove-option"><i class="fa-solid fa-xmark"></i></button>
                    </div>`;
                    container.append(html);
                });
            }
            updateCorrectAnswer();
        }

        $('#btnAddOption').click(function() {
            let html = `
            <div class="option-row">
                <input class="form-check-input correct-radio" type="radio" name="correct_radio" value="" required>
                <input type="text" class="form-control option-input" name="options[]" value="" required>
                <button type="button" class="btn btn-sm btn-outline-danger btn-remove-option"><i class="fa-solid fa-xmark"></i></button>
            </div>`;
            $('#optionsContainer').append(html);
        });

        $(document).on('click', '.btn-remove-option', function() {
            if ($('.option-row').length > 2) {
                $(this).closest('.option-row').remove();
                updateCorrectAnswer();
            } else {
                alert('At least two options are required.');
            }
        });

        $(document).on('input', '.option-input', function() {
            let val = $(this).val();
            $(this).siblings('.correct-radio').val(val);
            if($(this).siblings('.correct-radio').is(':checked')) {
                $('#formCorrectAnswer').val(val);
            }
        });

        $(document).on('change', '.correct-radio', function() {
            updateCorrectAnswer();
        });

        function updateCorrectAnswer() {
            let selected = $('.correct-radio:checked').val();
            $('#formCorrectAnswer').val(selected || '');
        }

        $('#formType').change(function() {
            renderOptions($(this).val(), [], '');
        });

        $('.btn-create-trigger').on('click', function() {
            $('#createModalLabel').text('Create New Question');
            $('#createForm')[0].reset();
            $('#createForm').attr('action', '{{ route('admin.training-questions.store') }}');
            renderOptions('Single Choice', [], '');
        });

        $(document).on('click', '.btn-edit', function() {
            let id = $(this).data('id');
            $('#createModalLabel').text('Edit Question');
            $('#formType').val($(this).data('question_type'));
            $('#formQuestion').val($(this).data('question'));
            $('#formMarks').val($(this).data('marks'));
            $('#formSortOrder').val($(this).data('sort_order'));
            $('#formStatus').val($(this).data('status'));
            
            let options = $(this).data('options');
            if (typeof options === 'string') {
                try { options = JSON.parse(options); } catch(e) { options = []; }
            }
            
            renderOptions($(this).data('question_type'), options, $(this).data('correct_answer'));
            
            $('#createForm').attr('action', '{{ url('admin/training-questions/update') }}/' + id);
        });
        


        $('#createForm').on('submit', function(e) {
            e.preventDefault();
            updateCorrectAnswer();
            
            const form = $(this);
            const submitBtn = form.find('button[type="submit"]');

            if (!form[0].checkValidity()) {
                form[0].reportValidity();
                return;
            }

            if(!$('#formCorrectAnswer').val()) {
                toastr.error('Please select a correct answer by checking one of the radio buttons.');
                return;
            }

            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: form.serialize(),
                beforeSend: function() {
                    submitBtn.prop('disabled', true).text('Saving...');
                },
                success: function(response) {
                    if(response.success) {
                        toastr.success(response.message);
                        $('#createModal').modal('hide');
                        setTimeout(() => window.location.reload(), 1000);
                    } else {
                        toastr.error(response.message);
                        submitBtn.prop('disabled', false).text('Save changes');
                    }
                },
                error: function(xhr) {
                    let msg = xhr.responseJSON?.message || 'Something went wrong.';
                    toastr.error(msg);
                    submitBtn.prop('disabled', false).text('Save changes');
                }
            });
        });
    });
</script>
@endpush



