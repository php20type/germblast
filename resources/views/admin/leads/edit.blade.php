@extends('admin.includes.layout')

@section('title', 'Lead Details')

@section('content')

    <!-- company details start -->
    <div class="company-details-section">
        <div class="container-fluid">
            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <div class="main-content">
                        <div class="project-container">
                            <div class="project-header">
                                <div class="title-row">
                                    <div class="title-section">
                                        <div class="d-flex justify-content-between align-items-center">

                                            <img src="{{ $leadStatusIcon }}" alt="Lead Status" id="lead-status-icon">
                                            {{-- <i class="fas fa-star star-icon"></i> --}}

                                            <h1 contenteditable="true" spellcheck="false">
                                                {{ $leads->name }}
                                            </h1>
                                        </div>
                                        <div class="project-id">#{{ $leads->id }}</div>
                                        <div class="mt-3">

                                            <div class="d-flex justify-content-left align-items-center flex-wrap">
                                                @foreach ($leads->leadTags as $leadTag)
                                                    <div class="badge-customer me-2 mb-2 d-flex align-items-center">
                                                        <span class="me-1">{{ $leadTag->tag->name }}</span>
                                                        <span class="btn btn-sm delete-item p-0">
                                                            <i class="fas fa-times"></i>
                                                        </span>
                                                    </div>
                                                @endforeach
                                            </div>

                                        </div>
                                    </div>
                                    <div class="amount">$2</div>
                                </div>

                                <div class="my-3">
                                    <select class="form-select d-inline-block w-100" aria-label="Default select example">
                                        <option selected="">Add tags...</option>
                                        {{-- <option value="1">Type 1</option>
                                        <option value="2">Type 2</option> --}}
                                        @foreach ($tags as $tag)
                                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="info-grid">
                                    <div class="info-item">
                                        <h6>Opened by</h6>
                                        <p>{{ $leads->assignee?->name ?? 'N/A' }}</p>
                                    </div>
                                    <div class="info-item">
                                        <h6>Opened on</h6>
                                        <p>{{ \Carbon\Carbon::parse($leads->created_at)->format('j F Y') }}</p>
                                    </div>
                                    <div class="info-item">
                                        <h6>Expected to close</h6>
                                        <p>{{ \Carbon\Carbon::parse($leads->close_date)->format('j F Y') }}</p>
                                    </div>
                                    <div class="info-item">
                                        <h6>Confidence</h6>
                                        <p>{{ $leads->confidence }}%</p>
                                    </div>
                                    <div class="info-item">
                                        <h6>Territory</h6>
                                        <p>Lubbock Office</p>
                                    </div>
                                </div>
                            </div>

                            <div class="pipeline-section">
                                <div class="pipeline-header">
                                    <div class="pipeline-title">Pipeline: Default Pipeline</div>
                                </div>

                                <ul class="step-menu list-inline">
                                    @foreach ($leadStages as $leadStage)
                                        <li role="button"
                                            class="stage-item {{ $leadStage->id <= $leads->stage_id ? 'current' : '' }}"
                                            data-stage-id="{{ $leadStage->id }}" data-lead-id="{{ $leads->id }}">
                                            {{ $leadStage->name }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="pipeline-section">
                                <div class="pipeline-header">
                                    <div class="pipeline-title">GermBlast</div>
                                    <a href="#" class="text-warning">Edit processes</a>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="GermBlast" />
                                </div>
                            </div>
                        </div>

                        <!-- Tasks Section -->
                        <div class="section-card">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5>Custom fields</h5>
                                <a href="#" class="text-warning">Create custom fields</a>
                            </div>
                            <div class="d-flex align-items-start">
                                <div class="task-icon me-3">
                                    <i class="fas fa-list"></i>
                                </div>
                                <div class="flex-1">
                                    <h6>Customize relevant information about your leads</h6>
                                    <p class="text-muted mb-0">Create your own fields to capture unique details
                                        about your leads, benefiting both you and your company. Prioritize your
                                        top three fields here; the remaining fields will be accessible on the
                                        sidebar.</p>
                                </div>
                            </div>
                        </div>

                        {{-- Tasks section --}}
                        <div class="section-card">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5>TASKS</h5>
                                <a class="text-warning" href="javascript:void(0);" id="toggleAddTask">Add A Task</a>
                            </div>
                            <div class="d-flex align-items-start">
                                <div class="task-icon me-3">
                                    <i class="fas fa-list"></i>
                                </div>
                                <div class="flex-1">
                                    <h6>NO UPCOMING TASKS</h6>
                                    <p class="text-muted mb-0">Nice work! Now, add tasks to your leads like
                                        "Mail a proposal" or "Send follow-up email" to be reminded here.</p>
                                </div>
                            </div>
                        </div>
                        {{-- Task form --}}
                        {{-- <div id="addTaskForm" class="my-3" style="display: none;">

                            <form id="addTaskAjaxForm" action="{{ route('admin.tasks.store') }}" post="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <input type="text" name="title" class="form-control"
                                                placeholder="Add a Task">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <input type="datetime-local" name="due_date" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-2">
                                            <select class="form-select" name="user_id" required>
                                                <option value="">-- Select User --</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-2">
                                            <textarea rows="3" placeholder="" name="description" class="form-control"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-warning btn-sm">Add
                                            Task</button>
                                    </div>
                                </div>
                            </form>

                        </div> --}}
                        {{-- Task form --}}
                        <div id="addTaskForm" class="my-3" style="display: none;">

                            <form id="addTaskAjaxForm" action="{{ route('admin.tasks.store') }}" post="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <input type="text" name="title" class="form-control"
                                                placeholder="Add a Task" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <input type="datetime-local" name="due_date" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-2">
                                            <select class="form-select" name="user_id" required>
                                                <option value="">-- Select User --</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-2">
                                            <textarea rows="3" placeholder="Include any description you need to help complete this task…" name="description"
                                                class="form-control"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-warning btn-sm">Add
                                            Task</button>
                                    </div>
                                </div>
                            </form>

                        </div>

                        <!-- Activities Section -->
                        <div class="section-card">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5>ACTIVITIES</h5>
                                <a href="javascript:void(0)" onclick="scheduleActivity()" class="text-warning">Schedule
                                    an activity</a>
                            </div>
                            <div class="d-flex align-items-start">
                                <div class="activity-icon me-3">
                                    <i class="fas fa-list"></i>
                                </div>
                                <div class="flex-1">
                                    <h6>NO UPCOMING ACTIVITIES</h6>
                                    <p class="text-muted mb-0">Schedule a meeting or phone call to remind
                                        yourself and your colleagues. Once the activity occurs, log it to see it
                                        in the timeline.</p>
                                </div>
                            </div>
                        </div>
                        <!-- Notes Section -->
                        <div class="section-card">
                            <!-- Header Tabs -->
                            <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="activity-tab" data-bs-toggle="tab"
                                        data-bs-target="#write-activity-content" type="button" role="tab"
                                        aria-controls="write-activity-content" aria-selected="true">
                                        LOG AN ACTIVITY
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="note-tab" data-bs-toggle="tab"
                                        data-bs-target="#write-note-content" type="button" role="tab"
                                        aria-controls="write-note-content" aria-selected="false">
                                        <i class="fas fa-edit me-2"></i>WRITE A NOTE
                                    </button>
                                </li>
                                <li class="nav-item ms-auto">
                                    <button class="btn btn-outline-secondary btn-sm me-2">
                                        <i class="fas fa-arrow-up me-1"></i>SEND A TEXT
                                    </button>
                                    <button class="btn btn-dark btn-sm">
                                        <i class="fas fa-envelope me-1"></i>SEND AN EMAIL
                                    </button>
                                </li>
                            </ul>

                            <!-- Tab Content -->
                            <div class="tab-content">
                                <!-- Activity Tab -->
                                <div class="tab-pane fade show active activity-form" id="write-activity-content"
                                    role="tabpanel" aria-labelledby="activity-tab">

                                    <form action="{{ route('admin.login.activity') }}" method="post"
                                        id="loginActivity">
                                        @csrf
                                        <textarea class="form-textarea w-100" name="title" placeholder="Type Here..."></textarea>

                                        <div class="form-row">
                                            <div class="form-group">
                                                <label class="form-label">ACTIVITY</label>
                                                <select class="form-select-custom" name="activity_type">
                                                    <option value="">-- Select --</option>
                                                    @foreach ($activity_types as $activity_type)
                                                        <option value="{{ $activity_type->id }}">
                                                            {{ $activity_type->type }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label">DURATION</label>
                                                <input type="hidden" name="start_time" id="start_time">
                                                <input type="hidden" name="end_time" id="end_time">
                                                {{-- <input type="hidden" name="participant_id" value={{ $peoples->id }}> --}}

                                                <select class="form-select-custom" name="duration" id="duration">
                                                    <option value="">-- Select --</option>
                                                    <option value="15">15 Min</option>
                                                    <option value="30">30 Min</option>
                                                    <option value="60">1 Hour</option>
                                                    <option value="120">2 Hours</option>
                                                </select>
                                            </div>

                                            <button type="submit" class="btn-login">LOGIN ACTIVITY</button>
                                        </div>
                                    </form>

                                </div>

                                <!-- Note Tab -->
                                <div class="tab-pane fade activity-form" id="write-note-content" role="tabpanel"
                                    aria-labelledby="note-tab">
                                    <textarea class="form-textarea w-100" placeholder="Write your note here..." rows="6"></textarea>
                                    <div class="form-row">
                                        <button class="btn-login">SAVE NOTE</button>
                                    </div>
                                </div>
                            </div>


                            <!-- Filter Section -->
                            <div class="filter-section">
                                <div class="row g-2">
                                    <div class="col-auto">
                                        <select class="form-select dropdown-orange">
                                            <option selected>All Entries</option>
                                            <option value="1">Last 7 Days</option>
                                            <option value="2">Last 30 Days</option>
                                            <option value="3">Last 90 Days</option>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <select class="form-select dropdown-orange">
                                            <option selected>All Activity Type</option>
                                            <option value="1">Phone Call</option>
                                            <option value="2">Email</option>
                                            <option value="3">Meeting</option>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <select class="form-select dropdown-orange">
                                            <option selected>All Users & Team</option>
                                            <option value="1">User 1</option>
                                            <option value="2">User 2</option>
                                            <option value="3">Team A</option>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <select class="form-select dropdown-orange">
                                            <option selected>All Time</option>
                                            <option value="1">Open</option>
                                            <option value="2">Closed</option>
                                            <option value="3">Pending</option>
                                        </select>
                                    </div>
                                    <div class="col-auto ms-auto">
                                        <button class="btn btn-warning">
                                            <i class="fa-regular fa-gear"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="timeline-container">
                                <div class="timeline">

                                    <!-- Comment Timeline Item -->
                                    <div class="timeline-item">
                                        <div class="timeline-icon comment">
                                            <i class="fa-solid fa-phone-volume"></i>
                                        </div>
                                        <div class="timeline-content">
                                            <div class="timeline-header">
                                                <div class="timestamp">9:30 PM on Feb 8, 2022</div>
                                            </div>
                                            <div class="timeline-body">
                                                <p> <a href="#"
                                                        class="author-link">{{ $leads->assignee?->name ?? 'N/A' }}</a>
                                                    logged an
                                                    activity with <span
                                                        class="organization">{{ $leads->companies->pluck('company.name')->filter()->join(', ') ?? 'N/A' }},
                                                        {{-- <a href="#" class="author-link">Paul Blake</a>Heath Herrington --}}
                                                        <a href="#"
                                                            class="author-link"></a>{{ $leads->peoples->pluck('name')->join(', ') ?: 'N/A' }}
                                                        <a href="#"
                                                            class="author-link">{{ $leads->name ?? 'N/A' }}</a> </span>
                                                </p>
                                                <div class="activity-details">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <div class="activity-label mb-0">Phone Call</div>
                                                            <div class="activity-description">
                                                                Heath spoke with Paul Blake who is the Chairman
                                                                of Deacons at 12th St Church of Christ. We did a
                                                                single service response for them back in
                                                                November. But we hadn't done quarterly services
                                                                for them in the 9 months leading up to that. So
                                                                Heath talked with Mr Blake about the possibility
                                                                of doing a renewal with them for quarterly
                                                                services and a partnership....
                                                            </div>
                                                        </div>
                                                        <div class="col-2">
                                                            <div class="activity-badges">
                                                                <div class="activity-badge badge-cc">CC</div>
                                                                <div class="activity-badge badge-chcl">CHCL
                                                                </div>
                                                                <div class="activity-badge badge-bb">BB</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Note Timeline Item -->
                                    <div class="timeline-item">
                                        <div class="timeline-icon note">
                                            <i class="fa-solid fa-star"></i>
                                        </div>
                                        <div class="timeline-content">
                                            <div class="timeline-header">
                                                <div class="timestamp">1:54 AM on Nov 11, 2021</div>
                                            </div>
                                            <div class="timeline-body">
                                                <p><a href="#"
                                                        class="author-link">{{ $leads->assignee?->name ?? 'N/A' }}</a> won
                                                    the
                                                    lead <span class="organization">
                                                        {{ $leads->name ?? 'N/A' }}</span> worth $955</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Note Timeline Item -->
                                    <div class="timeline-item">
                                        <div class="timeline-icon note">
                                            <i class="fa-solid fa-angles-right"></i>
                                        </div>
                                        <div class="timeline-content">
                                            <div class="timeline-header">
                                                <div class="timestamp">1:54 AM on Nov 11, 2021</div>
                                            </div>
                                            <div class="timeline-body">
                                                <p><a href="#"
                                                        class="author-link">{{ $leads->assignee?->name ?? 'N/A' }}</a> won
                                                    the
                                                    lead <span class="organization">
                                                        {{ $leads->name ?? 'N/A' }}</span> worth $955</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Activity Timeline Item -->
                                    <div class="timeline-item">
                                        <div class="timeline-icon activity">
                                            <i class="fa-solid fa-envelope"></i>
                                        </div>
                                        <div class="timeline-content">
                                            <div class="timeline-header">
                                                <div class="timestamp">
                                                    {{ \Carbon\Carbon::parse($leads->created_at)->format('g:i A \o\n M d, Y') }}
                                                </div>
                                            </div>
                                            <div class="timeline-body">
                                                <a href="#" class="author-link">
                                                    {{ $leads->assignee?->name ?? 'N/A' }}
                                                </a>
                                                logged an activity with <span class="organization">
                                                    {{ $leads->companies->pluck('company.name')->filter()->join(', ') ?? 'N/A' }}
                                                </span>,
                                                {{-- Barbra Moore, <a href="#" class="author-link">Brennan Baxter</a>. --}}
                                                <a href="#"
                                                    class="author-link">{{ $leads->peoples->pluck('name')->join(', ') ?: 'N/A' }}
                                                </a>
                                                <div class="activity-title">{{ $leads->name ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <div class="sidebar">

                        {{-- Starting of leads-details-container --}}
                        <div id="leads-details-container" data-lead-id="{{ $leads->id }}">
                            <form class="assignee-form" id="assigneeForm" method="post">
                                @csrf

                                {{-- Lead Status --}}
                                <div class="form-group mb-3">
                                    <select class="form-select" id="leadStatusSelect"
                                        data-lead-id="{{ $leads->id }}">
                                        <option value="open" {{ $leads->lead_status == 'open' ? 'selected' : '' }}>Open
                                        </option>
                                        <option value="won" {{ $leads->lead_status == 'won' ? 'selected' : '' }}>Won
                                        </option>
                                        <option value="lost" {{ $leads->lead_status == 'lost' ? 'selected' : '' }}>Lost
                                        </option>
                                        <option value="cancelled"
                                            {{ $leads->lead_status == 'cancelled' ? 'selected' : '' }}>
                                            Cancelled</option>
                                        <option value="pending" {{ $leads->lead_status == 'pending' ? 'selected' : '' }}>
                                            Pending</option>
                                    </select>
                                </div>

                                {{-- Lead Flags --}}
                                <div class="form-group mb-3">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-check">
                                                <input class="form-check-input lead-flag" name="lead_flag"
                                                    type="checkbox" value="watching" id="checkbox1"
                                                    data-lead-id="{{ $leads->id }}"
                                                    @if (is_array($leads->lead_flags) && in_array('watching', $leads->lead_flags)) checked @endif>
                                                <label class="form-check-label" for="checkbox1"><b>Watching</b></label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-check">
                                                <input class="form-check-input lead-flag" name="lead_flag"
                                                    type="checkbox" value="hot" id="checkbox2"
                                                    data-lead-id="{{ $leads->id }}"
                                                    @if (is_array($leads->lead_flags) && in_array('hot', $leads->lead_flags)) checked @endif>
                                                <label class="form-check-label" for="checkbox2"><b>Hot</b></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Assignee --}}
                                <div class="form-group mb-3">
                                    <label for="assigneeSelect" class="form-label">
                                        <b>ASSIGNEE</b>
                                    </label>
                                    <select class="form-select" id="assigneeSelect">
                                        <option selected>Select assignee</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>
                            <hr>

                            <div class="sidebar-section">

                                {{-- Companies --}}
                                <div id="company-container">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="text-uppercase">Companies</h6>
                                        <div id="toggle-add-company" class="text-warning" style="cursor: pointer;">
                                            Add a company
                                        </div>
                                    </div>

                                    <div class="d-none mb-3" id="add-company">
                                        <select class="form-select update-field-select" data-type="company"
                                            id="companySelect">
                                            <option selected>Add a company</option>
                                            @foreach ($companies as $company)
                                                <option value="{{ $company->id }}">
                                                    {{ $company->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div id="company-list">
                                        @foreach ($leads->companies as $leadCompany)
                                            <div class="company-list d-flex justify-content-between align-items-center mb-3"
                                                id="company-{{ $leadCompany->id }}">
                                                <div class="row">
                                                    <div class="col-2">
                                                        <div class="company-icon">
                                                            <img src="{{ asset('img/home/companyimages1.png') }}"
                                                                alt="Company Logo" class="img-fluid">
                                                        </div>
                                                    </div>
                                                    <div class="col-10">
                                                        <div class="company-name">
                                                            <p><b>{{ $leadCompany->name ?? 'N/A' }}</b></p>
                                                            <p>{{ $leadCompany->description ?? 'N/A' }}</p>
                                                            <p>{{ $leadCompany->companyAddress->address ?? 'N/A' }}</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="delete-company">
                                                    {{-- <button class="btn btn-sm btn-outline-secondary"
                                                    onclick="deleteField('{{ $leads->id }}', '{{ $leadCompany->id }}', 'company')">
                                                    <i class="fas fa-times"></i>
                                                </button> --}}
                                                    <button class="btn btn-sm btn-outline-secondary delete-item"
                                                        data-lead="{{ $leads->id }}" data-id="{{ $leadCompany->id }}"
                                                        data-type="company" data-target="company-{{ $leadCompany->id }}">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>

                                            </div>
                                        @endforeach
                                    </div>

                                </div>

                                {{-- Peoples --}}
                                <div id="people-container">
                                    <div class="d-flex justify-content-between align-items-center mb-2 mt-3">
                                        <h6 class="text-uppercase">Peoples</h6>
                                        <div id="toggle-add-person" class="text-warning" style="cursor: pointer;">
                                            Add a people
                                        </div>
                                    </div>

                                    <div class="d-none mb-3" id="add-person">
                                        <select class="form-select update-field-select" data-type="people"
                                            id="personSelect">
                                            <option selected>Add a person</option>
                                            @foreach ($allpeoples as $allpeople)
                                                <option value="{{ $allpeople->id }}">
                                                    {{ $allpeople->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div id="people-list">
                                        @foreach ($leads->peoples as $person)
                                            <div class="company-list d-flex justify-content-between align-items-center mb-3"
                                                id="person-{{ $person->id }}">
                                                <div class="row">
                                                    <div class="col-2">
                                                        <div class="company-icon">
                                                            <img src="{{ asset('img/home/profile-image.png') }}"
                                                                alt="People Logo" class="img-fluid">
                                                        </div>
                                                    </div>
                                                    <div class="col-10">
                                                        <div class="company-name">
                                                            <p><strong>{{ $person->name }}</strong></p>
                                                            <p>{{ $person->bio ?? 'N/A' }}</p>
                                                            <p>{{ $person->peoplePhone->phone ?? 'N/A' }}</p>
                                                            <p>{{ $person->peopleEmail->email ?? 'N/A' }}</p>
                                                            <p class="text-warning">Contacted 8 Feb 2022</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="delete-people">
                                                    {{-- <button class="btn btn-sm btn-outline-secondary" {{-- onclick="deleteField('{{ $company->id }}', '{{ $email['selected'] }}', 'email')"> --}
                                                        onclick="deleteField('{{ $leads->id }}', '{{ $person->id }}', 'people')">
                                                        <i class="fas fa-times"></i>
                                                    </button> --}}
                                                    <button class="btn btn-sm btn-outline-secondary delete-item"
                                                        data-lead="{{ $leads->id }}" data-id="{{ $person->id }}"
                                                        data-type="people" data-target="person-{{ $person->id }}">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>

                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                            </div>

                            <hr>

                            <div class="sidebar-section">
                                {{-- Product --}}
                                <div class="form-group mb-3" id="product-container">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="text-uppercase">
                                            Products <span style="font-weight: normal;"> U.S. (USD)</span>
                                        </h6>
                                        <div id="toggle-add-product" class="text-warning" style="cursor: pointer;">
                                            Add a product
                                        </div>
                                    </div>

                                    <div id="add-product" class="mb-3 p-3 border rounded bg-light d-none">
                                        <div class="row">
                                            <div class="col-md-12 mb-2">
                                                <label>Name</label>
                                                <select class="form-select" id="product-name">
                                                    @foreach ($products as $product)
                                                        <option value="{{ $product->id }}">
                                                            {{ $product->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <label>Qty</label>
                                                <input type="number" name="inline_qty" class="form-control" required>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <label>Price</label>
                                                <input type="text" name="inline_price" class="form-control" required>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-success mt-2" id="submitAddPerson">Add
                                            Product</button>
                                    </div>

                                    <div id="product-list">
                                        @foreach ($leads->leadProducts as $leadProduct)
                                            <div class="company-list d-flex justify-content-between align-items-center mb-3"
                                                id="product-{{ $leadProduct->id }}">
                                                <div class="row">
                                                    <div class="col-2">
                                                        <div class="company-icon">
                                                            <img src="{{ asset('img/icons/menu-icon8.svg') }}"
                                                                alt="Product Logo" class="img-fluid">
                                                        </div>
                                                    </div>
                                                    <div class="col-10">
                                                        <div class="company-name">
                                                            <p><b>{{ $leadProduct->product->name ?? 'N/A' }}</b></p>
                                                            <p>{{ $leadProduct->price }} * {{ $leadProduct->qty }}</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="delete-product">
                                                    <button class="btn btn-sm btn-outline-secondary delete-item"
                                                        data-lead="{{ $leads->id }}" data-id="{{ $leadProduct->id }}"
                                                        data-type="product" data-target="product-{{ $leadProduct->id }}">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>

                                            </div>
                                        @endforeach
                                    </div>

                                </div>

                                {{-- Competitors --}}
                                <div class="form-group mb-3" id="competitor-container">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="text-uppercase">
                                            Competitors
                                        </h6>
                                        <div id="toggle-add-competitor" class="text-warning" style="cursor: pointer;">
                                            Add a competitor
                                        </div>
                                    </div>

                                    <div id="add-competitor" class="mb-3 d-none">
                                        <select class="form-select update-field-select" data-type="competitor"
                                            id="urlInput">
                                            <option selected>Add a Competitors</option>
                                            @foreach ($competitors as $competitor)
                                                <option value="{{ $competitor->id }}">
                                                    {{ $competitor->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div id="competitor-list">
                                        @foreach ($leads->leadCompetitors as $leadCompetitor)
                                            <div class="company-list d-flex justify-content-between align-items-center mb-3"
                                                id="competitor-{{ $leadCompetitor->id }}">
                                                <div class="row">
                                                    <div class="col-2">
                                                        <div class="company-icon">
                                                            <img src="{{ asset('img/icons/menu-icon12.svg') }}"
                                                                alt="Competitor Logo" class="img-fluid">
                                                        </div>
                                                    </div>
                                                    <div class="col-10">
                                                        <div class="company-name">
                                                            <p><b>{{ $leadCompetitor->competitor->name ?? 'N/A' }}</b></p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="delete-competitor">
                                                    {{-- <button class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-times"></i>
                                                </button> --}}
                                                    <button class="btn btn-sm btn-outline-secondary delete-item"
                                                        data-lead="{{ $leads->id }}"
                                                        data-id="{{ $leadCompetitor->id }}" data-type="competitor"
                                                        data-target="competitor-{{ $leadCompetitor->id }}">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>

                                            </div>
                                        @endforeach
                                    </div>

                                </div>

                                {{-- Sources --}}
                                <div class="form-group mb-3" id="source-container">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="text-uppercase">
                                            Sources
                                        </h6>
                                        <div id="toggle-add-source" class="text-warning" style="cursor: pointer;">
                                            Add a source
                                        </div>
                                    </div>

                                    <div id="add-source" class="mb-3 d-none">
                                        <select class="form-select update-field-select" data-type="source"
                                            id="urlInput">
                                            <option selected>Add a Source</option>
                                            @foreach ($sources as $source)
                                                <option value="{{ $source->id }}">
                                                    {{ $source->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div id="source-list">
                                        @foreach ($leads->leadSources as $leadSource)
                                            <div class="company-list d-flex justify-content-between align-items-center mb-3"
                                                id="source-{{ $leadSource->id }}">
                                                <div class="row">
                                                    <div class="col-2">
                                                        <div class="company-icon">
                                                            <img src="{{ asset('img/icons/menu-icon13.svg') }}"
                                                                alt="Source Logo" class="img-fluid">
                                                        </div>
                                                    </div>
                                                    <div class="col-10">
                                                        <div class="company-name">
                                                            <p><b>{{ $leadSource->source->name ?? 'N/A' }}</b></p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="delete-source">
                                                    {{-- <button class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-times"></i>
                                                </button> --}}
                                                    <button class="btn btn-sm btn-outline-secondary delete-item"
                                                        data-lead="{{ $leads->id }}" data-id="{{ $leadSource->id }}"
                                                        data-type="source" data-target="source-{{ $leadSource->id }}">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>

                                            </div>
                                        @endforeach
                                    </div>

                                </div>

                                {{-- Quotes --}}
                                <div class="form-group mb-3" id="quote-container">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        {{-- <label for="urlInput" class="form-label text-uppercase">
                                        <b>Quotes</b>
                                    </label> --}}
                                        <h6 class="text-uppercase">
                                            Quotes
                                        </h6>
                                        <div id="add-quote" class="text-warning" style="cursor: pointer;">
                                            Add a quote
                                        </div>
                                    </div>
                                </div>

                                {{-- Attached Files --}}
                                <div class="form-group mb-3">
                                    <label class="form-label"><b>ATTACHED FILES</b> </label>
                                    <button class="btn btn-outline-secondary w-100">
                                        <i class="fas fa-upload me-2"></i>Upload File
                                    </button>
                                </div>

                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- Activities modal --}}
        <div class="modal fade" id="schedule-activity" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title" id="exampleModalLabel">Schedule Activity</h1>
                        <div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                    </div>
                    <div class="modal-body ps-0">

                        <form class="company-form" action="{{ route('admin.activity.store') }}" method="post"
                            id="store_activity">
                            @csrf
                            {{-- Hidden field for storing  company id --}}
                            <input type="hidden" name="leads_id" value="{{ $leads->id }}">

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
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="flexCheckDefault" name="all_day">
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

                                        @foreach ($allpeoples as $allpeople)
                                            <div
                                                class="d-flex align-items-center justify-content-between mb-3 participant-entry">
                                                <div class="d-flex align-items-center">
                                                    {{-- <img src="img/home/profile.png" alt="Paul Blake" class="person-avatar me-3"> --}}
                                                    <div>
                                                        <input type="hidden" name="participant_id[]"
                                                            value="{{ $allpeople->id }}">
                                                        <h6 class="mb-0">{{ $allpeople->name }}</h6>
                                                        <small class="text-warning">{{ $allpeople->email }}</small>
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
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success" id="AddActivity">Create activity</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>


    @endsection

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        {{-- <script>
            document.addEventListener("DOMContentLoaded", function() {

                // common ajax update function
                function updateLead(data, onSuccess) {
                    fetch("{{ route('admin.leads.ajax_update') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify(data)
                        })
                        .then(response => response.json())
                        .then(resp => {
                            if (resp.success) {
                                if (typeof onSuccess === "function") onSuccess();
                            } else {
                                alert("Failed to update lead!");
                            }
                        })
                        .catch(err => console.error(err));
                }

                // Handle flag checkboxes
                document.querySelectorAll(".lead-flag").forEach((flagSelect) => {
                    flagSelect.addEventListener("change", function() {
                        let leadId = this.dataset.leadId;

                        // Collect all checked flags for this lead
                        let checkedFlags = [];
                        document.querySelectorAll('.lead-flag[data-lead-id="' + leadId + '"]:checked')
                            .forEach(cb => checkedFlags.push(cb.value));

                        updateLead({
                                lead_flags: checkedFlags,
                                lead_id: leadId
                            },
                            () => console.log("Lead flags updated to:", checkedFlags)
                        );
                    });
                });

                // status dropdown handler
                let statusSelect = document.getElementById("leadStatusSelect");
                if (statusSelect) {
                    statusSelect.addEventListener("change", function() {
                        let leadId = this.dataset.leadId;
                        let leadStatus = this.value;

                        updateLead({
                                lead_status: leadStatus,
                                lead_id: leadId
                            },
                            () => console.log("Lead status updated to:", leadStatus)
                        );
                    });
                }

            });
        </script> --}}

        <script>
            document.addEventListener("DOMContentLoaded", function() {

                // common ajax update function
                function updateLead(data, onSuccess) {
                    fetch("{{ route('admin.leads.ajax_update') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify(data)
                        })
                        .then(response => response.json())
                        .then(resp => {
                            if (resp.success) {
                                if (typeof onSuccess === "function") onSuccess();
                            } else {
                                Swal.fire("Error", "Failed to update lead!", "error");
                            }
                        })
                        .catch(err => console.error(err));
                }

                // Handle flag checkboxes
                document.querySelectorAll(".lead-flag").forEach((flagSelect) => {
                    flagSelect.addEventListener("change", function() {
                        let leadId = this.dataset.leadId;

                        // Collect all checked flags for this lead
                        let checkedFlags = [];
                        document.querySelectorAll('.lead-flag[data-lead-id="' + leadId + '"]:checked')
                            .forEach(cb => checkedFlags.push(cb.value));

                        updateLead({
                                lead_flags: checkedFlags,
                                lead_id: leadId
                            },
                            () => {
                                Swal.fire({
                                    icon: "success",
                                    title: "Updated!",
                                    text: "Lead flags updated successfully.",
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    location.reload();
                                });
                            }
                        );
                    });
                });

                // status dropdown handler
                let statusSelect = document.getElementById("leadStatusSelect");
                if (statusSelect) {
                    statusSelect.addEventListener("change", function() {
                        let leadId = this.dataset.leadId;
                        let leadStatus = this.value;

                        updateLead({
                                lead_status: leadStatus,
                                lead_id: leadId
                            },
                            () => {
                                Swal.fire({
                                    icon: "success",
                                    title: "Updated!",
                                    text: "Lead status updated successfully.",
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    location.reload();
                                });
                            }
                        );
                    });
                }

            });
        </script>


        <script>
            // Sidebar records delete functionalities
            $(document).on("click", ".delete-item", function(e) {
                e.preventDefault();

                let leadId = $(this).data("lead");
                let relatedId = $(this).data("id");
                let type = $(this).data("type");
                let target = $(this).data("target");

                // Use the new container-list structure
                let container = $(`#${type}-container`);
                let list = container.find(`#${type}-list`);
                let count = list.children().length;

                if (count <= 1) {
                    toastr.warning(`At least one ${type} is required.`);
                    return false;
                }

                Swal.fire({
                    title: 'Are you sure?',
                    text: `This ${type} will be removed from the lead record!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('admin.leads.delete-field') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                lead_id: leadId,
                                related_id: relatedId,
                                type: type
                            },
                            success: function(response) {
                                if (response.success) {
                                    $("#" + target).remove(); // Remove the specific DOM element
                                    toastr.success(response.message);
                                } else {
                                    toastr.error(response.message || "Delete failed.");
                                }
                            },
                            error: function(xhr) {
                                toastr.error("Something went wrong.");
                                console.error(xhr.responseText);
                            }
                        });
                    }
                });
            });


            // Unified update for all select fields
            $(document).on("change", ".update-field-select", function() {
                let relatedId = $(this).val(); // selected item id
                let type = $(this).data("type"); // type: company | people | source | competitor | product
                let leadId = "{{ $leads->id }}"; // current lead

                if (!relatedId) return; // do nothing if no selection

                $.ajax({
                    url: "{{ route('admin.leads.update-field') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        lead_id: leadId,
                        related_id: relatedId,
                        type: type
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Updated!',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => location.reload());
                        } else {
                            toastr.error(response.message || "Failed to update " + type + ".");
                        }
                    },
                    error: function(xhr) {
                        toastr.error("Something went wrong.");
                        console.error(xhr.responseText);
                    }
                });
            });




            const toggleTaskBtn = document.getElementById('toggleAddTask');
            const formTaskDiv = document.getElementById('addTaskForm');

            toggleTaskBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (formTaskDiv.style.display === "none" || formTaskDiv.style.display === "") {
                    formTaskDiv.style.display = "block";
                } else {
                    formTaskDiv.style.display = "none";
                }
            });

            $("#addTaskAjaxForm").validate({
                ignore: [],
                rules: {
                    title: {
                        required: true
                    },
                    due_date: {
                        required: true
                    },
                    user_id: {
                        required: true
                    },
                    description: {
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
                    user_id: {
                        required: "Please select the user."
                    },
                    description: {
                        required: "Please enter the description."
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


            $('#addTaskAjaxForm').submit(function(e) {
                e.preventDefault();

                if (!$('#addTaskAjaxForm').valid()) {
                    return; // Stop if validation fails
                }

                $.ajax({
                    url: "{{ route('admin.tasks.store') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        alert('Task added successfully!');
                        $('#addTaskAjaxForm')[0].reset();
                        console.log(response);
                        location.reload();

                    },
                    error: function(xhr) {
                        alert('Error: ' + xhr.responseText);
                        toastr.error('Something went wrong while adding the task.');
                    }
                });
            });



            // $('.step-menu li').click(function() {
            //     $('.current').removeClass('current')
            //     $('.complete').removeClass('complete')
            //     $(this).addClass('current')
            //     $(this).prevAll().addClass('complete')
            // })


            function scheduleActivity() {
                $('#schedule-activity').modal('show');
            }

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
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        toastr.error('Something went wrong while adding the activity.');
                    }
                });
            });


            $(document).ready(function() {

                $(document).on('click', '.remove-participant', function(e) {
                    e.preventDefault();
                    $(this).closest('.participant-entry').remove();
                });

                // Toggle the Add Person
                $('#toggle-add-person').on('click', function() {
                    $('#add-person').toggleClass('d-none');
                });

                // Toggle the Add company
                $('#toggle-add-company').on('click', function() {
                    $('#add-company').toggleClass('d-none');
                });

                // Toggle the Add Product
                $('#toggle-add-product').on('click', function() {
                    $('#add-product').toggleClass('d-none');
                });

                // Toggle the Add Competitor
                $('#toggle-add-competitor').on('click', function() {
                    $('#add-competitor').toggleClass('d-none');
                });

                // Toggle the Add Source
                $('#toggle-add-source').on('click', function() {
                    $('#add-source').toggleClass('d-none');
                });

            });

            $("#loginActivity").validate({
                ignore: [],
                rules: {
                    title: {
                        required: true
                    },
                    activity_type: {
                        required: true
                    },
                    duration: {
                        required: true
                    },

                },
                messages: {
                    title: {
                        required: "Please enter the title."
                    },
                    activity_type: {
                        required: "Please select the activity."
                    },
                    duration: {
                        required: "Please select the duration."
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


            $('#loginActivity').submit(function(e) {
                e.preventDefault();

                if (!$('#loginActivity').valid()) {
                    return; // Stop if validation fails
                }

                $.ajax({
                    url: "{{ route('admin.login.activity') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        alert('Logged an activity successfully!');
                        $('#loginActivity')[0].reset();
                        console.log(response);
                        location.reload();

                    },
                    error: function(xhr) {
                        alert('Error: ' + xhr.responseText);
                        toastr.error('Something went wrong while logging an activity.');
                    }
                });
            });


            document.addEventListener('DOMContentLoaded', function() {
                const durationSelect = document.getElementById('duration');
                const startInput = document.getElementById('start_time');
                const endInput = document.getElementById('end_time');

                durationSelect.addEventListener('change', function() {
                    const durationMinutes = parseInt(this.value);
                    const now = new Date();

                    const pad = n => String(n).padStart(2, '0');
                    const formatTime = date => `${pad(date.getHours())}:${pad(date.getMinutes())}:00`;

                    const end = new Date(now.getTime() + durationMinutes * 60000);

                    startInput.value = formatTime(now);
                    endInput.value = formatTime(end);
                });

                // Trigger default duration on load (optional)
                durationSelect.dispatchEvent(new Event('change'));
            });
        </script>
    @endpush
