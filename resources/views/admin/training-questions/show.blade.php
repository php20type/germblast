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
                                                        <a href="#" class="btn btn-outline-primary btn-edit" 
                                                           data-id="{{ $q->id }}"
                                                           data-question="{{ $q->question }}"
                                                           data-question_type="{{ $q->question_type }}"
                                                           data-options="{{ json_encode($q->options) }}"
                                                           data-correct_answer="{{ $q->correct_answer }}"
                                                           data-marks="{{ $q->marks }}"
                                                           data-sort_order="{{ $q->sort_order }}"
                                                           data-status="{{ $q->status }}"
                                                           data-bs-toggle="modal" 
                                                           data-bs-target="#editModal">
                                                            Edit
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

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
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
                                <label class="form-label">Question Type <span class="text-danger">*</span></label>
                                <select class="form-select" name="question_type" id="formType" required>
                                    <option value="Single Choice">Single Choice</option>
                                    <option value="Multiple Choice">Multiple Choice</option>
                                    <option value="True/False">True/False</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Question <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="question" id="formQuestion" rows="3" placeholder="e.g. What is the primary purpose of..." required></textarea>
                            </div>
                        </div>
                        
                        <div class="col-lg-12">
                            <div class="card bg-light mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="mb-0">Options & Correct Answer</h6>
                                        <button type="button" class="btn btn-sm btn-outline-primary" id="btnAddOptionCreate">+ Add Option</button>
                                    </div>
                                    <small class="text-muted d-block mb-3">Select the radio button next to the correct answer.</small>
                                    
                                    <div id="createOptionsContainer">
                                        <!-- Dynamic options injected here -->
                                    </div>
                                    <input type="hidden" name="correct_answer" id="formCorrectAnswer">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label">Marks <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="marks" id="formMarks" value="1" min="1" placeholder="e.g. 1" required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label">Sort Order <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="sort_order" id="formSortOrder" value="0" placeholder="e.g. 1" required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select" name="status" id="formStatus" required>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer mt-3">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="btnSaveCreate">Save Question</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="editModalLabel">Edit Question</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm" class="company-form" action="" method="POST">
                    @csrf
                    <input type="hidden" name="test_id" value="{{ $test->id }}">
                    
                    <div class="row mx-0">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Question Type <span class="text-danger">*</span></label>
                                <select class="form-select" name="question_type" id="editType" required>
                                    <option value="Single Choice">Single Choice</option>
                                    <option value="Multiple Choice">Multiple Choice</option>
                                    <option value="True/False">True/False</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Question <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="question" id="editQuestion" rows="3" placeholder="e.g. What is the primary purpose of..." required></textarea>
                            </div>
                        </div>
                        
                        <div class="col-lg-12">
                            <div class="card bg-light mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="mb-0">Options & Correct Answer</h6>
                                        <button type="button" class="btn btn-sm btn-outline-primary" id="btnAddOptionEdit">+ Add Option</button>
                                    </div>
                                    <small class="text-muted d-block mb-3">Select the radio button next to the correct answer.</small>
                                    
                                    <div id="editOptionsContainer">
                                        <!-- Dynamic options injected here -->
                                    </div>
                                    <input type="hidden" name="correct_answer" id="editCorrectAnswer">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label">Marks <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="marks" id="editMarks" value="1" min="1" placeholder="e.g. 1" required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label">Sort Order <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="sort_order" id="editSortOrder" value="0" placeholder="e.g. 1" required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select" name="status" id="editStatus" required>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer mt-3">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="btnSaveEdit">Update Question</button>
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
        
        const validationConfig = {
            ignore: [],
            rules: {
                question_type: { required: true },
                question: { required: true },
                marks: { required: true, min: 1 },
                sort_order: { required: true },
                status: { required: true }
            },
            messages: {
                question_type: { required: "Please select a question type." },
                question: { required: "Please enter the question text." },
                marks: { required: "Please enter marks.", min: "Marks must be at least 1." },
                sort_order: { required: "Please enter sort order." },
                status: { required: "Please select a status." }
            },
            errorElement: 'span',
            errorClass: 'invalid-feedback d-block',
            highlight: function (element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            },
            errorPlacement: function (error, element) {
                if (element.closest('.input-group').length) {
                    error.insertAfter(element.closest('.input-group'));
                } else if (element.closest('.option-row').length) {
                    error.insertAfter(element.closest('.option-row'));
                } else {
                    error.insertAfter(element);
                }
            }
        };

        $("#createForm").validate(validationConfig);
        $("#editForm").validate(validationConfig);

        function renderOptions(mode, type, options = [], correctAnswer = '') {
            let container = mode === 'create' ? $('#createOptionsContainer') : $('#editOptionsContainer');
            let btnAdd = mode === 'create' ? $('#btnAddOptionCreate') : $('#btnAddOptionEdit');
            
            container.empty();
            
            if (type === 'True/False') {
                btnAdd.hide();
                let opts = ['True', 'False'];
                opts.forEach(function(opt, index) {
                    let isChecked = (correctAnswer === opt) ? 'checked' : '';
                    let html = `
                    <div class="option-row">
                        <input class="form-check-input correct-radio" type="radio" name="correct_radio_${mode}" value="${opt}" ${isChecked}>
                        <input type="text" class="form-control" name="options[${index}]" value="${opt}" readonly>
                    </div>`;
                    container.append(html);
                });
            } else {
                btnAdd.show();
                if(options.length === 0) options = ['', ''];
                
                options.forEach(function(opt, index) {
                    let isChecked = (correctAnswer === opt && opt !== '') ? 'checked' : '';
                    let html = `
                    <div class="option-row">
                        <input class="form-check-input correct-radio" type="radio" name="correct_radio_${mode}" value="${opt}" ${isChecked}>
                        <input type="text" class="form-control option-input" name="options[${index}]" value="${opt}" placeholder="e.g. Option text" required>
                        <button type="button" class="btn btn-sm btn-outline-danger btn-remove-option"><i class="fa-solid fa-xmark"></i></button>
                    </div>`;
                    container.append(html);
                });
            }
            updateCorrectAnswer(mode);
        }

        $('#btnAddOptionCreate').click(function() {
            let uniqueId = Date.now() + Math.floor(Math.random() * 1000);
            let html = `
            <div class="option-row">
                <input class="form-check-input correct-radio" type="radio" name="correct_radio_create" value="">
                <input type="text" class="form-control option-input" name="options[${uniqueId}]" value="" placeholder="e.g. Option text" required>
                <button type="button" class="btn btn-sm btn-outline-danger btn-remove-option"><i class="fa-solid fa-xmark"></i></button>
            </div>`;
            $('#createOptionsContainer').append(html);
        });
        
        $('#btnAddOptionEdit').click(function() {
            let uniqueId = Date.now() + Math.floor(Math.random() * 1000);
            let html = `
            <div class="option-row">
                <input class="form-check-input correct-radio" type="radio" name="correct_radio_edit" value="">
                <input type="text" class="form-control option-input" name="options[${uniqueId}]" value="" placeholder="e.g. Option text" required>
                <button type="button" class="btn btn-sm btn-outline-danger btn-remove-option"><i class="fa-solid fa-xmark"></i></button>
            </div>`;
            $('#editOptionsContainer').append(html);
        });

        $(document).on('click', '.btn-remove-option', function() {
            let container = $(this).closest('.option-row').parent();
            let mode = container.attr('id') === 'createOptionsContainer' ? 'create' : 'edit';
            
            if (container.find('.option-row').length > 2) {
                $(this).closest('.option-row').remove();
                updateCorrectAnswer(mode);
            } else {
                alert('At least two options are required.');
            }
        });

        $(document).on('input', '.option-input', function() {
            let val = $(this).val();
            let mode = $(this).closest('form').attr('id') === 'createForm' ? 'create' : 'edit';
            let correctInput = mode === 'create' ? $('#formCorrectAnswer') : $('#editCorrectAnswer');
            
            $(this).siblings('.correct-radio').val(val);
            if($(this).siblings('.correct-radio').is(':checked')) {
                correctInput.val(val);
            }
        });

        $(document).on('change', '.correct-radio', function() {
            let mode = $(this).closest('form').attr('id') === 'createForm' ? 'create' : 'edit';
            updateCorrectAnswer(mode);
        });

        function updateCorrectAnswer(mode) {
            let container = mode === 'create' ? $('#createOptionsContainer') : $('#editOptionsContainer');
            let correctInput = mode === 'create' ? $('#formCorrectAnswer') : $('#editCorrectAnswer');
            let selected = container.find('.correct-radio:checked').val();
            correctInput.val(selected || '');
        }

        $('#formType').change(function() {
            renderOptions('create', $(this).val(), [], '');
        });
        
        $('#editType').change(function() {
            renderOptions('edit', $(this).val(), [], '');
        });

        $('#createModal').on('hidden.bs.modal', function () {
            const validator = $("#createForm").validate();
            if(validator) validator.resetForm();
            $('#createForm')[0].reset();
            $('#createForm .is-invalid').removeClass('is-invalid');
            $('#createOptionsContainer').empty();
        });

        $('#editModal').on('hidden.bs.modal', function () {
            const validator = $("#editForm").validate();
            if(validator) validator.resetForm();
            $('#editForm')[0].reset();
            $('#editForm .is-invalid').removeClass('is-invalid');
            $('#editOptionsContainer').empty();
        });

        $('.btn-create-trigger').on('click', function() {
            renderOptions('create', 'Single Choice', [], '');
        });

        $(document).on('click', '.btn-edit', function() {
            let id = $(this).data('id');
            $('#editType').val($(this).data('question_type'));
            $('#editQuestion').val($(this).data('question'));
            $('#editMarks').val($(this).data('marks'));
            $('#editSortOrder').val($(this).data('sort_order'));
            $('#editStatus').val($(this).data('status'));
            
            let options = $(this).data('options');
            if (typeof options === 'string') {
                try { options = JSON.parse(options); } catch(e) { options = []; }
            }
            
            renderOptions('edit', $(this).data('question_type'), options, $(this).data('correct_answer'));
            
            $('#editForm').attr('action', '{{ url('admin/training-questions/update') }}/' + id);
        });

        function handleAjaxSubmit(e) {
            e.preventDefault();
            const form = $(this);
            const mode = form.attr('id') === 'createForm' ? 'create' : 'edit';
            updateCorrectAnswer(mode);
            
            const submitBtn = form.find('button[type="submit"]');
            const originalText = submitBtn.text();

            if (!form.valid()) {
                return;
            }

            let correctInput = mode === 'create' ? $('#formCorrectAnswer') : $('#editCorrectAnswer');
            if(!correctInput.val()) {
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
                        form.closest('.modal').modal('hide');
                        setTimeout(() => window.location.reload(), 1000);
                    } else {
                        toastr.error(response.message);
                        submitBtn.prop('disabled', false).text(originalText);
                    }
                },
                error: function(xhr) {
                    let msg = xhr.responseJSON?.message || 'Something went wrong.';
                    toastr.error(msg);
                    submitBtn.prop('disabled', false).text(originalText);
                }
            });
        }

        $('#createForm').on('submit', handleAjaxSubmit);
        $('#editForm').on('submit', handleAjaxSubmit);
    });
</script>
@endpush



