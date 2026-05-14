@extends('admin.includes.layout')

@section('title', 'Employees')

@section('content')

    <!-- All Companies Section start  -->
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">
                <!-- Main Content -->
                <div class="col-md-12 p-0">
                    <div class="main-content">
                        <!-- Header -->
                        <div class="heading-area-sec">
                            <div class="left-part-sec">
                                <h3 class="mb-1">All EMPLOYEES <span style="font-size: 24px;">📌</span></h3>
                                <p class="text-muted mb-0">Internal users excluding clients</p>
                            </div>
                            <div class="right-part">
                                <a href="{{ route('admin.employee.create') }}" class="btn btn-export">+ Add Employee</a>
                            </div>
                        </div>

                        <!-- Filter Section -->
                        <div class="filter-section">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center position-relative">
                                        <div class="search-form">
                                            <input type="search" class="form-control" placeholder="Search by name.." aria-label="Search"
                                                id="employee-search">
                                        </div>
                                        <span class="company-count">{{ $employeesCount }} Employee Found</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="table-responsive">
                            <div class="table-container mt-3">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Profile</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Staff Type</th>
                                            <th>Territory</th>
                                            <th>Hourly Rate</th>
                                            <th>Joined</th>
                                        </tr>
                                    </thead>
                                    <tbody id="employee-table-body">
                                        @include('admin.employee.partials.employee-table-rows')
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Action Bar -->
                        <div class="action-bar" id="actionBar">
                            <div class="d-flex align-items-center justify-content-center">
                                <span class="me-3"><strong id="selectedCount">1</strong> Selected</span>
                                {{-- <button class="btn btn-delete btn-action">DELETE</button> --}}
                            </div>
                        </div>

                    </div>

                </div>
            </div>
            <!-- All Companies Section End  -->

        </div>

    @endsection

    @push('scripts')
        <script>
            $(document).ready(function() {
                function fetchEmployees() {
                    let search = $('#employee-search').val();

                    $.ajax({
                        url: "{{ route('admin.employee.index') }}",
                        method: "GET",
                        data: {
                            search: search,
                        },
                        success: function(response) {
                            $('#employee-table-body').html(response.table);
                            $('.company-count').text(response.count + ' Employee Found');
                        },
                        error: function() {
                            console.error('Error fetching employee data');
                        }
                    });
                }

                // Trigger AJAX on typing
                $('#employee-search').on('input', function () {
                    fetchEmployees();
                });

                $(document).on('click', '.toggle-rate', function () {
                    let icon = $(this);
                    let span = icon.closest('td').find('.hourly-rate');

                    let value = span.data('value');

                    if (icon.hasClass('fa-eye')) {
                        span.text('$' + value);
                        icon.removeClass('fa-eye').addClass('fa-eye-slash');
                    } else {
                        span.text('*****');
                        icon.removeClass('fa-eye-slash').addClass('fa-eye');
                    }
                });

            });
        </script>
    @endpush
