@extends('admin.includes.layout')

@section('title', 'Company Types')

@section('content')


    <main class="app-wrapper">
        <!-- All Companies Section start  -->
        <div class="profile-section my-4">
            <div class="container-fluid">
                <div class="row">
                    <!-- Sidebar -->
                    @include('admin.settings.sidebar')

                    <!-- Main Content -->
                    <div class="col-md-10 p-0">
                        <div class="activity-type-content">
                            <div class="heading-area-sec">
                                <div class="left-part-sec">
                                    <h3 class="mb-1 fw-bold">COMPANY TYPES</h3>
                                    <p class="text-muted mb-0">Categorize the companies you work with, i.e. “Partner,” “Vendor,” “Potential customer”.</p>
                                </div>
                                <hr>
                            </div>

                            <div class="table-container">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-bold mb-0">COMPANY TYPES ({{ $totalCounts }})</h6>
                                    <a href="javascript:void(0);" class="btn-add-activity" id="toggleAddCompany" onclick="addCompanyType()">Add Company type</a>
                                </div>

                                <div class="table-responsive">
                                    <table class="table activity-table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Name</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($company_types as $company_type)
                                                <tr>
                                                    <td>{{ $company_type->type }}</td>
                                                    <td style="text-align:right;"><a href="javascript:void(0);" class="report-link">Report</a></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="info-section">
                                <div class="info-cards">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6>WHAT IS A COMPANY TYPE?</h6>
                                    </div>
                                    <p>Every company has a company type. This allows you to choose between Customers, Potential Customers, Partners, etc. The first listed type is the default.</p>
                                </div>
                                <div class="info-cards">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6>CONVERT "PROSPECTS" TO "CUSTOMERS" WHEN LEADS ARE WON</h6>
                                    </div>
                                    <p>Use our <a href="javascript:void(0);" class="view-quotas-link">Sales Automation</a> to automatically change a company’s type to "Customer" (or any company type!) when its lead is closed.</p>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- All Companies Section End  -->
    </main>

    {{-- Competitor modal --}}
    <div class="modal fade" id="add_company_type" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        {{-- Just remove modal-fullscreen from below class , to get a popup instead of full modal --}}
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="exampleModalLabel">New Company Type</h1>
                    <div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
                <div class="modal-body ps-0">

                    <form class="company-form" action="{{ route('admin.settings.company_type.store') }}" method="post" id="store_company_type">
                        @csrf


                        <div class="row mx-0">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Name</label>
                                    <input type="text" placeholder="" name="name"
                                        class="form-control" />
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success" id="AddCompetitor">New Company Type</button>
                </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>

        function addCompanyType() {
            $('#add_company_type').modal('show');
        }

         $("#store_company_type").validate({
            ignore: [],
            rules: {
                name: {
                    required: true
                },
            },
            messages: {
                name: {
                    required: "Please enter the company type name."
                },
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


        $('#store_company_type').submit(function(e) {
            e.preventDefault();

            if (!$('#store_company_type').valid()) {
                return; // Stop if validation fails
            }

            $.ajax({
                url: "{{ route('admin.settings.company_type.store') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    alert('Company type added successfully!');
                    $('#add_company_type').modal('hide');
                    console.log(response);
                    location.reload();

                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseText);
                    toastr.error('Something went wrong while adding new company type.');
                }
            });
        });


        function toggleSettings() {
            const settingsContent = document.getElementById('settingsContent');
            const chevronIcon = document.getElementById('settingsChevron');

            if (settingsContent.classList.contains('show')) {
                settingsContent.classList.remove('show');
                chevronIcon.classList.add('rotated');
            } else {
                settingsContent.classList.add('show');
                chevronIcon.classList.remove('rotated');
            }
        }

        function toggleDropdown(section) {
            const sections = ['administration', 'sales', 'data', 'organization', 'connections'];

            // Close all other dropdowns
            sections.forEach(otherSection => {
                if (otherSection !== section) {
                    const otherContent = document.getElementById(otherSection + 'Content');
                    const otherChevron = document.getElementById(otherSection + 'Chevron');
                    otherContent.classList.remove('show');
                    otherChevron.classList.remove('rotated');
                }
            });

            // Toggle the clicked dropdown
            const dropdownContent = document.getElementById(section + 'Content');
            const chevronIcon = document.getElementById(section + 'Chevron');

            if (dropdownContent.classList.contains('show')) {
                dropdownContent.classList.remove('show');
                chevronIcon.classList.remove('rotated');
            } else {
                dropdownContent.classList.add('show');
                chevronIcon.classList.add('rotated');
            }
        }

        // Initialize Bootstrap tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endpush
