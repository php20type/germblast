@extends('admin.includes.layout')

@section('title', 'Add Employee')

@section('content')
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                @include('admin.hr.sidebar')

                <!-- Main Content -->
                <div class="col-md-10 p-0">
                    <div class="main-content">

                        <form action="{{ route('admin.employee.store') }}" method="POST" id="employee-add-form">
                            @csrf

                            <div class="sales-dashboard">

                        {{-- HEADER --}}
                        <div class="heading-area-sec mb-3">
                            <div class="left-part-sec">
                                <h3 class="mb-1">Add Employee</h3>
                                <p class="text-muted mb-0">Create and assign role-based access for an employee</p>
                            </div>
                            <div class="right-part-sec">
                                <button type="submit" class="btn btn-success">
                                    Save Employee
                                </button>
                            </div>
                        </div>

                            {{-- BASIC INFORMATION --}}
                            <div class="px-4 pb-2">
                                <div class="section-card">
                                    <div class="section-header">
                                        <h3 class="section-title">Basic Information</h3>
                                    </div>

                                    <table class="table table-bordered align-middle">
                                        <tbody>
                                            <tr>
                                                <th>Name</th>
                                                <td>
                                                    <input type="text" name="name" class="form-control" required>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>Email</th>
                                                <td>
                                                    <input type="email" name="email" class="form-control" required>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>Password</th>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="password" name="password" id="password"
                                                            class="form-control" required>
                                                        <button type="button"
                                                            class="btn btn-outline-secondary toggle-password"
                                                            data-target="password">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>Confirm Password</th>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="password" name="password_confirmation"
                                                            id="password_confirmation" class="form-control" required>
                                                        <button type="button"
                                                            class="btn btn-outline-secondary toggle-password"
                                                            data-target="password_confirmation">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>Role</th>
                                                <td>
                                                    <select name="role" class="form-select" required>
                                                        <option value="">Select Role</option>
                                                        @foreach ($roles as $role)
                                                            <option value="{{ $role->name }}">
                                                                {{ strtoupper(str_replace('_', ' ', $role->name)) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>Staff Type</th>
                                                <td>
                                                    <select name="staff_type" class="form-select" required>
                                                        <option value="">Select Staff Type</option>
                                                        <option value="leader">Leader</option>
                                                        <option value="technician">Technician</option>
                                                        <option value="corporate">Corporate</option>
                                                    </select>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>Territory</th>
                                                <td>
                                                    <select name="territory_id" class="form-select">
                                                        <option value="">Select Territory</option>
                                                        @foreach ($territories as $territory)
                                                            <option value="{{ $territory->id }}">
                                                                {{ $territory->name }}
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
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.toggle-password').forEach(btn => {
            btn.addEventListener('click', function() {
                const input = document.getElementById(this.dataset.target);
                const icon = this.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });

        $("#employee-add-form").validate({
            ignore: [],

            rules: {
                name: {
                    required: true,
                    minlength: 2
                },
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 8
                },
                password_confirmation: {
                    required: true,
                    equalTo: "#password"
                },
                role: {
                    required: true
                },
                staff_type: {
                    required: true
                },
                territory_id: {
                    required: true
                }
            },

            messages: {
                name: "Employee name is required.",
                email: "Valid email address is required.",
                password: {
                    required: "Password is required.",
                    minlength: "Password must be at least 8 characters."
                },
                password_confirmation: {
                    required: "Please confirm password.",
                    equalTo: "Passwords do not match."
                },
                role: "Please select a role.",
                staff_type: "Please select a type.",
                territory_id: "Please select a territory.",
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
        $('#employee-add-form').on('submit', function(e) {
            e.preventDefault();

            let form = $(this);

            if (!form.valid()) {
                return;
            }

            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                data: form.serialize(),

                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message || 'Employee created successfully.',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        window.location.href = "{{ route('admin.employee.index') }}";
                    });
                },

                error: function(xhr) {

                    if (xhr.status === 422 && xhr.responseJSON?.errors) {
                        $.each(xhr.responseJSON.errors, function(field, messages) {
                            messages.forEach(function(message) {
                                toastr.error(message);
                            });
                        });
                        return;
                    }

                    toastr.error(
                        xhr.responseJSON?.message ||
                        'Something went wrong while creating employee.'
                    );
                }
            });
        });
    </script>
@endpush
