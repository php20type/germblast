@extends('admin.includes.layout')

@section('title', 'Manage Evaluation Questions')

@push('styles')
    <style>
        .questions-table {
            border: 1px solid #e5e7eb !important;
            border-radius: 12px !important;
            border-collapse: separate !important;
            border-spacing: 0 !important;
            overflow: hidden !important;
            background: #fff !important;
            width: 100% !important;
            margin-top: 10px !important;
        }

        .questions-table thead th {
            background-color: rgba(255, 184, 28, 0.4) !important;
            border-bottom: 1px solid #e5e7eb !important;
            color: #374151 !important;
            font-weight: 600 !important;
            padding: 15px 20px !important;
            border-right: 1px solid rgba(0, 0, 0, 0.05) !important;
            font-size: 14px !important;
        }

        .questions-table td {
            padding: 12px 20px !important;
            vertical-align: middle !important;
            border-bottom: 1px solid #f3f4f6 !important;
            font-size: 14px !important;
            color: #4b5563;
        }

        .role-header {
            background-color: #fdf6e3 !important;
            font-size: 15px !important;
            font-weight: bold !important;
            color: #1f2937 !important;
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
                                <h3 class="mb-1 text-uppercase">Manage Evaluation Questions</h3>
                                <p class="text-muted mb-0">Add and categorize questions for different roles.</p>
                                <p class="text-danger fw-bold mt-2 mb-0">NOTE: This module is a work in progress and is for testing purposes only.</p>
                            </div>
                            <div class="right-part-sec d-flex align-items-center gap-2">
                                <a href="{{ route('admin.operations.evaluations') }}" class="btn btn-outline-dark" style="padding: 10px 20px;"><i class="fas fa-arrow-left"></i> Back</a>
                                <button class="btn btn-export" data-bs-toggle="modal" data-bs-target="#addQuestionModal">
                                    Add Question
                                </button>
                            </div>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success mt-3 mx-4">{{ session('success') }}</div>
                        @endif

                        <div class="px-4 pb-4">
                            @php
                                $groupedQuestions = $questions->groupBy('role');
                            @endphp

                            @forelse($groupedQuestions as $role => $roleQuestions)
                                <div class="table-responsive mt-4">
                                    <table class="table questions-table">
                                        <thead>
                                            <tr>
                                                <th colspan="4" class="role-header text-capitalize">
                                                    {{ str_replace('_', ' ', $role) }} Questions
                                                </th>
                                            </tr>
                                            <tr>
                                                <th width="20%">Section</th>
                                                <th width="50%">Question</th>
                                                <th width="10%">Max Score</th>
                                                <th width="20%">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($roleQuestions as $question)
                                            <tr>
                                                <td class="fw-bold">{{ $question->section }}</td>
                                                <td>{{ $question->question_text }}</td>
                                                <td class="text-center">{{ $question->max_score }}</td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary edit-btn"
                                                        data-id="{{ $question->id }}"
                                                        data-role="{{ $question->role }}"
                                                        data-section="{{ $question->section }}"
                                                        data-text="{{ $question->question_text }}"
                                                        data-score="{{ $question->max_score }}"
                                                        data-bs-toggle="modal" data-bs-target="#editQuestionModal">Edit</button>
                                                    <form action="{{ route('admin.operations.evaluation_questions.destroy', $question->id) }}" method="POST" class="d-inline delete-question-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-sm btn-outline-danger delete-btn">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @empty
                                <div class="alert alert-light border text-center mt-4 p-5">
                                    <p class="text-muted mb-0">No evaluation questions have been added yet.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Question Modal -->
<div class="modal fade" id="addQuestionModal" tabindex="-1" aria-labelledby="addQuestionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="addQuestionModalLabel">Add Evaluation Question</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addQuestionForm" action="{{ route('admin.operations.evaluation_questions.store') }}" method="POST" class="company-form">
                    @csrf
                    <div class="row mx-0">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Role Category</label>
                                <span class="text-danger">*</span>
                                <select name="role" class="form-select" required>
                                    <option value="">Select Role...</option>
                                    <option value="supervisor">Supervisor</option>
                                    <option value="training_supervisor">Supervisor In Training (SIT)</option>
                                    <option value="operations_manager">Operations Manager</option>
                                    <option value="technician">Technician</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Section Name</label>
                                <span class="text-danger">*</span>
                                <input type="text" name="section" class="form-control" placeholder="e.g. General, Front Office, Policies" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Question</label>
                                <span class="text-danger">*</span>
                                <textarea name="question_text" class="form-control" rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Max Score</label>
                                <span class="text-danger">*</span>
                                <input type="number" name="max_score" class="form-control" value="3" min="1" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Question Modal -->
<div class="modal fade" id="editQuestionModal" tabindex="-1" aria-labelledby="editQuestionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="editQuestionModalLabel">Edit Evaluation Question</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm" method="POST" class="company-form">
                    @csrf
                    @method('PUT')
                    <div class="row mx-0">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Role Category</label>
                                <span class="text-danger">*</span>
                                <select name="role" id="edit_role" class="form-select" required>
                                    <option value="supervisor">Supervisor</option>
                                    <option value="training_supervisor">Supervisor In Training (SIT)</option>
                                    <option value="operations_manager">Operations Manager</option>
                                    <option value="technician">Technician</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Section Name</label>
                                <span class="text-danger">*</span>
                                <input type="text" name="section" id="edit_section" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Question</label>
                                <span class="text-danger">*</span>
                                <textarea name="question_text" id="edit_text" class="form-control" rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Max Score</label>
                                <span class="text-danger">*</span>
                                <input type="number" name="max_score" id="edit_score" class="form-control" min="1" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
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
        $('.edit-btn').on('click', function() {
            const id = $(this).data('id');
            $('#editForm').attr('action', '/admin/operations/evaluation-questions/' + id);
            $('#edit_role').val($(this).data('role'));
            $('#edit_section').val($(this).data('section'));
            $('#edit_text').val($(this).data('text'));
            $('#edit_score').val($(this).data('score'));
        });

        function handleAjaxForm(formId) {
            $(formId).validate({
                errorElement: 'span',
                errorClass: 'invalid-feedback d-block',
                highlight: function(element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                }
            });

            $(formId).on('submit', function(e) {
                e.preventDefault();
                let form = $(this);
                
                if (!form.valid()) return;

                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message || 'Operation completed successfully.',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire('Error', xhr.responseJSON?.message || 'An error occurred.', 'error');
                    }
                });
            });
        }

        handleAjaxForm('#addQuestionForm');
        handleAjaxForm('#editForm');

        $('.delete-btn').on('click', function() {
            let form = $(this).closest('.delete-question-form');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: form.attr('action'),
                        type: 'POST',
                        data: form.serialize(),
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response.message || 'Question has been deleted.',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire('Error', 'Failed to delete question.', 'error');
                        }
                    });
                }
            });
        });
    });
</script>
@endpush
