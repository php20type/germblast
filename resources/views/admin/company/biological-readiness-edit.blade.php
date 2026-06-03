@extends('admin.includes.layout')

@section('title', 'Edit Biological Readiness')

@push('styles')
    <style>
        /* Section Card Refinement */
        .section-card {
            background: #ffffff !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 16px !important;
            padding: 25px !important;
            margin-bottom: 25px !important;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.02) !important;
            transition: all 0.3s ease !important;
        }

        .section-card:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.04) !important;
        }

        .section-title {
            font-size: 18px !important;
            font-weight: 600 !important;
            color: #374151 !important;
            margin-bottom: 0 !important;
        }

        .section-header {
            border-bottom: 1px solid #f3f4f6 !important;
            padding-bottom: 15px !important;
            margin-bottom: 20px !important;
        }

        .main-content {
            background-color: #ffffff;
            border-radius: 10px;
        }
    </style>
@endpush

@section('content')
<div class="companies-section my-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 p-0">

                <form action="{{ route('admin.company.biological.readiness.update', [$company->id, $readiness->id]) }}"
                      method="POST"
                      id="biological-readiness-form">
                    @csrf

                    <div class="main-content">

                        {{-- HEADER --}}
                        <div class="heading-area-sec border-bottom-0 pb-0">
                            <div class="left-part-sec">
                                <h3 class="mb-2" style="font-size: 26px; font-weight: 500;">
                                    BIOLOGICAL READINESS <span style="font-size: 24px;">🛡️</span>
                                </h3>
                                <p class="text-muted mb-2" style="font-size: 16px;">
                                    Edit readiness agreement details
                                </p>
                            </div>
                            <div class="right-part-sec">
                                <button type="submit" class="btn btn-export fw-semibold">
                                    Update
                                </button>
                            </div>
                        </div>

                        <div class="my-4"></div>

                        <div class="dashboard-body px-4 pb-4">

                            {{-- BASIC INFORMATION --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header">
                                            <h3 class="section-title">Basic Information</h3>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-bordered align-middle">
                                                <tbody>
                                                    <tr>
                                                        <th>Project Name</th>
                                                        <td>
                                                            <input type="text" name="project_name" class="form-control"
                                                                   value="{{ old('project_name', $readiness->project_name) }}">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th>Price per Hour Reduction Amount</th>
                                                        <td>
                                                            <input type="number" step="0.01" name="per_hour_reduction_amount"
                                                                   class="form-control"
                                                                   value="{{ old('per_hour_reduction_amount', $readiness->per_hour_reduction_amount) }}">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th>Length of Contract (months)</th>
                                                        <td>
                                                            <input type="number" name="length" class="form-control"
                                                                   value="{{ old('length', $readiness->length) }}">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th>Monthly Rate</th>
                                                        <td>
                                                            <input type="number" step="0.01" name="monthly_rate"
                                                                   class="form-control"
                                                                   value="{{ old('monthly_rate', $readiness->monthly_rate) }}">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th>Status</th>
                                                        <td>
                                                            <select name="status" class="form-control">
                                                                @foreach(['Open','Won','Lost','Pending','Closed'] as $status)
                                                                    <option value="{{ $status }}"
                                                                        {{ old('status', $readiness->status) === $status ? 'selected' : '' }}>
                                                                        {{ $status }}
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

                            {{-- READINESS DETAILS --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header">
                                            <h3 class="section-title">Readiness Details</h3>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-bordered align-middle">
                                                <tbody>
                                                    <tr>
                                                        <th>Default Readiness Includes</th>
                                                        <td>
                                                            <textarea name="default_readiness_includes_1"
                                                                      rows="3"
                                                                      class="form-control">{{ old('default_readiness_includes_1', $readiness->default_readiness_includes_1) }}</textarea>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th>Default Readiness Includes</th>
                                                        <td>
                                                            <textarea name="default_readiness_includes_2"
                                                                      rows="3"
                                                                      class="form-control">{{ old('default_readiness_includes_2', $readiness->default_readiness_includes_2) }}</textarea>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th>In addition Include</th>
                                                        <td>
                                                            <textarea name="additional_includes"
                                                                      rows="4"
                                                                      class="form-control"></textarea>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
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
$(document).ready(function () {

    // Tagify with existing includes
    let input = document.querySelector('textarea[name=additional_includes]');
    let tagify = new Tagify(input);

    tagify.addTags(@json(
        $readiness->includes->map(fn($i) => ['value' => $i->includes])
    ));

    $("#biological-readiness-form").validate({
        ignore: [],
        rules: {
            project_name: { required: true },
            per_hour_reduction_amount: { required: true, number: true },
            length: { required: true, number: true },
            monthly_rate: { required: true, number: true },
            status: { required: true },
            default_readiness_includes_1: { required: true },
            default_readiness_includes_2: { required: true }
        },
        errorElement: 'span',
        errorClass: 'invalid-feedback d-block',
        highlight: el => $(el).addClass('is-invalid'),
        unhighlight: el => $(el).removeClass('is-invalid'),
        errorPlacement: (err, el) => err.insertAfter(el)
    });

    $('#biological-readiness-form').on('submit', function (e) {
        e.preventDefault();
        let form = $(this);
        if (!form.valid()) return;

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            success: res => {
                Swal.fire({
                    icon: 'success',
                    title: 'Updated',
                    text: res.message || 'Biological readiness updated successfully',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => location.reload());
            },
            error: xhr => {
                if (xhr.status === 422 && xhr.responseJSON?.errors) {
                    Object.values(xhr.responseJSON.errors).flat()
                        .forEach(msg => toastr.error(msg));
                    return;
                }
                toastr.error('Something went wrong.');
            }
        });
    });
});
</script>
@endpush
