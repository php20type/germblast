@extends('admin.includes.layout')

@section('title', 'Edit Employee')

@section('content')
<div class="companies-section my-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 p-0">

                <form action="{{ route('admin.employee.update', $employee->id) }}"
                      method="POST"
                      id="employee-edit-form">
                    @csrf

                    <div class="sales-dashboard">

                        {{-- HEADER --}}
                        <div class="dashboard-header section-card d-flex justify-content-between align-items-center">
                            <div>
                                <h1 class="display-6 mb-2 fw-bold">Edit Employee</h1>
                                <p class="text-muted">Update employee details and role</p>
                            </div>

                            <button type="submit" class="btn btn-success">
                                Update Employee
                            </button>
                        </div>

                        {{-- BASIC INFORMATION --}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="section-card">
                                    <div class="section-header">
                                        <h3 class="section-title">Basic Information</h3>
                                    </div>

                                    <table class="table table-bordered align-middle">
                                        <tbody>
                                            <tr>
                                                <th>Name</th>
                                                <td>
                                                    <input type="text" name="name" class="form-control" value="{{ $employee->name }}" required>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>Role</th>
                                                <td>
                                                    <select name="role" class="form-select" required>
                                                        <option value="">Select Role</option>
                                                        @foreach ($roles as $role)
                                                            <option value="{{ $role->name }}"
                                                                {{ $employee->role === $role->name ? 'selected' : '' }}>
                                                                {{ strtoupper(str_replace('_', ' ', $role->name)) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    /* ===============================
       Toggle Password Visibility
    =============================== */
    document.querySelectorAll('.toggle-password').forEach(btn => {
        btn.addEventListener('click', function () {
            const input = document.getElementById(this.dataset.target);
            const icon  = this.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });
    });

    /* ===============================
       Validation
    =============================== */
    $("#employee-edit-form").validate({
        ignore: [],

        rules: {
            name: { required: true, minlength: 2 },
            role: { required: true }
        },

        messages: {
            name: "Employee name is required.",
            role: "Please select a role."
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
            } else {
                error.insertAfter(element);
            }
        }
    });

    /* ===============================
       AJAX Submission
    =============================== */
    $('#employee-edit-form').on('submit', function (e) {
        e.preventDefault();

        let form = $(this);

        if (!form.valid()) return;

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),

            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Updated',
                    text: response.message || 'Employee updated successfully.',
                    showConfirmButton: false,
                    timer: 2000
                }).then(() => {
                    window.location.href = "{{ route('admin.employee.index') }}";
                });
            },

            error: function (xhr) {
                if (xhr.status === 422 && xhr.responseJSON?.errors) {
                    $.each(xhr.responseJSON.errors, function (field, messages) {
                        messages.forEach(msg => toastr.error(msg));
                    });
                    return;
                }

                toastr.error(
                    xhr.responseJSON?.message ||
                    'Something went wrong while updating employee.'
                );
            }
        });
    });
</script>
@endpush
