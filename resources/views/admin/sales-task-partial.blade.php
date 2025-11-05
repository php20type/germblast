@foreach ($alltasks as $task)
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
                        <button class="btn btn-sm btn-outline-success mark-complete-btn" title="Mark as Completed"
                            data-id="{{ $task->id }}">
                            <i class="fas fa-check"></i>
                        </button>

                        <!-- Edit -->
                        <button class="btn btn-sm btn-outline-primary toggleEditTask" data-id="{{ $task->id }}"
                            data-title="{{ $task->title }}" data-due="{{ $task->due_time }}"
                            data-user="{{ $task->assignee_id }}" data-description="{{ $task->description }}"
                            title="Edit Task">
                            <i class="fas fa-edit"></i>
                        </button>

                        <!-- Delete -->
                        <button class="btn btn-sm btn-outline-secondary delete-task-btn" title="Delete Task"
                            data-id="{{ $task->id }}">
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
