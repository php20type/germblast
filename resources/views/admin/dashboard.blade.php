@extends('admin.includes.layout')

@section('title', 'Dashboard')

@section('content')

    <!-- dashboard card start  -->
    <div class="dashboard-card my-4">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="container-fluid">
            <div class="row">
                <!-- Top Row -->
                <div class="col-lg-3 col-md-6 col-module">
                    <div class="card-module" data-bs-toggle="modal" data-bs-target="#AddCompany">
                        <div class="icon-wrapper icon-company">
                            <img src={{ asset('img/icons/dashboard-app1.png') }} alt="app icon" />
                            <h5 class="card-title">COMPANY</h5>
                        </div>
                        <p class="card-text">Organizations And Groups You May Do Business With</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-module">
                    <div class="card-module" data-bs-toggle="modal" data-bs-target="#AddPerson">
                        <div class="icon-wrapper icon-person">
                            <img src={{ asset('img/icons/dashboard-app2.png') }} alt="app icon" />
                            <h5 class="card-title">PERSON</h5>
                        </div>
                        <p class="card-text">Individuals You Know Or May Do Business With</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-module">
                    <div class="card-module" data-bs-toggle="modal" data-bs-target="#AddLead">
                        <div class="icon-wrapper icon-lead">
                            <img src={{ asset('img/icons/dashboard-app3.png') }} alt="app icon" />
                            <h5 class="card-title">LEAD</h5>
                        </div>
                        <p class="card-text">A Deal Or Opportunity To Make A Sale</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-module">
                    <div class="card-module" data-bs-toggle="modal" data-bs-target="#AddActivity">
                        <div class="icon-wrapper icon-activity">
                            <img src={{ asset('img/icons/dashboard-app4.png') }} alt="app icon" />
                            <h5 class="card-title">ACTIVITY</h5>
                        </div>
                        <p class="card-text">Phone Calls, Meetings, And Other Interactions</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-module">
                    <div class="card-module" data-bs-toggle="modal" data-bs-target="#AddTask">
                        <div class="icon-wrapper icon-task">
                            <img src={{ asset('img/icons/dashboard-app5.png') }} alt="app icon" />
                            <h5 class="card-title">TASK</h5>
                        </div>
                        <p class="card-text">Reminders And Other Things You Don't Want To Forget</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-module">
                    <div class="card-module">
                        <div class="icon-wrapper icon-form">
                            <img src={{ asset('img/icons/dashboard-app6.png') }} alt="app icon" />
                            <h5 class="card-title">FORM</h5>
                        </div>
                        <p class="card-text">Collect Leads Directly From Your Website</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-module">
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
                    <form action="{{ route('admin.companies.store') }}" method="POST" class="company-form"
                        id="add-company-form">
                        @csrf
                        <div class="row mx-0">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Company name</label>
                                    <input type="text" name="name" placeholder="Company" class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Description</label>
                                    <input type="text" name="description" placeholder="" class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    <input type="text" name="email" placeholder="" class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">Phone Number</label>
                                    <input type="text" name="phone" placeholder="" class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Address</label>
                                    <input type="text" name="address" placeholder="" class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Person</label>
                                    <select name="people_id" class="form-select">
                                        <option value="">Select Person</option>
                                        @foreach ($peoples as $people)
                                            <option value="{{ $people->id }}">{{ $people->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">URL</label>
                                    <input type="text" name="url" placeholder="https://" class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Tags</label>
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
                                    <select name="company_type_id" class="form-select">
                                        <option value="">Select company Type</option>
                                        @foreach ($company_types as $company_type)
                                            <option value="{{ $company_type->id }}">{{ $company_type->type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Assignee</label>
                                    <select name="user_id" class="form-select">
                                        <option value="">Select Assignee</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Industry</label>
                                    <select name="industry_id" class="form-select">
                                        <option value="">Select Industry</option>
                                        @foreach ($industries as $industry)
                                            <option value="{{ $industry->id }}">{{ $industry->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Territory</label>
                                    <select name="territory_id" class="form-select">
                                        <option value="">Select Territory</option>
                                        <option value="1">Territory 1</option>
                                        {{-- @foreach ($territories as $territory)
                                            <option value="{{ $territory->id }}">{{ $territory->name }}</option>
                                        @endforeach --}}
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
                                    <input type="text" name="name" placeholder="Person name"
                                        class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" placeholder="email@example.com"
                                        class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Bio</label>
                                    <input type="text" name="bio" placeholder="Your bio...."
                                        class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Company</label>
                                    <select name="company_id" class="form-select">
                                        <option value="">Choose...</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Phone Number</label>
                                    <input type="text" name="phone" placeholder="123-456-7890"
                                        class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Address</label>
                                    <textarea name="address" id="address" class="form-control" placeholder="Your address..."></textarea>
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
                                    <select name="user_id" class="form-select">
                                        <option value="">Select Assignee</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Territory</label>
                                    <select name="territory_id" class="form-select">
                                        <option value="">Select Territory</option>
                                        <option value="1">Territory 1</option>
                                        {{-- @foreach ($territories as $territory)
                                            <option value="{{ $territory->id }}">{{ $territory->name }}</option>
                                        @endforeach --}}
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
                    <form action="{{ route('admin.leads.store') }}" class="company-form" id="add-lead-form"
                        method="POST">
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
                                        class="form-control" />
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
                                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
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
                                    {{-- <select name="company_id[]" id="companySelect" class="form-select">
                                        @foreach ($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select> --}}
                                    <select name="company_id[]" id="companySelect" class="form-select select2" multiple>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
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
                                    <select id="person_select" name="person_id[]" class="form-select select2" multiple>
                                        @foreach ($peoples as $people)
                                            <option value="{{ $people->id }}">{{ $people->name }}
                                                ({{ $people->email }})
                                            </option>
                                        @endforeach
                                    </select>

                                    {{-- Toggle Button --}}
                                    <button type="button" id="toggleAddPerson" class="btn btn-sm btn-link text-primary">
                                        + Add New Person
                                    </button>

                                    {{-- ====== --}}
                                    <div id="addPersonInlineForm" class="mt-3 p-3 border rounded bg-light d-none">
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <label>Name</label>
                                                <input type="text" name="inline_name" class="form-control">
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <label>Email</label>
                                                <input type="email" name="inline_email" class="form-control">
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <label>Phone</label>
                                                <input type="text" name="inline_phone" class="form-control">
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <label>Postal Code</label>
                                                <input type="text" name="inline_code" class="form-control">
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-success mt-2" id="submitAddPerson">Add
                                            Person</button>
                                    </div>


                                    {{-- ===== --}}
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">Sources</label>
                                    @error('source_id')
                                        <span class="text-danger">* {{ $message }}</span>
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
                                    @error('competitors_id')
                                        <span class="text-danger">* {{ $message }}</span>
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
                    <h1 class="modal-title" id="exampleModalLabel">Add a Activity</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="company-form" action="{{ route('admin.activity.store') }}" method="post"
                        id="store_activity">
                        @csrf

                        <div class="row mx-0">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Activity Title</label>
                                    <input type="text" placeholder="Phone Call" name="title"
                                        class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Activity type</label>
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
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label">Date</label>
                                    <input type="date" placeholder="" class="form-control" name="date" />
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label class="form-label">Time</label>
                                    <div class="d-flex">
                                        <select class="form-select mt-2" name="start_time">
                                            <option value="11:00 AM" selected>11 : 00 AM</option>
                                            <option value="11:15 AM">11 : 15 AM</option>
                                            <option value="11:30 AM">11 : 30 AM</option>
                                            <option value="11:45 AM">11 : 45 AM</option>
                                        </select>
                                        <select class="form-select mt-2" name="end_time">
                                            <option value="01:11 PM" selected>01 : 11 PM (3 min)</option>
                                            <option value="01:15 PM">01 : 15 PM (15 min)</option>
                                            <option value="01:30 PM">01 : 30 PM (30 min)</option>
                                            <option value="01:45 PM">01 : 45 PM (45 min)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
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
                                    <input type="text" placeholder="Add a Location" class="form-control"
                                        name="location" />
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mb-4">
                                    <label class="form-label">Participant </label>
                                    <input type="text" placeholder="Type to search for participants…"
                                        class="form-control" name="search_participant" />
                                </div>
                                <div class="participant-list">

                                    @foreach ($peoples as $people)
                                        <div
                                            class="d-flex align-items-center justify-content-between mb-3 participant-entry">
                                            <div class="d-flex align-items-center">
                                                {{-- <img src="img/home/profile.png" alt="Paul Blake" class="person-avatar me-3"> --}}
                                                <div>
                                                    <input type="hidden" name="participant_id[]"
                                                        value="{{ $people->id }}">
                                                    <h6 class="mb-0">{{ $people->name }}</h6>
                                                    <small class="text-warning">{{ $people->email }}</small>
                                                </div>
                                            </div>
                                            <div class="d-flex gap-3 align-items-center">
                                                <div class="text-end">
                                                    <a href="#" class="remove-participant"><i
                                                            class="fa-regular fa-xmark"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>

                            <div class="col-lg-12">
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
                                    <input type="text" name="name" placeholder="" class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Due Date</label>
                                    <input type="date" name="due_date" placeholder="" class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Assignee</label>
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
                                    <label class="form-label">Related to</label>
                                    <input type="text" name="related_to" placeholder="Type to search..."
                                        class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Notes</label>
                                    <textarea name="notes" id="notes" class="form-control"></textarea>
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

            $(document).on('click', '.remove-participant', function(e) {
                e.preventDefault();
                $(this).closest('.participant-entry').remove();
            });

            // Toggle the Add Person form
            $('#toggleAddPerson').on('click', function() {
                $('#addPersonInlineForm').toggleClass('d-none');
            });

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



            // Submit Add Person via AJAX
            $('#submitAddPerson').on('click', function() {
                let formData = {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    name: $('input[name="inline_name"]').val(),
                    email: $('input[name="inline_email"]').val(),
                    phone: $('input[name="inline_phone"]').val(),
                    code: $('input[name="inline_code"]').val(),
                };

                $.ajax({
                    url: "{{ route('admin.people.ajax.store') }}",
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            toastr.success('Person added successfully!');
                            $('input[name="inline_name"], input[name="inline_email"], input[name="inline_phone"], input[name="inline_code"]')
                                .val('');
                            $('#addPersonInlineForm').addClass('d-none');

                            const newPerson = response.people;
                            const option = new Option(newPerson.email, newPerson.id);
                            $('#person_select').append(option);

                        } else {
                            console.log(response);
                            toastr.error('Failed to add person. Please try again.');
                        }
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON?.errors) {
                            let messages = Object.values(xhr.responseJSON.errors).flat().join(
                                '\n');
                            toastr.error(messages, 'Validation Error');
                        } else {
                            console.log(xhr.responseText);
                            toastr.error("Something went wrong.");
                        }
                    }
                });
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


            // Submit Lead form
            $('#add-lead-form').submit(function(e) {
                e.preventDefault();

                if (!$('#add-lead-form').valid()) {
                    return; // Stop if validation fails
                }

                $.ajax({
                    url: '{{ route('admin.leads.store') }}',
                    method: 'POST',
                    data: $(this).serialize(),

                    success: function(response) {
                        toastr.success('Lead created successfully! Redirecting...');
                        $('#add-lead-form')[0].reset();

                        // 1.5 seconds delay
                        setTimeout(function() {
                            window.location.href = "{{ route('admin.leads.index') }}";
                        }, 1500);
                    },
                    error: function(xhr) {
                        alert(xhr.responseText);
                        toastr.error('Something went wrong while creating the lead.');
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
                        required: true
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
                    user_id: {
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
                    people_id: {
                        required: "Please select the person."
                    },
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
                    user_id: {
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

                if (!$('#add-company-form').valid()) {
                    return; // Stop if validation fails
                }

                $.ajax({
                    url: '{{ route('admin.companies.store') }}',
                    method: 'POST',
                    data: $(this).serialize(),

                    success: function(response) {
                        toastr.success('Company created successfully! Redirecting...');
                        $('#add-company-form')[0].reset();

                        // 1.5 seconds delay
                        setTimeout(function() {
                            window.location.href =
                                "{{ route('admin.company.index') }}";
                        }, 1500);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        toastr.error('Something went wrong while creating the company.');
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
                        required: true
                    },
                    phone: {
                        required: true
                    },
                    address: {
                        required: true
                    },
                    url: {
                        required: true,
                        url: true
                    },
                    tag_id: {
                        required: true
                    },
                    user_id: {
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
                    company_id: {
                        required: "Please select the company."
                    },
                    phone: {
                        required: "Please enter the phone number."
                    },
                    address: {
                        required: "Please enter the address."
                    },
                    url: {
                        required: "Please enter the url.",
                        url: "The url field must be a valid URL."
                    },
                    tag_id: {
                        required: "Please select a tag."
                    },
                    user_id: {
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

                if (!$('#add-person-form').valid()) {
                    return; // Stop if validation fails
                }

                $.ajax({
                    url: '{{ route('admin.people.store') }}',
                    method: 'POST',
                    data: $(this).serialize(),

                    success: function(response) {
                        toastr.success('Person created successfully! Redirecting...');
                        $('#add-person-form')[0].reset();
                        // $('#AddPerson').modal('hide');

                        // 1.5 seconds delay
                        setTimeout(function() {
                            window.location.href =
                                "{{ route('admin.peoples.index') }}";
                        }, 1500);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        toastr.error('Something went wrong while adding the person.');
                    }
                });
            });
            // ========

            $("#store_activity").validate({
                ignore: [],
                rules: {
                    title: {
                        required: true
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
                    },
                    agenda: {
                        required: true
                    },
                },
                messages: {
                    title: {
                        required: "Please enter the title."
                    },
                    activity_type_id: {
                        required: "Please select an activity."
                    },
                    date: {
                        required: "Please enter the date."
                    },
                    start_time: {
                        required: "Please enter the time."
                    },
                    end_time: {
                        required: "Please enter the time."
                    },
                    location: {
                        required: "Please enter the location."
                    },
                    agenda: {
                        required: "Please enter the agenda."
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

            // Submit Activity form
            $('#store_activity').submit(function(e) {
                e.preventDefault();

                if (!$('#store_activity').valid()) {
                    return; // Stop if validation fails
                }

                $.ajax({
                    url: '{{ route('admin.activity.store') }}',
                    method: 'POST',
                    data: $(this).serialize(),

                    success: function(response) {
                        toastr.success('Activity added successfully!');
                        $('#store_activity')[0].reset();
                        $('#AddActivity').modal('hide');

                        // // 1.5 seconds delay
                        // setTimeout(function() {
                        //     window.location.href =
                        //         "{{ route('admin.company.index') }}";
                        // }, 1500);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        toastr.error('Something went wrong while adding the activity.');
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
                        required: "Please enter data in related_to."
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

            // Submit Activity form
            $('#add-task').submit(function(e) {
                e.preventDefault();

                if (!$('#add-task').valid()) {
                    return; // Stop if validation fails
                }

                $.ajax({
                    url: '{{ route('admin.task.ajax.store') }}',
                    method: 'POST',
                    data: $(this).serialize(),

                    success: function(response) {
                        toastr.success('Task added successfully!');
                        $('#add-task')[0].reset();
                        $('#AddTask').modal('hide');

                        // // 1.5 seconds delay
                        // setTimeout(function() {
                        //     window.location.href =
                        //         "{{ route('admin.company.index') }}";
                        // }, 1500);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        toastr.error('Something went wrong while adding the activity.');
                    }
                });
            });



        });
    </script>
@endpush
