@extends('admin.includes.layout')

@section('title', 'People Details')

@section('content')

    <!-- company details start -->
    <div class="company-details-section">
        <div class="container-fluid">
            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <div class="main-content">
                        <!-- Map Section -->
                        <div class="map-container">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d56430970.783862405!2d-173.4960524!3d30.314748300000012!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8647393108e90293%3A0x2541772067591635!2sValero!5e0!3m2!1sen!2sin!4v1750656614795!5m2!1sen!2sin"
                                width="100%" height="240" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>

                        <!-- Lead Header -->
                        <div class="lead-header">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="d-flex">
                                    <img src="{{ asset('img/home/profile-image.png') }}" alt="Company"
                                        class="company-logo me-3">
                                    <div>
                                        <!-- People Name -->
                                        <div class="d-flex align-items-center mb-2" style="gap: 5px;">
                                            <h4 class="mb-1 editable-field" contenteditable="true" spellcheck="false"
                                                id="people-update-name" data-people-id="{{ $peoples->id }}">
                                                {{ $peoples->name ?? 'N/A' }}
                                            </h4>
                                            <button
                                                class="btn btn-sm btn-outline-success editable-icon editable-submit d-none"
                                                id="people-name-submit" title="Save People Name" data-field="name">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button
                                                class="btn btn-sm btn-outline-danger editable-icon editable-cancel d-none"
                                                id="people-name-cancel" title="Cancel">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>

                                        <!-- People Bio -->
                                        <div class="d-flex align-items-center mb-2" style="gap: 5px;">
                                            <div class="editable-field" contenteditable="true" spellcheck="false"
                                                id="people-update-bio" data-people-id="{{ $peoples->id }}">
                                                {{ $peoples->bio ?? 'N/A' }}
                                            </div>
                                            <button
                                                class="btn btn-sm btn-outline-success editable-icon editable-submit d-none"
                                                id="people-bio-submit" title="Save People Bio" data-field="bio">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button
                                                class="btn btn-sm btn-outline-danger editable-icon editable-cancel d-none"
                                                id="people-bio-cancel" title="Cancel">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>

                                        <div class="star-rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star star-empty"></i>
                                            <i class="fas fa-star star-empty"></i>
                                        </div>
                                    </div>
                                </div>
                                <button class="delete-btn">
                                    <i class="fas fa-trash me-2"></i>DELETE
                                </button>
                            </div>
                            <div class="mt-3">
                                <small class="text-muted">Created by <span
                                        class="text-warning">{{ $peoples->user->name }}</span>
                                    {{ $peoples->created_at->diffForHumans() }}</small>
                            </div>
                            <div class="mt-3">
                                @foreach ($peoples->tags as $tag)
                                    <span class="badge-customer mx-1 px-2">
                                        {{ $tag->name }}
                                        <button type="button" class="btn btn-sm delete-tag-btn"
                                            data-id="{{ $tag->id }}">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </span>
                                @endforeach
                            </div>

                            <div class="mt-4" id="addCompanyTag">
                                <select class="form-select d-inline-block w-100 tag-update"
                                    aria-label="Default select example" id="tagSelect">
                                    <option value="">Add tags...</option>
                                    @foreach ($persontags as $persontag)
                                        <option value="{{ $persontag->id }}">{{ $persontag->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- People Section -->
                        <div class="section-card">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5>Companies</h5>
                                <a href="javascript:void(0);" class="text-warning" id="toggleAddCompany">Add A Company</a>
                            </div>

                            @foreach ($peoples->companiesAlt as $company)
                                <div class="people-card mb-3">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('img/home/companyimages1.png') }}" alt="{{ $company->name }}"
                                            class="person-avatar me-3">
                                        <div>
                                            <h6 class="mb-0">{{ $company->name ?? 'N/A' }}</h6>
                                            <small class="text-warning">{{ $company->description ?? 'N/A' }}</small>
                                        </div>
                                    </div>

                                    <div class="d-flex gap-3 align-items-center mt-2">
                                        <div class="text-end">
                                            <div>{{ $company->companyPhone->phone ?? 'N/A' }}</div>
                                            <div class="text-muted">{{ $company->companyAddress->address ?? 'N/A' }}</div>
                                        </div>

                                        {{-- <button class="btn btn-sm btn-outline-secondary"
                                            onclick="deleteCompany({{ $company->id }})">
                                            <i class="fas fa-times"></i>
                                        </button> --}}
                                        <button class="btn btn-sm btn-outline-secondary remove-company-btn"
                                            data-company-id="{{ $company->id }}" data-people-id="{{ $peoples->id }}">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach


                            <!-- Slide Toggle Form -->
                            <div id="addCompanyForm" class="mt-3" style="display: none;">
                                <div class="mb-3">
                                    <select class="form-select company-update" data-field="" id="companiesSelect">
                                        <option selected>Add Company</option>
                                        @foreach ($availableCompanies as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>


                        <!-- Tasks Section -->
                        <div class="section-card">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5>TASKS</h5>
                                <a class="text-warning" href="javascript:void(0);" id="toggleAddTask">Add A Task</a>
                            </div>

                            @foreach ($completed_tasks as $task)
                                <div class="task-section mt-2">
                                    <div class="company-list mb-3 border rounded p-3">
                                        <div class="row align-items-start">
                                            <div class="col-md-6">
                                                <div class="company-name">
                                                    <p><strong>{{ $task->title ?? 'N/A' }}</strong></p>
                                                    <p class="text-secondary">
                                                        Completed On
                                                        {{ \Carbon\Carbon::parse($task->completed_time)->format('M d, \a\t g:i a') }}
                                                    </p>
                                                    <p class="text-warning">By {{ $task->completed_user_name ?? 'N/A' }}
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="col-md-6 d-flex justify-content-end">
                                                <div class="d-flex gap-2">
                                                    <!-- Reopen -->
                                                    <button class="btn btn-sm btn-outline-warning reopen-task-btn"
                                                        title="Reopen Task" data-id="{{ $task->id }}">
                                                        <i class="fas fa-undo"></i>
                                                    </button>

                                                    <!-- Delete -->
                                                    <button class="btn btn-sm btn-outline-secondary delete-task-btn"
                                                        title="Delete Task" data-id="{{ $task->id }}">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach

                            @foreach ($pending_tasks as $task)
                                <div class="task-section mt-2">
                                    <div class="company-list mb-3 border rounded p-3">
                                        <div class="row align-items-start">
                                            <div class="col-md-6">
                                                <div class="company-name">
                                                    <p><strong>{{ $task->title ?? 'N/A' }}</strong></p>
                                                    <p class="text-secondary">
                                                        Due
                                                        {{ \Carbon\Carbon::parse($task->due_time)->format('M d, \a\t g:i a') }}
                                                    </p>
                                                    <p class="text-warning">{{ $task->assignee_name ?? 'N/A' }}</p>
                                                </div>
                                            </div>

                                            <div class="col-md-6 d-flex justify-content-end">
                                                <div class="d-flex gap-2">
                                                    <!-- Completed -->
                                                    <button class="btn btn-sm btn-outline-success mark-complete-btn"
                                                        title="Mark as Completed" data-id="{{ $task->id }}">
                                                        <i class="fas fa-check"></i>
                                                    </button>

                                                    <!-- Edit -->
                                                    <button class="btn btn-sm btn-outline-primary toggleEditTask"
                                                        data-id="{{ $task->id }}" data-title="{{ $task->title }}"
                                                        data-due="{{ $task->due_time }}"
                                                        data-user="{{ $task->assignee_id }}"
                                                        data-description="{{ $task->description }}" title="Edit Task">
                                                        <i class="fas fa-edit"></i>
                                                    </button>


                                                    <!-- Delete -->
                                                    <button class="btn btn-sm btn-outline-secondary delete-task-btn"
                                                        title="Delete Task" data-id="{{ $task->id }}">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-2">
                                            <div class="col-12">
                                                <div class="email-preview border rounded p-3 text-secondary">
                                                    {{ $task->description ?? 'N/A' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

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
                        <div id="addTaskForm" class="my-3" style="display: none;">

                            <form id="addTaskAjaxForm" action="{{ route('admin.people.tasks.store', $peoples->id) }}"
                                method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <input type="text" name="title" class="form-control"id="title"
                                                placeholder="Add a Task" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <input type="text" name="due_date" id="due_date" class="form-control"
                                                placeholder="Select due date" required>
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
                                            <textarea rows="3" placeholder="Include any description you need to help complete this task…"
                                                name="description" class="form-control"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-warning btn-sm">Add
                                            Task</button>
                                    </div>
                                </div>
                            </form>

                        </div>


                        <div id="EditTaskForm" class="my-3" style="display: none;">

                            <form id="editTaskAjaxForm" action="" method="POST">
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
                                            <input type="text" name="due_date" id="due_date" class="form-control"
                                                placeholder="Select due date" required>
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
                                            <textarea rows="3" placeholder="Include any description you need to help complete this task…"
                                                name="description" class="form-control"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-warning btn-sm">Update
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

                            @foreach ($scheduled_activities as $scheduled_activity)
                                <div class="task-section mt-2">
                                    <div class="company-list mb-3 border rounded p-3">
                                        <div class="row align-items-start">
                                            <div class="col-md-8">
                                                <div class="company-name mt-1">
                                                    <p><strong>{{ $scheduled_activity->activityType->type ?? 'N/A' }}</strong>
                                                    </p>
                                                    <p class="text-secondary mt-1">
                                                        {{ \Carbon\Carbon::parse($scheduled_activity->date . ' ' . $scheduled_activity->end_time)->format('M j, g:i A') }}
                                                    </p>
                                                    <div class="mt-1">
                                                        <span class="fw-bold">
                                                            {{ $scheduled_activity->creator->name ?? 'N/A' }}
                                                        </span>
                                                        -
                                                        <span class="text-muted">
                                                            {{ $scheduled_activity->participant_names ?? 'N/A' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4 d-flex justify-content-end">
                                                <div class="d-flex gap-2">
                                                    <!-- Completed -->
                                                    <button class="btn btn-sm btn-outline-success log-activity-btn"
                                                        title="Mark as Completed"
                                                        data-id="{{ $scheduled_activity->id }}">
                                                        Log Activity
                                                    </button>

                                                    <!-- Delete -->
                                                    <button class="btn btn-sm btn-outline-secondary delete-activity-btn"
                                                        title="Delete Task" data-id="{{ $scheduled_activity->id }}">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-2">
                                            <div class="col-12">
                                                <div class="email-preview border rounded p-3 text-secondary">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <div class="activity-description">
                                                                <div class="text-muted mb-2">
                                                                    <span><i
                                                                            class="fas fa-pen-to-square text-primary me-1"></i></span>
                                                                    {{ $scheduled_activity->note ?? 'N/A' }}
                                                                </div>
                                                                <div class="text-muted">
                                                                    <span><i
                                                                            class="fas fa-file-alt text-warning me-1"></i></span>
                                                                    {{ $scheduled_activity->description ?? 'N/A' }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

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
                                        data-owner-type="People" data-owner-id="{{ $peoples->id }}"
                                        data-status="Logged" id="loginActivity">
                                        @csrf

                                        <textarea id="activity-note" name="note" class="form-textarea w-100"
                                            placeholder="Log what happened in your activity… @Mention other users to grab their attention, or reference other companies, people, or users."></textarea>

                                        <!-- Related Leads of this entity -->
                                        @foreach ($related_leads as $related_lead)
                                            <input type="hidden" name="leads_ids[]" value="{{ $related_lead->id }}">
                                        @endforeach

                                        <!-- hidden fields populated before submit -->
                                        <input type="hidden" name="mentioned_company_ids" id="mentioned_company_ids"
                                            value="">
                                        <input type="hidden" name="mentioned_people_ids" id="mentioned_people_ids"
                                            value="">
                                        <input type="hidden" name="mentioned_user_ids" id="mentioned_user_ids"
                                            value="">
                                        <input type="hidden" name="note_value" id="note_value" value="">


                                        <div class="form-row">
                                            <div class="activity-form-group">
                                                <label class="form-label">PARTICIPANTS</label>
                                                <select id="activity_participant_select" name="participant_id[]"
                                                    class="form-select-custom" multiple>
                                                    {{-- Companies --}}
                                                    <optgroup label="Companies">
                                                        @foreach ($companies as $company)
                                                            <option value="{{ $company->id }}"
                                                                data-entity-type="company">
                                                                {{ $company->name }}
                                                            </option>
                                                        @endforeach

                                                    </optgroup>

                                                    {{-- Peoples --}}
                                                    <optgroup label="Peoples">
                                                        @foreach ($allpeoples as $p)
                                                            <option value="{{ $p->id }}" data-entity-type="people"
                                                                {{ $p->id == $peoples->id ? 'selected' : '' }}>
                                                                {{ $p->name }}
                                                            </option>
                                                        @endforeach
                                                    </optgroup>

                                                    {{-- Users --}}
                                                    <optgroup label="Users">
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}" data-entity-type="user">
                                                                {{ $user->name }}
                                                            </option>
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                            </div>

                                            <div class="activity-form-group">
                                                <label class="form-label">DESCRIPTION</label>
                                                <input type="text" style="width: 380px;"
                                                    placeholder="Add an agenda to share with your attendees..."
                                                    class="form-select-custom" name="description" />
                                            </div>

                                        </div>

                                        <div class="form-row">
                                            <div class="activity-form-group">
                                                <label class="form-label">ACTIVITY</label>
                                                <select class="form-select-custom" name="activity_type">
                                                    <option value="">-- Select --</option>
                                                    @foreach ($activity_types as $activity_type)
                                                        <option value="{{ $activity_type->id }}">
                                                            {{ $activity_type->type }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="activity-form-group">
                                                <label class="form-label">DURATION</label>
                                                <input type="hidden" name="start_time" id="start_time">
                                                <input type="hidden" name="end_time" id="end_time">

                                                <select class="form-select-custom" name="duration" id="duration">
                                                    <option value="">-- Select --</option>
                                                    <option value="15">15 Min</option>
                                                    <option value="30">30 Min</option>
                                                    <option value="60">1 Hour</option>
                                                    <option value="120">2 Hours</option>
                                                </select>
                                            </div>

                                            <div class="activity-form-group">
                                                <label class="form-label">DATE</label>
                                                <input type="date" name="date" id="date"
                                                    class="activity-date">
                                            </div>

                                            <div class="activity-form-group">
                                                <label class="form-label">LOCATION</label>
                                                <input type="text" placeholder="Add a Location"
                                                    class="form-select-custom" name="location" />
                                            </div>

                                        </div>

                                        <div class="my-4">
                                            <button type="submit" class="btn-login">LOGIN ACTIVITY</button>
                                        </div>

                                    </form>

                                </div>

                                <!-- Note Tab -->
                                {{-- <div class="tab-pane fade activity-form" id="write-note-content" role="tabpanel"
                                    aria-labelledby="note-tab">
                                    <textarea class="form-textarea w-100" placeholder="Write your note here..." rows="6"></textarea>
                                    <div class="form-row">
                                        <button class="btn-login">SAVE NOTE</button>
                                    </div>
                                </div> --}}

                                <div class="tab-pane fade activity-form" id="write-note-content" role="tabpanel"
                                    aria-labelledby="note-tab">

                                    <form action="{{ route('admin.add.note') }}" method="POST" data-owner-type="People"
                                        data-owner-id="{{ $peoples->id }}" id="logNoteForm">
                                        @csrf

                                        <textarea id="note-textarea" name="note" class="form-textarea w-100"
                                            placeholder="Write a note… @Mention other users to grab their attention, or reference other companies and people."
                                            rows="6"></textarea>

                                        <!-- Hidden fields for mentioned entities -->
                                        <input type="hidden" name="mentioned_company_ids"
                                            id="note_mentioned_company_ids" value="">
                                        <input type="hidden" name="mentioned_people_ids" id="note_mentioned_people_ids"
                                            value="">
                                        <input type="hidden" name="mentioned_user_ids" id="note_mentioned_user_ids"
                                            value="">

                                        <!-- Hidden field to store processed note content -->
                                        <input type="hidden" name="note_value" id="note_value" value="">

                                        <div class="form-row mt-4">
                                            <button type="submit" class="btn-login">SAVE NOTE</button>
                                        </div>
                                    </form>
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

                                    <!-- Note Timeline Item -->
                                    {{-- <div class="timeline-item">
                                        <div class="timeline-icon note">
                                            <i class="fa-regular fa-note-sticky"></i>
                                        </div>
                                        <div class="timeline-content">
                                            <button class="close-button"
                                                onclick="this.closest('.timeline-item').style.display='none'">×</button>
                                            <div class="timeline-header">
                                                <div class="timestamp">11:30 PM on Jan 14</div>
                                            </div>
                                            <div class="timeline-body">
                                                <a href="#" class="author-link">Rodney Madsen</a> wrote a note
                                                on <span class="organization">Community Health Centers of
                                                    Lubbock</span>
                                                <div class="question-text">
                                                    Brennan Baxter: What is the status of this lead?
                                                </div>
                                                <div class="nested-response">
                                                    <div class="response-header">
                                                        <div class="response-author">
                                                            <div class="response-avatar">BB</div>
                                                            <div class="response-name">
                                                                <h4>Brennan Baxter</h4>
                                                                <p>I will follow up with lead tomorrow. Chance
                                                                    had reached
                                                                    out to Stephanie about doing a site survey.
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="response-time">4 Months Ago</div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}

                                    {{-- Activities List --}}
                                    {{-- @foreach ($activities as $activity)
                                        <div class="timeline-item">
                                            <div class="timeline-icon">
                                                <i class="{{ $activity->activityType->icon }}"></i>
                                            </div>
                                            <div class="timeline-content">
                                                <div class="timeline-header">
                                                    <div class="timestamp">
                                                        {{ \Carbon\Carbon::parse($activity->created_at)->format('g:i A \o\n M j, Y') }}
                                                    </div>
                                                </div>

                                                <div class="timeline-body">
                                                    <div class="row align-items-center">
                                                        <!-- Text section (col-8) -->
                                                        <div class="col-8">
                                                            <p class="mb-0">
                                                                <span class="author-link">
                                                                    {{ $activity->creator->name ?? 'N/A' }}
                                                                </span>
                                                                logged an activity with
                                                                <span class="organization">
                                                                    {{ $activity->participant_names }}
                                                                </span>
                                                            </p>
                                                        </div>

                                                        <!-- Buttons section (col-4) -->
                                                        <div class="col-4 text-end">
                                                            <button class="btn btn-sm btn-outline-primary me-1"
                                                                title="Add Comment" data-id="">
                                                                <i class="fas fa-comment"></i>
                                                            </button>
                                                            <button class="btn btn-sm btn-outline-danger"
                                                                title="Delete Activity" data-id="">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </div>
                                                    </div>


                                                    <div class="activity-details">
                                                        <div class="row">
                                                            <div class="col-10">
                                                                <div class="activity-label mb-0">
                                                                    {{ $activity->activityType->type ?? 'N/A' }}</div>
                                                                <div class="activity-description">
                                                                    <div class="text-muted mb-2">
                                                                        <span><i class="fas fa-pen-to-square text-primary me-1"></i></span>
                                                                        {{ $activity->note }}
                                                                    </div>
                                                                    <div class="text-muted">
                                                                        <span><i class="fas fa-file-alt text-warning me-1"></i></span>
                                                                        {{ $activity->description }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-2">
                                                                <div class="activity-badges">
                                                                    <span class="activity-badge badge-cc">JB</span>
                                                                    <span class="activity-badge badge-cc">TC</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="comment-box">
                                                        <span class="comment-avatar">BB</span>
                                                        <span class="comment-text">I will follow up with lead
                                                            tomorrow. Chance had reached out to Stephanie about
                                                            doing a site survey.</span>
                                                    </div>

                                                </div>


                                            </div>
                                        </div>
                                    @endforeach --}}

                                    @foreach ($timeline as $item)
                                        @if ($item->type === 'activity')
                                            <div class="timeline-item">
                                                <div class="timeline-icon">
                                                    <i class="{{ $item->activityType->icon }}"></i>
                                                </div>
                                                <div class="timeline-content">
                                                    <div class="timeline-header">
                                                        <div class="timestamp">
                                                            {{-- {{ \Carbon\Carbon::parse($item->created_at)->format('g:i A \o\n M j, Y') }} --}}
                                                            {{ \Carbon\Carbon::parse($item->end_time)->format('g:i A') ?? 'N/A' }}
                                                            on {{ \Carbon\Carbon::parse($item->date)->format('M j, Y') }}

                                                        </div>
                                                    </div>

                                                    <div class="timeline-body">
                                                        <div class="row align-items-center">
                                                            <div class="col-8">
                                                                <p class="mb-0">
                                                                    <span class="author-link">
                                                                        {{ $item->creator->name ?? 'N/A' }}
                                                                    </span>
                                                                    logged an activity with
                                                                    <span class="organization">
                                                                        {{ $item->participant_names }}
                                                                    </span>
                                                                </p>
                                                            </div>

                                                            <div class="col-4 text-end">
                                                                <button
                                                                    class="btn btn-sm btn-outline-primary me-1 add-comment-btn"
                                                                    title="Add Comment" data-type="Activity"
                                                                    data-id="{{ $item->id }}">
                                                                    <i class="fas fa-comment"></i>
                                                                </button>
                                                                <button
                                                                    class="btn btn-sm btn-outline-danger delete-activity-btn"
                                                                    title="Delete Activity" data-type="Activity"
                                                                    data-id="{{ $item->id }}">
                                                                    <i class="fas fa-times"></i>
                                                                </button>
                                                            </div>
                                                        </div>


                                                        <div class="activity-details">
                                                            <div class="row">
                                                                <div class="col-10">
                                                                    <div class="activity-label mb-0">
                                                                        {{ $item->activityType->type ?? 'N/A' }}</div>
                                                                    <div class="activity-description">
                                                                        <div class="text-muted mb-2">
                                                                            <span><i
                                                                                    class="fas fa-pen-to-square text-primary me-1"></i></span>
                                                                            {{ $item->note }}
                                                                        </div>
                                                                        <div class="text-muted">
                                                                            <span><i
                                                                                    class="fas fa-file-alt text-warning me-1"></i></span>
                                                                            {{ $item->description }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-2">
                                                                    <div class="activity-badges">
                                                                        <span class="activity-badge badge-cc">JB</span>
                                                                        <span class="activity-badge badge-cc">TC</span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        @if ($item->comments->isNotEmpty())
                                                            <div class="comment-box d-flex flex-column">
                                                                @foreach ($item->comments as $comment)
                                                                    <div
                                                                        class="d-flex justify-content-between align-items-center mb-2">
                                                                        <div>
                                                                            <span class="comment-avatar">
                                                                                {{ strtoupper(substr($comment->creator->name ?? 'N/A', 0, 2)) }}
                                                                            </span>
                                                                            <span
                                                                                class="comment-text">{{ $comment->comment }}</span>
                                                                        </div>
                                                                        <span class="btn btn-sm delete-comment-btn"
                                                                            data-id="{{ $comment->id }}"
                                                                            data-type="Activity">
                                                                            <i class="fas fa-times"></i>
                                                                        </span>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endif

                                                        <div class="mt-3 d-none add-comment"
                                                            data-id="{{ $item->id }}" data-type="Activity">
                                                            <textarea id="activity-comment-textarea" name="comment_text" class="form-textarea"
                                                                placeholder="Write a comment…"data-tribute="true" style="width:100%"></textarea>

                                                            <button
                                                                class="mt-3 btn btn-sm btn-outline-success add-comment-submit"
                                                                title="">
                                                                Add Comment
                                                            </button>
                                                            <button
                                                                class="mt-3 btn btn-sm btn-outline-danger comment-cancel"
                                                                title="Close">
                                                                Close
                                                            </button>
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                        @elseif ($item->type === 'note')
                                            <div class="timeline-item">
                                                <div class="timeline-icon">
                                                    <i class="fas fa-sticky-note"></i>
                                                </div>
                                                <div class="timeline-content">
                                                    <div class="timeline-header">
                                                        <div class="timestamp">
                                                            {{ \Carbon\Carbon::parse($item->created_at)->format('g:i A \o\n M j, Y') }}
                                                        </div>
                                                    </div>

                                                    <div class="timeline-body">
                                                        <div class="row align-items-center">
                                                            <div class="col-8">
                                                                <p class="mb-0">
                                                                    <span class="author-link">
                                                                        {{ $item->creator->name ?? 'N/A' }}
                                                                    </span>
                                                                    wrote a note on
                                                                    <span class="organization">
                                                                        {{ $item->owner->name }}
                                                                    </span>
                                                                </p>
                                                            </div>

                                                            <div class="col-4 text-end">
                                                                <button
                                                                    class="btn btn-sm btn-outline-primary me-1 add-comment-btn"
                                                                    title="Add Comment" data-type="Note"
                                                                    data-id="{{ $item->id }}">
                                                                    <i class="fas fa-comment"></i>
                                                                </button>
                                                                <button
                                                                    class="btn btn-sm btn-outline-danger delete-note-btn"
                                                                    title="Delete Note" data-type="Note"
                                                                    data-id="{{ $item->id }}">
                                                                    <i class="fas fa-times"></i>
                                                                </button>
                                                            </div>
                                                        </div>


                                                        <div class="activity-details">
                                                            <div class="row">
                                                                <div class="col-10">
                                                                    <div class="activity-description">
                                                                        <div class="text-muted mb-2">
                                                                            <span><i
                                                                                    class="fas fa-pen-to-square text-primary me-1"></i></span>
                                                                            {{ $item->note }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-2">
                                                                    <div class="activity-badges">
                                                                        <span class="activity-badge badge-cc">JB</span>
                                                                        <span class="activity-badge badge-cc">TC</span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        @if ($item->comments->isNotEmpty())
                                                            <div class="comment-box d-flex flex-column">
                                                                @foreach ($item->comments as $comment)
                                                                    <div
                                                                        class="d-flex justify-content-between align-items-center mb-2">
                                                                        <div>
                                                                            <span class="comment-avatar">
                                                                                {{ strtoupper(substr($comment->creator->name ?? 'N/A', 0, 2)) }}
                                                                            </span>
                                                                            <span
                                                                                class="comment-text">{{ $comment->comment }}</span>
                                                                        </div>
                                                                        <span class="btn btn-sm delete-comment-btn"
                                                                            data-id="{{ $comment->id }}"
                                                                            data-type="Activity">
                                                                            <i class="fas fa-times"></i>
                                                                        </span>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endif


                                                        <div class="mt-3 d-none add-comment"
                                                            data-id="{{ $item->id }}" data-type="Note">
                                                            <textarea id="note-comment-textarea" name="comment_text" class="form-textarea"
                                                                placeholder="Write a comment…"data-tribute="true" style="width:100%"></textarea>

                                                            <button
                                                                class="mt-3 btn btn-sm btn-outline-success add-comment-submit"
                                                                title="">
                                                                Add Comment
                                                            </button>
                                                            <button
                                                                class="mt-3 btn btn-sm btn-outline-danger comment-cancel"
                                                                title="Close">
                                                                Close
                                                            </button>
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                        @endif
                                    @endforeach


                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <div class="sidebar">
                        <div class="sidebar-section">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6>LEADS</h6>
                                <a href="javascript:void(0)" onclick="addLead()" class="text-warning">Create a lead</a>
                            </div>
                            <div class="lead-carder" onclick="relatedLeads()">
                                <div class="row text-center">
                                    <div class="col-3">
                                        <div class="metric-value">${{ $formattedLeadsCount }}</div>
                                    </div>
                                    <div class="col-3">
                                        <div class="metric-value won">{{ $wonLeadsCount }} Won</div>
                                    </div>
                                    <div class="col-3">
                                        <div class="metric-value">{{ $lostLeadsCount }} Lost</div>
                                    </div>
                                    <div class="col-3">
                                        <div class="metric-value lost">{{ $hotLeadsCount }} Hot</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="sidebar-section">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6>KEEP IN TOUCH</h6>
                                <a href="#" class="text-warning">Remind me to follow up</a>
                            </div>
                            <p class="small text-muted">Last Contacted 3 Years Ago<br>
                                You've Never Contacted This Company</p>
                        </div>
                        <div id="people-details-container" data-people-id="{{ $peoples->id }}">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6>PEOPLE DETAILS</h6>
                                {{-- <button class="btn btn-outline-secondary btn-sm">Update</button> --}}
                            </div>
                            <div class="form-group mb-3">
                                <label for="assigneeSelect" class="form-label"><b>ASSIGNEE</b> </label>
                                <select class="form-select people-update" data-field="user_id" data-field-name="Assingee"
                                    id="assigneeSelect">
                                    <option selected>Select assignee</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ $peoples->user_id == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="territorySelect" class="form-label"><b>TERRITORY</b> </label>
                                <select class="form-select people-update" data-field="territory_id"
                                    data-field-name="Territory" id="territorySelect">
                                    <option selected>Select territory</option>
                                    @foreach ($territories as $territory)
                                        <option value="{{ $territory->id }}"
                                            {{ $peoples->territory_id == $territory->id ? 'selected' : '' }}>
                                            {{ $territory->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <hr>

                        {{-- Add Email Option --}}
                        <div class="sidebar-section" id="email">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="form-label">EMAIL</h6>
                                <div class="text-warning small toggle-inline-email" style="cursor: pointer;">
                                    Add/Update Email
                                </div>
                            </div>

                            <div class="col-12 inline-detail-input">
                                <div class="row g-2" id="email-list">
                                    @forelse($emails as $email)
                                        <div class="col-12 mb-2">
                                            <div class="row g-2">
                                                <!-- Type Selector -->
                                                <div class="col-md-4">
                                                    <select name="detail_type[]" class="form-control" disabled>
                                                        @foreach ($emailTypes as $field => $label)
                                                            <option value="{{ $field }}"
                                                                {{ $email['selected'] === $field ? 'selected' : '' }}>
                                                                {{ $label }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Value Input -->
                                                <div class="col-md-8 d-flex gap-3 align-items-center">
                                                    <input type="text" name="detail_value[]" class="form-control"
                                                        value="{{ $email['value'] }}" placeholder="Enter email"
                                                        disabled>
                                                    <button class="btn btn-sm btn-outline-secondary delete-field-btn"
                                                        data-people-id="{{ $peoples->id }}"
                                                        data-type="{{ $email['selected'] }}" data-field-name="email"
                                                        {{ $email['selected'] === 'email' ? 'disabled' : '' }}>
                                                        <i class="fas fa-times"></i>
                                                    </button>


                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="small m-2">N/A</p>
                                    @endforelse
                                </div>
                            </div>

                            <div class="col-12 inline-detail-email" style="display: none;"
                                data-people-id="{{ $peoples->id }}">
                                <div class="row g-2">
                                    <!-- Type Selector -->
                                    <div class="col-md-4">
                                        <select name="detail_type" class="form-select" id="new-email-type">
                                            <option value="email">Email</option>
                                            <option value="personal_email">Personal Email</option>
                                            <option value="support_email">Support Email</option>
                                        </select>
                                    </div>

                                    <!-- Value Input -->
                                    <div class="col-md-8">
                                        <input type="text" name="detail_value" class="form-control"
                                            id="new-email-value" placeholder="Enter email">
                                    </div>

                                    <!-- Buttons -->
                                    <div class="d-flex justify-content-end align-items-center mt-2" style="gap: 10px;">
                                        <button class="btn btn-sm btn-outline-success editable-icon" id="email-submit"
                                            title="Save Email">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger editable-icon" id="email-cancel"
                                            title="Cancel">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>



                        </div>

                        <hr>

                        {{-- Add Address Option --}}
                        <div class="sidebar-section" id="address">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="form-label">ADDRESS</h6>
                                <div class="text-warning small toggle-inline-address" style="cursor: pointer;">
                                    Add/Update Address
                                </div>
                            </div>

                            <div class="col-12 inline-detail-input">
                                <div class="row g-2" id="address-list">
                                    @forelse($addresses as $address)
                                        <div class="col-12 mb-2">
                                            <div class="row g-2">
                                                <!-- Type Selector -->
                                                <div class="col-md-4">
                                                    <select name="address_type[]" class="form-control" disabled>
                                                        @foreach ($addressTypes as $field => $label)
                                                            <option value="{{ $field }}"
                                                                {{ $address['selected'] === $field ? 'selected' : '' }}>
                                                                {{ $label }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Value Input -->
                                                <div class="col-md-8 d-flex gap-3 align-items-center">
                                                    <input type="text" name="address_value[]" class="form-control"
                                                        value="{{ $address['value'] }}" placeholder="Enter address"
                                                        disabled>
                                                    <button class="btn btn-sm btn-outline-secondary delete-field-btn"
                                                        data-people-id="{{ $peoples->id }}"
                                                        data-type="{{ $address['selected'] }}" data-field-name="address"
                                                        {{ $address['selected'] === 'address' ? 'disabled' : '' }}>
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="small m-2">N/A</p>
                                    @endforelse
                                </div>
                            </div>

                            <div class="col-12 inline-detail-address" style="display: none;"
                                data-people-id="{{ $peoples->id }}">
                                <div class="row g-2">
                                    <!-- Type Selector -->
                                    <div class="col-md-4">
                                        <select name="address_type" class="form-select" id="new-address-type">
                                            <option value="address">Address</option>
                                            <option value="main_address">Main Address</option>
                                            <option value="work_address">Work Address</option>
                                            <option value="home_address">Home Address</option>
                                            <option value="billing_address">Billing Address</option>
                                            <option value="mailing_address">Mailing Address</option>
                                        </select>
                                    </div>

                                    <!-- Value Input -->
                                    <div class="col-md-8">
                                        <input type="text" name="address_value" class="form-control"
                                            id="new-address-value" placeholder="Enter address">
                                    </div>

                                    <!-- Buttons -->
                                    <div class="d-flex justify-content-end align-items-center mt-2" style="gap: 10px;">
                                        <button class="btn btn-sm btn-outline-success editable-icon" id="address-submit"
                                            title="Save Address">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger editable-icon" id="address-cancel"
                                            title="Cancel">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <hr>

                        {{-- Add Phone Option --}}
                        <div class="sidebar-section" id="phone">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="form-label">PHONE</h6>
                                <div class="text-warning small toggle-inline-phone" style="cursor: pointer;">
                                    Add/Update Phone
                                </div>
                            </div>

                            <div class="col-12 inline-detail-input">
                                <div class="row g-2" id="phone-list">
                                    @forelse($phones as $phone)
                                        <div class="col-12 mb-2">
                                            <div class="row g-2">
                                                <!-- Type Selector -->
                                                <div class="col-md-4">
                                                    <select name="phone_type[]" class="form-control" disabled>
                                                        @foreach ($phoneTypes as $field => $label)
                                                            <option value="{{ $field }}"
                                                                {{ $phone['selected'] === $field ? 'selected' : '' }}>
                                                                {{ $label }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Value Input -->
                                                <div class="col-md-8 d-flex gap-3 align-items-center">
                                                    <input type="text" name="phone_value[]" class="form-control"
                                                        value="{{ $phone['value'] }}" placeholder="Enter phone number"
                                                        disabled>
                                                    <button class="btn btn-sm btn-outline-secondary delete-field-btn"
                                                        data-people-id="{{ $peoples->id }}"
                                                        data-type="{{ $phone['selected'] }}" data-field-name="phone"
                                                        {{ $phone['selected'] === 'phone' ? 'disabled' : '' }}>
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="small m-2">N/A</p>
                                    @endforelse
                                </div>
                            </div>

                            <div class="col-12 inline-detail-phone" style="display: none;"
                                data-people-id="{{ $peoples->id }}">
                                <div class="row g-2">
                                    <!-- Type Selector -->
                                    <div class="col-md-4">
                                        <select name="phone_type" class="form-select" id="new-phone-type">
                                            <option value="phone">Phone</option>
                                            <option value="home_phones">Home Phone</option>
                                            <option value="mobile_phones">Mobile Phone</option>
                                            <option value="work_phones">Work Phone</option>
                                            <option value="fax_phones">Fax Phone</option>
                                        </select>
                                    </div>

                                    <!-- Value Input -->
                                    <div class="col-md-8">
                                        <input type="text" name="phone_value" class="form-control"
                                            id="new-phone-value" placeholder="Enter phone number">
                                    </div>

                                    <!-- Buttons -->
                                    <div class="d-flex justify-content-end align-items-center mt-2" style="gap: 10px;">
                                        <button class="btn btn-sm btn-outline-success editable-icon" id="phone-submit"
                                            title="Save Phone">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger editable-icon" id="phone-cancel"
                                            title="Cancel">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <hr>

                        {{-- Add URL Option --}}
                        <div class="sidebar-section" id="url">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="form-label">URL</h6>
                                <div class="text-warning small toggle-inline-url" style="cursor: pointer;">
                                    Add/Update URL
                                </div>
                            </div>

                            <div class="col-12 inline-detail-input">
                                <div class="row g-2" id="url-list">
                                    @forelse($urls as $url)
                                        <div class="col-12 mb-2">
                                            <div class="row g-2">
                                                <!-- Type Selector -->
                                                <div class="col-md-4">
                                                    <select name="url_type[]" class="form-control" disabled>
                                                        @foreach ($urlTypes as $field => $label)
                                                            <option value="{{ $field }}"
                                                                {{ $url['selected'] === $field ? 'selected' : '' }}>
                                                                {{ $label }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Value Input -->
                                                <div class="col-md-8 d-flex gap-3 align-items-center">
                                                    <input type="text" name="url_value[]" class="form-control"
                                                        value="{{ $url['value'] }}" placeholder="Enter URL" disabled>
                                                    <button class="btn btn-sm btn-outline-secondary delete-field-btn"
                                                        data-people-id="{{ $peoples->id }}"
                                                        data-type="{{ $url['selected'] }}" data-field-name="url"
                                                        {{ $url['selected'] === 'url' ? 'disabled' : '' }}>
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="small m-2">N/A</p>
                                    @endforelse
                                </div>
                            </div>

                            <div class="col-12 inline-detail-url" style="display: none;"
                                data-people-id="{{ $peoples->id }}">
                                <div class="row g-2">
                                    <!-- Type Selector -->
                                    <div class="col-md-4">
                                        <select name="url_type" class="form-select" id="new-url-type">
                                            <option value="url">URL</option>
                                            <option value="blog_url">Blog URL</option>
                                            <option value="twitter_url">Twitter URL</option>
                                        </select>
                                    </div>

                                    <!-- Value Input -->
                                    <div class="col-md-8">
                                        <input type="text" name="url_value" class="form-control" id="new-url-value"
                                            placeholder="Enter URL">
                                    </div>

                                    <!-- Buttons -->
                                    <div class="d-flex justify-content-end align-items-center mt-2" style="gap: 10px;">
                                        <button class="btn btn-sm btn-outline-success editable-icon" id="url-submit"
                                            title="Save Url">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger editable-icon" id="url-cancel"
                                            title="Cancel">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <hr>

                        <div class="sidebar-section">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6>AUDIENCES</h6>
                                <div>
                                    <p><a href="#" class="text-warning">Add to audience</a></p>
                                </div>
                            </div>
                            <p class="small">isn’t in any audiences</p>
                            <p class="small">Unsubscribe from all future outreach</p>
                        </div>
                        <hr>
                        <div class="sidebar-section">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6>EMAIL ENGAGEMENT</h6>
                                {{-- <div>
                                    <p><a href="javascript:void(0)" onclick="addLead()" class="text-warning">Create a
                                            lead</a></p>
                                </div> --}}
                            </div>
                            <div class="row engagement-card">
                                <div class="col-6">
                                    <p class="small">Emails sent: 0</p>
                                    <p class="small">Open rate:-0%</p>
                                </div>
                                <div class="col-6">
                                    <p class="small">Click rate: 0</p>
                                    <p class="small">Reply rate:-0%</p>
                                </div>
                            </div>
                        </div>
                        <hr>
                        {{-- <form class="url-form" id="urlForm">
                            <div class="form-group mb-3">
                                <label for="urlInput" class="form-label"><b>URLS</b> </label>
                                <input type="text" class="form-control" id="urlInput"
                                    placeholder="https://example.com">
                            </div>
                        </form> --}}
                        <div class="sidebar-section">
                            <h6 class="form-label">ATTACHED FILES</h6>
                            <button class="btn btn-outline-secondary w-100">
                                <i class="fas fa-upload me-2"></i>Upload File
                            </button>
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
                        <a href="#" class="link-decoration">Customize fields</a>
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
                                    {{-- <select name="company_id[]" id="companySelect" class="form-select">
                                        @foreach ($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select> --}}
                                    <select name="company_id[]" id="companySelect" class="form-select" multiple>
                                        <option value="">Choose Company</option>
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
                                    <select id="person_select" name="person_id[]" class="form-select" multiple>
                                        <option value="">-- Select Person --</option>
                                        @foreach ($allpeoples as $allpeople)
                                            <option value="{{ $allpeople->id }}"
                                                {{ $allpeople->id == $peoples->id ? 'selected' : '' }}>
                                                {{ $allpeople->name }}
                                                ({{ $allpeople->peopleEmail->email }})
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
                                        @foreach ($persontags as $persontag)
                                            <option value="{{ $persontag->id }}">{{ $persontag->name }}</option>
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

    {{-- Activities modal --}}
    <div class="modal fade" id="schedule-activity" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="exampleModalLabel">Schedule Activity</h1>
                    <div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
                <div class="modal-body ps-0">


                    <form class="company-form" action="{{ route('admin.schedule.activity') }}" method="post"
                        data-owner-type="People" data-owner-id="{{ $peoples->id }}" data-status="Scheduled"
                        id="store_activity">
                        @csrf

                        <div class="row mx-0">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Note</label>
                                    <textarea id="schedule-note-textarea" name="note" class="form-control w-100"
                                        placeholder="Write a note… @Mention other users to grab their attention, or reference other companies and people."
                                        rows="6"></textarea>

                                    <!-- Related Leads of this entity -->
                                    @foreach ($related_leads as $related_lead)
                                        <input type="hidden" name="leads_ids[]" value="{{ $related_lead->id }}">
                                    @endforeach

                                    <!-- Hidden fields for mentioned entities -->
                                    <input type="hidden" name="mentioned_company_ids"
                                        id="schedule_mentioned_company_ids" value="">
                                    <input type="hidden" name="mentioned_people_ids"
                                        id="schedule_mentioned_people_ids" value="">
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
                                    <input type="date" placeholder="" class="form-control" name="date" />
                                </div>
                            </div>

                            <div class="col-lg-6 mt-2">
                                <div class="form-group">
                                    <label class="form-label">Start Time</label>
                                    <select class="form-select select2" id="start_time" name="start_time" required>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 mt-2">
                                <div class="form-group">
                                    <label class="form-label">End Time</label>
                                    <select class="form-select select2" id="end_time" name="end_time" required>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12 mt-2">
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
                                    <label class="form-label">Participants</label>
                                    <select id="participant_select" name="participant_id[]" class="form-select mt-2"
                                        multiple>
                                        {{-- Companies --}}
                                        <optgroup label="Companies">
                                            @foreach ($companies as $c)
                                                <option value="{{ $c->id }}" data-entity-type="company">
                                                    {{ $c->name }}
                                                </option>
                                            @endforeach
                                        </optgroup>

                                        {{-- Peoples --}}
                                        <optgroup label="Peoples">
                                            @foreach ($allpeoples as $allpeople)
                                                <option value="{{ $allpeople->id }}" data-entity-type="people"
                                                    {{ $allpeople->id == $peoples->id ? 'selected' : '' }}>
                                                    {{ $allpeople->name }}
                                                </option>
                                            @endforeach
                                        </optgroup>

                                        {{-- Users --}}
                                        <optgroup label="Users">
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}" data-entity-type="user">
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success" id="AddActivity">Create activity</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Leads List modal --}}
    <div class="modal fade" id="related-leads-list" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="exampleModalLabel">Related Leads</h1>
                    <div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                </div>
                <div class="modal-body ps-0">

                    <div class="sidebar-section">

                        {{-- Leads List --}}
                        @foreach ($related_leads as $related_lead)
                            <div class="company-list d-flex justify-content-between align-items-center mb-3"
                                id="">
                                <div class="row">
                                    <div class="col-2">
                                        <div class="company-icon">
                                            <img src="{{ $related_lead->status_icon }}" alt="Lead Status">
                                        </div>
                                    </div>
                                    <div class="col-10">
                                        <div class="company-name">
                                            <p title="Lead Name">
                                                <a href="{{ route('admin.leads.show', $related_lead->id) }}">
                                                    <strong>{{ $related_lead->name }}</strong>
                                                </a>
                                            </p>
                                            <p title="Assignee">{{ $related_lead->assignee->name }}</p>
                                            @foreach ($related_lead->companies as $leadcompanies)
                                                <p class="text-primary" title="Related Company">
                                                    {{ $leadcompanies->name }}</p>
                                            @endforeach
                                            @foreach ($related_lead->peoples as $leadpeoples)
                                                <p class="text-warning" title="Related People">
                                                    {{ $leadpeoples->name }}</p>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div title="Total Value">
                                    ${{ \App\Helpers\Helper::calculateTotalValue($related_lead) }}
                                </div>
                            </div>
                        @endforeach


                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // ==============================
        // Modal Show for lead and activity
        // ==============================
        function addLead() {
            $('#AddLead').modal('show');
        }

        function scheduleActivity() {
            $('#schedule-activity').modal('show');
        }

        function relatedLeads() {
            $('#related-leads-list').modal('show');
        }

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            // ==============================
            // Activity and note Comment box toggle functionality
            // ==============================
            $('.add-comment-btn').click(function() {
                // Find the nearest comment box relative to this button
                $(this).closest('.timeline-item').find('.add-comment').toggleClass('d-none');
            });

            $('.comment-cancel').click(function() {
                const $commentBox = $(this).closest('.add-comment');
                $commentBox.addClass('d-none');
                $commentBox.find('textarea').val(''); // Clear the textarea content
            });

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

            // ==============================
            // Show/Hide icons beside editable fields
            // ==============================
            $('.editable-field').on('focus', function() {
                $(this).siblings('.editable-icon').removeClass('d-none');
            });

            $('.editable-field').on('blur', function() {
                let $icons = $(this).siblings('.editable-icon');
                setTimeout(() => {
                    $icons.addClass('d-none');
                }, 300);
            });

            // ==============================
            // Update people details(name and description) on change
            // ==============================
            $('.editable-submit').click(function() {
                let $button = $(this);
                let $field = $button.siblings('.editable-field');
                let peopleId = $field.data('people-id');
                let fieldName = $button.data('field'); // e.g., 'name' or 'description'
                let newValue = $field.text().trim();

                Swal.fire({
                    title: 'Are you sure?',
                    text: `Do you want to update the ${fieldName}?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#dc3545',
                    confirmButtonText: 'Yes, update'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.post(`/admin/people/${peopleId}/update-detail`, {
                                _token: '{{ csrf_token() }}',
                                field: fieldName,
                                value: newValue
                            })
                            .done(response => {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Updated',
                                    text: response.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            })
                            .fail(xhr => {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: xhr.responseJSON?.message ||
                                        'Something went wrong.'
                                });
                                console.error(xhr.responseText);
                            });
                    }
                });
            });

            // Cancel button hides sibling buttons
            $('.editable-cancel').click(function() {
                $(this).siblings('.editable-icon').addClass('d-none');
            });

            // ==============================
            // Adding tags to the company
            // ==============================
            $('#tagSelect').change(function() {
                let tagId = $(this).val();
                let tagName = $("#tagSelect option:selected").text();

                if (!tagId) {
                    return; // ignore placeholder
                }

                Swal.fire({
                    title: "Are you sure?",
                    text: "Do you want to add the tag \"" + tagName + "\" to this person?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#28a745",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, Add"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/admin/people/{{ $peoples->id }}/tags/add", // ✅ new route for tags
                            method: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                tag_id: tagId
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Added",
                                    text: response.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    location.reload();
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: "error",
                                    title: "Error",
                                    text: xhr.responseJSON?.message ||
                                        "Something went wrong."
                                });
                            }
                        });
                    } else {
                        // Reset dropdown back to default if cancelled
                        $('#tagSelect').val("");
                    }
                });
            });

            // ==============================
            // Removing the tag from the company
            // ==============================
            $(document).on('click', '.delete-tag-btn', function() {
                var tagId = $(this).data('id');

                Swal.fire({
                    title: "Are you sure?",
                    text: "Do you want to remove this tag from the person?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, Remove"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/admin/people/{{ $peoples->id }}/tags/" + tagId +
                                "/remove",
                            method: "POST",
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Removed",
                                    text: response.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    location
                                        .reload(); // reload to update tag list
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: "error",
                                    title: "Error",
                                    text: xhr.responseJSON?.message ||
                                        "Something went wrong."
                                });
                                console.error(xhr.responseText);
                            }
                        });
                    }
                });
            });


            // ==============================
            // Toggle Add company and task
            // ==============================
            const toggleTaskBtn = document.getElementById('toggleAddTask');
            const formTaskDiv = document.getElementById('addTaskForm');

            const toggleBtn = document.getElementById('toggleAddCompany');
            const formDiv = document.getElementById('addCompanyForm');

            toggleBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (formDiv.style.display === "none" || formDiv.style.display === "") {
                    formDiv.style.display = "block";
                } else {
                    formDiv.style.display = "none";
                }
            });

            toggleTaskBtn.addEventListener('click', function(e) {
                e.preventDefault();

                if (formTaskDiv.style.display === "none" || formTaskDiv.style.display === "") {
                    formTaskDiv.style.display = "block";

                    // Reset form
                    const form = formTaskDiv.querySelector('form');
                    form.reset();

                    // Reset form action back to store route
                    form.setAttribute('action', "{{ route('admin.people.tasks.store', $peoples->id) }}");

                    // Reset button text and style
                    const submitBtn = form.querySelector('button[type="submit"]');
                    submitBtn.textContent = "Add Task";
                    submitBtn.classList.remove('btn-primary');
                    submitBtn.classList.add('btn-warning');

                } else {
                    formTaskDiv.style.display = "none";
                }
            });


            // ==============================
            // Adding company to people
            // ==============================
            $('#companiesSelect').change(function() {
                let companyId = $(this).val();
                let companyName = $("#companiesSelect option:selected").text();

                if (!companyId || companyId === "Add Company") {
                    return; // ignore placeholder
                }

                Swal.fire({
                    title: "Are you sure?",
                    text: "Do you want to add " + companyName + " to this person?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#28a745",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, Add"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/admin/people/{{ $peoples->id }}/company/add", // ✅ route
                            method: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                company_id: companyId
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Added",
                                    text: response.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    location.reload();
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: "error",
                                    title: "Error",
                                    text: xhr.responseJSON?.message ||
                                        "Something went wrong."
                                });
                            }
                        });
                    } else {
                        // Reset dropdown back to default if cancelled
                        $('#companiesSelect').val("Add Company");
                    }
                });
            });


            // ==============================
            // Remove person from the company
            // ==============================
            $(document).on('click', '.remove-company-btn', function() {
                let companyId = $(this).data('company-id');
                let peopleId = $(this).data('people-id');
                let $btn = $(this);

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This company will be removed from the person.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: 'Yes, remove'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/people/${peopleId}/remove-company`,
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                company_id: companyId
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Removed',
                                    text: response.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                                location.reload(); // keep the flow same as others
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: xhr.responseJSON?.message ||
                                        'Something went wrong.'
                                });
                            }
                        });
                    }
                });
            });


            // ==============================
            // Add Task ajax form validation and submittion
            // ==============================
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
                    return;
                }

                let form = $(this);
                let actionUrl = form.attr('action');
                let method = form.attr('method');
                let formData = form.serialize();

                $.ajax({
                    url: actionUrl,
                    method: method,
                    data: formData,
                    success: function(response) {
                        console.log('Task Added successfully:', response);
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            location.reload(); // reload after popup closes
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseText ||
                                'Something went wrong while adding the task.'
                        });
                        console.error(xhr.responseText);
                    }
                });
            });


            // ==============================
            // Mark Complete Task
            // ==============================
            $(document).on('click', '.mark-complete-btn', function() {
                var taskId = $(this).data('id'); // get task ID from button

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to mark this task as completed?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, complete it!',
                    cancelButtonText: 'Cancel'
                }).then(function(result) {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/admin/people/tasks/' + taskId + '/complete',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Completed',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 2000
                                }).then(function() {
                                    location
                                        .reload(); // reload after completion
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: xhr.responseJSON?.message ||
                                        'Something went wrong while marking the task completed.'
                                });
                                console.error(xhr.responseText);
                            }
                        });
                    }
                });
            });


            // ==============================
            // Reopen Task
            // ==============================
            $(document).on('click', '.reopen-task-btn', function() {
                var taskId = $(this).data('id'); // get task ID from button

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to re-open this task?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ffc107',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, re-open it!',
                    cancelButtonText: 'Cancel'
                }).then(function(result) {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/admin/people/tasks/' + taskId + '/reopen',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Re-open',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 2000
                                }).then(function() {
                                    location.reload(); // refresh task state
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: xhr.responseJSON?.message ||
                                        'Something went wrong while reopening this task.'
                                });
                                console.error(xhr.responseText);
                            }
                        });
                    }
                });
            });

            // ==============================
            // Delete Task
            // ==============================
            $(document).on('click', '.delete-task-btn', function() {
                var taskId = $(this).data('id'); // get task ID from button

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to undo this action!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then(function(result) {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/admin/people/tasks/delete/" + task_id,
                            method: "POST",
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: response.message ||
                                        "Task deleted successfully.",
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(function() {
                                    location.reload(); // reload after deletion
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: xhr.responseJSON?.message ||
                                        'Something went wrong.'
                                });
                                console.error(xhr.responseText);
                            }
                        });
                    }
                });
            });

            // ==============================
            // Toggle Edit Task Form
            // ==============================
            $('.toggleEditTask').click(function() {
                var taskId = $(this).data('id');

                // Get data from button
                var title = $(this).data('title');
                var due = $(this).data('due');
                var userId = $(this).data('user');
                var description = $(this).data('description');

                $('#addTaskForm').toggle();

                // Fill the form
                $('#addTaskForm #title').val(title);
                $('#addTaskForm #due_date').val(due);
                $('#addTaskForm select[name="user_id"]').val(userId);
                $('#addTaskForm textarea[name="description"]').val(description);

                $('#addTaskAjaxForm').attr('method', 'PUT');
                // Change form action for update (FIX: point to update route)
                $('#addTaskAjaxForm').attr('action', '/admin/people/tasks/' + taskId + '/update');

                // Optional: Change button text to "Update Task"
                $('#addTaskAjaxForm button[type="submit"]').text('Update Task');

            });

            // ==============================
            // Flatpickr for Task Due Date
            // ==============================
            flatpickr("#due_date", {
                enableTime: true,
                dateFormat: "Y-m-d h:i K", // h = 12-hour, K = AM/PM
                minDate: "today",
                defaultDate: new Date().setHours(18, 30, 0, 0), // today at 6:30 PM
                time_24hr: false
            });

            // ==============================
            // Lead & Activities Form - Select2 Integration
            // ==============================
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

            $('#schedule-activity').on('shown.bs.modal', function() {
                $('#participant_select').select2({
                    dropdownParent: $('#schedule-activity'),
                    placeholder: 'Choose...',
                    allowClear: true
                });
            });

            $('#activity_participant_select').select2({
                placeholder: '-- Select --',
                allowClear: true,
                width: '450px' // make it fit the parent width
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
                    alert('At least one product row is required.');
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

            // Submit Lead form
            $('#add-lead-form').submit(function(e) {
                e.preventDefault();

                if (!$('#add-lead-form').valid()) {
                    return;
                }

                $.ajax({
                    url: '{{ route('admin.leads.store') }}',
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

            // ==============================
            // Updating of person fields in sidebar - logic
            // ==============================
            // Store previous value when element gains focus
            $(document).on('focus', '.people-update', function() {
                $(this).data('prev', $(this).val());
            });

            // Handle selects (only on change)
            $(document).on('change', 'select.people-update', function() {
                let prev = $(this).data('prev');
                let current = $(this).val();
                if (prev === current) return;

                updatePeopleField($(this));
            });

            // AJAX function
            function updatePeopleField($el) {
                let peopleId = $('#people-details-container').data('people-id');
                let field = $el.data('field');
                let value = $el.val();
                let fieldName = $el.data('field-name') || field; // optional friendly name

                // Show confirmation dialog first
                Swal.fire({
                    title: 'Are you sure?',
                    text: `This ${fieldName} will be updated!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6', // blue
                    cancelButtonColor: '#d33', // red
                    confirmButtonText: 'Yes, update it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Perform AJAX update
                        $.ajax({
                            url: `/admin/peoples/${peopleId}/update-field`,
                            type: 'POST',
                            data: {
                                field: field,
                                value: value
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message || 'Successfully Updated',
                                    showConfirmButton: false,
                                    timer: 2000
                                }).then(() => {
                                    location.reload();
                                });
                            },
                            error: function(xhr) {
                                console.error(xhr.responseText);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Update failed',
                                    showConfirmButton: true
                                });
                            }
                        });
                    }
                });
            }




            // ==============================
            // Toggle email, address, phone, and url , and cancel buttons
            // ==============================
            $('.toggle-inline-email').on('click', function() {
                $('.inline-detail-email').toggle(); // smooth animation
            });

            $('.toggle-inline-address').on('click', function() {
                $('.inline-detail-address').toggle(); // smooth animation
            });

            $('.toggle-inline-phone').on('click', function() {
                $('.inline-detail-phone').toggle(); // smooth animation
            });

            $('.toggle-inline-url').on('click', function() {
                $('.inline-detail-url').toggle(); // smooth animation
            });

            // Email Cancel Buttons
            $('#email-cancel').on('click', function() {
                // Hide input section
                $('.inline-detail-email').hide();

                // Reset fields
                $('.inline-detail-email select[name="detail_type"]').prop('selectedIndex', 0);
                $('.inline-detail-email input[name="detail_value"]').val('');

            });

            // Address Cancel Buttons
            $('#address-cancel').on('click', function() {
                // Hide input section
                $('.inline-detail-address').hide();

                // Reset fields
                $('.inline-detail-address select[name="address_type"]').prop('selectedIndex', 0);
                $('.inline-detail-address input[name="address_value"]').val('');

            });

            // Phone Cancel Buttons
            $('#phone-cancel').on('click', function() {
                // Hide input section
                $('.inline-detail-phone').hide();

                // Reset fields
                $('.inline-detail-phone select[name="phone_type"]').prop('selectedIndex', 0);
                $('.inline-detail-phone input[name="phone_value"]').val('');

            });

            // Url Cancel Buttons
            $('#url-cancel').on('click', function() {
                // Hide input section
                $('.inline-detail-url').hide();

                // Reset fields
                $('.inline-detail-url select[name="url_type"]').prop('selectedIndex', 0);
                $('.inline-detail-url input[name="url_value"]').val('');

            });


            // ==============================
            // Updating and inserting email, address, phone and url to company
            // ==============================
            function handleUpdateClick(buttonSelector, containerClass, category, token) {
                $(buttonSelector).on('click', function() {
                    let container = $(this).closest(containerClass);
                    let peopleId = container.data('people-id');
                    let type = container.find('[id^="new-"][id$="-type"]').val();
                    let value = container.find('[id^="new-"][id$="-value"]').val();

                    $.ajax({
                        url: "{{ route('admin.update.people.field') }}",
                        type: "POST",
                        data: {
                            _token: token,
                            people_id: peopleId,
                            category: category,
                            type: type,
                            value: value
                        },
                        success: function(res) {
                            console.log(category + ' updated successfully:', res);
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: res.message,
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => location.reload());
                        },
                        error: function(xhr) {
                            console.error('AJAX Error:', xhr.status, xhr.statusText);
                            try {
                                let response = JSON.parse(xhr.responseText);
                                alert('Error: ' + (response.message || 'Failed to save.'));
                            } catch {
                                alert('Failed to save. Check console for details.');
                            }
                        }
                    });
                });
            }

            // Calls for each category
            handleUpdateClick('#email-submit', '.inline-detail-email', 'email', "{{ csrf_token() }}");
            handleUpdateClick('#address-submit', '.inline-detail-address', 'address', "{{ csrf_token() }}");
            handleUpdateClick('#phone-submit', '.inline-detail-phone', 'phone', "{{ csrf_token() }}");
            handleUpdateClick('#url-submit', '.inline-detail-url', 'url', "{{ csrf_token() }}");

            // ==============================
            // Delete email, address, phone and url of company
            // ==============================
            $(document).on('click', '.delete-field-btn', function() {
                let peopleId = $(this).data('people-id');
                let type = $(this).data('type');
                let fieldName = $(this).data('field-name');

                let list = $(`#${fieldName}-list`);
                let count = list.children().length;

                if (count <= 1) {
                    toastr.warning(`At least one ${fieldName} is required.`);
                    return false;
                }

                Swal.fire({
                    title: 'Are you sure?',
                    text: `This ${fieldName} will be removed from the people record!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('admin.peoples.delete-field') }}",
                            type: 'POST',
                            data: {
                                people_id: peopleId,
                                type: type,
                                field_name: fieldName,
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                toastr.success(response.message);
                                location.reload();
                            },
                            error: function(xhr) {
                                toastr.error(`Failed to delete ${fieldName}.`);
                                console.error(xhr.responseText);
                            }
                        });
                    }
                });
            });


            // ==============================
            // Schedule activity validation and submition logic
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


            $("#loginActivity").validate({
                ignore: [],
                rules: {
                    note: { // textarea
                        required: true
                    },
                    description: { // text input
                        required: true
                    },
                    'participant_id[]': {
                        required: true,
                        minlength: 1
                    },
                    activity_type: {
                        required: true
                    },
                    duration: {
                        required: true
                    },
                    date: {
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
                    description: {
                        required: "Please enter the description."
                    },
                    'participant_id[]': {
                        required: "Please select at least one participant.",
                        minlength: "Please select at least one participant."
                    },
                    activity_type: {
                        required: "Please select the activity."
                    },
                    duration: {
                        required: "Please select the duration."
                    },
                    date: {
                        required: "Please select the date."
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


            $('#loginActivity').submit(function(e) {
                e.preventDefault();

                var form = $(this);

                if (!form.valid()) return;

                // Get owner type and id from data attributes
                var ownerType = form.data('owner-type');
                var ownerId = form.data('owner-id');
                var status = form.data('status');

                // Collect selected participants with their entity types
                var selectedParticipants = $('#activity_participant_select option:selected').map(
                    function() {
                        return {
                            id: $(this).val(),
                            type: $(this).data('entity-type')
                        };
                    }).get();

                // Append them to serialized data
                var formData = form.serializeArray();
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

                $.ajax({
                    url: "{{ route('admin.login.activity') }}",
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
                        toastr.error('Something went wrong while logging an activity.');
                    }
                });
            });

            // ==============================
            // Log the scheduled Activity
            // ==============================
            $(document).on('click', '.log-activity-btn', function() {
                var activityId = $(this).data('id'); // Get the activity ID

                Swal.fire({
                    title: 'Mark as Logged?',
                    text: "Do you want to log this activity?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, log it!'
                }).then(function(result) {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/admin/log_activity/" + activityId,
                            method: "POST",
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Activity Logged!',
                                    text: response.message ||
                                        'Activity has been marked as logged.',
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(function() {
                                    location
                                        .reload(); // Reload to reflect the updated status
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: xhr.responseJSON?.message ||
                                        'Something went wrong while logging the activity.'
                                });
                                console.error(xhr.responseText);
                            }
                        });
                    }
                });
            });

            // ==============================
            // Delete Activity
            // ==============================

            $(document).on('click', '.delete-activity-btn', function() {
                var activityId = $(this).data('id'); // get task ID from button

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to delete this activity?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then(function(result) {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/admin/delete_activity/" + activityId,
                            method: "POST",
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: response.message ||
                                        "Activity deleted successfully.",
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(function() {
                                    location.reload(); // reload after deletion
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: xhr.responseJSON?.message ||
                                        'Something went wrong.'
                                });
                                console.error(xhr.responseText);
                            }
                        });
                    }
                });
            });

            // ==============================
            // Adding the comment
            // ==============================
            $(document).on('click', '.add-comment-submit', function() {
                let commentBox = $(this).closest('.add-comment');
                let type = commentBox.data('type'); // Activity or Note
                let id = commentBox.data('id'); // Item ID
                let commentText = commentBox.find('textarea[name="comment_text"]').val();

                if (!commentText.trim()) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Empty Comment',
                        text: 'Please enter a comment before submitting.'
                    });
                    return;
                }

                // Determine URL based on type (like delete)
                let url = '';
                if (type === 'Activity') {
                    url = '/admin/activity/add_comment/' + id;
                } else {
                    url = '/admin/note/add_comment/' + id;
                }

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        comment: commentText
                    },
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
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message ||
                                'Something went wrong while adding the comment.'
                        });
                    }
                });
            });


            // ==============================
            // Removing the comment
            // ==============================
            $(document).on('click', '.delete-comment-btn', function() {
                var commentId = $(this).data('id');
                var type = $(this).data('type'); // Activity or Note
                var url = '';

                // Determine URL based on type
                if (type === "Activity") {
                    url = "/admin/activity/delete_comment/" + commentId;
                } else {
                    url = "/admin/note/delete_comment/" + commentId;
                }

                Swal.fire({
                    title: "Are you sure?",
                    text: "Do you want to remove this comment?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, Remove"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            method: "POST",
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Removed",
                                    text: response.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    location
                                        .reload(); // reload to update comment list
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: "error",
                                    title: "Error",
                                    text: xhr.responseJSON?.message ||
                                        "Something went wrong."
                                });
                                console.error(xhr.responseText);
                            }
                        });
                    }
                });
            });


            // Log Note Form
            $("#logNoteForm").validate({
                ignore: [],
                rules: {
                    note: { // textarea
                        required: true
                    }
                },
                messages: {
                    note: {
                        required: "Please enter some note details before saving."
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

            $('#logNoteForm').submit(function(e) {
                e.preventDefault();

                var form = $(this);

                if (!form.valid()) return;

                // Get owner type and id
                var ownerType = form.data('owner-type');
                var ownerId = form.data('owner-id');

                // Serialize form data
                var formData = form.serializeArray();

                // Append owner details
                formData.push({
                    name: 'owner_type',
                    value: ownerType
                });
                formData.push({
                    name: 'owner_id',
                    value: ownerId
                });

                $.ajax({
                    url: "{{ route('admin.add.note') }}",
                    method: "POST",
                    data: $.param(formData),
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message || 'Note added successfully!',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => location.reload());
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        toastr.error('Something went wrong while saving the note.');
                    }
                });
            });

            // Delete Note
            $(document).on('click', '.delete-note-btn', function() {
                var noteId = $(this).data('id'); // get task ID from button

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to delete this note?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then(function(result) {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/admin/note_activity/" + noteId,
                            method: "POST",
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: response.message ||
                                        "Note deleted successfully.",
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(function() {
                                    location.reload(); // reload after deletion
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: xhr.responseJSON?.message ||
                                        'Something went wrong.'
                                });
                                console.error(xhr.responseText);
                            }
                        });
                    }
                });
            });

            const durationSelect = document.getElementById('duration');
            const startInput = document.getElementById('start_time');
            const endInput = document.getElementById('end_time');

            if (durationSelect && startInput && endInput) {
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
            }


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
                    @if (!$loop->last || count($allpeoples) > 0 || count($users) > 0)
                        ,
                    @endif
                @endforeach

                @foreach ($allpeoples as $person)
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
                'activity-note',
                'mentioned_company_ids',
                'mentioned_people_ids',
                'mentioned_user_ids',
                'note_value'
            );

            // --- Initialize for Note ---
            initTribute(
                'note-textarea',
                'note_mentioned_company_ids',
                'note_mentioned_people_ids',
                'note_mentioned_user_ids',
                'note_value'
            );

        });
    </script>
@endpush
