@extends('admin.includes.layout')

@section('title', 'Biological Readiness')

@section('content')
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 p-0">

                    <form action="{{ route('admin.company.biological.readiness.store', $company->id) }}" method="POST"
                        id="biological-readiness-form">
                        @csrf

                        <div class="sales-dashboard">

                            {{-- HEADER --}}
                            <div class="dashboard-header section-card d-flex justify-content-between align-items-center">
                                <div>
                                    <h1 class="display-6 mb-2 fw-bold">Biological Readiness</h1>
                                    <p class="text-muted">Create readiness agreement details</p>
                                </div>

                                <button type="submit" class="btn btn-success">
                                    Submit
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
                                                    <th>Project Name</th>
                                                    <td>
                                                        <input type="text" name="project_name" class="form-control">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Price per Hour Reduction Amount</th>
                                                    <td>
                                                        <input type="number" step="0.01" name="per_hour_reduction_amount"
                                                            class="form-control">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Length of Contract (months)</th>
                                                    <td>
                                                        <input type="number" name="length"
                                                            class="form-control">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Monthly Rate</th>
                                                    <td>
                                                        <input type="number" step="0.01" name="monthly_rate"
                                                            class="form-control">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Status</th>
                                                    <td>
                                                        <select name="status" class="form-control">
                                                            <option value="Open">Open</option>
                                                            <option value="Won">Won</option>
                                                            <option value="Lost">Lost</option>
                                                            <option value="Pending">Pending</option>
                                                            <option value="Closed">Closed</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            {{-- READINESS DETAILS --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header">
                                            <h3 class="section-title">Readiness Details</h3>
                                        </div>

                                        <table class="table table-bordered align-middle">
                                            <tbody>
                                                <tr>
                                                    <th>Default Readiness Includes</th>
                                                    <td>
                                                        <textarea name="default_readiness_includes_1" rows="3" class="form-control">
Reserved chemical, personal protective equipment, and other needed supplies to ensure availability for GermBlast to respond to your outbreak
                                                    </textarea>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Default Readiness Includes</th>
                                                    <td>
                                                        <textarea name="default_readiness_includes_2" rows="3" class="form-control">
Required biological response supplies and chemical included with each service
                                                    </textarea>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>In addition Include</th>
                                                    <td>
                                                        <textarea name="additional_includes" rows="4" class="form-control" placeholder="Type a addition and press Enter"></textarea>
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
        $(document).ready(function() {

            var input = document.querySelector('textarea[name=additional_includes]');
            if (input) new Tagify(input);

            $("#biological-readiness-form").validate({
                ignore: [],
                rules: {
                    project_name: {
                        required: true
                    },
                    per_hour_reduction_amount: {
                        required: true,
                        number: true
                    },
                    length: {
                        required: true,
                        number: true
                    },
                    monthly_rate: {
                        required: true,
                        number: true
                    },
                    status: {
                        required: true
                    },
                    default_readiness_includes_1: {
                        required: true
                    },
                    default_readiness_includes_2: {
                        required: true
                    }
                },

                messages: {
                    project_name: "Project name is required.",
                    per_hour_reduction_amount: "Per hour reduction amount is required.",
                    length: "Contract length is required.",
                    monthly_rate: "Monthly rate is required.",
                    status: "Please select a status.",
                    default_readiness_includes_1: "This field is required.",
                    default_readiness_includes_2: "This field is required."
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


            $('#biological-readiness-form').on('submit', function(e) {
                e.preventDefault();

                let form = $(this);

                if (!form.valid()) return;

                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: form.serialize(),

                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message ||
                                'Biological readiness saved successfully.',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            location.reload();
                        });
                    },

                    error: function(xhr) {

                        if (xhr.status === 422 && xhr.responseJSON?.errors) {
                            $.each(xhr.responseJSON.errors, function(field, messages) {
                                messages.forEach(msg => toastr.error(msg));
                            });
                            return;
                        }

                        toastr.error(
                            xhr.responseJSON?.message ||
                            'Something went wrong while saving readiness.'
                        );
                    }
                });
            });

        });
    </script>
@endpush
