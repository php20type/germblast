@extends('admin.includes.layout')

@section('title', 'Employee Performance')

@push('styles')
    <style>
        .cursor-pointer {
            cursor: pointer !important;
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
                                <h3 class="mb-1 text-uppercase">EMPLOYEE DISCIPLINE</h3>
                                <p class="text-muted mb-0">In keeping with GermBlast's goal to continuously improve.</p>
                            </div>
                        </div>
                        
                        <div class="px-4 pb-4">
                            
                            <!-- Filter Control Bar (Quarterly) -->
                            <div class="filter-section py-3 px-4 my-3 rounded-3 border bg-white" style="border-color: #e5e7eb !important;">
                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                    <!-- Left Side: Current Range Header -->
                                    <div>
                                        <h4 class="mb-0 fw-bold text-dark" style="font-size: 18px;">
                                            Quarter: {{ $quarter }}
                                        </h4>
                                    </div>

                                    <!-- Right Side: Unified Navigation Segment Control -->
                                    <div class="d-flex align-items-center gap-1 bg-light p-1 rounded-3 border" style="border-color: #e5e7eb !important;">
                                        <a href="{{ request()->url() }}?quarter={{ urlencode($prevQuarter) }}" class="calendar-nav-btn" title="Previous Quarter">
                                            <i class="fas fa-chevron-left me-1" style="font-size: 10px;"></i> Prev Quarter
                                        </a>

                                        <span class="text-muted opacity-25 px-1">|</span>

                                        <a href="{{ request()->url() }}?quarter={{ urlencode($currentQuarter) }}" class="calendar-nav-btn {{ $quarter === $currentQuarter ? 'btn-today' : '' }}">
                                             Current Quarter
                                         </a>

                                        <span class="text-muted opacity-25 px-1">|</span>

                                        <a href="{{ request()->url() }}?quarter={{ urlencode($nextQuarter) }}" class="calendar-nav-btn" title="Next Quarter">
                                            Next Quarter <i class="fas fa-chevron-right ms-1" style="font-size: 10px;"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Discipline Guidelines Table -->
                            <div class="py-3 px-4 my-3 rounded-3 border bg-white" style="border-color: #e5e7eb !important;">
                                <div class="row" style="font-size: 13px; color: #4b5563;">
                                    <div class="col-md-4">
                                        <h6 class="fw-bold border-bottom pb-2 mb-2" style="font-size: 14px;">Tardiness/ Absenteeism</h6>
                                        <ul class="list-unstyled mt-2" style="line-height: 1.6;">
                                            <li><span class="fw-bold">1-</span> 5 min or more late</li>
                                            <li><span class="fw-bold">2-</span> Unexcused call-ins less than 12 hours before a scheduled service</li>
                                            <li><span class="fw-bold">6-</span> No call no show</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4">
                                        <h6 class="fw-bold border-bottom pb-2 mb-2" style="font-size: 14px;">Uniform</h6>
                                        <ul class="list-unstyled mt-2" style="line-height: 1.6;">
                                            <li><span class="fw-bold">2-</span> Failure to abide by the uniform policy</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4">
                                        <h6 class="fw-bold border-bottom pb-2 mb-2" style="font-size: 14px;">Employee Conduct</h6>
                                        <ul class="list-unstyled mt-2" style="line-height: 1.6;">
                                            <li><span class="fw-bold">1-</span> Profanity</li>
                                            <li><span class="fw-bold">2-</span> Failure to abide by the PPE policy</li>
                                            <li><span class="fw-bold">2-</span> Failure to abide by the tobacco policy( e-cigarettes/ vaping, smoke product tobacco and smokeless tobacco products)</li>
                                            <li><span class="fw-bold">3-</span> Insubordination to supervisor</li>
                                            <li><span class="fw-bold">12-</span> Failure to abide by the sexual harassment policy</li>
                                            <li><span class="fw-bold">12-</span> Failure to abide by the employee conduct and work rules policy such as but not limited to fighting, theft, etc</li>
                                            <li><span class="fw-bold">12-</span> Failure to abide by the anti-substance abuse policy</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Employees List -->
                            <div class="table-responsive mt-4">
                                <table class="table table-hover w-100 equipment-report-table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th></th>
                                            <th>Points This Quarter</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Technicians Section -->
                                        <tr class="category-header-row" style="background-color: #fdf6e3 !important; border-bottom: 2px solid #fff;">
                                            <td colspan="3" class="fw-bold text-dark py-3" style="font-size: 14px;">Technicians</td>
                                        </tr>
                                        
                                        @foreach($technicians as $user)
                                        <tr style="border-bottom: 1px solid #f3f4f6;">
                                            <td class="fw-bold align-middle py-3 border-0 text-dark" style="font-size: 12px;">{{ $user->name }}</td>
                                            <td class="align-middle border-0 py-2">
                                                <a href="#" class="text-info text-decoration-none d-block mb-1 add-record-btn" data-user-id="{{ $user->id }}" data-category="Tardy" style="color: #60a5fa !important;">Add Tardy</a>
                                                <a href="#" class="text-info text-decoration-none d-block mb-1 add-record-btn" data-user-id="{{ $user->id }}" data-category="Uniform" style="color: #60a5fa !important;">Add Uniform</a>
                                                <a href="#" class="text-info text-decoration-none d-block add-record-btn" data-user-id="{{ $user->id }}" data-category="Employee Conduct" style="color: #60a5fa !important;">Add Employee Conduct</a>
                                            </td>
                                            <td class="align-middle border-0 py-2">
                                                <div class="d-flex align-items-center">
                                                    <span class="me-auto text-muted">Total points: {{ $user->disciplineRecords->sum('points') }}</span>
                                                    <button class="btn btn-light border text-muted view-more-btn" data-target="details-tech-{{ $user->id }}" style="font-size: 13px; padding: 6px 14px; background-color: #f3f4f6;">View More</button>
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- Expandable Details Row -->
                                        <tr id="details-tech-{{ $user->id }}" style="display: none; background-color: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                                            <td colspan="3" class="p-3 border-0">
                                                <h6 class="fw-bold mb-3" style="font-size: 14px; color: #4b5563;">Performance Records this Quarter:</h6>
                                                @if($user->disciplineRecords->isEmpty())
                                                    <p class="text-muted mb-0" style="font-size: 14px;">No records found.</p>
                                                @else
                                                    <ul class="list-group list-group-flush border rounded bg-white">
                                                        @foreach($user->disciplineRecords as $record)
                                                            <li class="list-group-item p-3 border-0 border-bottom">
                                                                <div class="d-flex justify-content-between align-items-start mb-1">
                                                                    <span class="fw-bold text-dark" style="font-size: 14px;">{{ $record->category }}</span>
                                                                    <span class="badge bg-danger rounded-pill px-2 py-1" style="font-size: 12px;">{{ $record->points }} pts</span>
                                                                </div>
                                                                @if($record->comments)
                                                                    <div class="text-muted" style="font-size: 13px;">{{ $record->comments }}</div>
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach

                                        <!-- Header row again -->
                                        <tr>
                                            <th colspan="3" class="bg-light text-muted border-0 py-3" style="font-size: 13px;">Name &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Points This Quarter</th>
                                        </tr>
                                        <tr class="category-header-row" style="background-color: #fdf6e3 !important; border-bottom: 2px solid #fff;">
                                            <td colspan="3" class="fw-bold text-dark py-3" style="font-size: 14px;">Warehouse</td>
                                        </tr>
                                        @foreach($warehouse as $user)
                                        <tr style="border-bottom: 1px solid #f3f4f6;">
                                            <td class="fw-bold align-middle py-3 border-0 text-dark" style="font-size: 12px;">{{ $user->name }}</td>
                                            <td class="align-middle border-0 py-2">
                                                <a href="#" class="text-info text-decoration-none d-block mb-1 add-record-btn" data-user-id="{{ $user->id }}" data-category="Tardy" style="color: #60a5fa !important;">Add Tardy</a>
                                                <a href="#" class="text-info text-decoration-none d-block mb-1 add-record-btn" data-user-id="{{ $user->id }}" data-category="Uniform" style="color: #60a5fa !important;">Add Uniform</a>
                                                <a href="#" class="text-info text-decoration-none d-block add-record-btn" data-user-id="{{ $user->id }}" data-category="Employee Conduct" style="color: #60a5fa !important;">Add Employee Conduct</a>
                                            </td>
                                            <td class="align-middle border-0 py-2">
                                                <div class="d-flex align-items-center">
                                                    <span class="me-auto text-muted">Total points: {{ $user->disciplineRecords->sum('points') }}</span>
                                                    <button class="btn btn-light border text-muted view-more-btn" data-target="details-ware-{{ $user->id }}" style="font-size: 13px; padding: 6px 14px; background-color: #f3f4f6;">View More</button>
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- Expandable Details Row -->
                                        <tr id="details-ware-{{ $user->id }}" style="display: none; background-color: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                                            <td colspan="3" class="p-3 border-0">
                                                <h6 class="fw-bold mb-3" style="font-size: 14px; color: #4b5563;">Performance Records this Quarter:</h6>
                                                @if($user->disciplineRecords->isEmpty())
                                                    <p class="text-muted mb-0" style="font-size: 14px;">No records found.</p>
                                                @else
                                                    <ul class="list-group list-group-flush border rounded bg-white">
                                                        @foreach($user->disciplineRecords as $record)
                                                            <li class="list-group-item p-3 border-0 border-bottom">
                                                                <div class="d-flex justify-content-between align-items-start mb-1">
                                                                    <span class="fw-bold text-dark" style="font-size: 14px;">{{ $record->category }}</span>
                                                                    <span class="badge bg-danger rounded-pill px-2 py-1" style="font-size: 12px;">{{ $record->points }} pts</span>
                                                                </div>
                                                                @if($record->comments)
                                                                    <div class="text-muted" style="font-size: 13px;">{{ $record->comments }}</div>
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach

                                        <tr class="category-header-row" style="background-color: #fdf6e3 !important; border-bottom: 2px solid #fff;">
                                            <td colspan="3" class="fw-bold text-dark py-3" style="font-size: 14px;">Supervisors</td>
                                        </tr>
                                        @foreach($supervisors as $user)
                                        <tr style="border-bottom: 1px solid #f3f4f6;">
                                            <td class="fw-bold align-middle py-3 border-0 text-dark" style="font-size: 12px;">{{ $user->name }}</td>
                                            <td class="align-middle border-0 py-2">
                                                <a href="#" class="text-info text-decoration-none d-block mb-1 add-record-btn" data-user-id="{{ $user->id }}" data-category="Tardy" style="color: #60a5fa !important;">Add Tardy</a>
                                                <a href="#" class="text-info text-decoration-none d-block mb-1 add-record-btn" data-user-id="{{ $user->id }}" data-category="Uniform" style="color: #60a5fa !important;">Add Uniform</a>
                                                <a href="#" class="text-info text-decoration-none d-block add-record-btn" data-user-id="{{ $user->id }}" data-category="Employee Conduct" style="color: #60a5fa !important;">Add Employee Conduct</a>
                                            </td>
                                            <td class="align-middle border-0 py-2">
                                                <div class="d-flex align-items-center">
                                                    <span class="me-auto text-muted">Total points: {{ $user->disciplineRecords->sum('points') }}</span>
                                                    <button class="btn btn-light border text-muted view-more-btn" data-target="details-sup-{{ $user->id }}" style="font-size: 13px; padding: 6px 14px; background-color: #f3f4f6;">View More</button>
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- Expandable Details Row -->
                                        <tr id="details-sup-{{ $user->id }}" style="display: none; background-color: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                                            <td colspan="3" class="p-3 border-0">
                                                <h6 class="fw-bold mb-3" style="font-size: 14px; color: #4b5563;">Performance Records this Quarter:</h6>
                                                @if($user->disciplineRecords->isEmpty())
                                                    <p class="text-muted mb-0" style="font-size: 14px;">No records found.</p>
                                                @else
                                                    <ul class="list-group list-group-flush border rounded bg-white">
                                                        @foreach($user->disciplineRecords as $record)
                                                            <li class="list-group-item p-3 border-0 border-bottom">
                                                                <div class="d-flex justify-content-between align-items-start mb-1">
                                                                    <span class="fw-bold text-dark" style="font-size: 14px;">{{ $record->category }}</span>
                                                                    <span class="badge bg-danger rounded-pill px-2 py-1" style="font-size: 12px;">{{ $record->points }} pts</span>
                                                                </div>
                                                                @if($record->comments)
                                                                    <div class="text-muted" style="font-size: 13px;">{{ $record->comments }}</div>
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
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

<!-- Add Performance Record Modal Start -->
<div class="modal fade" id="addRecordModal" tabindex="-1" aria-labelledby="addRecordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="addRecordModalLabel">Add Performance Record</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.employee-performance.store') }}" method="POST" class="company-form" id="add-record-form">
                    @csrf
                    <input type="hidden" name="user_id" id="modal_user_id">
                    <input type="hidden" name="quarter" value="{{ $quarter }}">
                    
                    <div class="row mx-0">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Category</label>
                                <span class="text-danger">*</span>
                                <select class="form-select select2" name="category" id="modal_category" required style="width: 100%;">
                                    <option value="">Select an option</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-lg-12">
                            <div class="form-group">    
                                <label class="form-label">Points</label>
                                <input type="number" class="form-control" name="points" placeholder="Points will auto-fill" readonly>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Comments (Optional)</label>
                                <textarea class="form-control" name="comments" rows="3" placeholder="Additional details..."></textarea>
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
<!-- Add Performance Record Modal End -->

@endsection

@push('styles')
<style>
    /* Allow Select2 options to wrap */
    .select2-container--default .select2-results__option {
        white-space: normal;
        word-wrap: break-word;
    }
    
    /* Disable hover effect on category header rows */
    .table-hover > tbody > tr.category-header-row > td,
    .table-hover > tbody > tr.category-header-row:hover > td {
        background-color: #fdf6e3 !important;
        box-shadow: none !important;
        color: inherit !important;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addRecordBtns = document.querySelectorAll('.add-record-btn');
        const modalUserIdInput = document.getElementById('modal_user_id');
        const $modalCategorySelect = $('#modal_category');
        const pointsInput = document.querySelector('input[name="points"]');
        const addRecordModal = new bootstrap.Modal(document.getElementById('addRecordModal'));

        $modalCategorySelect.select2({
            dropdownParent: $('#addRecordModal'),
            placeholder: "Select an option"
        });

        const categoryOptions = {
            'Tardy': [
                { text: '5 min or more late', points: 1 },
                { text: 'Unexcused call-ins less than 12 hours before a scheduled service', points: 2 },
                { text: 'No call no show', points: 6 }
            ],
            'Uniform': [
                { text: 'Failure to abide by the uniform policy', points: 2 }
            ],
            'Employee Conduct': [
                { text: 'Profanity', points: 1 },
                { text: 'Failure to abide by the PPE policy', points: 2 },
                { text: 'Failure to abide by the tobacco policy( e-cigarettes/ vaping, smoke product tobacco and smokeless tobacco products)', points: 2 },
                { text: 'Insubordination to supervisor', points: 3 },
                { text: 'Failure to abide by the sexual harassment policy', points: 12 },
                { text: 'Failure to abide by the employee conduct and work rules policy such as but not limited to fighting, theft, etc', points: 12 },
                { text: 'Failure to abide by the anti-substance abuse policy', points: 12 }
            ]
        };

        addRecordBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                modalUserIdInput.value = this.dataset.userId;
                
                // Populate dropdown
                const selectedCategory = this.dataset.category;
                $modalCategorySelect.empty().append('<option value="">Select an option</option>');
                pointsInput.value = ''; // Reset points
                
                if (categoryOptions[selectedCategory]) {
                    categoryOptions[selectedCategory].forEach(option => {
                        const opt = $('<option></option>').val(option.text).text(option.text);
                        opt.attr('data-points', option.points);
                        $modalCategorySelect.append(opt);
                    });
                }
                
                $modalCategorySelect.trigger('change');
                addRecordModal.show();
            });
        });

        // Auto-fill points when a category is selected
        $modalCategorySelect.on('change', function() {
            const selectedOption = $(this).find('option:selected');
            if (selectedOption.length && selectedOption.attr('data-points')) {
                pointsInput.value = selectedOption.attr('data-points');
            } else {
                pointsInput.value = '';
            }
        });

        const viewMoreBtns = document.querySelectorAll('.view-more-btn');
        viewMoreBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.dataset.target;
                const targetRow = document.getElementById(targetId);
                
                if (targetRow.style.display === 'none' || targetRow.style.display === '') {
                    targetRow.style.display = 'table-row';
                    this.textContent = 'Hide Details';
                } else {
                    targetRow.style.display = 'none';
                    this.textContent = 'View More';
                }
            });
        });
    });

    $(document).ready(function() {
        // Form Validation
        $("#add-record-form").validate({
            ignore: [],
            rules: {
                category: {
                    required: true
                }
            },
            messages: {
                category: {
                    required: "Please select a category."
                }
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
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent()); // Inserts after the .input-group
                } else {
                    error.insertAfter(element); // Default
                }
            }
        });

        // AJAX Form Submission
        $('#add-record-form').submit(function(e) {
            e.preventDefault();

            const $form = $(this);
            const $submitBtn = $form.find('button[type="submit"]');

            if (!$form.valid()) return;

            $.ajax({
                url: $form.attr('action'),
                method: 'POST',
                data: $form.serialize(),
                beforeSend: function() {
                    $submitBtn.prop('disabled', true).text('Saving...');
                },
                success: function() {
                    toastr.success('Performance record created successfully! Redirecting...');
                    $form[0].reset();
                    
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                },
                error: function(xhr) {
                    if (xhr.status === 422 && xhr.responseJSON?.errors) {
                        $.each(xhr.responseJSON.errors, function(field, messages) {
                            messages.forEach(function(message) { toastr.error(message); });
                        });
                    } else {
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong while adding the record.');
                    }
                    $submitBtn.prop('disabled', false).text('Save changes');
                }
            });
        });
    });
</script>
@endpush
