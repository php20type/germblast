@extends('admin.includes.layout')

@section('title', 'Dashboard')

@section('content')

    <!-- dashboard card start  -->
    <div class="dashboard-card my-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="container-fluid">
            <div class="row">
                <!-- Top Row -->
                @can('company.create')
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 col-module">
                    <div class="card-module" data-bs-toggle="modal" data-bs-target="#AddCompany">
                        <div class="icon-wrapper icon-company">
                            <img src={{ asset('img/icons/dashboard-app1.png') }} alt="app icon" />
                            <h5 class="card-title">COMPANY</h5>
                        </div>
                        <p class="card-text">Organizations And Groups You May Do Business With</p>
                    </div>
                </div>
                @endcan

                @can('people.create')
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 col-module">
                    <div class="card-module" data-bs-toggle="modal" data-bs-target="#AddPerson">
                        <div class="icon-wrapper icon-person">
                            <img src={{ asset('img/icons/dashboard-app2.png') }} alt="app icon" />
                            <h5 class="card-title">PERSON</h5>
                        </div>
                        <p class="card-text">Individuals You Know Or May Do Business With</p>
                    </div>
                </div>
                @endcan

                @can('lead.create')
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 col-module">
                    <div class="card-module" data-bs-toggle="modal" data-bs-target="#AddLead">
                        <div class="icon-wrapper icon-lead">
                            <img src={{ asset('img/icons/dashboard-app3.png') }} alt="app icon" />
                            <h5 class="card-title">LEAD</h5>
                        </div>
                        <p class="card-text">A Deal Or Opportunity To Make A Sale</p>
                    </div>
                </div>
                @endcan

                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 col-module">
                    <div class="card-module" data-bs-toggle="modal" data-bs-target="#AddActivity">
                        <div class="icon-wrapper icon-activity">
                            <img src={{ asset('img/icons/dashboard-app4.png') }} alt="app icon" />
                            <h5 class="card-title">ACTIVITY</h5>
                        </div>
                        <p class="card-text">Phone Calls, Meetings, And Other Interactions</p>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 col-module">
                    <div class="card-module" data-bs-toggle="modal" data-bs-target="#AddTask">
                        <div class="icon-wrapper icon-task">
                            <img src={{ asset('img/icons/dashboard-app5.png') }} alt="app icon" />
                            <h5 class="card-title">TASK</h5>
                        </div>
                        <p class="card-text">Reminders And Other Things You Don't Want To Forget</p>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 col-module">
                    <div class="card-module">
                        <div class="icon-wrapper icon-form">
                            <img src={{ asset('img/icons/dashboard-app6.png') }} alt="app icon" />
                            <h5 class="card-title">FORM</h5>
                        </div>
                        <p class="card-text">Collect Leads Directly From Your Website</p>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 col-module">
                    <div class="card-module">
                        <div class="icon-wrapper icon-import">
                            <img src={{ asset('img/icons/dashboard-app7.png') }} alt="app icon" />
                            <h5 class="card-title">IMPORT</h5>
                        </div>
                        <p class="card-text">Transfer Your Existing Data Into Nutshell</p>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <!-- dashboard card End  -->
    <!-- Add Company Modal Start -->
    <div class="modal fade" id="AddCompany" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="exampleModalLabel">Add a company</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.company.store') }}" method="POST" class="company-form"
                        id="add-company-form">
                        @csrf
                        <div class="row mx-0">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Company name</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="name" placeholder="Name" class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Description</label>
                                    <span class="text-danger">*</span>
                                    <textarea name="description" rows="3"
                                        placeholder="Add some description about the company..." class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="email" placeholder="example@gmail.com"
                                        class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">Phone Number</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="phone" placeholder="123-456-7890"
                                        class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Location Name</label>
                                    <input type="text" name="location_name" class="form-control" placeholder="Eg. Head Office, Warehouse, Branch A">
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
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
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
                                    <label class="form-label">Person</label>
                                    {{-- <span class="text-danger">*</span> --}}
                                    <select name="people_id" class="form-select">
                                        <option value="">Select person</option>
                                        @foreach ($peoples as $people)
                                            <option value="{{ $people->id }}">{{ $people->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">URL</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="url" placeholder="https://" class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Tags</label>
                                    <span class="text-danger">*</span>
                                    <select name="tag_id" class="form-select">
                                        <option value="">Select tag</option>
                                        @foreach ($companytags as $companytag)
                                            <option value="{{ $companytag->id }}">{{ $companytag->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Company Type</label>
                                    <span class="text-danger">*</span>
                                    <select name="company_type_id" class="form-select">
                                        <option value="">Select company type</option>
                                        @foreach ($company_types as $company_type)
                                            <option value="{{ $company_type->id }}">{{ $company_type->type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Tax Rate</label>
                                    <select name="tax_rate" class="form-select">
                                        <option value="">Please Select</option>
                                        @foreach(config('mapping.tax_rates') as $value => $label)
                                            <option value="{{ $value }}">{{ $label }}</option>
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
                                            @if($user->isSalesRepresentative())
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Industry</label>
                                    <span class="text-danger">*</span>
                                    <select name="industry_id" class="form-select">
                                        <option value="">Select industry</option>
                                        @foreach ($industries as $industry)
                                            <option value="{{ $industry->id }}">{{ $industry->name }}</option>
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
    <!-- Add Company Modal End -->


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
                                    <select name="company_id" class="form-select">
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
                                    <label class="form-label">Location Name</label>
                                    <input type="text" name="location_name" class="form-control" placeholder="Eg. Head Office, Warehouse, Branch A">
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
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
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
                                            @if($user->isSalesRepresentative())
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endif
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
                                    <label class="form-label">Anticipated close date</label>
                                    <span class="text-danger">*</span>
                                    @error('close_date')
                                        {{ $message }}
                                    @enderror
                                    <input type="text" name="close_date" placeholder="04-Apr-2004"
                                        class="form-control" />
                                </div>
                            </div>

                            <!-- Product Row Container -->
                            <div id="productRowContainer" class="mt-3">
                                <div class="row product-row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">Product</label>
                                            <span class="text-danger">*</span>
                                            <select class="form-select mt-2" name="product_id[]">
                                                <option value="">Select product...</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Qty :</label>
                                            <span class="text-danger">*</span>
                                            <input type="number" name="quantity[]" placeholder="Add quantity"
                                                class="form-control" />
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group d-flex justify-content-between align-items-end">
                                            <div style="width: 100%">
                                                <label class="form-label">Price <span
                                                        class="fw-light">(USD)</span></label>
                                                <span class="text-danger">*</span>
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

    {{-- Activity modal start --}}
    <div class="modal fade" id="AddActivity" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="exampleModalLabel">Add an Activity</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form class="company-form" action="{{ route('admin.schedule.activity') }}" method="post"
                        data-owner-type="User" data-owner-id="{{ auth()->id() }}" data-status="Scheduled"
                        id="store_activity">
                        @csrf

                        <div class="row mx-0">

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Note</label>
                                    <span class="text-danger">*</span>
                                    <textarea id="schedule-note-textarea" name="note" class="form-control w-100"
                                        placeholder="Write a note… @Mention other users to grab their attention, or reference other companies and people."
                                        rows="6"></textarea>

                                    <!-- Hidden fields for mentioned entities -->
                                    <input type="hidden" name="mentioned_company_ids"
                                        id="schedule_mentioned_company_ids" value="">
                                    <input type="hidden" name="mentioned_people_ids" id="schedule_mentioned_people_ids"
                                        value="">
                                    <input type="hidden" name="mentioned_user_ids" id="schedule_mentioned_user_ids"
                                        value="">

                                    <!-- Hidden field to store processed note content -->
                                    <input type="hidden" name="schedule_note_value" id="schedule_note_value"
                                        value="">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Activity type</label>
                                    <span class="text-danger">*</span>
                                    <select class="form-select mt-2" name="activity_type_id">
                                        <option selected>Choose...</option>
                                        @foreach ($activity_types as $activity_type)
                                            <option value="{{ $activity_type->id }}">
                                                {{ $activity_type->type }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Date</label>
                                    <span class="text-danger">*</span>
                                    <input type="date" placeholder="" class="form-control" name="date" />
                                </div>
                            </div>

                            <div class="col-lg-6 mt-2">
                                <div class="form-group">
                                    <label class="form-label">Start Time</label>
                                    <span class="text-danger">*</span>
                                    <select class="form-select select2" id="start_time" name="start_time" required>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 mt-2">
                                <div class="form-group">
                                    <label class="form-label">End Time</label>
                                    <span class="text-danger">*</span>
                                    <select class="form-select select2" id="end_time" name="end_time" required>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12 mt-2">
                                <div class="form-check mb-4">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"
                                        name="all_day">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        All day
                                    </label>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mb-4">
                                    <label class="form-label">Location</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" placeholder="Add a Location" class="form-control"
                                        name="location" />
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mb-4">
                                    <label class="form-label">Participants</label>
                                    <span class="text-danger">*</span>
                                    <select id="participant_select" name="participant_id[]" class="form-select mt-2"
                                        multiple>
                                        {{-- Companies --}}
                                        <optgroup label="Companies">
                                            @foreach ($companies as $company)
                                                <option value="company:{{ $company->id }}" data-entity-type="company">
                                                    {{ $company->name }}
                                                </option>
                                            @endforeach
                                        </optgroup>

                                        {{-- Peoples --}}
                                        <optgroup label="Peoples">
                                            @foreach ($peoples as $people)
                                                <option value="people:{{ $people->id }}" data-entity-type="people">
                                                    {{ $people->name }}
                                                </option>
                                            @endforeach
                                        </optgroup>

                                        {{-- Users --}}
                                        <optgroup label="Users">
                                            @foreach ($users as $user)
                                                <option value="user:{{ $user->id }}" data-entity-type="user">
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <label class="form-label">Description</label>
                                <textarea rows="5" placeholder="Add an agenda to share with your attendees" class="form-control"
                                    name="agenda"></textarea>
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
    {{-- Activity modal end --}}

    <!-- Add Task Modal Start -->
    <div class="modal fade" id="AddTask" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="exampleModalLabel">Add a task</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST" class="company-form" id="add-task">
                        @csrf
                        <div class="row mx-0">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Name</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="name" placeholder="Enter task name"
                                        class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Due Date</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="due_date" placeholder="" class="form-control"
                                        id="due_date" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Assignee</label>
                                    <span class="text-danger">*</span>
                                    <select name="assignee_id" class="form-select">
                                        <option value="">Select a assingee</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Related to <span class="text-danger">*</span></label>

                                    <!-- Hidden field to store type dynamically -->
                                    <input type="hidden" id="related_type" name="related_type">

                                    <select id="related_to_select" name="related_to" class="form-select mt-2">
                                        {{-- Companies --}}
                                        <optgroup label="Companies">
                                            @foreach ($companies as $company)
                                                <option value="{{ $company->id }}" data-entity-type="company">
                                                    {{ $company->name }}
                                                </option>
                                            @endforeach
                                        </optgroup>

                                        {{-- Peoples --}}
                                        <optgroup label="Peoples">
                                            @foreach ($peoples as $people)
                                                <option value="{{ $people->id }}" data-entity-type="people">
                                                    {{ $people->name }}
                                                </option>
                                            @endforeach
                                        </optgroup>

                                        {{-- Leads --}}
                                        <optgroup label="Leads">
                                            @foreach ($leads as $lead)
                                                <option value="{{ $lead->id }}" data-entity-type="lead">
                                                    {{ $lead->name }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Notes</label>
                                    <span class="text-danger">*</span>
                                    <textarea name="notes" id="notes" class="form-control" placeholder="Enter task details"></textarea>
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
    <!-- Add Task Modal End -->

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

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

            $('#AddCompany').on('shown.bs.modal', function() {
                $(this).find('.country_select').select2({
                    dropdownParent: $('#AddCompany'),
                    placeholder: 'Select Country',
                    allowClear: true
                });
                $(this).find('.state_select').select2({
                    dropdownParent: $('#AddCompany'),
                    placeholder: 'Select State',
                    allowClear: true
                });
                $(this).find('.city_select').select2({
                    dropdownParent: $('#AddCompany'),
                    placeholder: 'Select City',
                    allowClear: true
                });
            });

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
            });

            $('#AddActivity').on('shown.bs.modal', function() {
                $('#participant_select').select2({
                    dropdownParent: $('#AddActivity'),
                    placeholder: 'Choose...',
                    allowClear: true
                });
            });

            $('#AddTask').on('shown.bs.modal', function() {
                $('#related_to_select').select2({
                    dropdownParent: $('#AddTask'),
                    placeholder: 'Choose...',
                    allowClear: true
                });
            });
        });


        $(document).ready(function() {

            // ==============================
            // Start time and end time display in schedule activity
            // ==============================
            const startTimeSelect = $('#store_activity select[name="start_time"]');
            const endTimeSelect = $('#store_activity select[name="end_time"]');
            const allDayCheckbox = $('#store_activity input[name="all_day"]');

            // --- Generate time options every X minutes ---
            function generateTimeOptions(interval = 15) {
                const times = [];
                let time = moment().startOf('day');
                const end = moment(time).endOf('day').add(1, 'minute'); // include 24:00

                while (time.isBefore(end)) {
                    // value in HH:mm:ss, display in hh:mm A
                    times.push({
                        value: time.format('HH:mm:ss'),
                        display: time.format('hh:mm A')
                    });
                    time.add(interval, 'minutes');
                }
                return times;
            }

            // --- Populate dropdowns ---
            function populateDropdowns() {
                const times = generateTimeOptions(15);

                startTimeSelect.empty().append('<option value="">Select Start Time</option>');
                endTimeSelect.empty().append('<option value="">Select End Time</option>');

                times.forEach(t => {
                    startTimeSelect.append(`<option value="${t.value}">${t.display}</option>`);
                    endTimeSelect.append(`<option value="${t.value}">${t.display}</option>`);
                });

                updateEndTimeOptions();
            }

            // --- Disable end times <= selected start time ---
            function updateEndTimeOptions() {
                const selectedStart = startTimeSelect.val();
                if (!selectedStart) {
                    endTimeSelect.find('option').prop('disabled', false).removeClass('text-secondary');
                    return;
                }

                const startMoment = moment(selectedStart, 'HH:mm:ss');
                endTimeSelect.find('option').each(function() {
                    const optionVal = $(this).val();
                    if (!optionVal) return;

                    const optionMoment = moment(optionVal, 'HH:mm:ss');
                    if (optionMoment.isSameOrBefore(startMoment)) {
                        $(this).prop('disabled', true).addClass('text-secondary');
                    } else {
                        $(this).prop('disabled', false).removeClass('text-secondary');
                    }
                });

                if (endTimeSelect.find('option:selected').prop('disabled')) {
                    endTimeSelect.val('');
                }
            }

            allDayCheckbox.on('change', function() {
                if (this.checked) {
                    startTimeSelect.val('00:00:00').trigger('change').prop('disabled', false);
                    endTimeSelect.val('23:45:00').trigger('change').prop('disabled', false);
                } else {
                    startTimeSelect.prop('disabled', false).val('').trigger('change');
                    endTimeSelect.prop('disabled', false).val('').trigger('change');
                }
            });

            // --- Event listener ---
            startTimeSelect.on('change', updateEndTimeOptions);

            // --- Initialize Select2 ---
            startTimeSelect.select2({
                dropdownParent: $('#store_activity'),
                width: '100%',
                dropdownPosition: 'below'
            });
            endTimeSelect.select2({
                dropdownParent: $('#store_activity'),
                width: '100%',
                dropdownPosition: 'below'
            });

            // --- Initial population ---
            populateDropdowns();


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


            // Companies storing and validation
            $("#add-company-form").validate({
                ignore: [],
                rules: {
                    name: {
                        required: true
                    },
                    description: {
                        required: true
                    },
                    email: {
                        required: true
                    },
                    phone: {
                        required: true
                    },
                    address: {
                        required: true
                    },
                    people_id: {
                        required: false
                    },
                    url: {
                        required: true,
                        url: true
                    },
                    tag_id: {
                        required: true
                    },
                    company_type_id: {
                        required: true
                    },
                    assignee_id: {
                        required: true
                    },
                    industry_id: {
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
                    description: {
                        required: "Please enter the description."
                    },
                    email: {
                        required: "Please enter the email."
                    },
                    phone: {
                        required: "Please enter the phone number."
                    },
                    address: {
                        required: "Please enter the address."
                    },
                    // people_id: {
                    //     required: "Please select the person."
                    // },
                    url: {
                        required: "Please enter the url.",
                        url: "The url field must be a valid URL."
                    },
                    tag_id: {
                        required: "Please select a tag."
                    },
                    company_type_id: {
                        required: "Please select a company type."
                    },
                    assignee_id: {
                        required: "Please select an assignee."
                    },
                    industry_id: {
                        required: "Please select an industry."
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


            // Submit Lead form
            $('#add-company-form').submit(function(e) {
                e.preventDefault();

                const $form = $(this);
                const $submitBtn = $form.find('button[type="submit"]');

                if (!$form.valid()) return;

                $.ajax({
                    url: '{{ route('admin.company.store') }}',
                    method: 'POST',
                    data: $form.serialize(),

                    beforeSend: function() {
                        $submitBtn.prop('disabled', true).text('Saving...');
                    },

                    success: function() {
                        toastr.success('Company created successfully! Redirecting...');
                        $form[0].reset();

                        setTimeout(() => {
                            window.location.href =
                                "{{ route('admin.company.index') }}";
                        }, 1500);
                    },

                    error: function() {
                        toastr.error('Something went wrong while creating the company.');
                        $submitBtn.prop('disabled', false).text('Submit');
                    }
                });
            });

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

            // ========

            $("#store_activity").validate({
                ignore: [],
                rules: {
                    note: {
                        required: true
                    },
                    agenda: {
                        required: true
                    },
                    'participant_id[]': {
                        required: true,
                        minlength: 1
                    },
                    activity_type_id: {
                        required: true
                    },
                    date: {
                        required: true
                    },
                    start_time: {
                        required: true
                    },
                    end_time: {
                        required: true
                    },
                    location: {
                        required: true
                    }
                },
                messages: {
                    note: {
                        required: "Please enter the activity details in the note."
                    },
                    agenda: {
                        required: "Please enter the description/agenda."
                    },
                    'participant_id[]': {
                        required: "Please select at least one participant.",
                        minlength: "Please select at least one participant."
                    },
                    activity_type_id: {
                        required: "Please select the activity type."
                    },
                    date: {
                        required: "Please select the date."
                    },
                    start_time: {
                        required: "Please select the start time."
                    },
                    end_time: {
                        required: "Please select the end time."
                    },
                    location: {
                        required: "Please enter the location."
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
                        error.insertAfter(element.parent());
                    } else {
                        error.insertAfter(element);
                    }
                }
            });

            $('#store_activity').submit(function(e) {
                e.preventDefault();

                var form = $(this);
                if (!form.valid()) return;

                // Get owner type, id, and status from data attributes
                var ownerType = form.data('owner-type');
                var ownerId = form.data('owner-id');
                var status = form.data('status');

                // Collect selected participants with their entity types
                var selectedParticipants = $('#participant_select option:selected').map(function() {
                    var val = $(this).val();
                    var type = $(this).data('entity-type') || val.split(':')[
                        0]; // handle value like "people:3"
                    var id = val.includes(':') ? val.split(':')[1] : val;
                    return {
                        id: id,
                        type: type
                    };
                }).get();

                // Serialize other form data
                var formData = form.serializeArray();

                // Append owner info, status, and participants
                formData.push({
                    name: 'owner_type',
                    value: ownerType
                });
                formData.push({
                    name: 'owner_id',
                    value: ownerId
                });
                formData.push({
                    name: 'status',
                    value: status
                });
                formData.push({
                    name: 'participants',
                    value: JSON.stringify(selectedParticipants)
                });

                // AJAX request
                $.ajax({
                    url: "{{ route('admin.schedule.activity') }}",
                    method: "POST",
                    data: $.param(formData),
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => location.reload());
                    },
                    error: function(xhr) {
                        alert('Error: ' + xhr.responseText);
                        toastr.error('Something went wrong while scheduling the activity.');
                    }
                });

            });


            $("#add-task").validate({
                ignore: [],
                rules: {
                    name: {
                        required: true
                    },
                    due_date: {
                        required: true
                    },
                    assignee_id: {
                        required: true
                    },
                    related_to: {
                        required: true
                    },
                    notes: {
                        required: true
                    },
                },
                messages: {
                    name: {
                        required: "Please enter the task name."
                    },
                    due_date: {
                        required: "Please enter the due date."
                    },
                    assignee_id: {
                        required: "Please select the assignee."
                    },
                    related_to: {
                        required: "Please select an entity."
                    },
                    notes: {
                        required: "Please enter the notes."
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

            // // Submit Task form
            $('#add-task').submit(function(e) {
                e.preventDefault();

                const $form = $(this);
                const $submitBtn = $form.find('button[type="submit"]');

                if (!$form.valid()) return;

                $.ajax({
                    url: '{{ route('admin.task.ajax.store') }}',
                    method: 'POST',
                    data: $form.serialize(),

                    beforeSend: function() {
                        $submitBtn.prop('disabled', true).text('Saving...');
                    },

                    success: function() {
                        toastr.success('Task added successfully!');
                        $form[0].reset();
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    },

                    error: function(xhr) {
                        console.log(xhr.responseText);
                        toastr.error('Something went wrong while adding the task.');
                        $submitBtn.prop('disabled', false).text('Submit');
                    }
                });
            });

        });

    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {

            /**
             * Prepare mentions array dynamically from Blade variables
             */
            var mentions = [
                @foreach ($companies as $company)
                    {
                        key: "{{ addslashes($company->name) }}",
                        value: "company:{{ $company->id }}"
                    }
                    @if (!$loop->last || count($peoples) > 0 || count($users) > 0)
                        ,
                    @endif
                @endforeach

                @foreach ($peoples as $person)
                    {
                        key: "{{ addslashes($person->name) }}",
                        value: "people:{{ $person->id }}"
                    }
                    @if (!$loop->last || count($users) > 0)
                        ,
                    @endif
                @endforeach

                @foreach ($users as $user)
                    {
                        key: "{{ addslashes($user->name) }}",
                        value: "user:{{ $user->id }}"
                    }
                    @if (!$loop->last)
                        ,
                    @endif
                @endforeach
            ];

            /**
             * Initialize Tribute.js for a textarea
             * @param {string} textareaId - ID of the textarea
             */
            function initTribute(textareaId, companyInputId, peopleInputId, userInputId, rawInputId) {
                var tribute = new Tribute({
                    trigger: '@',
                    values: mentions,
                    lookup: 'key',
                    fillAttr: 'key',
                    menuItemTemplate: function(item) {
                        var type = item.original.value.split(':')[0];
                        return `<div><strong>${item.string}</strong> <small>(${type})</small></div>`;
                    },
                    selectTemplate: function(item) {
                        return item.original ? item.original.key : '';
                    }
                });

                tribute.attach(document.getElementById(textareaId));

                // Attach form submit handler
                var form = document.getElementById(textareaId).closest('form');
                form.addEventListener('submit', function() {
                    var rawText = document.getElementById(textareaId).value;

                    var companyIds = [];
                    var peopleIds = [];
                    var userIds = [];

                    mentions.forEach(m => {
                        var regex = new RegExp(`\\b${escapeRegExp(m.key)}\\b`, 'g');
                        if (regex.test(rawText)) {
                            let [type, id] = m.value.split(':');
                            if (type === 'company') companyIds.push(id);
                            else if (type === 'people') peopleIds.push(id);
                            else if (type === 'user') userIds.push(id);
                        }
                    });

                    document.getElementById(companyInputId).value = companyIds.join(',');
                    document.getElementById(peopleInputId).value = peopleIds.join(',');
                    document.getElementById(userInputId).value = userIds.join(',');
                    document.getElementById(rawInputId).value = rawText;
                });
            }

            // Helper function to escape regex characters
            function escapeRegExp(string) {
                return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
            }

            // --- Initialize for Activity ---

            initTribute(
                'schedule-note-textarea',
                'schedule_mentioned_company_ids',
                'schedule_mentioned_people_ids',
                'schedule_mentioned_user_ids',
                'schedule_note_value'
            );

        });

    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const relatedToSelect = document.getElementById('related_to_select');
            const relatedTypeInput = document.getElementById('related_type');

            // Function to update the hidden type field
            const updateRelatedType = () => {
                const selectedOption = relatedToSelect.options[relatedToSelect.selectedIndex];
                // Check if an option is actually selected
                if (selectedOption) {
                    // Get the entity type from the data attribute
                    const entityType = selectedOption.getAttribute('data-entity-type');
                    relatedTypeInput.value = entityType ||
                        ''; // Set value, default to empty string if not found
                } else {
                    relatedTypeInput.value = '';
                }
            };

            // Attach event listener to update on change
            relatedToSelect.addEventListener('change', updateRelatedType);

            // Also run once on page load to initialize the hidden field
            // in case an option is pre-selected (though not required by your current form)
            updateRelatedType();
        });

    </script>

    <script>
    $(document).ready(function() {
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




