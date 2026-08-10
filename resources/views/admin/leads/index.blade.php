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
                                    <p class="text-muted mb-0">All business deals with your companies and people</p>
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
                            <div class="row m-3">
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
    @include('admin.leads.partials.add-lead-modal')


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
                    beforeSend: function() {
                        AppLoader.show();
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
                    },
                    complete: function() {
                        AppLoader.hide();
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

    @include('admin.leads.partials.add-lead-scripts')

    
@endpush

