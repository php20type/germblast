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
                                <!-- <div class="d-none right-part">
                                    <button class="btn btn-email">Email</button>
                                    <button class="btn btn-export">EXPORT</button>
                                </div> -->
                                @can('people.create')
                                <div class="right-part">
                                    <button class="btn btn-export" data-bs-toggle="modal" data-bs-target="#AddPerson">
                                        <i class="fa-solid fa-plus"></i> 
                                        Add People
                                    </button>
                                </div>
                                @endcan
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
                                                                <option value="{{ $user->id }}">{{ $user->name }}
                                                                    </option>
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
                                                                    {{ $people->companies->first()?->name ?? 'N/A' }}
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
                                            <option value="{{ $user->id }}">
                                                    {{ $user->name }}
                                                </option>
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
    </div>

     <!-- Add Person Modal Start -->
    <div class="modal fade" id="AddPerson" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="exampleModalLabel">Add a person</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST" class="company-form" id="add-person-form">
                        @csrf
                        <div class="row mx-0">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Person name</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="name" placeholder="Add person name"
                                        class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    <span class="text-danger">*</span>
                                    <input type="email" name="email" placeholder="email@example.com"
                                        class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Bio</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="bio" placeholder="Your bio...."
                                        class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Company</label>
                                    {{-- <span class="text-danger">*</span> --}}
                                    <select name="company_id" id="add_person_company_select" class="form-select select2">
                                        <option value="">Select company</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Phone Number</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="phone" placeholder="123-456-7890"
                                        class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Address Line 1</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="address_1" class="form-control" placeholder="Street address">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Address Line 2</label>
                                    <input type="text" name="address_2" class="form-control" placeholder="Suite, floor, unit (optional)">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Country</label>
                                    <span class="text-danger">*</span>
                                    <select name="country_id" class="form-select select2 country_select">
                                        <option value="">Select Country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}" {{ $country->id == 233 ? 'selected' : '' }}>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">State</label>
                                    <span class="text-danger">*</span>
                                    <select name="state_id" class="form-select select2 state_select">
                                        <option value="">Select State</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">City</label>
                                    <span class="text-danger">*</span>
                                    <select name="city_id" class="form-select select2 city_select">
                                        <option value="">Select City</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Zip Code</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="zip" class="form-control" placeholder="Postal / Zip code">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">URL</label>
                                    <input type="text" name="url" placeholder="https://..."
                                        class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Tags</label>
                                    <span class="text-danger">*</span>
                                    <select name="tag_id" class="form-select">
                                        <option value="">Select tag</option>
                                        @foreach ($persontags as $persontag)
                                            <option value="{{ $persontag->id }}">{{ $persontag->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Assignee</label>
                                    <span class="text-danger">*</span>
                                    <select name="assignee_id" class="form-select">
                                        <option value="">Select assignee</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Territory</label>
                                    <span class="text-danger">*</span>
                                    <select name="territory_id" class="form-select">
                                        <option value="">Select territory</option>
                                        @foreach ($territories as $territory)
                                            <option value="{{ $territory->id }}">{{ $territory->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label class="form-label"><b>Contact Type</b></label>
                                    <div class="d-flex gap-4 mt-1">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="contact_types[]" value="service" id="contact_type_service">
                                            <label class="form-check-label" for="contact_type_service">
                                                Service
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="contact_types[]" value="scheduling" id="contact_type_scheduling">
                                            <label class="form-check-label" for="contact_type_scheduling">
                                                Scheduling
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="contact_types[]" value="billing" id="contact_type_billing">
                                            <label class="form-check-label" for="contact_type_billing">
                                                Billing
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Person Modal End -->



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

         <script>
        document.addEventListener('DOMContentLoaded', function() {

            $('#AddPerson').on('shown.bs.modal', function() {
                $(this).find('.country_select').select2({
                    dropdownParent: $('#AddPerson'),
                    placeholder: 'Select Country',
                    allowClear: true
                });
                $(this).find('.state_select').select2({
                    dropdownParent: $('#AddPerson'),
                    placeholder: 'Select State',
                    allowClear: true
                });
                $(this).find('.city_select').select2({
                    dropdownParent: $('#AddPerson'),
                    placeholder: 'Select City',
                    allowClear: true
                });
                $('#add_person_company_select').select2({
                    dropdownParent: $('#AddPerson'),
                    placeholder: 'Select company',
                    allowClear: true
                });
                $(this).find('.country_select').trigger('change');
            });

        });


        $(document).ready(function() {

            // ========
            $("#add-person-form").validate({
                ignore: [],
                rules: {
                    name: {
                        required: true
                    },
                    email: {
                        required: true
                    },
                    bio: {
                        required: true
                    },
                    company_id: {
                        required: false
                    },
                    phone: {
                        required: true
                    },
                    address: {
                        required: true
                    },
                    url: {
                        required: false,
                        url: true
                    },
                    tag_id: {
                        required: true
                    },
                    assignee_id: {
                        required: true
                    },
                    territory_id: {
                        required: true
                    },
                },
                messages: {
                    name: {
                        required: "Please enter Company name."
                    },
                    email: {
                        required: "Please enter the email."
                    },
                    bio: {
                        required: "Please enter the bio."
                    },
                    // company_id: {
                    //     required: "Please select the company."
                    // },
                    phone: {
                        required: "Please enter the phone number."
                    },
                    address: {
                        required: "Please enter the address."
                    },
                    url: {
                        url: "The url field must be a valid URL."
                    },
                    tag_id: {
                        required: "Please select a tag."
                    },
                    assignee_id: {
                        required: "Please select an assignee."
                    },
                    territory_id: {
                        required: "Please select a territory."
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


            // Submit People form
            $('#add-person-form').submit(function(e) {
                e.preventDefault();

                const $form = $(this);
                const $submitBtn = $form.find('button[type="submit"]');

                if (!$form.valid()) return;

                $.ajax({
                    url: '{{ route('admin.people.store') }}',
                    method: 'POST',
                    data: $form.serialize(),

                    beforeSend: function() {
                        $submitBtn.prop('disabled', true).text('Saving...');
                    },

                    success: function() {
                        toastr.success('Person created successfully! Redirecting...');
                        $form[0].reset();

                        setTimeout(() => {
                            window.location.href = "{{ route('admin.people.index') }}";
                        }, 1500);
                    },

                    error: function(xhr) {
                        console.log(xhr.responseText);
                        toastr.error('Something went wrong while adding the person.');
                        $submitBtn.prop('disabled', false).text('Submit');
                    }
                });
            });

        // Address cascades for Add Location structures
        $('.country_select').on('change', function() {
            let countryId = $(this).val();
            let modal = $(this).closest('.modal');
            let stateSelect = modal.find('.state_select');
            let citySelect = modal.find('.city_select');

            stateSelect.empty().append('<option value="">Select State</option>').prop('disabled', true).trigger('change');
            citySelect.empty().append('<option value="">Select City</option>').prop('disabled', true).trigger('change');

            if (!countryId) return;
            $.get(`/states/` + countryId, function(states) {
                stateSelect.prop('disabled', false);
                $.each(states, function(i, state) {
                    stateSelect.append(`<option value="` + state.state_id + `">` + state.name + `</option>`);
                });
                if (countryId == 233) {
                    stateSelect.val('1407').trigger('change');
                }
            });
        });

        $('.state_select').on('change', function() {
            let stateId = $(this).val();
            let modal = $(this).closest('.modal');
            let citySelect = modal.find('.city_select');

            citySelect.empty().append('<option value="">Select City</option>').prop('disabled', true).trigger('change');
            if (!stateId) return;
            $.get(`/cities/` + stateId, function(cities) {
                citySelect.prop('disabled', false);
                $.each(cities, function(i, city) {
                    citySelect.append(`<option value="` + city.id + `">` + city.name + `</option>`);
                });
            });
        });
    });
    </script>
    @endpush
