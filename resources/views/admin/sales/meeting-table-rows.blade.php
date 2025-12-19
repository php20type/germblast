 @forelse ($meetings as $meeting)
     <tr>
         {{-- Checkbox --}}
         <td class="checkbox-cell">
             <input type="checkbox" class="form-check-input row-checkbox" data-id="{{ $meeting->id }}">
         </td>

         {{-- Meeting Name --}}
         <td>
             <strong>{{ $meeting->name }}</strong>
         </td>

         {{-- Type --}}
         <td>
             @if ($meeting->meeting_type === 'zoom')
                 <span class="badge-customer">Zoom</span>
             @else
                 <span class="badge-prospect">Live</span>
             @endif
         </td>

         {{-- Date & Time --}}
         <td>
             {{ \Carbon\Carbon::parse($meeting->date)->format('d M Y') }}<br>
             <small class="text-muted">
                 {{ \Carbon\Carbon::parse($meeting->start_time)->format('h:i A') }}
                 –
                 {{ \Carbon\Carbon::parse($meeting->end_time)->format('h:i A') }}
             </small>
         </td>

         <td>
             {{ $meeting->status ?? 'N/A' }}
         </td>

         <td>
             {{ $meeting->activityType->type ?? 'N/A' }}
         </td>

         {{-- Actions --}}
         <td class="text-center">
             <button class="btn btn-sm btn-outline-info view-meeting" data-id="{{ $meeting->id }}">
                 <i class="fa fa-eye"></i>
             </button>

             {{-- Edit & Delete ONLY for meeting owner --}}
             @if ($meeting->user_id === auth()->id())
                 @if ($meeting->status !== 'Completed')
                     <button type="button" class="btn btn-sm btn-outline-primary edit-meeting"
                         data-id="{{ $meeting->id }}">
                         <i class="fa fa-edit"></i>
                     </button>

                     <button type="button" class="btn btn-sm btn-outline-success complete-meeting"
                         data-id="{{ $meeting->id }}">
                         <i class="fa fa-check"></i>
                     </button>
                 @endif

                 <button type="button" class="btn btn-sm btn-outline-danger delete-meeting"
                     data-id="{{ $meeting->id }}">
                     <i class="fa fa-trash"></i>
                 </button>
             @endif
         </td>
     </tr>
 @empty
     <tr>
         <td colspan="9" class="text-center text-muted">
             No meetings scheduled.
         </td>
     </tr>
 @endforelse
