@extends('admin.includes.layout')

@section('title', 'Sales')

@section('content')


    <!-- All Companies Section start  -->
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                @include('admin.sales.sidebar')

                <!-- Main Content -->
                <div class="col-md-10 p-0">
                    <div class="sales-dashboard">
                        <div class="dashboard-header section-card">
                            <div class="container-fluid">
                                <h1 class="display-6 mb-2 fw-bold">DASHBOARD</h1>
                                <p class="text-muted">Add cards to track the metrics, leads and reports that
                                    matter most to you</p>
                            </div>
                        </div>

                        <!-- Sales Metrics Row -->
                        <div class="section-card">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h2 class="section-title">SALES METRICS</h2>
                                    <p class="section-subtitle">Metrics - Month - to - date</p>
                                </div>
                                <div class="info-icon d-none">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#SalesMetricsModal"><i
                                            class="fa-regular fa-gear"></i></a>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="metric-card new-lead" id="newLeadCard">
                                        <h3>NEW LEAD</h3>
                                        <div class="metric-value green">{{ $newLeadsThisMonth }}</div>
                                        {{-- <div class="metric-change">Down 14% From 7 This Time Last Month</div> --}}
                                        <div class="metric-change">{{ $newLeadsChange }}</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="metric-card open-leads" id="openLeadCard">
                                        <h3>OPEN LEADS</h3>
                                        <div class="metric-value blue">{{ $openLeadsThisMonth }}</div>
                                        {{-- <div class="metric-change">Down 6% From $5.48m This Time Last Month</div> --}}
                                        <div class="metric-change">{{ $openLeadsChange }}</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="metric-card sales" id="saleLeadCard">
                                        <h3>SALES</h3>
                                        <div class="metric-value red">{{ $salesLeadsThisMonth }}</div>
                                        {{-- <div class="metric-change">Down 75% From $66.2k This Time Last Month</div> --}}
                                        <div class="metric-change">{{ $salesLeadsChange }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Lead Summary and Pipeline Row -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="section-card">
                                    <div class="section-header">
                                        <div>
                                            <h3 class="section-title">LEAD SUMMARY</h3>
                                            <p class="section-subtitle">List Summary</p>
                                        </div>
                                        <div class="info-icon d-none">
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#LeadSummaryModal"><i
                                                    class="fa-regular fa-gear"></i></a>
                                        </div>
                                    </div>

                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Lead Type</th>
                                                <th>Count</th>
                                                <th>Value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    @can('lead.list.all.view')
                                                        <a href="{{ route('admin.lead.index') }}">All Leads</a>
                                                    @else
                                                        <span>All Leads</span>
                                                    @endcan
                                                </td>
                                                <td>{{ $allLeadsCount }}</td>
                                                <td>${{ $allLeadsValueFormatted }}</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    @can('lead.list.my.view')
                                                        <a href="{{ route('admin.lead.my_leads', auth()->id()) }}">My Leads</a>
                                                    @else
                                                        <span>My Leads</span>
                                                    @endcan
                                                </td>
                                                <td>{{ $myLeadsCount }}</td>
                                                <td>${{ $myLeadsValueFormatted }}</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                     @can('lead.list.added_this_week.view')
                                                        <a href="{{ route('admin.lead.added_this_week') }}">Added this week</a>
                                                    @else
                                                        <span>Added this week</span>
                                                    @endcan
                                                </td>
                                                <td>{{ $addedThisWeekCount }}</td>
                                                {{-- <td>$8.99k</td> --}}
                                                <td>${{ $addedThisWeekValueFormatted }}</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    @can('lead.list.closing_this_week.view')
                                                        <a href="{{ route('admin.lead.closing_this_week') }}">Closing this week</a>
                                                    @else
                                                        <span>Closing this week</span>
                                                    @endcan
                                                </td>
                                                <td>{{ $closingThisWeekCount }}</td>
                                                <td>${{ $closingThisWeekValueFormatted }}</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                     @can('lead.list.hot.view')
                                                        <a href="{{ route('admin.lead.hot_leads') }}">Hot leads</a>
                                                    @else
                                                        <span>Hot leads</span>
                                                    @endcan
                                                </td>
                                                <td>{{ $hotLeadsCount }}</td>
                                                <td>${{ $hotLeadsValueFormatted }}</td>
                                            </tr>

                                        </tbody>
                                    </table>

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="section-card">
                                    <div class="section-header">
                                        <div>
                                            <h3 class="section-title">PIPELINE</h3>
                                            <p class="section-subtitle">Default Pipeline by stage</p>
                                        </div>
                                        <div class="info-icon d-none">
                                            <a href="#EditPipelineModal" data-bs-toggle="modal"
                                                data-bs-target="#EditPipelineModal"><i class="fa-regular fa-gear"></i></a>
                                        </div>
                                    </div>

                                    <div class="pipeline-card">
                                        <div class="company-form">
                                            <div class="pipeline-stages">
                                                <!-- Stage 1: Int. GB Presentation -->
                                                <div class="pipeline-stage stage-1" data-lead-stage="1">
                                                    <div class="stage-info">
                                                        <div class="stage-name">Int. GB Presentation</div>
                                                        <div class="stage-metrics">
                                                            <span class="leads-count">{{ $gbPresentationCount }}
                                                                leads</span>
                                                            <span
                                                                class="revenue-amount">${{ $gbPresentationCountValueFormatted }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar"></div>
                                                    </div>
                                                </div>

                                                <!-- Stage 2: Site Survey -->
                                                <div class="pipeline-stage stage-2" data-lead-stage="2">
                                                    <div class="stage-info">
                                                        <div class="stage-name">Site Survey</div>
                                                        <div class="stage-metrics">
                                                            <span class="leads-count">{{ $siteSurveyCount }} leads</span>
                                                            <span
                                                                class="revenue-amount">${{ $siteSurveyCountValueFormatted }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar"></div>
                                                    </div>
                                                </div>

                                                <!-- Stage 3: Proposal Approval -->
                                                <div class="pipeline-stage stage-3" data-lead-stage="3">
                                                    <div class="stage-info">
                                                        <div class="stage-name">Proposal Approval</div>
                                                        <div class="stage-metrics">
                                                            <span class="leads-count">{{ $proposalApprovalCount }}
                                                                leads</span>
                                                            <span
                                                                class="revenue-amount">${{ $proposalApprovalCountValueFormatted }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar"></div>
                                                    </div>
                                                </div>

                                                <!-- Stage 4: Proposal Pres. -->
                                                <div class="pipeline-stage stage-4" data-lead-stage="4">
                                                    <div class="stage-info">
                                                        <div class="stage-name">Proposal Pres.</div>
                                                        <div class="stage-metrics">
                                                            <span class="leads-count">{{ $proposalPresentationCount }}
                                                                leads</span>
                                                            <span
                                                                class="revenue-amount">${{ $proposalPresentationCountValueFormatted }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar"></div>
                                                    </div>
                                                </div>

                                                <!-- Stage 5: Rec. Signed Proposal -->
                                                <div class="pipeline-stage stage-5" data-lead-stage="5">
                                                    <div class="stage-info">
                                                        <div class="stage-name">Rec. Signed Proposal</div>
                                                        <div class="stage-metrics">
                                                            <span class="leads-count">{{ $signedProposalCount }}
                                                                leads</span>
                                                            <span
                                                                class="revenue-amount">${{ $signedProposalCountValueFormatted }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar"></div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Add Card Section -->
                        <div class="section-card d-none">
                            <div class="row">
                                <div class="col-12">
                                    <h3 class="section-title">ADD A CARD</h3>
                                    <div class="add-card-area" onclick="addCard()">
                                        <i class="fas fa-plus add-icon"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Activities Section -->
                        <div class="row company-details-section">
                            <div class="col-12">
                                <div class="section-card">
                                    <!-- Bootstrap Nav Tabs -->
                                    <ul class="nav nav-tabs" id="activityTabs" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="activities-tab" data-bs-toggle="tab"
                                                data-bs-target="#activities" type="button" role="tab"
                                                aria-controls="activities" aria-selected="true">ACTIVITIES</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="todo-tab" data-bs-toggle="tab"
                                                data-bs-target="#todo" type="button" role="tab"
                                                aria-controls="todo" aria-selected="false">TO DO</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="timeline-tab" data-bs-toggle="tab"
                                                data-bs-target="#timeline" type="button" role="tab"
                                                aria-controls="timeline" aria-selected="false">TIMELINE</button>
                                        </li>
                                    </ul>

                                    <!-- Tab Content -->
                                    <div class="tab-content pt-2" id="activityTabsContent">
                                        <!-- ACTIVITIES TAB -->
                                        <div class="tab-pane fade show active" id="activities" role="tabpanel"
                                            aria-labelledby="activities-tab">
                                            <div class="filter-section mb-3">
                                                <div class="row g-2 align-items-center">
                                                    <!-- Filter Range -->
                                                    <div class="col-auto">
                                                        <select class="form-select dropdown-orange" id="filter-range"
                                                            name="filter_range">
                                                            <option value="all">All Entries</option>
                                                            <option value="7">Last 7 Days</option>
                                                            <option value="30">Last 30 Days</option>
                                                            <option value="90">Last 90 Days</option>
                                                        </select>
                                                    </div>

                                                    <!-- Activity Type -->
                                                    <div class="col-auto">
                                                        <select class="form-select dropdown-orange" id="filter-activity"
                                                            name="activity_type_id">
                                                            <option value="all">All Activity Types</option>
                                                            @foreach ($activitytypes as $activitytype)
                                                                <option value="{{ $activitytype->id }}">
                                                                    {{ $activitytype->type }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <!-- Status -->
                                                    <div class="col-auto">
                                                        <select class="form-select dropdown-orange" id="filter-status"
                                                            name="status">
                                                            <option value="all">All Status</option>
                                                            <option value="logged">Logged</option>
                                                            <option value="scheduled">Scheduled</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="timeline-container">
                                                <div class="timeline position-relative" id="allActivitiesContainer">
                                                    @foreach ($allactivities as $item)
                                                        <div class="timeline-item">
                                                            <div class="timeline-icon">
                                                                <i class="fas fa-angle-double-right"></i>
                                                            </div>
                                                            <div class="timeline-content">
                                                                <div class="timeline-header">
                                                                    <div class="timestamp">
                                                                        {{-- {{ \Carbon\Carbon::parse($item->created_at)->format('g:i A \o\n M j, Y') }} --}}
                                                                        {{ \Carbon\Carbon::parse($item->end_time)->format('g:i A') ?? 'N/A' }}
                                                                        on
                                                                        {{ \Carbon\Carbon::parse($item->date)->format('M j, Y') }}

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
                                                                                title="Delete Activity"
                                                                                data-type="Activity"
                                                                                data-id="{{ $item->id }}">
                                                                                <i class="fas fa-times"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>

                                                                    <div class="activity-details">
                                                                        <div class="row">
                                                                            <div class="col-10">
                                                                                <div class="activity-label mb-0">
                                                                                    {{ $item->activityType->type ?? 'N/A' }}
                                                                                </div>
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
                                                                                    <span
                                                                                        class="activity-badge badge-cc">JB</span>
                                                                                    <span
                                                                                        class="activity-badge badge-cc">TC</span>
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
                                                                                    <span
                                                                                        class="btn btn-sm delete-comment-btn"
                                                                                        data-id="{{ $comment->id }}"
                                                                                        data-type="Activity">
                                                                                        <i class="fas fa-times"></i>
                                                                                    </span>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    @endif

                                                                    <div class="mt-3 d-none add-comment"
                                                                        data-id="{{ $item->id }}"
                                                                        data-type="Activity">
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
                                                    @endforeach

                                                </div>
                                            </div>

                                        </div>

                                        <!-- TO DO TAB -->
                                        <div class="tab-pane fade" id="todo" role="tabpanel"
                                            aria-labelledby="todo-tab">

                                            <div class="filter-section mb-3">
                                                <div class="row g-2 align-items-center">
                                                    <!-- Filter Range -->
                                                    <div class="col-auto">
                                                        <select class="form-select dropdown-orange" id="filter-task-range"
                                                            name="filter_range">
                                                            <option value="all">All Entries</option>
                                                            <option value="7">Last 7 Days</option>
                                                            <option value="30">Last 30 Days</option>
                                                            <option value="90">Last 90 Days</option>
                                                        </select>
                                                    </div>

                                                    <!-- Status -->
                                                    <div class="col-auto">
                                                        <select class="form-select dropdown-orange"
                                                            id="filter-task-status" name="status">
                                                            <option value="all">All Status</option>
                                                            <option value="completed">Completed</option>
                                                            <option value="uncompleted">Uncompleted</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="pendingTasksContainer">

                                                {{-- @foreach ($alltasks as $task)
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
                                                                        <p class="text-warning">
                                                                            {{ $task->assignee_name ?? 'N/A' }}</p>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6 d-flex justify-content-end">
                                                                    <div class="d-flex gap-2">
                                                                        <!-- Completed -->
                                                                        <button
                                                                            class="btn btn-sm btn-outline-success mark-complete-btn"
                                                                            title="Mark as Completed"
                                                                            data-id="{{ $task->id }}">
                                                                            <i class="fas fa-check"></i>
                                                                        </button>

                                                                        <!-- Edit -->
                                                                        <button
                                                                            class="btn btn-sm btn-outline-primary toggleEditTask"
                                                                            data-id="{{ $task->id }}"
                                                                            data-title="{{ $task->title }}"
                                                                            data-due="{{ $task->due_time }}"
                                                                            data-user="{{ $task->assignee_id }}"
                                                                            data-description="{{ $task->description }}"
                                                                            title="Edit Task">
                                                                            <i class="fas fa-edit"></i>
                                                                        </button>

                                                                        <!-- Delete -->
                                                                        <button
                                                                            class="btn btn-sm btn-outline-secondary delete-task-btn"
                                                                            title="Delete Task"
                                                                            data-id="{{ $task->id }}">
                                                                            <i class="fas fa-times"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row mt-2">
                                                                <div class="col-12">
                                                                    <div
                                                                        class="email-preview border rounded p-3 text-secondary">
                                                                        {{ $task->description ?? 'N/A' }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach --}}

                                                @foreach ($completedTasks as $task)
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
                                                                        <p class="text-warning">By
                                                                            {{ $task->completed_user_name ?? 'N/A' }}
                                                                        </p>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6 d-flex justify-content-end">
                                                                    <div class="d-flex gap-2">
                                                                        <!-- Reopen Task -->
                                                                        <button
                                                                            class="btn btn-sm btn-outline-warning reopen-task-btn"
                                                                            title="Reopen Task"
                                                                            data-id="{{ $task->id }}">
                                                                            <i class="fas fa-undo"></i>
                                                                        </button>

                                                                        <!-- Delete -->
                                                                        <button
                                                                            class="btn btn-sm btn-outline-secondary delete-task-btn"
                                                                            title="Delete Task"
                                                                            data-id="{{ $task->id }}">
                                                                            <i class="fas fa-times"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                @endforeach

                                                @foreach ($pendingTasks as $task)
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
                                                                        <p class="text-warning">
                                                                            {{ $task->assignee_name ?? 'N/A' }}</p>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6 d-flex justify-content-end">
                                                                    <div class="d-flex gap-2">
                                                                        <!-- Completed -->
                                                                        <button
                                                                            class="btn btn-sm btn-outline-success mark-complete-btn"
                                                                            title="Mark as Completed"
                                                                            data-id="{{ $task->id }}">
                                                                            <i class="fas fa-check"></i>
                                                                        </button>

                                                                        <!-- Edit -->
                                                                        <button
                                                                            class="btn btn-sm btn-outline-primary toggleEditTask"
                                                                            data-id="{{ $task->id }}"
                                                                            data-title="{{ $task->title }}"
                                                                            data-due="{{ $task->due_time }}"
                                                                            data-user="{{ $task->assignee_id }}"
                                                                            data-description="{{ $task->description }}"
                                                                            title="Edit Task">
                                                                            <i class="fas fa-edit"></i>
                                                                        </button>

                                                                        <!-- Delete -->
                                                                        <button
                                                                            class="btn btn-sm btn-outline-secondary delete-task-btn"
                                                                            title="Delete Task"
                                                                            data-id="{{ $task->id }}">
                                                                            <i class="fas fa-times"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row mt-2">
                                                                <div class="col-12">
                                                                    <div
                                                                        class="email-preview border rounded p-3 text-secondary">
                                                                        {{ $task->description ?? 'N/A' }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach


                                            </div>

                                        </div>

                                        <!-- TIMELINE TAB -->
                                        <div class="tab-pane fade" id="timeline" role="tabpanel"
                                            aria-labelledby="timeline-tab">

                                            <div class="filter-section mb-3">
                                                <div class="row g-2 align-items-center">
                                                    <!-- Filter Range -->
                                                    <div class="col-auto">
                                                        <select class="form-select dropdown-orange"
                                                            id="filter-timeline-range" name="filter_range">
                                                            <option value="all">All Entries</option>
                                                            <option value="7">Last 7 Days</option>
                                                            <option value="30">Last 30 Days</option>
                                                            <option value="90">Last 90 Days</option>
                                                        </select>
                                                    </div>

                                                    <!-- Activity Type -->
                                                    <div class="col-auto">
                                                        <select class="form-select dropdown-orange"
                                                            id="filter-timeline-activity" name="activity_type_id">
                                                            <option value="all">All Activity Types</option>
                                                            @foreach ($activitytypes as $activitytype)
                                                                <option value="{{ $activitytype->id }}">
                                                                    {{ $activitytype->type }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <!-- Status -->
                                                    <div class="col-auto">
                                                        <select class="form-select dropdown-orange"
                                                            id="filter-timeline-status" name="status">
                                                            <option value="all">All Status</option>
                                                            <option value="logged">Logged</option>
                                                            <option value="scheduled">Scheduled</option>
                                                        </select>
                                                    </div>

                                                    <!-- Type -->
                                                    <div class="col-auto">
                                                        <select class="form-select dropdown-orange"
                                                            id="filter-timeline-type" name="type">
                                                            <option value="all">All Types</option>
                                                            <option value="activities">Activities</option>
                                                            <option value="notes">Notes</option>
                                                            <option value="updates">Updates</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Timeline -->
                                            <div class="timeline-container">
                                                <div class="timeline position-relative" id="timelineContainer">
                                                    @foreach ($timeline as $item)
                                                        @if ($item->type === 'activity')
                                                            <div class="timeline-item">
                                                                <div class="timeline-icon">
                                                                    <i class="fas fa-angle-double-right"></i>
                                                                </div>
                                                                <div class="timeline-content">
                                                                    <div class="timeline-header">
                                                                        <div class="timestamp">
                                                                            {{-- {{ \Carbon\Carbon::parse($item->created_at)->format('g:i A \o\n M j, Y') }} --}}
                                                                            {{ \Carbon\Carbon::parse($item->end_time)->format('g:i A') ?? 'N/A' }}
                                                                            on
                                                                            {{ \Carbon\Carbon::parse($item->date)->format('M j, Y') }}

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
                                                                                    title="Add Comment"
                                                                                    data-type="Activity"
                                                                                    data-id="{{ $item->id }}">
                                                                                    <i class="fas fa-comment"></i>
                                                                                </button>
                                                                                <button
                                                                                    class="btn btn-sm btn-outline-danger delete-activity-btn"
                                                                                    title="Delete Activity"
                                                                                    data-type="Activity"
                                                                                    data-id="{{ $item->id }}">
                                                                                    <i class="fas fa-times"></i>
                                                                                </button>
                                                                            </div>
                                                                        </div>

                                                                        <div class="activity-details">
                                                                            <div class="row">
                                                                                <div class="col-10">
                                                                                    <div class="activity-label mb-0">
                                                                                        {{ $item->activityType->type ?? 'N/A' }}
                                                                                    </div>
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
                                                                                        <span
                                                                                            class="activity-badge badge-cc">JB</span>
                                                                                        <span
                                                                                            class="activity-badge badge-cc">TC</span>
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
                                                                                        <span
                                                                                            class="btn btn-sm delete-comment-btn"
                                                                                            data-id="{{ $comment->id }}"
                                                                                            data-type="Activity">
                                                                                            <i class="fas fa-times"></i>
                                                                                        </span>
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>
                                                                        @endif

                                                                        <div class="mt-3 d-none add-comment"
                                                                            data-id="{{ $item->id }}"
                                                                            data-type="Activity">
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
                                                                                        <span
                                                                                            class="activity-badge badge-cc">JB</span>
                                                                                        <span
                                                                                            class="activity-badge badge-cc">TC</span>
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
                                                                                        <span
                                                                                            class="btn btn-sm delete-comment-btn"
                                                                                            data-id="{{ $comment->id }}"
                                                                                            data-type="Activity">
                                                                                            <i class="fas fa-times"></i>
                                                                                        </span>
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>
                                                                        @endif

                                                                        <div class="mt-3 d-none add-comment"
                                                                            data-id="{{ $item->id }}"
                                                                            data-type="Note">
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
                                                        @elseif ($item->type === 'milestone')
                                                            <div class="timeline-item milestone">
                                                                <div class="timeline-icon">
                                                                    <i class="fa-brands fa-web-awesome"></i>
                                                                </div> 
                                                                <strong>🎉 {{ $item->title }}</strong>
                                                                <span
                                                                    class="text-muted">{{ $item->timestamp->format('M d, Y') }}</span>
                                                            </div>
                                                        @endif
                                                    @endforeach

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>


                </div>
            </div>
        </div>
        <!-- All Companies Section End  -->


        <!-- Add Sales Metrics Modal Start -->
        <div class="modal fade" id="SalesMetricsModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title" id="exampleModalLabel">Edit Sales metrics card</h1>
                        <div>

                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                    </div>
                    <div class="modal-body">
                        <form class="company-form">
                            <div class="form-group mb-3">
                                <label for="cardTitle" class="form-label">Name OF card *</label>
                                <input type="text" class="form-control" id="cardTitle" placeholder="Sales metrics"
                                    value="Sales metrics">
                            </div>
                            <div class="filter-tags mt-3 d-flex flex-wrap gap-3">
                                <div class="filter-group">
                                    <select class="form-select filter-tag">
                                        <option selected="">Date Range</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <select class="form-select filter-tag">
                                        <option selected="">Assignee</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <select class="form-select filter-tag">
                                        <option selected="">Tags</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <select class="form-select filter-tag">
                                        <option selected="">Sources</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <select class="form-select filter-tag">
                                        <option selected="">Products</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <select class="form-select filter-tag">
                                        <option selected="">Territory</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="preview-section">
                                <div class="preview-header">Preview</div>

                                <!-- Metric Cards -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="metric-card new-lead">
                                            <div class="metric-title">New Lead</div>
                                            <div class="metric-value">6</div>
                                            <p class="metric-change">Down 14% From 7 This Time Last Month</p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="metric-card open-leads">
                                            <div class="metric-title">My Open Leads</div>
                                            <div class="metric-value">$5.17M</div>
                                            <p class="metric-change">Down 6% From $5.48m This Time Last Month</p>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="metric-card sales">
                                            <div class="metric-title">Sales</div>
                                            <div class="metric-value">$16.4K</div>
                                            <p class="metric-change">Down 75% From $66.2k This Time Last Month</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary">Create lead</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add Sales Metrics Modal Start -->

        <!-- Edit pipeline Modal Start -->
        <div class="modal fade" id="EditPipelineModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title" id="exampleModalLabel">Edit Pipeline card</h1>
                        <div>

                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                    </div>
                    <div class="modal-body">
                        <form class="company-form">
                            <div class="form-group mb-3">
                                <label for="cardTitle" class="form-label">Name OF card *</label>
                                <input type="text" class="form-control" id="cardTitle" placeholder="Pipeline"
                                    value="Pipeline">
                            </div>
                            <div class="filter-tags mt-3 d-flex flex-wrap gap-3">
                                <div class="filter-group">
                                    <select class="form-select filter-tag">
                                        <option selected="">Assignee</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <select class="form-select filter-tag">
                                        <option selected="">Tags</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <select class="form-select filter-tag">
                                        <option selected="">Sources</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <select class="form-select filter-tag">
                                        <option selected="">Products</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <select class="form-select filter-tag">
                                        <option selected="">Territory</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                                <div class="form-check filter-tag">
                                    <input class="form-check-input" type="checkbox" id="hotLead">
                                    <label class="form-check-label" for="hotLead">Hot leads only</label>
                                </div>
                            </div>

                            <div class="pipeline-card">
                                <div class="pipeline-header">
                                    <h2 class="section-title">Pipeline</h2>
                                    <p class="pipeline-subtitle">Default Pipeline by stage </p>
                                </div>

                                <div class="pipeline-stages">
                                    <!-- Stage 1: Int. GB Presentation -->
                                    <div class="pipeline-stage stage-1">
                                        <div class="stage-info">
                                            <div class="stage-name">Int. GB Presentation</div>
                                            <div class="stage-metrics">
                                                <span class="leads-count">104 leads</span>
                                                <span class="revenue-amount">$976k</span>
                                            </div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar"></div>
                                        </div>
                                    </div>

                                    <!-- Stage 2: Site Survey -->
                                    <div class="pipeline-stage stage-2">
                                        <div class="stage-info">
                                            <div class="stage-name">Site Survey</div>
                                            <div class="stage-metrics">
                                                <span class="leads-count">44 leads</span>
                                                <span class="revenue-amount">$286k</span>
                                            </div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar"></div>
                                        </div>
                                    </div>

                                    <!-- Stage 3: Proposal Approval -->
                                    <div class="pipeline-stage stage-3">
                                        <div class="stage-info">
                                            <div class="stage-name">Proposal Approval</div>
                                            <div class="stage-metrics">
                                                <span class="leads-count">106 leads</span>
                                                <span class="revenue-amount">$2.34m</span>
                                            </div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar"></div>
                                        </div>
                                    </div>

                                    <!-- Stage 4: Proposal Pres. -->
                                    <div class="pipeline-stage stage-4">
                                        <div class="stage-info">
                                            <div class="stage-name">Proposal Pres.</div>
                                            <div class="stage-metrics">
                                                <span class="leads-count">64 leads</span>
                                                <span class="revenue-amount">$1.56m</span>
                                            </div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar"></div>
                                        </div>
                                    </div>

                                    <!-- Stage 5: Rec. Signed Proposal -->
                                    <div class="pipeline-stage stage-5">
                                        <div class="stage-info">
                                            <div class="stage-name">Rec. Signed Proposal</div>
                                            <div class="stage-metrics">
                                                <span class="leads-count">3 leads</span>
                                                <span class="revenue-amount">$8.03k</span>
                                            </div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Edit pipeline Modal End -->

        <!-- Add LeadSummaryModal Modal Start -->
        <div class="modal fade" id="LeadSummaryModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <div>
                            <h1 class="modal-title" id="exampleModalLabel">Edit Leads Summary card</h1>
                        </div>
                        <div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                    </div>
                    <div class="modal-body">
                        <div class="customize-fields">
                            <form class="company-form">
                                <div class="form-group mb-3">
                                    <label for="lead-title" class="mb-2">Name OF card *</label>
                                    <input type="text" class="form-control" id="lead-title"
                                        placeholder="Leads Summary">
                                </div>
                                <div class="form-group">
                                    <div class="section-title">NUTSHELL FIELDS</div>
                                    <div class="fields-grid">
                                        <div>
                                            <!-- Field checkboxes (left column) -->
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="my-lead" checked>
                                                <label class="form-check-label" for="my-lead">My leads</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="Addedthisweek"
                                                    checked><label class="form-check-label" for="Addedthisweek">Added this
                                                    week</label>
                                            </div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox"
                                                    id="closing"><label class="form-check-label" for="closing">Closing
                                                    this
                                                    week </label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox"
                                                    id="lead" checked><label class="form-check-label"
                                                    for="lead">All leads
                                                </label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox"
                                                    id="watching"><label class="form-check-label" for="watching">Leads
                                                    I'm
                                                    watching</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox"
                                                    id="open-leads"><label class="form-check-label" for="open-leads">My
                                                    open
                                                    leads </label>
                                            </div>
                                        </div>
                                        <div>
                                            <!-- Field checkboxes (right column) -->
                                            <div class="form-check"><input class="form-check-input" type="checkbox"
                                                    id="hot-leads" checked><label class="form-check-label"
                                                    for="hot-leads">Hot leads </label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox"
                                                    id="all-companies"><label class="form-check-label"
                                                    for="all-companies">All companies</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox"
                                                    id="my-companies " checked><label class="form-check-label"
                                                    for="my-companies ">My companies </label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox"
                                                    id="all-people" checked><label class="form-check-label"
                                                    for="all-people">All people
                                                    number</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox"
                                                    id="my-people"><label class="form-check-label" for="my-people">My
                                                    people
                                                    to</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox"
                                                    id="marketing-contacts"><label class="form-check-label"
                                                    for="marketing-contacts">Marketing contacts</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <hr>
                                </div>
                                <div class="form-group">
                                    <div class="section-title mb-1">Lead Summary</div>
                                    <p class="text-gray mb-2">List Summary </p>
                                    <table class="table table-strip">
                                        <tbody>
                                            <tr>
                                                <td>My leads</td>
                                                <td>7</td>
                                                <td>$12k</td>
                                            </tr>
                                            <tr>
                                                <td>Added this week</td>
                                                <td>6</td>
                                                <td>$8.99k</td>
                                            </tr>
                                            <tr>
                                                <td>Closing this week</td>
                                                <td>0</td>
                                                <td>$0</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary">SAVE & UPDATE</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add AddCustomizefields Modal End -->

    </div>

@endsection


@push('scripts')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            function fetchFilteredAllActivities() {
                let filters = {
                    filter_range: $('#filter-range').val(),
                    activity_type_id: $('#filter-activity').val(),
                    status: $('#filter-status').val(),
                    section: 'logged_activities'
                };

                $.ajax({
                    url: "{{ route('admin.sales.index') }}",
                    method: "GET",
                    data: filters,
                    beforeSend: function() {
                        AppLoader.show();
                    },
                    success: function(response) {
                        $('#allActivitiesContainer').html(response.activity_html);
                    },
                    error: function() {
                        alert('Error fetching filtered activities.');
                    },
                    complete: function() {
                        AppLoader.hide();
                    }
                });
            }

            $('#filter-range, #filter-activity, #filter-status')
                .on('change', fetchFilteredAllActivities);

            function fetchFilteredTimeline() {
                console.log("Timeline filtered function called");
                let filters = {
                    filter_range: $('#filter-timeline-range').val(),
                    activity_type_id: $('#filter-timeline-activity').val(),
                    status: $('#filter-timeline-status').val(),
                    type: $('#filter-timeline-type').val(),
                    section: 'timeline'
                };

                $.ajax({
                    url: "{{ route('admin.sales.index') }}",
                    method: "GET",
                    data: filters,
                    beforeSend: function() {
                        AppLoader.show();
                    },
                    success: function(response) {
                        $('#timelineContainer').html(response.timeline_html);
                    },
                    error: function() {
                        alert('Error fetching filtered timeline.');
                    },
                    complete: function() {
                        AppLoader.hide();
                    }
                });
            }

            $('#filter-timeline-range, #filter-timeline-activity, #filter-timeline-status, #filter-timeline-type')
                .on('change', fetchFilteredTimeline);

            function fetchFilteredTask() {
                console.log("Task filtered function called");

                let filters = {
                    filter_range: $('#filter-task-range').val(),
                    status: $('#filter-task-status').val(),
                    section: 'task'
                };

                $.ajax({
                    url: "{{ route('admin.sales.index') }}", // confirm this route hits your main controller
                    method: "GET",
                    data: filters,
                    beforeSend: function() {
                        AppLoader.show();
                    },
                    success: function(response) {
                        $('#pendingTasksContainer').html(response.task_html);
                    },
                    error: function() {
                        alert('Error fetching filtered task.');
                    },
                    complete: function() {
                        AppLoader.hide();
                    }
                });
            }

            $('#filter-task-range, #filter-task-status').on('change', fetchFilteredTask);

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
                        url: '/admin/company/tasks/' + taskId + '/complete',
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
                        url: '/admin/company/tasks/' + taskId + '/reopen',
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
                        url: "/admin/company/tasks/delete/" + taskId,
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

        // Close button functionality
        document.querySelector('.btn-close').addEventListener('click', function() {
            console.log('Modal would close');
        });

        // Checkbox interaction for Choose Fields tab
        document.querySelectorAll('.form-check-input').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                console.log(`${this.id} is now ${this.checked ? 'checked' : 'unchecked'}`);
            });
        });

        // Field checkbox interaction for Re-order Fields tab
        document.querySelectorAll('.field-checkbox').forEach(checkbox => {
            checkbox.addEventListener('click', function() {
                this.classList.toggle('checked');
                if (this.classList.contains('checked')) {
                    this.innerHTML = '<i class="fas fa-check"></i>';
                } else {
                    this.innerHTML = '';
                }
            });
        });

        // Drag and drop functionality
        let draggedElement = null;

        document.querySelectorAll('.reorderable-fields .field-item').forEach(item => {
            item.addEventListener('dragstart', function(e) {
                draggedElement = this;
                this.classList.add('dragging');
                e.dataTransfer.effectAllowed = 'move';
            });

            item.addEventListener('dragend', function(e) {
                this.classList.remove('dragging');
                draggedElement = null;
            });

            item.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.dataTransfer.dropEffect = 'move';
            });

            item.addEventListener('drop', function(e) {
                e.preventDefault();
                if (draggedElement && draggedElement !== this) {
                    const container = this.parentNode;
                    const afterElement = getDragAfterElement(container, e.clientY);
                    if (afterElement == null) {
                        container.appendChild(draggedElement);
                    } else {
                        container.insertBefore(draggedElement, afterElement);
                    }
                }
            });
        });

        function getDragAfterElement(container, y) {
            const draggableElements = [...container.querySelectorAll('.field-item:not(.dragging)')];

            return draggableElements.reduce((closest, child) => {
                const box = child.getBoundingClientRect();
                const offset = y - box.top - box.height / 2;

                if (offset < 0 && offset > closest.offset) {
                    return {
                        offset: offset,
                        element: child
                    };
                } else {
                    return closest;
                }
            }, {
                offset: Number.NEGATIVE_INFINITY
            }).element;
        }

        // Redirecting user to index page of leads with attached filters
        $('.pipeline-stage').on('click', function() {
            const stageId = $(this).data('lead-stage');
            sessionStorage.setItem('selectedLeadStage', stageId);
            window.location.href = "{{ route('admin.lead.index') }}";
        });

        // When user clicks on "NEW LEAD" metric card
        $('#newLeadCard').on('click', function() {
            sessionStorage.setItem('lead_filters', JSON.stringify({
                month_to_date: true,
            }));
            window.location.href = "{{ route('admin.lead.index') }}";
        });

        // Handle "OPEN LEADS" card click
        $('#openLeadCard').on('click', function() {
            // Save both filters (Month-to-Date + Open status)
            sessionStorage.setItem('lead_filters', JSON.stringify({
                month_to_date: true,
                leads_status: ['open']
            }));
            window.location.href = "{{ route('admin.lead.index') }}";
        });

        // Handle "SALE LEADS" card click
        $('#saleLeadCard').on('click', function() {
            // Save both filters (Month-to-Date + Open status)
            sessionStorage.setItem('lead_filters', JSON.stringify({
                month_to_date: true,
                leads_status: ['won']
            }));
            window.location.href = "{{ route('admin.lead.index') }}";
        });
    </script>
@endpush
