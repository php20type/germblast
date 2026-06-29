@extends('admin.includes.layout')

@section('title', 'Peoples')

@section('content')


    <main class="app-wrapper">


        <!-- All Companies Section start  -->
        <div class="companies-section my-4">
            <div class="container-fluid">
                <div class="row">
                    <!-- Sidebar -->
                    @include('admin.peoples.sidebar')

                    <!-- Main Content -->
                    <div class="col-md-10 p-0">
                        <div class="main-content">
                            <!-- Header -->
                            <div class="heading-area-sec">
                                <div class="left-part-sec">
                                    <h3 class="mb-1">All people <span style="font-size: 24px;">📌</span></h3>
                                    <p class="text-muted mb-0">Contacts (or the individuals) you do business with
                                    </p>
                                </div>
                                <div class="d-none right-part">
                                    <button class="btn btn-email">Email</button>
                                    <button class="btn btn-export">EXPORT</button>
                                </div>
                            </div>

                            <!-- Tabs Content -->
                            <div class="tab-content" id="viewTabsContent">
                                <!-- LIST Tab Content -->
                                <div class="tab-pane fade show active" id="list-content" role="tabpanel"
                                    aria-labelledby="list-tab">
                                    <!-- Filter Section -->
                                    <div class="filter-section mt-3">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center position-relative">
                                                    <div class="search-form">
                                                        <input type="search" class="form-control" placeholder=""
                                                            aria-label="Search" id="people-search">
                                                    </div>
                                                    <span class="company-count">{{ $peoplesCount }} People Found</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center justify-content-end dropdown">
                                                    <div class="me-2">
                                                        <select class="form-select" aria-label="Default select example"
                                                            name="company_id">
                                                            <option value="">Company</option>
                                                            @foreach ($companies as $company)
                                                                <option value="{{ $company->id }}">{{ $company->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="me-2">
                                                            <select class="form-select" aria-label="Default select example"
                                                            name="assignee_id">
                                                            <option value="">Assingee</option>
                                                            @foreach ($users as $user)
                                                                @if($user->isSalesRepresentative())
                                                                    <option value="{{ $user->id }}">{{ $user->name }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <button class="btn btn-primary me-2 position-relative"
                                                        onclick="addFilter()">
                                                        <img src="{{ asset('img/icons/filter.svg') }}" alt="" />

                                                        <!-- Filter Count Badge -->
                                                        <span id="filterCount"
                                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger d-none">
                                                            0
                                                        </span>
                                                    </button>

                                                    <button class="d-none btn btn-primary"><img
                                                            src="{{ asset('img/icons/bar.svg') }}" alt=""></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Table Section -->
                                    <div class="table-responsive">
                                        <div class="table-container mt-3 px-3">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th class="checkbox-cell">
                                                            <input type="checkbox" class="form-check-input" id="selectAll">
                                                        </th>
                                                        <th>People name</th>
                                                        <th>Last contact</th>
                                                        <th>Email</th>
                                                        <th>Phone</th>
                                                        <th>Address</th>
                                                        <th>Tags</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($peoples as $people)
                                                        <tr>
                                                            <td>
                                                                <input type="checkbox" class="form-check-input row-checkbox"
                                                                    data-id="{{ $people->id }}">
                                                            </td>
                                                            <td>
                                                                <div class="person-name">
                                                                    @can('people.detail.view')
                                                                        <a href="{{ route('admin.people.show', $people->id) }}"
                                                                            class="text-decoration-none text-dark">
                                                                            {{ $people->name ?? 'N/A' }}
                                                                        </a>
                                                                    @else
                                                                        <span class="text-dark">
                                                                            {{ $people->name ?? 'N/A' }}
                                                                        </span>
                                                                    @endcan
                                                                </div>
                                                                <div class="company-name">
                                                                    {{ $people->companiesAlt->first()?->name ?? 'N/A' }}
                                                                </div>
                                                                @if(!empty($people->contact_types))
                                                                    <div class="contact-types-list mt-1 d-flex flex-wrap gap-1">
                                                                        @foreach($people->contact_types as $type)
                                                                            <span class="badge bg-light text-dark border px-1 py-0.5" style="font-size: 0.65rem; font-weight: 500; text-transform: uppercase; border-radius: 3px;">
                                                                                {{ $type }}
                                                                            </span>
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                {{ \Carbon\Carbon::parse($people->created_at)->format('j F Y') }}
                                                            </td>
                                                            <td>
                                                                {{ $people->peopleEmail->email ?? 'N/A' }}
                                                            </td>
                                                            <td>
                                                                {{ $people->peoplePhone->phone ?? 'N/A' }}
                                                            </td>
                                                            <td>
                                                                {{ $people->peopleAddress->address ?? 'N/A' }}
                                                            </td>
                                                            <td>
                                                                @if ($people->tags->isNotEmpty())
                                                                    @foreach ($people->tags as $tag)
                                                                        <span
                                                                            class="badge-customer">{{ $tag->name }}</span>
                                                                    @endforeach
                                                                @else
                                                                    <span>N/A</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="7" class="text-center">No People found</td>
                                                        </tr>
                                                    @endforelse


                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Pagination -->
                                    <div class="row">
                                        <div id="people-pagination" class="col-12 mt-3">
                                            {{ $peoples->links() }}
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <!-- Action Bar -->
                            <div class="action-bar" id="actionBar">
                                <div class="d-flex align-items-center justify-content-center">
                                    <span class="me-3"><strong id="selectedCount">1</strong> Selected</span>

                                    {{-- @can('lead.create')
                                        <button class="btn btn-edit btn-action" onclick="addLead()">
                                            CREATE LEAD
                                        </button>
                                    @endcan --}}

                                    @can('people.delete')
                                        <button class="btn btn-delete btn-action">
                                            DELETE
                                        </button>
                                    @endcan

                                </div>
                            </div>

                        </div>

                    </div>
                </div>

                <!-- All Companies Section End  -->

    </main>


    <!-- Add Lead Modal Start -->
    <div class="modal fade" id="AddLead" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="exampleModalLabel">Add a lead</h1>
                    <div>
                        <a href="#" class="link-decoration">Customize fields</a>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                </div>
                <div class="modal-body">

                    {{-- <form class="company-form" id="add-lead-form"> --}}
                    <form action="{{ route('admin.lead.store') }}" class="company-form" id="add-lead-form" method="POST">
                        @csrf


                        <div class="row mx-0">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Lead name</label>
                                    @error('name')
                                        <span class="text-danger">* {{ $message }}</span>
                                    @enderror
                                    <input type="text" name="name" placeholder="Lead Name" class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Assignee</label>
                                    @error('assignee_id')
                                        <span class="text-danger">* {{ $message }}</span>
                                    @enderror
                                    <select name="assignee_id" class="form-select">
                                        <option value="">Choose...</option>
                                        @foreach ($users as $user)
                                            @if($user->isSalesRepresentative())
                                                <option value="{{ $user->id }}">
                                                    {{ $user->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Anticipated closed date</label>
                                    @error('close_date')
                                        <span class="text-danger">* {{ $message }}</span>
                                    @enderror
                                    <input type="text" name="close_date" placeholder="04-Apr-2004"
                                        pattern="\d{2}-[A-Za-z]{3}-\d{4}" class="form-control" />
                                </div>
                            </div>

                            <!-- Product Row Container -->
                            <div id="productRowContainer" class="mt-3">
                                <div class="row product-row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label">Products</label>
                                            <select class="form-select mt-2" name="product_id[]">
                                                <option value="">Choose...</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label">Qty :</label>
                                            <input type="number" name="quantity[]" placeholder="Add quantity"
                                                class="form-control" />
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group d-flex justify-content-between align-items-end">
                                            <div style="width: 100%">
                                                <label class="form-label fw-light">U.S(USD)</label>
                                                <input type="number" name="price[]" step="0.01"
                                                    placeholder="Add price" class="form-control" />
                                            </div>
                                            <button type="button"
                                                class="btn btn-danger btn-sm ms-2 remove-product-row">X</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Add New Product Button -->
                            <button type="button" id="addProductRow"
                                class="btn btn-sm btn-link text-primary text-start">
                                + Add New Product
                            </button>

                            <div class="col-lg-12 mt-2">
                                <div class="form-group">
                                    <label class="form-label">Confidence</label>
                                    @error('confidence')
                                        <span class="text-danger">* {{ $message }}</span>
                                    @enderror
                                    <input type="number" name="confidence" placeholder="Confidence %"
                                        class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Companies</label>
                                    @error('company_id')
                                        <span class="text-danger">* {{ $message }}</span>
                                    @enderror
                                    <select name="company_id[]" id="companySelect" class="form-select" multiple>
                                        <option value="">Choose Company</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}">
                                                {{ $company->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Select Person</label>
                                    @error('person_id')
                                        <span class="text-danger">* {{ $message }}</span>
                                    @enderror
                                    <select id="person_select" name="person_id[]" class="form-select" multiple>
                                        <option value="">-- Select Person --</option>
                                        @foreach ($allPeoples as $people)
                                            <option value="{{ $people->id }}">
                                                {{ $people->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">Sources</label>
                                    @error('source_id')
                                        <span class="text-danger">* {{ $message }}</span>
                                    @enderror
                                    <select id="source_select" name="source_id[]" class="form-select mt-2" multiple>
                                        <option value="">Choose...</option>
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
                                    @error('competitors_id')
                                        <span class="text-danger">* {{ $message }}</span>
                                    @enderror
                                    <select id="competitor_select" name="competitors_id[]" class="form-select mt-2"
                                        multiple>
                                        <option value="">Choose...</option>
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
                                    <select name="tag_id" class="form-select">
                                        <option value="">Select tag</option>
                                        @foreach ($peopletags as $peopletag)
                                            <option value="{{ $peopletag->id }}">{{ $peopletag->name }}
                                            </option>
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
                                <label class="form-label">People Tags</label>
                                <div class="checkbox-group">
                                    @foreach ($peopletags as $peopletag)
                                        <div class="form-check">
                                            <input type="checkbox" name="people_tags_filter_id[]"
                                                value="{{ $peopletag->id }}" class="form-check-input"
                                                id="peopletag_{{ $peopletag->id }}">
                                            <label class="form-check-label" for="peopletag_{{ $peopletag->id }}">
                                                {{ $peopletag->name }}
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

    @endsection
    @push('scripts')
        <script>
            function addFilter() {
                $('#AddFilter').modal('show');
            }

            // ==============================
            // Modal Show for leads
            // ==============================
            function addLead() {
                // Collect all checked company IDs
                let selectedPersons = [];
                $('.row-checkbox:checked').each(function() {
                    selectedPersons.push($(this).data('id'));
                });

                // Preselect these companies in the modal dropdown
                $('#person_select').val(selectedPersons).trigger('change');

                // Show the modal
                $('#AddLead').modal('show');
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
                function fetchPeoples() {
                    let search = $('#people-search').val();
                    let assignee_id = $('select[name="assignee_id"]').val();
                    let company_id = $('select[name="company_id"]').val();

                    // collect checkbox values
                    let people_tags_filter_id = [];
                    $('input[name="people_tags_filter_id[]"]:checked').each(function() {
                        people_tags_filter_id.push($(this).val());
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
                        url: "{{ route('admin.people.index') }}",
                        method: "GET",
                        data: {
                            search: search,
                            assignee_id: assignee_id,
                            company_id: company_id,
                            people_tags_filter_id: people_tags_filter_id,
                            territory_filter_id: territory_filter_id,
                            leads_status: leads_status,
                            activity_type_filter_id: activity_type_filter_id,
                        },
                        success: function(response) {
                            $('table tbody').html(response.table);
                            $('.company-count').text(response.count + ' People Found');
                            $('#people-pagination').html(response.pagination);
                        },
                        error: function(err) {
                            console.error('Error fetching people data', err);
                        }
                    });
                }

                $('#people-search').on('input', function () {
                    fetchPeoples();
                });
                $('#checkDefault,select[name="assignee_id"], select[name="company_id"]').on(
                    'change',
                    fetchPeoples);
                // catch all checkbox changes
                // $('#filter-section input[type="checkbox"]').on('change', fetchPeoples);
                $('#filter-section input[type="checkbox"]').on('change', function() {
                    fetchPeoples();
                    updateFilterCount();
                });



                // ==============================
                // Lead & Activities Form - Select2 Integration
                // ==============================
                $('#AddLead').on('shown.bs.modal', function() {
                    $('#companySelect').select2({
                        dropdownParent: $('#AddLead'),
                        placeholder: '-- Select a company --',
                        allowClear: true,
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

                // ==============================
                // Product row add and remove logic in add lead form
                // ==============================
                $('#addProductRow').click(function() {
                    var row = $('.product-row:first').clone(); // Clone the first row
                    row.find('input').val(''); // Clear inputs
                    row.find('select').val(''); // Clear dropdown
                    $('#productRowContainer').append(row); // Append to container
                });

                $(document).on('click', '.remove-product-row', function() {
                    if ($('.product-row').length > 1) {
                        $(this).closest('.product-row').remove();
                    } else {
                        toastr.warning('At least one product row is required.');
                    }
                });

                // ==============================
                // Add lead form validation and submittion
                // ==============================
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
                        "company_id[]": {
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
                        "company_id[]": {
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

                $('#add-lead-form').submit(function(e) {
                    e.preventDefault();

                    if (!$('#add-lead-form').valid()) {
                        return; // Stop if validation fails
                    }

                    $.ajax({
                        url: '{{ route('admin.lead.store') }}',
                        method: 'POST',
                        data: $(this).serialize(),

                        success: function(response) {
                            toastr.success('Lead created successfully!');
                            $('#add-lead-form')[0].reset();
                            $('#AddLead').modal('hide');

                        },
                        error: function(xhr) {
                            alert(xhr.responseText);
                            toastr.error('Something went wrong while creating the lead.');
                        }
                    });
                });

                $(document).on('click', '.btn-delete', function() {
                    let selectedPeoples = $('.row-checkbox:checked').map(function() {
                        return $(this).data('id');
                    }).get();

                    Swal.fire({
                        title: "Are you sure?",
                        text: "This action will permanently delete the selected people.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Yes, delete",
                        cancelButtonText: "Cancel"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{ route('admin.people.delete') }}",
                                type: "POST",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    ids: selectedPeoples
                                },
                                success: function(response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: response.message ||
                                            'People deleted successfully.',
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
    @endpush
