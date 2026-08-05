@extends('admin.includes.layout')

@section('title', 'Leads')

@section('content')

    <main class="app-wrapper">
        <!-- All Companies Section start  -->
        <div class="companies-section my-4">
            <div class="container-fluid">
                <div class="row">
                    <!-- Sidebar -->
                    @include('admin.leads.sidebar')

                    <!-- Main Content -->
                    <div class="col-md-10 p-0">
                        <div class="main-content">
                            <!-- Header -->
                            <div class="heading-area-sec">
                                <div class="left-part-sec">
                                    <h3 class="mb-1">ALL LEADS <span style="font-size: 24px;">📌</span></h3>
                                    <p class="text-muted mb-0">Business deals with your companies and people</p>
                                </div>
                                <!-- <div class="d-none right-part">
                                    <button class="btn btn-email">Email</button>
                                    <button class="btn btn-export">EXPORT</button>
                                </div> -->
                                @can('lead.create')
                                <div class="right-part">
                                    <button class="btn btn-export" data-bs-toggle="modal" data-bs-target="#AddLead">
                                        <i class="fa-solid fa-plus"></i> 
                                        Add Lead
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
                                                <input type="search" class="form-control" placeholder=""
                                                    aria-label="Search" id="lead-search">
                                            </div>
                                            <span class="company-count">{{ $formattedTotalLeads }} Lead Found</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="d-flex align-items-center justify-content-end dropdown">
                                            <div class="me-2 form-check">
                                                <input class="form-check-input" type="checkbox" value="hot"
                                                    id="checkDefault" name="hot">
                                                <label class="form-check-label text-nowrap" for="checkDefault">Only Hot</label>
                                            </div>
                                            <div class="me-2">
                                                <select class="form-select" name="status" aria-label="Status select">
                                                    <option value="">Status</option>
                                                    <option value="open">Open</option>
                                                    <option value="lost">Lost</option>
                                                    <option value="won">Won</option>
                                                    <option value="cancelled">Cancelled</option>
                                                    <option value="pending">Pending</option>
                                                </select>
                                            </div>
                                            <div class="me-2">
                                                <select class="form-select" name="assignee_id" aria-label="Assigned to select">
                                                    <option value="">Assignee</option>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }}
                                                            </option>
                                                    @endforeach
                                                </select>
                                            </div>


                                            <button class="btn btn-primary me-2 position-relative" onclick="addFilter()">
                                                <img src="{{ asset('img/icons/filter.svg') }}" alt="" />

                                                <!-- Active Filter Count -->
                                                <span id="filterCount"
                                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger d-none">
                                                    0
                                                </span>
                                            </button>

                                            <button class="d-none btn btn-primary"><img
                                                    src="{{ asset('img/icons/bar.svg') }}" alt="" /></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="filter-value">
                                <div class="row">
                                    <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
                                        <div class="filter-card">
                                            <h5 id="total-value" class="text-nowrap">Total value: <span>${{ $formattedTotalValue }}</span></h5>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
                                        <div class="filter-card">
                                            <h5 id="avg-value" class="text-nowrap">Avg value: <span>${{ $formattedAvgValue }}</span></h5>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
                                        <div class="filter-card">
                                            <h5 class="text-nowrap">Avg time open: <span>16 Days</span></h5>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
                                        <div class="filter-card">
                                            <h5 id="confidence-value" class="text-nowrap">Win rate: <span>{{ $avgConfidence }}%</span></h5>
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
                                                <th class="checkbox-cell">
                                                    <input type="checkbox" class="form-check-input" id="selectAll">
                                                </th>
                                                <th>Lead name</th>
                                                <th>Age</th>
                                                <th>Value</th>
                                                <th>Assignee</th>
                                                <th>Stage</th>
                                                <th>Confidence</th>
                                                <th>Close date</th>
                                                <th>Sources</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($groupedLeads as $lead)
                                                <tr>
                                                    <td><input type="checkbox" class="form-check-input row-checkbox"
                                                            data-id="{{ $lead['id'] }}"></td>

                                                    <td>
                                                        <div class="company-name">

                                                            @can('lead.detail.view')
                                                                <a href="{{ route('admin.lead.show', $lead['id']) }}"
                                                                class="text-decoration-none text-dark">
                                                                    {{ $lead['name'] }}
                                                                </a>
                                                            @else
                                                                <span class="text-dark">
                                                                    {{ $lead['name'] }}
                                                                </span>
                                                            @endcan

                                                        </div>
                                                        <div class="company-name">{{ $lead['company_name'] }}</div>
                                                    </td>

                                                    <td>{{ $lead['created_at'] }}</td>
                                                    <td>${{ number_format($lead['total_price'], 2) }}</td>
                                                    <td>{{ $lead['assignee'] }}</td>
                                                    <td>{{ $lead['stage_name'] }}</td>
                                                    <td>{{ $lead['confidence'] }}%</td>
                                                    <td>{{ $lead['close_date'] }}</td>
                                                    <td>{{ $lead['sources'] }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="9" class="text-center">No leads found</td>
                                                </tr>
                                            @endforelse

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Pagination -->
                            <div class="row">
                                <div id="lead-pagination" class="col-12 mt-3">
                                    {{ $paginator->links() }}
                                </div>
                            </div>

                            <!-- Action Bar -->
                            <div class="action-bar" id="actionBar">
                                <div class="d-flex align-items-center justify-content-center">
                                    <span class="me-3"><strong id="selectedCount">1</strong> Selected</span>

                                    @can('lead.delete')
                                        <button class="btn btn-delete btn-action">
                                            DELETE
                                        </button>
                                    @endcan

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <!-- Extended Filters Modal Start -->
    <div class="modal fade" id="AddFilter" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="exampleModalLabel">Extended Filters</h1>
                    <div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                </div>
                <div class="modal-body">


                    <div class="row mx-0" id="filter-section">

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Open Date</label>
                                <div class="checkbox-group">
                                    <!-- Month-to-Date Checkbox -->
                                    <div class="form-check">
                                        <input type="checkbox" name="month_to_date" id="month_to_date"
                                            class="form-check-input">
                                        <label class="form-check-label" for="month_to_date">Month-to-Date</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Lead Tags</label>
                                <div class="checkbox-group">
                                    @foreach ($leadtags as $leadtag)
                                        <div class="form-check">
                                            <input type="checkbox" name="lead_tags_filter_id[]"
                                                value="{{ $leadtag->id }}" class="form-check-input"
                                                id="leadtag_{{ $leadtag->id }}">
                                            <label class="form-check-label" for="leadtag_{{ $leadtag->id }}">
                                                {{ $leadtag->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Lead Stage</label>
                                <div class="checkbox-group">
                                    @foreach ($lead_stages as $lead_stage)
                                        <div class="form-check">
                                            <input type="checkbox" name="lead_stage_filter_id[]"
                                                value="{{ $lead_stage->id }}" class="form-check-input"
                                                id="lead_stage_{{ $lead_stage->id }}">
                                            <label class="form-check-label" for="lead_stage_{{ $lead_stage->id }}">
                                                {{ $lead_stage->name }}
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
                                            <label class="form-check-label" for="activitytype_{{ $activity_type->id }}">
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

    <!-- Add Lead Modal Start -->
    <div class="modal fade" id="AddLead" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="exampleModalLabel">Add a lead</h1>
                    <div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                </div>
                <div class="modal-body">

                    {{-- <form class="company-form" id="add-lead-form"> --}}
                    <form action="{{ route('admin.lead.store') }}" class="company-form" id="add-lead-form"
                        method="POST">
                        @csrf

                        <div class="row mx-0">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Lead name</label>
                                    <span class="text-danger">*</span>
                                    @error('name')
                                        {{ $message }}
                                    @enderror
                                    <input type="text" name="name" placeholder="Lead name" class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Assignee</label>
                                    <span class="text-danger">*</span>
                                    @error('assignee_id')
                                        {{ $message }}
                                    @enderror
                                    <select name="assignee_id" class="form-select">
                                        <option value="">Select assignee</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">
                                                    {{ $user->name }}
                                                </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Anticipated close date</label>
                                    <span class="text-danger">*</span>
                                    @error('close_date')
                                        {{ $message }}
                                    @enderror
                                    <input type="text" name="close_date" placeholder="04-Apr-2004"
                                        class="form-control" />
                                </div>
                            </div>

                            <!-- Product Section -->
                            <div class="mt-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <label class="form-label fw-semibold mb-0">Products</label>
                                        <span class="text-danger">*</span>
                                    </div>
                                    <button type="button" id="addProductRow" class="btn btn-sm btn-link text-primary p-0" style="font-size: 13px;">
                                        <i class="fas fa-plus me-1"></i> Add New Product
                                    </button>
                                </div>
                                <div id="productRowContainer">
                                    <div class="product-row mb-2" style="border: 1px solid #dee2e6; border-radius: 8px; padding: 12px; background: #f9fafb;">
                                        <div class="row g-2 align-items-end">
                                            <div class="col-12">
                                                <label class="form-label small text-muted mb-1">Name</label>
                                                <select class="form-select" name="product_id[]">
                                                    <option value="">Select product...</option>
                                                    @foreach ($products as $product)
                                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label small text-muted mb-1">Qty</label>
                                                <input type="number" name="quantity[]" placeholder="Quantity" class="form-control" />
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex align-items-end gap-2">
                                                    <div class="flex-grow-1">
                                                        <label class="form-label small text-muted mb-1">Price <span class="fw-light">(USD)</span></label>
                                                        <input type="number" name="price[]" step="0.01" placeholder="Price" class="form-control" />
                                                    </div>
                                                    <button type="button" class="btn btn-outline-danger btn-sm remove-product-row" style="height:38px; padding: 0 10px;">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 mt-2">
                                <div class="form-group">
                                    <label class="form-label">Confidence</label>
                                    <span class="text-danger">*</span>
                                    @error('confidence')
                                        {{ $message }}
                                    @enderror
                                    <input type="number" name="confidence" placeholder="Confidence %"
                                        class="form-control" />
                                </div>
                            </div>
                            {{-- <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Companies</label>
                                    <span class="text-danger">*</span>
                                    @error('company_id')
                                        {{ $message }}
                                    @enderror
                                    <select name="company_id[]" id="companySelect" class="form-select select2" multiple>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Companies</label>
                                    <span class="text-danger">*</span>
                                    @error('company_id')
                                        {{ $message }}
                                    @enderror
                                    <select name="company_id" id="companySelect" class="form-select select2">
                                        <option value=""></option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Select Person</label>
                                    <span class="text-danger">*</span>
                                    @error('person_id')
                                        {{ $message }}
                                    @enderror
                                    <select id="person_select" name="person_id[]" class="form-select select2" multiple>
                                        @foreach ($peoples as $people)
                                            <option value="{{ $people->id }}">{{ $people->name }}
                                                ({{ $people->peopleEmail->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">Sources</label>
                                    <span class="text-danger">*</span>
                                    @error('source_id')
                                        {{ $message }}
                                    @enderror
                                    <select id="source_select" name="source_id[]" class="form-select mt-2 select2"
                                        multiple>
                                        @foreach ($sources as $source)
                                            <option value="{{ $source->id }}">
                                                {{ $source->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">Competitors</label>
                                    <span class="text-danger">*</span>
                                    @error('competitors_id')
                                        {{ $message }}
                                    @enderror
                                    <select id="competitor_select" name="competitors_id[]"
                                        class="form-select mt-2 select2" multiple>
                                        @foreach ($competitors as $competitor)
                                            <option value="{{ $competitor->id }}">
                                                {{ $competitor->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Tags</label>
                                    <span class="text-danger">*</span>
                                    <select name="tag_id" class="form-select">
                                        <option value="">Select tag</option>
                                        @foreach ($leadtags as $leadtag)
                                            <option value="{{ $leadtag->id }}">{{ $leadtag->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        {{-- div=row mx-0 closed --}}

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Create lead</button>
                        </div>
                    </form>
                    {{-- form closed --}}

                </div>
            </div>
        </div>
    </div>
    {{-- Lead modal end --}}


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

            // ==============================
            // Redirecting user from sales page to leads page with applied filters
            // ==============================
            const selectedStage = sessionStorage.getItem('selectedLeadStage');

            if (selectedStage) {
                $('#lead_stage_' + selectedStage).prop('checked', true);
                fetchLeads();
                updateFilterCount();
                sessionStorage.removeItem('selectedLeadStage'); // clear after use
            }

            const savedFilters = sessionStorage.getItem('lead_filters');
            if (savedFilters) {
                const filters = JSON.parse(savedFilters);

                // Apply "Month-to-Date" filter
                if (filters.month_to_date) {
                    $('#month_to_date').prop('checked', true);
                }

                // Apply "Open Leads" filter
                if (filters.leads_status && filters.leads_status.includes('open')) {
                    $('#leadstatus_open').prop('checked', true);
                }

                // Apply "Sales (Won)" filter
                if (filters.leads_status && filters.leads_status.includes('won')) {
                    $('#leadstatus_won').prop('checked', true);
                }

                // Fetch leads with filters applied
                fetchLeads();
                updateFilterCount();

                // Clear after applying once
                sessionStorage.removeItem('lead_filters');
            }

            // ==============================
            // End
            // ==============================


            function fetchLeads() {
                let search = $('#lead-search').val();
                let status = $('select[name="status"]').val();
                let assignee_id = $('select[name="assignee_id"]').val();
                let hot = $('#checkDefault').is(':checked') ? 'hot' : '';

                // collect checkbox values
                let lead_tags_filter_id = [];
                $('input[name="lead_tags_filter_id[]"]:checked').each(function() {
                    lead_tags_filter_id.push($(this).val());
                });

                let lead_stage_filter_id = [];
                $('input[name="lead_stage_filter_id[]"]:checked').each(function() {
                    lead_stage_filter_id.push($(this).val());
                });

                let leads_status = [];
                $('input[name="leads_status[]"]:checked').each(function() {
                    leads_status.push($(this).val());
                });

                let activity_type_filter_id = [];
                $('input[name="activity_type_filter_id[]"]:checked').each(function() {
                    activity_type_filter_id.push($(this).val());
                });

                // New open date filters
                let month_to_date = $('#month_to_date').is(':checked') ? 1 : 0;

                $.ajax({
                    url: "{{ route('admin.lead.index') }}",
                    method: "GET",
                    data: {
                        search: search,
                        status: status,
                        assignee_id: assignee_id,
                        hot: hot,
                        lead_tags_filter_id: lead_tags_filter_id,
                        lead_stage_filter_id: lead_stage_filter_id,
                        leads_status: leads_status,
                        activity_type_filter_id: activity_type_filter_id,
                        month_to_date: month_to_date,
                    },
                    success: function(response) {
                        $('table tbody').html(response.table);
                        $('.company-count').text(response.count + ' Lead Found');
                        $('#total-value span').text('$' + response.total_value);
                        $('#avg-value span').text('$' + response.avg_value);
                        $('#confidence-value span').text(response.avg_confidence + '%');
                        $('#lead-pagination').html(response.pagination);
                    },
                    error: function() {
                        console.error('Error fetching lead data');
                    }
                });
            }

            $('#lead-search').on('input', function () {
                fetchLeads();
            });
            $('#checkDefault, select[name="status"], select[name="assignee_id"]').on('change', fetchLeads);
            // catch all checkbox changes
            // $('#filter-section input[type="checkbox"]').on('change', fetchLeads);
            $('#filter-section input[type="checkbox"]').on('change', function() {
                fetchLeads();
                updateFilterCount();
            });



            $(document).on('click', '.btn-delete', function() {
                let selectedLeads = $('.row-checkbox:checked').map(function() {
                    return $(this).data('id');
                }).get();

                Swal.fire({
                    title: "Are you sure?",
                    text: "This action will permanently delete the selected lead.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete",
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('admin.lead.delete') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                ids: selectedLeads
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: response.message ||
                                        'Lead deleted successfully.',
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (new URLSearchParams(window.location.search).get('create') === '1') {
                $('#AddLead').modal('show');
            }

            flatpickr("#due_date", {
                enableTime: true,
                dateFormat: "Y-m-d h:i K", // h = 12-hour, K = AM/PM
                minDate: "today",
                defaultDate: new Date(new Date().setDate(new Date().getDate() + 1)).setHours(18, 30, 0, 0),
                time_24hr: false
            });

            //  Select2 script
            $('#AddLead').on('shown.bs.modal', function() {
                $('#companySelect').select2({
                    dropdownParent: $('#AddLead'),
                    placeholder: '-- Select a company --',
                    allowClear: true
                });
                $('#person_select').select2({
                    dropdownParent: $('#AddLead'),
                    placeholder: '-- Select a person --',
                    allowClear: true
                });
                $('#source_select').select2({
                    dropdownParent: $('#AddLead'),
                    placeholder: 'Choose...',
                    allowClear: true
                });
                $('#competitor_select').select2({
                    dropdownParent: $('#AddLead'),
                    placeholder: 'Choose...',
                    allowClear: true

                });
            });

        });


        $(document).ready(function() {

           
            // Product row logic
            $('#addProductRow').click(function() {
                var row = $('.product-row:first').clone(); // Clone the first row
                row.find('input').val(''); // Clear inputs
                row.find('select').val(''); // Clear dropdown
                $('#productRowContainer').append(row); // Append to container
            });

            // Remove a specific product row
            $(document).on('click', '.remove-product-row', function() {
                if ($('.product-row').length > 1) {
                    $(this).closest('.product-row').remove();
                } else {
                    alert('At least one product row is required.');
                }
            });

            $("#add-lead-form").validate({
                ignore: [],
                rules: {
                    name: {
                        required: true
                    },
                    assignee_id: {
                        required: true
                    },
                    close_date: {
                        required: true
                    },
                    "product_id[]": {
                        required: true
                    },
                    "quantity[]": {
                        required: true
                    },
                    "price[]": {
                        required: true
                    },
                    confidence: {
                        required: true
                    },
                    // "company_id[]": {
                    //     required: true
                    // },
                    "company_id": {
                        required: true
                    },
                    "person_id[]": {
                        required: true
                    },
                    "source_id[]": {
                        required: true
                    },
                    "competitors_id[]": {
                        required: true
                    },
                    tag_id: {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: "Please enter lead name."
                    },
                    assignee_id: {
                        required: "Please select an assignee."
                    },
                    close_date: {
                        required: "Please select a close date."
                    },
                    "product_id[]": {
                        required: "Please select a product."
                    },
                    "quantity[]": {
                        required: "Please enter the quantity."
                    },
                    "price[]": {
                        required: "Please enter the price."
                    },
                    confidence: {
                        required: "Please enter the confidence level."
                    },
                    // "company_id[]": {
                    //     required: "Please select a company."
                    // },
                    "company_id": {
                        required: "Please select a company."
                    },
                    "person_id[]": {
                        required: "Please select a person."
                    },
                    "source_id[]": {
                        required: "Please select a source."
                    },
                    "competitors_id[]": {
                        required: "Please select a competitor."
                    },
                    tag_id: {
                        required: "Please select the tag."
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


            // Submit Lead form
            $('#add-lead-form').submit(function(e) {
                e.preventDefault();

                const $form = $(this);
                const $submitBtn = $form.find('button[type="submit"]');

                if (!$form.valid()) return;

                $.ajax({
                    url: '{{ route('admin.lead.store') }}',
                    method: 'POST',
                    data: $form.serialize(),

                    beforeSend: function() {
                        $submitBtn.prop('disabled', true).text('Saving...');
                    },

                    success: function() {
                        toastr.success('Lead created successfully! Redirecting...');
                        $form[0].reset();

                        setTimeout(function() {
                            window.location.href = "{{ route('admin.lead.index') }}";
                        }, 1500);
                    },

                    error: function(xhr) {
                        alert(xhr.responseText);
                        toastr.error('Something went wrong while creating the lead.');
                        $submitBtn.prop('disabled', false).text('Submit');
                    }
                });
            });

        });

    </script>

    
@endpush
