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

                                            <!-- Lead Name -->
                                            <div class="d-flex align-items-center mb-2" style="gap: 5px;">
                                                <h1 class="mb-1 editable-field" contenteditable="true" spellcheck="false"
                                                    id="lead-update-name" data-lead-id="{{ $leads->id }}">
                                                    {{ $leads->name ?? 'N/A' }}
                                                </h1>
                                                <button
                                                    class="btn btn-sm btn-outline-success editable-icon editable-submit d-none"
                                                    id="lead-name-submit" title="Save Lead Name" data-field="name">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button
                                                    class="btn btn-sm btn-outline-danger editable-icon editable-cancel d-none"
                                                    id="lead-name-cancel" title="Cancel">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>

                                        </div>
                                        <div class="project-id">#{{ $leads->id }}</div>

                                        <div class="mt-3">
                                            <div class="d-flex justify-content-left align-items-center flex-wrap">
                                                @foreach ($leads->tags as $tag)
                                                    <span class="badge-customer mx-1 px-2">
                                                        {{ $tag->name }}
                                                        <button type="button" class="btn btn-sm delete-tag-btn"
                                                            data-id="{{ $tag->id }}">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>

                                    </div>
                                    <div class="amount">${{ $formattedLeadValue }}</div>
                                </div>

                                <div class="mt-4 my-3" id="addLeadTag">
                                    <select class="form-select d-inline-block w-100 tag-update"
                                        aria-label="Default select example" id="tagSelect">
                                        <option value="">Add tags...</option>
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
                                    <div class="pipeline-title d-none">Stage Tasks</div>
                                    <a href="#" class="d-none text-warning">Edit processes</a>
                                </div>

                                <div id="initial-meeting-stage" class="{{ $leads->stage_id == 1 ? '' : 'd-none' }}">
                                    <div class="task-section mt-2">
                                        <div class="company-list mb-3 border rounded p-3">
                                            <div class="row align-items-start">
                                                <div class="col-md-8">
                                                    <div class="company-name">
                                                        <p><strong>Initial Meeting</strong></p>
                                                        <p class="text-secondary">
                                                            Completed On Aug 27, 2025 7:00 AM
                                                            <span class="text-warning">
                                                                By Jordan Barboza
                                                            </span>
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 d-flex justify-content-end">
                                                    <div class="d-flex gap-2">
                                                        <!-- Completed -->
                                                        {{-- <button class="btn btn-sm btn-outline-success"
                                                            onclick="markCompleted()" title="Mark as Completed">
                                                            <i class="fas fa-check"></i>
                                                        </button> --}}

                                                        {{-- Reopen --}}
                                                        {{-- <button class="btn btn-sm btn-outline-warning"
                                                            onclick="reopenTask()" title="Reopen Task">
                                                            <i class="fas fa-undo"></i>
                                                        </button> --}}

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="timeline-container" style="font-size: small">
                                                <div class="timeline-content p-3 mb-3">
                                                    This is the first step in the process. During this meeting you should
                                                    talk
                                                    to the client about their organization and its needs. You should explain
                                                    what GermBlast is using the company keynote presentation. <br><br>
                                                    YOU SHOULD CLOSE FOR A SITE SURVEY AT THE VERY LEAST.
                                                </div>
                                                <div class="timeline-content p-3">
                                                    You must have a person attached to the lead to complete this step.
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div id="site-survey-stage" class="{{ $leads->stage_id == 2 ? '' : 'd-none' }}">
                                    {{-- Sales Forecasting --}}
                                    <div class="task-section mt-2">
                                        <div class="company-list mb-3 border rounded p-3">
                                            <div class="row align-items-start">
                                                <div class="col-md-8">
                                                    <div class="company-name">
                                                        <p><strong>Sales Forecasting</strong></p>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 d-flex justify-content-end">
                                                    <div class="d-flex gap-2">
                                                        <a class="text-warning" href="javascript:void(0);"
                                                            onclick="addForecasting()">
                                                            Add Forecasting</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Survey & Proposal --}}
                                    <div class="task-section mt-2">
                                        <div class="company-list mb-3 border rounded p-3">
                                            <div class="row align-items-start">
                                                <div class="col-md-8">
                                                    <div class="company-name">
                                                        <p><strong>Survey & Proposal</strong></p>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 d-flex justify-content-end">
                                                    <div class="d-flex gap-2">
                                                        <a class="text-warning" href="{{ route('admin.leads.survey.proposal', $leads->id) }}"
                                                            target="_blank" id="toggleAddProposal">Add Proposal</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="task-section mt-2">
                                        <div class="company-list mb-3 border rounded p-3">
                                            <div class="row align-items-start">
                                                <div class="col-md-8">
                                                    <div class="company-name">
                                                        <p><strong>Perform Site Survey</strong></p>
                                                        <p class="text-secondary">
                                                            Completed On Aug 27, 2025 7:00 AM
                                                            <span class="text-warning">
                                                                By Jordan Barboza
                                                            </span>
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 d-flex justify-content-end">
                                                    <div class="d-flex gap-2">
                                                        {{-- Buttons --}}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="timeline-container" style="font-size: small">
                                                <div class="timeline-content p-3">
                                                    You must have a logged activity attached to the lead to complete this
                                                    step.
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>


                                <div id="present-proposal-stage" class="{{ $leads->stage_id == 4 ? '' : 'd-none' }}">
                                    <div class="task-section mt-2">
                                        <div class="company-list mb-3 border rounded p-3">
                                            <div class="row align-items-start">
                                                <div class="col-md-8">
                                                    <div class="company-name">
                                                        <p><strong>Present Proposal</strong></p>
                                                        <p class="text-secondary">
                                                            Completed On Aug 27, 2025 7:00 AM
                                                            <span class="text-warning">
                                                                By Jordan Barboza
                                                            </span>
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 d-flex justify-content-end">
                                                    <div class="d-flex gap-2">
                                                        <!-- Completed -->
                                                        {{-- <button class="btn btn-sm btn-outline-success"
                                                            onclick="markCompleted()" title="Mark as Completed">
                                                            <i class="fas fa-check"></i>
                                                        </button> --}}

                                                        {{-- Reopen --}}
                                                        {{-- <button class="btn btn-sm btn-outline-warning"
                                                            onclick="reopenTask()" title="Reopen Task">
                                                            <i class="fas fa-undo"></i>
                                                        </button> --}}

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="timeline-container" style="font-size: small">
                                                <div class="timeline-content p-3 mb-3">
                                                    Present your site survey data collected along with your proposal within
                                                    7
                                                    days of your survey. Address any issues with pricing at this time. Ask
                                                    how
                                                    long they think the decision process may take.
                                                </div>
                                                <div class="timeline-content p-3">
                                                    You must have a product attached to the lead to complete this step.
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="task-section mt-2">
                                        <div class="company-list mb-3 border rounded p-3">
                                            <div class="row align-items-start">
                                                <div class="col-md-8">
                                                    <div class="company-name">
                                                        <p><strong>Follow Up</strong></p>
                                                        <p class="text-secondary">
                                                            Completed On Aug 27, 2025 7:00 AM
                                                            <span class="text-warning">
                                                                By Jordan Barboza
                                                            </span>
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 d-flex justify-content-end">
                                                    <div class="d-flex gap-2">
                                                        <!-- Completed -->
                                                        {{-- <button class="btn btn-sm btn-outline-success"
                                                            onclick="markCompleted()" title="Mark as Completed">
                                                            <i class="fas fa-check"></i>
                                                        </button> --}}

                                                        {{-- Reopen --}}
                                                        <button class="btn btn-sm btn-outline-warning"
                                                            onclick="reopenTask()" title="Reopen Task">
                                                            <i class="fas fa-undo"></i>
                                                        </button>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="timeline-container" style="font-size: small">
                                                <div class="timeline-content p-3">
                                                    Every Sales Representation must have certain skills sets to survive in
                                                    sales. Selling is essential to GermBlast to create a consistent revenue
                                                    stream, however, follow up is essential to maintain a client long-term.
                                                    This will also prevent new market entrants from sneaking in the back
                                                    door without your knowledge.
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div id="signed-proposal-stage" class="{{ $leads->stage_id == 5 ? '' : 'd-none' }}">
                                    <div class="task-section mt-2">
                                        <div class="company-list mb-3 border rounded p-3">
                                            <div class="row align-items-start">
                                                <div class="col-md-8">
                                                    <div class="company-name">
                                                        <p><strong>Provided contract Rodney for Processing</strong></p>
                                                        <p class="text-secondary">
                                                            Completed On Aug 27, 2025 7:00 AM
                                                            <span class="text-warning">
                                                                By Jordan Barboza
                                                            </span>
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 d-flex justify-content-end">
                                                    <div class="d-flex gap-2">
                                                        <!-- Completed -->
                                                        {{-- <button class="btn btn-sm btn-outline-success"
                                                            onclick="markCompleted()" title="Mark as Completed">
                                                            <i class="fas fa-check"></i>
                                                        </button> --}}

                                                        {{-- Reopen --}}
                                                        {{-- <button class="btn btn-sm btn-outline-warning"
                                                            onclick="reopenTask()" title="Reopen Task">
                                                            <i class="fas fa-undo"></i>
                                                        </button> --}}

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Tasks Section -->
                        <div class="section-card">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5>Custom fields</h5>
                                <a href="javascript:void(0);" class="text-warning">Create custom fields</a>
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
                                    <br>
                                    <p class="text-muted mb-0">
                                        Note: User will be redirected to settings > organization > custom fields
                                        to create custom fields.
                                    </p>
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
                                                    <!-- Reopen Task -->
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

                            <form id="addTaskAjaxForm" action="{{ route('admin.leads.tasks.store', $leads->id) }}"
                                method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <input type="text" name="title" class="form-control" id="title"
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
                                        data-owner-type="Lead" data-owner-id="{{ $leads->id }}" data-status="Logged"
                                        id="loginActivity">
                                        @csrf

                                        <textarea id="activity-note" name="note" class="form-textarea w-100"
                                            placeholder="Log what happened in your activity… @Mention other users to grab their attention, or reference other companies, people, or users."></textarea>

                                        <!-- Related Leads of this entity -->
                                        <input type="hidden" name="leads_ids[]" value="{{ $leads->id }}">

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
                                                        @foreach ($allpeoples as $people)
                                                            <option value="{{ $people->id }}"
                                                                data-entity-type="people">
                                                                {{ $people->name }}
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

                                    <form action="{{ route('admin.add.note') }}" method="POST" data-owner-type="Lead"
                                        data-owner-id="{{ $leads->id }}" id="logNoteForm">
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
                                        <select class="form-select dropdown-orange select2" id="filter-range"
                                            data-lead-id="{{ $leads->id }}" name="filter_range">
                                            <option value="all">All Entries</option>
                                            <option value="7">Last 7 Days</option>
                                            <option value="30">Last 30 Days</option>
                                            <option value="90">Last 90 Days</option>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <select class="form-select dropdown-orange select2" id="filter-activity"
                                            data-lead-id="{{ $leads->id }}" name="activity_type_id">
                                            <option value="all">All Activity Type</option>
                                            @foreach ($activity_types as $activity_type)
                                                <option value="{{ $activity_type->id }}">{{ $activity_type->type }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <select class="form-select dropdown-orange select2" id="filter-user"
                                            name="user_id" data-lead-id="{{ $leads->id }}">
                                            <option value="all">All Users</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-auto ms-auto d-none">
                                        <button class="btn btn-warning">
                                            <i class="fa-regular fa-gear"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="timeline-container">
                                <div class="timeline position-relative" id="timeline">
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
                                        @elseif ($item->type === 'timeline')
                                            <div class="timeline-item">
                                                <div class="timeline-icon">
                                                    <i class="fas fa-angle-double-right"></i>
                                                </div>
                                                <div class="timeline-content">
                                                    <div class="timeline-header">
                                                        <div class="timestamp">
                                                            {{ \Carbon\Carbon::parse($item->created_at)->format('g:i A \o\n M j, Y') }}
                                                        </div>
                                                    </div>
                                                    <div class="timeline-body">
                                                        <div class="row align-items-center">
                                                            <div class="col-12">
                                                                <p class="mb-0">
                                                                    <span class="author-link">
                                                                        {{ $item->creator->name ?? 'N/A' }}
                                                                    </span>
                                                                    {{ $item->description ?? 'N/A' }}
                                                                </p>
                                                            </div>
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

                        {{-- Starting of leads-details-container --}}
                        <div id="leads-details-container" data-lead-id="{{ $leads->id }}">
                            <form class="assignee-form" id="assigneeForm" method="post">
                                @csrf

                                {{-- Lead Status --}}
                                <div class="form-group mb-3">
                                    <label for="leadStatusSelect" class="form-label">
                                        <b>LEAD STATUS</b>
                                    </label>
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

                                {{-- Lost outcome wrapper --}}
                                <div class="form-group mb-3 d-none" id="lostOutcomeWrapper">
                                    <label for="lostOutcomeSelect" class="form-label">
                                        <b>OUTCOME</b>
                                    </label>
                                    <select class="form-select" id="lostOutcomeSelect">
                                        <option value="">Select reason</option>
                                        @foreach ($lost_outcomes as $outcome)
                                            <option value="{{ $outcome->id }}"
                                                {{ $leads->outcome_id == $outcome->id && $leads->lead_status == 'lost' ? 'selected' : '' }}>
                                                {{ $outcome->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Cancelled outcome wrapper --}}
                                <div class="form-group mb-3 d-none" id="cancelledOutcomeWrapper">
                                    <label for="cancelledOutcomeSelect" class="form-label">
                                        <b>OUTCOME</b>
                                    </label>
                                    <select class="form-select" id="cancelledOutcomeSelect">
                                        <option value="">Select reason</option>
                                        @foreach ($cancelled_outcomes as $outcome)
                                            <option value="{{ $outcome->id }}"
                                                {{ $leads->outcome_id == $outcome->id && $leads->lead_status == 'cancelled' ? 'selected' : '' }}>
                                                {{ $outcome->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Lead Flags --}}
                                <div class="form-group mb-3">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-check">
                                                <input class="form-check-input lead-flag" name="lead_flag"
                                                    type="checkbox" value="is_watching" id="checkbox1"
                                                    data-lead-id="{{ $leads->id }}"
                                                    @if ($leads->is_watching) checked @endif>
                                                <label class="form-check-label" for="checkbox1"><b>Watching</b></label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-check">
                                                <input class="form-check-input lead-flag" name="lead_flag"
                                                    type="checkbox" value="is_hot" id="checkbox2"
                                                    data-lead-id="{{ $leads->id }}"
                                                    @if ($leads->is_hot) checked @endif>
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
                                    <select class="form-select update-field-select" id="assigneeSelect"
                                        data-type="assignee">
                                        <option selected>Select assignee</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ $leads->assignee_id == $user->id ? 'selected' : '' }}>
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
                                                    <button class="btn btn-sm btn-outline-secondary delete-item"
                                                        data-lead="{{ $leads->id }}"
                                                        data-id="{{ $leadCompany->id }}" data-type="company"
                                                        data-target="company-{{ $leadCompany->id }}">
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
                                        <button type="button" class="btn btn-success mt-2" id="submitAddProduct">Add
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
                                                        data-lead="{{ $leads->id }}"
                                                        data-id="{{ $leadProduct->id }}" data-type="product"
                                                        data-target="product-{{ $leadProduct->id }}">
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
                                                        data-lead="{{ $leads->id }}"
                                                        data-id="{{ $leadSource->id }}" data-type="source"
                                                        data-target="source-{{ $leadSource->id }}">
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

                                {{-- Attached Files
                                <div class="form-group mb-3">
                                    <label class="form-label"><b>ATTACHED FILES</b> </label>
                                    <button class="btn btn-outline-secondary w-100">
                                        <i class="fas fa-upload me-2"></i>Upload File
                                    </button>
                                </div> --}}

                                <hr>
                                <div class="sidebar-section">
                                    <h6 class="form-label">ATTACHED FILES</h6>

                                    {{-- Existing Uploaded Files --}}
                                    <div id="uploadedFilesList" class="m-3">
                                        @foreach ($leadFiles as $file)
                                            <div class="preview row align-items-center mb-3">
                                                <div class="img-upload col-4 text-center">
                                                    @if (in_array(strtolower(pathinfo($file->file_path, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                                        <img id="img-preview-file-{{ $file->id }}"
                                                            src="{{ asset('storage/' . $file->file_path) }}"
                                                            alt="{{ $file->file_name }}" class="img-fluid rounded"
                                                            style="width: 70px; height: 70px; object-fit: cover;">
                                                    @else
                                                        <i class="fa-regular fa-file fs-1 text-secondary"></i>
                                                    @endif
                                                </div>

                                                <div class="text-upload col-6">
                                                    <a href="{{ asset('storage/' . $file->file_path) }}" download>
                                                        <p class="mb-1 fw-semibold">{{ $file->file_name }}</p>
                                                        <p class="text-muted mb-0 small">
                                                            {{ number_format(Storage::disk('public')->size($file->file_path) / 1024, 2) }}
                                                            KB
                                                        </p>
                                                    </a>
                                                </div>

                                                <div class="col-2 text-end">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger delete-file-btn"
                                                        data-id="{{ $file->id }}"
                                                        data-lead-id="{{ $leads->id }}" title="Delete file">
                                                        <i class="fa-solid fa-xmark"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>


                                    <form id="leadFileUploadForm" enctype="multipart/form-data"
                                        data-lead-id="{{ $leads->id }}">
                                        @csrf
                                        <input type="file" id="leadFileInput" name="file" class="d-none" />
                                        <button type="button" class="btn btn-outline-secondary w-100"
                                            id="uploadLeadFileBtn">
                                            <i class="fas fa-upload me-2"></i>Upload File
                                        </button>
                                    </form>

                                    {{-- <div id="uploadedFilesList" class="mt-3"></div> --}}
                                </div>

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

                        <form class="company-form" action="{{ route('admin.schedule.activity') }}" method="post"
                            data-owner-type="Lead" data-owner-id="{{ $leads->id }}" data-status="Scheduled"
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
                                        <input type="hidden" name="leads_ids[]" value="{{ $leads->id }}">

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
                                        <select id="participant_select" name="participant_id[]"
                                            class="form-select mt-2" multiple>
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
                                                @foreach ($allpeoples as $people)
                                                    <option value="{{ $people->id }}" data-entity-type="people">
                                                        {{ $people->name }}
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

        {{-- Sales Forecasting modal --}}
        <div class="modal fade" id="add-forecasting" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title" id="exampleModalLabel">Sales Forecasting</h1>
                        <div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                    </div>
                    <div class="modal-body ps-0">


                        <form id="add_forecasting" class="company-form"
                            action="{{ route('admin.leads.forecasting.store') }}" method="POST"
                            data-owner-id="{{ $leads->id }}">
                            @csrf

                            <input type="hidden" name="lead_id" id="lead_id" value="{{ $leads->id }}">

                            <div class="row mx-0">
                                <div class="col-lg-12 mb-3">
                                    <label class="form-label">Confidence Level <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="confidence"
                                        value="{{ $leads->confidence ?? '' }}" placeholder="Enter confidence level">
                                </div>

                                <div class="col-lg-12 mb-3">
                                    <label class="form-label">Number of Services <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="expected_services"
                                    value="{{ $leads->expected_services ?? '' }}"
                                        placeholder="Enter expected number of services">
                                </div>

                                <div class="col-lg-12 mb-3">
                                    <label class="form-label">Number of Months <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="expected_months"
                                    value="{{ $leads->expected_months ?? '' }}"
                                        placeholder="Enter expected number of months (e.g. 12)">
                                </div>

                                <div class="col-lg-12 mb-3">
                                    <label class="form-label">Price <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="expected_price" value="{{ $leads->expected_price ?? '' }}"
                                        placeholder="Enter expected price per service">
                                </div>

                                <div class="col-lg-12 mb-3">
                                    <label class="form-label">First Service Date <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="service_date"
                                        name="expected_first_date"
                                        value="{{ $leads->expected_first_date ?? '' }}"
                                        placeholder="Select expected first service date">
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success" id="addForecasting">
                                    Save Forecasting</button>
                            </div>
                        </form>


                    </div>
                </div>
            </div>


        @endsection

        @push('scripts')
            <script>
                function scheduleActivity() {
                    $('#schedule-activity').modal('show');
                }

                function addForecasting() {
                    $('#add-forecasting').modal('show');
                }

                $(document).ready(function() {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });

                    // ==============================
                    // Flatpickr for Forecasting Serice Date
                    // ==============================
                    flatpickr("#service_date", {
                        dateFormat: "Y-m-d",
                        minDate: "today",
                        time_24hr: false
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
                        // Delay hiding to allow click event on icons
                        setTimeout(() => {
                            $icons.addClass('d-none');
                        }, 300);
                    });

                    // ==============================
                    // Update company details(name and description) on change
                    // ==============================
                    $('.editable-submit').click(function() {
                        let $button = $(this);
                        let $field = $button.siblings('.editable-field');
                        let leadId = $field.data('lead-id');
                        let fieldName = $button.data('field'); // e.g., 'name'
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
                                $.post(`/admin/leads/${leadId}/update-detail`, {
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


                    $(document).on('click', '.stage-item', function() {
                        var newStageId = $(this).data('stage-id');
                        var leadId = $(this).data('lead-id');
                        var currentStageId = {{ $leads->stage_id }};

                        // Only allow changing to a different stage
                        if (newStageId == currentStageId) return;

                        Swal.fire({
                            title: 'Are you sure?',
                            text: "Do you want to move this lead to the selected stage?",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, change it'
                        }).then(function(result) {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: '/admin/leads/check-stage-condition/' + leadId,
                                    method: 'POST',
                                    data: {
                                        _token: "{{ csrf_token() }}",
                                        stage_id: newStageId
                                    },
                                    success: function(response) {
                                        if (response.allowed) {
                                            // Stage change allowed
                                            $.ajax({
                                                url: '/admin/leads/change-stage/' +
                                                    leadId,
                                                method: 'POST',
                                                data: {
                                                    _token: "{{ csrf_token() }}",
                                                    stage_id: newStageId
                                                },
                                                success: function(res) {
                                                    Swal.fire({
                                                        icon: 'success',
                                                        title: 'Stage Updated',
                                                        text: res.message ||
                                                            'Lead stage updated successfully.',
                                                        timer: 1500,
                                                        showConfirmButton: false
                                                    }).then(() => location
                                                        .reload());
                                                }
                                            });
                                        } else {
                                            Swal.fire({
                                                icon: 'warning',
                                                title: 'Cannot Change Stage',
                                                text: response.message
                                            });
                                        }
                                    }
                                });
                            }
                        });
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
                            text: "Do you want to add the tag \"" + tagName + "\" to this lead?",
                            icon: "question",
                            showCancelButton: true,
                            confirmButtonColor: "#28a745",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Yes, Add"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: "/admin/leads/{{ $leads->id }}/tags/add", // new route for tags
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
                            text: "Do you want to remove this tag from the lead?",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#d33",
                            cancelButtonColor: "#3085d6",
                            confirmButtonText: "Yes, Remove"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: "/admin/leads/{{ $leads->id }}/tags/" + tagId +
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
                    // Toggle Add task
                    // ==============================
                    const toggleTaskBtn = document.getElementById('toggleAddTask');
                    const formTaskDiv = document.getElementById('addTaskForm');

                    toggleTaskBtn.addEventListener('click', function(e) {
                        e.preventDefault();

                        if (formTaskDiv.style.display === "none" || formTaskDiv.style.display === "") {
                            formTaskDiv.style.display = "block";

                            // Reset form
                            const form = formTaskDiv.querySelector('form');
                            form.reset();

                            // Reset form action back to store route
                            form.setAttribute('action', "{{ route('admin.leads.tasks.store', $leads->id) }}");

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
                    // Add Task ajax form validation and submittion
                    // ==============================
                    $('#add_forecasting').validate({
                        ignore: [],
                        rules: {
                            confidence: {
                                required: true
                            },
                            expected_services: {
                                required: true,
                                digits: true
                            },
                            expected_months: {
                                required: true,
                                digits: true
                            },
                            expected_price: {
                                required: true,
                                digits: true
                            },
                            expected_first_date: {
                                required: true
                            }
                        },
                        messages: {
                            confidence: {
                                required: "Please enter the confidence level."
                            },
                            expected_services: {
                                required: "Please enter the expected number of services.",
                                digits: "Only numeric values are allowed."
                            },
                            expected_months: {
                                required: "Please enter the expected number of months.",
                                digits: "Only numeric values are allowed."
                            },
                            expected_price: {
                                required: "Please enter the expected price per service.",
                                digits: "Only numeric values are allowed."
                            },
                            expected_first_date: {
                                required: "Please enter the expected first service date."
                            }
                        },
                        errorElement: 'span',
                        errorClass: 'invalid-feedback d-block',
                        highlight: element => $(element).addClass('is-invalid'),
                        unhighlight: element => $(element).removeClass('is-invalid'),
                        errorPlacement: (error, element) => {
                            element.parent('.input-group').length ? error.insertAfter(element.parent()) : error
                                .insertAfter(element);
                        }
                    });

                    $('#add_forecasting').on('submit', function(e) {
                        e.preventDefault();

                        if (!$('#add_forecasting').valid()) return;

                        const form = $(this);
                        const actionUrl = form.attr('action');
                        const formData = form.serialize();

                        $.ajax({
                            url: actionUrl,
                            method: 'POST',
                            data: formData,
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
                                        'Something went wrong while adding the sales forecasting.'
                                });
                                console.error(xhr.responseText);
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
                            return; // Stop if validation fails
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
                                    url: '/admin/leads/tasks/' + taskId + '/complete',
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
                                    url: '/admin/leads/tasks/' + taskId + '/reopen',
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
                                    url: "/admin/leads/tasks/delete/" + taskId,
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
                        $('#addTaskAjaxForm').attr('action', '/admin/leads/tasks/' + taskId + '/update');
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
                    // Activities Form - Select2 Integration
                    // ==============================
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
                    // Updating lead and flags status
                    // ==============================
                    // function updateLead(data, onSuccess) {
                    //     fetch("{{ route('admin.leads.ajax_update') }}", {
                    //             method: "POST",
                    //             headers: {
                    //                 "Content-Type": "application/json",
                    //                 "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    //             },
                    //             body: JSON.stringify(data)
                    //         })
                    //         .then(response => response.json())
                    //         .then(resp => {
                    //             if (resp.success) {
                    //                 if (typeof onSuccess === "function") onSuccess();
                    //             } else {
                    //                 Swal.fire("Error", "Failed to update lead!", "error");
                    //             }
                    //         })
                    //         .catch(err => console.error(err));
                    // }
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


                    // ==============================
                    // Handle lead status selection
                    // ==============================
                    // let statusSelect = document.getElementById("leadStatusSelect");
                    // if (statusSelect) {
                    //     // Store initial value
                    //     let previousValue = statusSelect.value;

                    //     statusSelect.addEventListener("change", function() {
                    //         let leadId = this.dataset.leadId;
                    //         let leadStatus = this.value;

                    //         Swal.fire({
                    //             title: 'Are you sure?',
                    //             text: `Do you want to update the lead status`,
                    //             icon: 'question',
                    //             showCancelButton: true,
                    //             confirmButtonColor: '#28a745',
                    //             cancelButtonColor: '#dc3545',
                    //             confirmButtonText: 'Yes, update'
                    //         }).then((result) => {
                    //             if (result.isConfirmed) {
                    //                 updateLead({
                    //                         lead_status: leadStatus,
                    //                         lead_id: leadId
                    //                     },
                    //                     () => {
                    //                         Swal.fire({
                    //                             icon: "success",
                    //                             title: "Updated!",
                    //                             text: "Lead status updated successfully.",
                    //                             timer: 1500,
                    //                             showConfirmButton: false
                    //                         }).then(() => {
                    //                             location.reload();
                    //                         });
                    //                     }
                    //                 );
                    //                 // Update previous value on success
                    //                 previousValue = leadStatus;
                    //             } else {
                    //                 // Revert select back to previous value on cancel
                    //                 this.value = previousValue;
                    //             }
                    //         });
                    //     });
                    // }
                    const statusSelect = document.getElementById('leadStatusSelect');
                    const lostWrapper = document.getElementById('lostOutcomeWrapper');
                    const cancelledWrapper = document.getElementById('cancelledOutcomeWrapper');
                    const lostSelect = document.getElementById('lostOutcomeSelect');
                    const cancelledSelect = document.getElementById('cancelledOutcomeSelect');

                    // store previous to revert if cancelled
                    let previousStatus = statusSelect.value;

                    // helper to hide both wrappers
                    function hideBoth() {
                        lostWrapper.classList.add('d-none');
                        cancelledWrapper.classList.add('d-none');
                    }

                    // initial state: show correct wrapper if lead already lost/cancelled
                    (function init() {
                        if (statusSelect.value === 'lost') {
                            lostWrapper.classList.remove('d-none');
                        } else if (statusSelect.value === 'cancelled') {
                            cancelledWrapper.classList.remove('d-none');
                        } else {
                            hideBoth();
                        }
                    })();

                    // When status changes
                    statusSelect.addEventListener('change', function() {
                        const selectedStatus = this.value;

                        // If it's Lost or Cancelled -> show the respective select and wait for outcome selection
                        if (selectedStatus === 'lost' || selectedStatus === 'cancelled') {
                            // show correct wrapper
                            if (selectedStatus === 'lost') {
                                lostWrapper.classList.remove('d-none');
                                cancelledWrapper.classList.add('d-none');
                                // focus the select so user chooses reason
                                lostSelect.focus();
                            } else {
                                cancelledWrapper.classList.remove('d-none');
                                lostWrapper.classList.add('d-none');
                                cancelledSelect.focus();
                            }

                            toastr.warning('Please select an outcome reason before submitting.',
                                'Action Required');

                            // Do NOT auto-send update here; wait for user to choose a reason.
                            // Keep previousStatus so we can revert if they cancel at confirmation step.
                            return;
                        }

                        // For other statuses: confirm immediately and send update (no outcome_id)
                        Swal.fire({
                            title: 'Are you sure?',
                            text: `Change status to "${selectedStatus}"?`,
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#28a745',
                            cancelButtonColor: '#dc3545',
                            confirmButtonText: 'Yes, update'
                        }).then(result => {
                            if (result.isConfirmed) {
                                // call updateLead (your existing AJAX helper)
                                updateLead({
                                    lead_status: selectedStatus,
                                    lead_id: statusSelect.dataset.leadId,
                                    outcome_id: null
                                }, () => {
                                    Swal.fire({
                                        icon: "success",
                                        title: "Updated!",
                                        text: "Lead status updated successfully.",
                                        timer: 1500,
                                        showConfirmButton: false
                                    }).then(() => location.reload());
                                });
                                previousStatus = selectedStatus;
                            } else {
                                statusSelect.value = previousStatus;
                            }
                        });
                    });

                    // When user selects a Lost outcome
                    lostSelect.addEventListener('change', function() {
                        const outcomeId = this.value;
                        const leadId = statusSelect.dataset.leadId;
                        if (!outcomeId) {
                            // if user chooses blank, do nothing (let them pick real reason)
                            return;
                        }

                        Swal.fire({
                            title: 'Confirm update',
                            text: 'Update status to "Lost" with selected reason?',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#28a745',
                            cancelButtonColor: '#dc3545',
                            confirmButtonText: 'Yes, update'
                        }).then(result => {
                            if (result.isConfirmed) {
                                updateLead({
                                    lead_status: 'lost',
                                    lead_id: leadId,
                                    outcome_id: outcomeId
                                }, () => {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Updated!',
                                        timer: 1200,
                                        showConfirmButton: false
                                    }).then(() => location.reload());
                                });
                                previousStatus = 'lost';
                            } else {
                                // revert status and hide wrapper
                                statusSelect.value = previousStatus;
                                hideBoth();
                            }
                        });
                    });

                    // When user selects a Cancelled outcome
                    cancelledSelect.addEventListener('change', function() {
                        const outcomeId = this.value;
                        const leadId = statusSelect.dataset.leadId;
                        if (!outcomeId) return;

                        Swal.fire({
                            title: 'Confirm update',
                            text: 'Update status to "Cancelled" with selected reason?',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#28a745',
                            cancelButtonColor: '#dc3545',
                            confirmButtonText: 'Yes, update'
                        }).then(result => {
                            if (result.isConfirmed) {
                                updateLead({
                                    lead_status: 'cancelled',
                                    lead_id: leadId,
                                    outcome_id: outcomeId
                                }, () => {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Updated!',
                                        timer: 1200,
                                        showConfirmButton: false
                                    }).then(() => location.reload());
                                });
                                previousStatus = 'cancelled';
                            } else {
                                statusSelect.value = previousStatus;
                                hideBoth();
                            }
                        });
                    });

                    // ==============================
                    // Handle lead flag checkboxes
                    // ==============================
                    // document.querySelectorAll(".lead-flag").forEach((flagSelect) => {
                    //     flagSelect.addEventListener("change", function() {
                    //         let leadId = this.dataset.leadId;

                    //         // Collect all checked flags for this lead
                    //         let checkedFlags = [];
                    //         document.querySelectorAll('.lead-flag[data-lead-id="' + leadId + '"]:checked')
                    //             .forEach(cb => checkedFlags.push(cb.value));

                    //         // Show confirmation popup before update
                    //         Swal.fire({
                    //             title: 'Are you sure?',
                    //             text: 'Do you want to update the lead flags?',
                    //             icon: 'question',
                    //             showCancelButton: true,
                    //             confirmButtonColor: '#28a745',
                    //             cancelButtonColor: '#dc3545',
                    //             confirmButtonText: 'Yes, update',
                    //             cancelButtonText: 'Cancel'
                    //         }).then((result) => {
                    //             if (result.isConfirmed) {
                    //                 updateLead({
                    //                         lead_flags: checkedFlags,
                    //                         lead_id: leadId
                    //                     },
                    //                     () => {
                    //                         Swal.fire({
                    //                             icon: "success",
                    //                             title: "Updated!",
                    //                             text: "Lead flags updated successfully.",
                    //                             timer: 1500,
                    //                             showConfirmButton: false
                    //                         }).then(() => {
                    //                             location.reload();
                    //                         });
                    //                     }
                    //                 );
                    //             } else {
                    //                 // Revert checkbox state
                    //                 // Uncheck the one that triggered this change
                    //                 this.checked = !this.checked;
                    //             }
                    //         });
                    //     });
                    // });

                    document.querySelectorAll(".lead-flag").forEach((checkbox) => {
                        checkbox.addEventListener("change", function() {
                            let leadId = this.dataset.leadId;
                            let flagType = this.value; // e.g., "is_hot" or "is_watching"
                            let isChecked = this.checked ? 1 : 0;

                            Swal.fire({
                                title: 'Are you sure?',
                                text: `Do you want to ${isChecked ? 'enable' : 'disable'} this flag?`,
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonColor: '#28a745',
                                cancelButtonColor: '#dc3545',
                                confirmButtonText: 'Yes, update',
                                cancelButtonText: 'Cancel'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    updateLead({
                                            lead_id: leadId,
                                            flag_type: flagType,
                                            flag_value: isChecked
                                        },
                                        () => {
                                            Swal.fire({
                                                icon: "success",
                                                title: "Updated!",
                                                text: "Lead flag updated successfully.",
                                                timer: 1500,
                                                showConfirmButton: false
                                            }).then(() => {
                                                location.reload();
                                            });
                                        }
                                    );
                                } else {
                                    // Revert checkbox state if cancelled
                                    this.checked = !this.checked;
                                }
                            });
                        });
                    });



                    // ==============================
                    // Toggle Fields on sidebar of leads details section
                    // ==============================
                    $('#toggle-add-person').on('click', function() {
                        $('#add-person').toggleClass('d-none');
                    });

                    $('#toggle-add-company').on('click', function() {
                        $('#add-company').toggleClass('d-none');
                    });

                    $('#toggle-add-product').on('click', function() {
                        $('#add-product').toggleClass('d-none');
                    });

                    $('#toggle-add-competitor').on('click', function() {
                        $('#add-competitor').toggleClass('d-none');
                    });

                    $('#toggle-add-source').on('click', function() {
                        $('#add-source').toggleClass('d-none');
                    });

                    // ==============================
                    // Update Fields on sidebar of leads details section
                    // ==============================
                    $(document).on("change", ".update-field-select", function() {
                        let relatedId = $(this).val(); // selected item id
                        let type = $(this).data("type"); // type: company | people | source | competitor | product
                        let leadId = "{{ $leads->id }}"; // current lead
                        let selectElement = this; // store reference in case we need to revert

                        if (!relatedId) return; // do nothing if no selection

                        // Show confirmation popup
                        Swal.fire({
                            title: 'Are you sure?',
                            text: `Do you want to update the lead ${type}?`,
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#28a745',
                            cancelButtonColor: '#dc3545',
                            confirmButtonText: 'Yes, update',
                            cancelButtonText: 'Cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Proceed with update via AJAX
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
                                            toastr.error(response.message ||
                                                "Failed to update " + type + ".");
                                        }
                                    },
                                    error: function(xhr) {
                                        toastr.error("Something went wrong.");
                                        console.error(xhr.responseText);
                                    }
                                });
                            } else {
                                // User canceled, revert select to previous value
                                // Optional: reset or set to default/empty
                                $(selectElement).val('').trigger('change.select2'); // works with Select2
                            }
                        });
                    });

                    // ==============================
                    // Add Product to Lead
                    // ==============================
                    $(document).on("click", "#submitAddProduct", function() {
                        let leadId = "{{ $leads->id }}";
                        let productId = $("#product-name").val();
                        let qty = $("input[name='inline_qty']").val();
                        let price = $("input[name='inline_price']").val();

                        if (!productId || !qty || !price) {
                            toastr.error("Please fill all product details before adding.");
                            return;
                        }

                        Swal.fire({
                            title: 'Add Product?',
                            text: "Do you want to add this product to the lead?",
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#28a745',
                            cancelButtonColor: '#dc3545',
                            confirmButtonText: 'Yes, add it',
                            cancelButtonText: 'Cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: "{{ route('admin.leads.add-product') }}",
                                    method: "POST",
                                    data: {
                                        _token: "{{ csrf_token() }}",
                                        lead_id: leadId,
                                        product_id: productId,
                                        qty: qty,
                                        price: price
                                    },
                                    success: function(response) {
                                        if (response.success) {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Added!',
                                                text: response.message,
                                                timer: 1500,
                                                showConfirmButton: false
                                            }).then(() => location.reload());
                                        } else {
                                            toastr.error(response.message ||
                                                "Failed to add product.");
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


                    // ==============================
                    // Delete fields on sidebar of leads details section
                    // ==============================
                    // $(document).on("click", ".delete-item", function(e) {
                    //     e.preventDefault();

                    //     let leadId = $(this).data("lead");
                    //     let relatedId = $(this).data("id");
                    //     let type = $(this).data("type");
                    //     let target = $(this).data("target");

                    //     // Use the new container-list structure
                    //     let container = $(`#${type}-container`);
                    //     let list = container.find(`#${type}-list`);
                    //     let count = list.children().length;

                    //     if (count <= 1) {
                    //         toastr.warning(`At least one ${type} is required.`);
                    //         return false;
                    //     }

                    //     Swal.fire({
                    //         title: 'Are you sure?',
                    //         text: `This ${type} will be removed from the lead record!`,
                    //         icon: 'warning',
                    //         showCancelButton: true,
                    //         confirmButtonColor: '#3085d6',
                    //         cancelButtonColor: '#d33',
                    //         confirmButtonText: 'Yes, delete it!'
                    //     }).then((result) => {
                    //         if (result.isConfirmed) {
                    //             $.ajax({
                    //                 url: "{{ route('admin.leads.delete-field') }}",
                    //                 type: "POST",
                    //                 data: {
                    //                     _token: "{{ csrf_token() }}",
                    //                     lead_id: leadId,
                    //                     related_id: relatedId,
                    //                     type: type
                    //                 },
                    //                 success: function(response) {
                    //                     if (response.success) {
                    //                         // toastr.success(response.message);
                    //                         // location.reload();
                    //                         Swal.fire({
                    //                             icon: 'success',
                    //                             title: 'Updated!',
                    //                             text: response.message,
                    //                             timer: 1500,
                    //                             showConfirmButton: false
                    //                         }).then(() => location.reload());
                    //                     } else {
                    //                         toastr.error(response.message || "Delete failed.");
                    //                     }
                    //                 },
                    //                 error: function(xhr) {
                    //                     toastr.error("Something went wrong.");
                    //                     console.error(xhr.responseText);
                    //                 }
                    //             });
                    //         }
                    //     });
                    // });
                    $(document).on("click", ".delete-item", function(e) {
                        e.preventDefault();

                        let leadId = $(this).data("lead");
                        let relatedId = $(this).data("id");
                        let type = $(this).data("type");
                        let target = $(this).data("target");

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
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Updated!',
                                                text: response.message,
                                                timer: 1500,
                                                showConfirmButton: false
                                            }).then(() => location.reload());
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


                    // ==============================
                    // Schedule activity validation and submition logic
                    // ==============================

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

            {{-- <script>
            document.addEventListener('DOMContentLoaded', function() {
                // --- Prepare mentions array ---
                var mentions = [
                    // companies
                    @foreach ($companies as $company)
                        {
                            key: "{{ addslashes($company->name) }}",
                            value: "company:{{ $company->id }}"
                        }
                        @if (!$loop->last || count($allpeoples) > 0 || count($users) > 0)
                            ,
                        @endif
                    @endforeach

                    // people
                    @foreach ($allpeoples as $person)
                        {
                            key: "{{ addslashes($person->name) }}",
                            value: "people:{{ $person->id }}"
                        }
                        @if (!$loop->last || count($users) > 0)
                            ,
                        @endif
                    @endforeach

                    // users
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

                // --- Initialize Tribute ---
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
                        // Insert only the display name
                        return item.original ? item.original.key : '';
                    }
                });

                tribute.attach(document.getElementById('activity-note'));

                // --- Handle form submit ---
                var form = document.getElementById('loginActivity');
                form.addEventListener('submit', function(e) {
                    var textarea = document.getElementById('activity-note');
                    var rawText = textarea.value;

                    var companyIds = [];
                    var peopleIds = [];
                    var userIds = [];

                    // Match exact names to database IDs
                    mentions.forEach(m => {
                        var regex = new RegExp(`\\b${escapeRegExp(m.key)}\\b`,
                            'g'); // avoid substring issues
                        if (regex.test(rawText)) {
                            let [type, id] = m.value.split(':');
                            if (type === 'company') companyIds.push(id);
                            else if (type === 'people') peopleIds.push(id);
                            else if (type === 'user') userIds.push(id);
                        }
                    });

                    // Populate hidden inputs
                    document.getElementById('mentioned_company_ids').value = companyIds.join(',');
                    document.getElementById('mentioned_people_ids').value = peopleIds.join(',');
                    document.getElementById('mentioned_user_ids').value = userIds.join(',');
                    document.getElementById('note_value').value = rawText;
                });

                // --- Helper: escape RegExp special characters ---
                function escapeRegExp(string) {
                    return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                }
            });
        </script> --}}
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

            <script>
                $(document).ready(function() {
                    function fetchFilteredTimeline() {
                        // ✅ Fetch lead_id dynamically from dropdown
                        let leadId = $('#filter-range').data('lead-id');
                        let filter_range = $('select[name="filter_range"]').val();
                        let activity_type_id = $('#filter-activity').val();
                        let user_id = $('#filter-user').val();


                        console.log("Fetching timeline with filters:", {
                            lead_id: leadId,
                            filter_range: filter_range,
                            activity_type_id: activity_type_id,
                            user_id: user_id
                        });

                        $.ajax({
                            url: "/admin/leads/" + leadId + "/timeline",
                            method: "GET",
                            data: {
                                filter_range: filter_range,
                                activity_type_id: activity_type_id,
                                user_id: user_id
                            },
                            success: function(response) {
                                $('#timeline').html(response.timeline_html);
                            },
                            error: function() {
                                console.error('Error fetching filtered timeline data');
                            }
                        });
                    }

                    // ✅ Trigger AJAX when filters change
                    $('select[name="filter_range"], select[name="activity_type_id"], select[name="user_id"]').on('change',
                        fetchFilteredTimeline);


                    const uploadBtn = document.getElementById("uploadLeadFileBtn");
                    const fileInput = document.getElementById("leadFileInput");
                    const uploadedList = document.getElementById("uploadedFilesList");
                    const leadId = document.getElementById("leadFileUploadForm").dataset.leadId;

                    uploadBtn.addEventListener("click", () => fileInput.click());

                    fileInput.addEventListener("change", function() {
                        const file = this.files[0];
                        if (!file) return;

                        let formData = new FormData();
                        formData.append("file", file);
                        formData.append("_token", "{{ csrf_token() }}");

                        uploadBtn.disabled = true;
                        uploadBtn.innerHTML = `<i class="fa-solid fa-spinner fa-spin me-2"></i> Uploading...`;

                        fetch(`/admin/leads/${leadId}/files/upload`, {
                                method: "POST",
                                body: formData,
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    location.reload();
                                } else {
                                    alert("Upload failed: " + data.message);
                                }
                            })
                            .catch(err => {
                                console.error("Upload error:", err);
                                alert("Something went wrong while uploading the file.");
                            })
                            .finally(() => {
                                uploadBtn.disabled = false;
                                uploadBtn.innerHTML = `<i class="fas fa-upload me-2"></i>Upload File`;
                                fileInput.value = "";
                            });
                    });


                    $(document).on('click', '.delete-file-btn', function() {
                        let fileId = $(this).data('id');
                        let leadId = $(this).data('lead-id'); // available from your Blade

                        Swal.fire({
                            title: "Are you sure?",
                            text: "This file will be permanently deleted.",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#d33",
                            cancelButtonColor: "#3085d6",
                            confirmButtonText: "Yes, delete it",
                            cancelButtonText: "Cancel"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: `/admin/leads/files/delete`,
                                    type: "POST",
                                    data: {
                                        _token: "{{ csrf_token() }}",
                                        lead_id: leadId,
                                        file_id: fileId
                                    },
                                    success: function(response) {
                                        Swal.fire({
                                            icon: "success",
                                            title: "Deleted!",
                                            text: response.message ||
                                                "File deleted successfully.",
                                            showConfirmButton: false,
                                            timer: 2000
                                        });
                                        setTimeout(() => location.reload(), 2000);
                                    },
                                    error: function(xhr) {
                                        Swal.fire({
                                            icon: "error",
                                            title: "Error!",
                                            text: xhr.responseJSON?.message ||
                                                "Something went wrong while deleting."
                                        });
                                    }
                                });
                            }
                        });
                    });


                });
            </script>
        @endpush
