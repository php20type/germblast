@extends('admin.includes.layout')

@section('title', 'Companies')

@section('content')

    <!-- All Companies Section start  -->
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                @include('admin.company.sidebar')

                <!-- Main Content -->
                <div class="col-md-10 p-0">
                    <div class="main-content">
                        <!-- Header -->
                        <div class="heading-area-sec">
                            <div class="left-part-sec">
                                <h3 class="mb-1">All COMPANIES <span style="font-size: 24px;">📌</span></h3>
                                <p class="text-muted mb-0">All accounts and organizations you do business with</p>
                            </div>
                            <!-- <div class="d-none right-part">
                                <button class="btn btn-email">Email</button>
                                <button class="btn btn-export">EXPORT</button>
                            </div> -->
                            @can('company.create')
                            <div class="right-part">
                                <button class="btn btn-export" data-bs-toggle="modal" data-bs-target="#AddCompany">
                                    <i class="fa-solid fa-plus"></i> 
                                    Add Company
                                </button>
                            </div>
                            @endcan
                        </div>

                        <!-- Filter Section -->
                        <div class="filter-section">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center position-relative">
                                        <div class="search-form">
                                            <input type="search" class="form-control" placeholder="" aria-label="Search"
                                                id="company-search">
                                        </div>
                                        <span class="company-count">{{ $companiesCount }} Company Found</span>
                                    </div>
                                </div>
                                <div class="col-md-6 ">
                                    <div class="d-flex align-items-center justify-content-end dropdown">
                                        <div class="me-2">
                                            <select class="form-select" aria-label="Default select example"
                                                name="company_type_id">
                                                <option value="">Company Type</option>
                                                @foreach ($company_types as $company_type)
                                                    <option value="{{ $company_type->id }}">
                                                        {{ $company_type->type }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="me-2">
                                            <select class="form-select" aria-label="Default select example" name="assignee_id">
                                                <option value="">Assignee</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}
                                                        </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="me-2">
                                            <select class="form-select" aria-label="Default select example"
                                                name="people_id">
                                                <option value="">People</option>
                                                @foreach ($peoples as $people)
                                                    <option value="{{ $people->id }}">{{ $people->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <button class="btn btn-primary me-2 position-relative" onclick="addFilter()">
                                            <img src="{{ asset('img/icons/filter.svg') }}" alt="" />

                                            <!-- Filter Count Badge -->
                                            <span id="filterCount"
                                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger d-none">
                                                0
                                            </span>
                                        </button>

                                        <button class="d-none btn btn-primary"><img src="{{ asset('img/icons/bar.svg') }}"
                                                alt="" /></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="table-responsive">
                            <div class="table-container mt-3">
                                <table class="table table-hover company-listing-table">
                                    <thead>
                                        <tr>
                                            <th class="checkbox-cell">
                                                <input type="checkbox" class="form-check-input" id="selectAll">
                                            </th>
                                            <th>Company name</th>
                                            <th>People</th>
                                            <th>Created</th>
                                            <th>Address</th>
                                            <th>Company type</th>
                                            <th>Tags</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($companies as $company)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="form-check-input row-checkbox"
                                                        data-id="{{ $company->id }}">
                                                </td>
                                                <td>
                                                    <div class="company-name">
                                                        @can('company.detail.view')
                                                            <a href="{{ route('admin.company.show', $company->id) }}"
                                                                class="text-decoration-none text-dark">
                                                                {{ $company->name ?? 'N/A' }}
                                                            </a>
                                                        @else
                                                            <span class="text-dark">
                                                                {{ $company->name ?? 'N/A' }}
                                                            </span>
                                                        @endcan
                                                    </div>
                                                    <div class="company-name">
                                                        {{ $company->assignee->name ?? 'N/A' }}
                                                    </div>
                                                </td>
                                                <td>
                                                    {{ $company->peoples->pluck('name')->join(', ') ?: 'N/A' }}
                                                </td>
                                                {{-- peoples of that company info --}}
                                                <td>{{ \Carbon\Carbon::parse($company->created_at)->format('d F Y') }}</td>
                                                <td>
                                                    {{ $company->locations->first()->full_address ?? 'N/A' }}
                                                </td>
                                                <td><span class="badge-customer">
                                                        {{ $company->companyType->type ?? 'N/A' }}
                                                    </span></td>
                                                <td>
                                                    @if ($company->tags->isNotEmpty())
                                                        @foreach ($company->tags as $tag)
                                                            <span class="badge-customer">{{ $tag->name }}</span>
                                                        @endforeach
                                                    @else
                                                        <span>N/A</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center">No Companies found</td>
                                            </tr>
                                        @endforelse


                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Pagination -->
                        <div class="row m-3">
                            <div id="company-pagination" class="col-12 mt-3">
                                {{ $companies->links() }}
                            </div>
                        </div>


                        <!-- Action Bar -->
                        <div class="action-bar" id="actionBar">
                            <div class="d-flex align-items-center justify-content-center">
                                <span class="me-3"><strong id="selectedCount">1</strong> Selected</span>

                                @can('company.delete')
                                <button class="btn btn-delete btn-action">DELETE</button>
                                @endcan

                            </div>
                        </div>

                    </div>

                </div>
            </div>
            <!-- All Companies Section End  -->

        </div>

        <!-- Add Lead Modal Start -->
        <!-- Extended Filters Modal Start -->
        <div class="modal fade" id="AddFilter" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title" id="exampleModalLabel">Extended Filters</h1>
                        <div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                    </div>
                    <div class="modal-body">


                        <div class="row mx-0" id="filter-section">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Company Tags</label>
                                    <div class="checkbox-group">
                                        @foreach ($companytags as $companytag)
                                            <div class="form-check">
                                                <input type="checkbox" name="company_tags_filter_id[]"
                                                    value="{{ $companytag->id }}" class="form-check-input"
                                                    id="companytag_{{ $companytag->id }}">
                                                <label class="form-check-label" for="companytag_{{ $companytag->id }}">
                                                    {{ $companytag->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Industry</label>
                                    <div class="checkbox-group">
                                        @foreach ($industries as $industry)
                                            <div class="form-check">
                                                <input type="checkbox" name="industry_filter_id[]"
                                                    value="{{ $industry->id }}" class="form-check-input"
                                                    id="industry_{{ $industry->id }}">
                                                <label class="form-check-label" for="industry_{{ $industry->id }}">
                                                    {{ $industry->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Territory</label>
                                    <div class="checkbox-group">
                                        @foreach ($territories as $territory)
                                            <div class="form-check">
                                                <input type="checkbox" name="territory_filter_id[]"
                                                    value="{{ $territory->id }}" class="form-check-input"
                                                    id="territory_{{ $territory->id }}">
                                                <label class="form-check-label" for="territory_{{ $territory->id }}">
                                                    {{ $territory->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Leads Status</label>
                                    <div class="checkbox-group">
                                        @php
                                            $lead_statuses = ['won', 'pending', 'open', 'lost', 'cancelled'];
                                        @endphp
                                        @foreach ($lead_statuses as $status)
                                            <div class="form-check">
                                                <input type="checkbox" name="leads_status[]" value="{{ $status }}"
                                                    class="form-check-input" id="leadstatus_{{ $status }}">
                                                <label class="form-check-label" for="leadstatus_{{ $status }}">
                                                    {{ ucfirst($status) }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Activity Types</label>
                                    <div class="checkbox-group">
                                        @foreach ($activity_types as $activity_type)
                                            <div class="form-check">
                                                <input type="checkbox" name="activity_type_filter_id[]"
                                                    value="{{ $activity_type->id }}" class="form-check-input"
                                                    id="activitytype_{{ $activity_type->id }}">
                                                <label class="form-check-label"
                                                    for="activitytype_{{ $activity_type->id }}">
                                                    {{ $activity_type->type }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>

            @include('admin.company.partials.add-company-modal')

        @endsection
        @push('scripts')
            <script>
                function addFilter() {
                    $('#AddFilter').modal('show');
                }

                function updateFilterCount() {
                    let count = $('#filter-section input[type="checkbox"]:checked').length;

                    if (count > 0) {
                        $('#filterCount').text(count).removeClass('d-none');
                    } else {
                        $('#filterCount').addClass('d-none');
                    }
                }


                $(document).ready(function() {
                    function fetchCompanies() {
                        let search = $('#company-search').val();
                        let company_type_id = $('select[name="company_type_id"]').val();
                        let assignee_id = $('select[name="assignee_id"]').val();
                        let people_id = $('select[name="people_id"]').val();

                        // collect checkbox values
                        let company_tags_filter_id = [];
                        $('input[name="company_tags_filter_id[]"]:checked').each(function() {
                            company_tags_filter_id.push($(this).val());
                        });

                        let industry_filter_id = [];
                        $('input[name="industry_filter_id[]"]:checked').each(function() {
                            industry_filter_id.push($(this).val());
                        });

                        let territory_filter_id = [];
                        $('input[name="territory_filter_id[]"]:checked').each(function() {
                            territory_filter_id.push($(this).val());
                        });

                        let leads_status = [];
                        $('input[name="leads_status[]"]:checked').each(function() {
                            leads_status.push($(this).val());
                        });

                        let activity_type_filter_id = [];
                        $('input[name="activity_type_filter_id[]"]:checked').each(function() {
                            activity_type_filter_id.push($(this).val());
                        });

                        $.ajax({
                            url: "{{ route('admin.company.index') }}",
                            method: "GET",
                            data: {
                                search: search,
                                company_type_id: company_type_id,
                                assignee_id: assignee_id,
                                people_id: people_id,
                                company_tags_filter_id: company_tags_filter_id,
                                industry_filter_id: industry_filter_id,
                                territory_filter_id: territory_filter_id,
                                leads_status: leads_status,
                                activity_type_filter_id: activity_type_filter_id,
                            },
                            beforeSend: function() {
                                AppLoader.show();
                            },
                            success: function(response) {
                                $('table tbody').html(response.table);
                                $('.company-count').text(response.count + ' Company Found');
                                $('#company-pagination').html(response.pagination);
                            },
                            error: function() {
                                console.error('Error fetching company data');
                            },
                            complete: function() {
                                AppLoader.hide();
                            }
                        });
                    }

                    // Trigger AJAX on typing or filter change
                    $('#company-search').on('input', function () {
                        fetchCompanies();
                    });
                    $('select[name="company_type_id"], select[name="assignee_id"], select[name="people_id"]').on('change',
                        fetchCompanies);
                    // catch all checkbox changes
                    // $('#filter-section input[type="checkbox"]').on('change', fetchCompanies);
                    $('#filter-section input[type="checkbox"]').on('change', function() {
                        fetchCompanies();
                        updateFilterCount();
                    });

                    // ==============================
                    // Lead & Activities Form - Select2 Integration
                    // ==============================





                    $(document).on('click', '.btn-delete', function() {
                        let selectedCompanies = $('.row-checkbox:checked').map(function() {
                            return $(this).data('id');
                        }).get();

                        Swal.fire({
                            title: "Are you sure?",
                            text: "This action will permanently delete the selected company.",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#d33",
                            cancelButtonColor: "#3085d6",
                            confirmButtonText: "Yes, delete",
                            cancelButtonText: "Cancel"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: "{{ route('admin.company.delete') }}",
                                    type: "POST",
                                    data: {
                                        _token: "{{ csrf_token() }}",
                                        ids: selectedCompanies
                                    },
                                    success: function(response) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Deleted!',
                                            text: response.message ||
                                                'Company deleted successfully.',
                                            showConfirmButton: false,
                                            timer: 2000
                                        });
                                        setTimeout(() => location.reload(), 2000);
                                    },
                                    error: function(xhr) {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error!',
                                            text: xhr.responseJSON?.message ||
                                                'Something went wrong while deleting.',
                                        });
                                    }
                                });
                            }
                        });
                    });


                });
            </script>

            @include('admin.company.partials.add-company-scripts')
        @endpush


