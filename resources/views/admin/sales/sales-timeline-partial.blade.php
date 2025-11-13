 @foreach ($timeline as $item)
     @if ($item->type === 'activity')
         <div class="timeline-item">
             {{-- <div class="timeline-icon">
                                                                    <i class="{{ $item->activityType->icon }}"></i>
                                                                </div> --}}
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
                             <button class="btn btn-sm btn-outline-primary me-1 add-comment-btn" title="Add Comment"
                                 data-type="Activity" data-id="{{ $item->id }}">
                                 <i class="fas fa-comment"></i>
                             </button>
                             <button class="btn btn-sm btn-outline-danger delete-activity-btn" title="Delete Activity"
                                 data-type="Activity" data-id="{{ $item->id }}">
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
                                         <span><i class="fas fa-pen-to-square text-primary me-1"></i></span>
                                         {{ $item->note }}
                                     </div>
                                     <div class="text-muted">
                                         <span><i class="fas fa-file-alt text-warning me-1"></i></span>
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
                                 <div class="d-flex justify-content-between align-items-center mb-2">
                                     <div>
                                         <span class="comment-avatar">
                                             {{ strtoupper(substr($comment->creator->name ?? 'N/A', 0, 2)) }}
                                         </span>
                                         <span class="comment-text">{{ $comment->comment }}</span>
                                     </div>
                                     <span class="btn btn-sm delete-comment-btn" data-id="{{ $comment->id }}"
                                         data-type="Activity">
                                         <i class="fas fa-times"></i>
                                     </span>
                                 </div>
                             @endforeach
                         </div>
                     @endif

                     <div class="mt-3 d-none add-comment" data-id="{{ $item->id }}" data-type="Activity">
                         <textarea id="activity-comment-textarea" name="comment_text" class="form-textarea"
                             placeholder="Write a comment…"data-tribute="true" style="width:100%"></textarea>

                         <button class="mt-3 btn btn-sm btn-outline-success add-comment-submit" title="">
                             Add Comment
                         </button>
                         <button class="mt-3 btn btn-sm btn-outline-danger comment-cancel" title="Close">
                             Close
                         </button>
                     </div>

                 </div>

             </div>
         </div>
     @elseif ($item->type === 'note')
         <div class="timeline-item">
             {{-- <div class="timeline-icon">
                                                                    <i class="fas fa-sticky-note"></i>
                                                                </div> --}}
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
                             <button class="btn btn-sm btn-outline-primary me-1 add-comment-btn" title="Add Comment"
                                 data-type="Note" data-id="{{ $item->id }}">
                                 <i class="fas fa-comment"></i>
                             </button>
                             <button class="btn btn-sm btn-outline-danger delete-note-btn" title="Delete Note"
                                 data-type="Note" data-id="{{ $item->id }}">
                                 <i class="fas fa-times"></i>
                             </button>
                         </div>
                     </div>


                     <div class="activity-details">
                         <div class="row">
                             <div class="col-10">
                                 <div class="activity-description">
                                     <div class="text-muted mb-2">
                                         <span><i class="fas fa-pen-to-square text-primary me-1"></i></span>
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
                                 <div class="d-flex justify-content-between align-items-center mb-2">
                                     <div>
                                         <span class="comment-avatar">
                                             {{ strtoupper(substr($comment->creator->name ?? 'N/A', 0, 2)) }}
                                         </span>
                                         <span class="comment-text">{{ $comment->comment }}</span>
                                     </div>
                                     <span class="btn btn-sm delete-comment-btn" data-id="{{ $comment->id }}"
                                         data-type="Activity">
                                         <i class="fas fa-times"></i>
                                     </span>
                                 </div>
                             @endforeach
                         </div>
                     @endif

                     <div class="mt-3 d-none add-comment" data-id="{{ $item->id }}" data-type="Note">
                         <textarea id="note-comment-textarea" name="comment_text" class="form-textarea"
                             placeholder="Write a comment…"data-tribute="true" style="width:100%"></textarea>

                         <button class="mt-3 btn btn-sm btn-outline-success add-comment-submit" title="">
                             Add Comment
                         </button>
                         <button class="mt-3 btn btn-sm btn-outline-danger comment-cancel" title="Close">
                             Close
                         </button>
                     </div>

                 </div>

             </div>
         </div>
     @elseif ($item->type === 'timeline')
         <div class="timeline-item">
             {{-- <div class="timeline-icon">
                                                                    <i class="fas fa-angle-double-right"></i>
                                                                </div> --}}
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
             {{-- <div class="timeline-icon">
                                                                    <i class="fa-brands fa-web-awesome"></i>
                                                                </div> --}}
             <strong>🎉 {{ $item->title }}</strong>
             <span class="text-muted">{{ $item->timestamp->format('M d, Y') }}</span>
         </div>
     @endif
 @endforeach
