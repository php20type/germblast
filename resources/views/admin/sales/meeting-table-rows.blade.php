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
                 <span class="badge bg-primary">Zoom</span>
             @else
                 <span class="badge bg-success">Live</span>
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

         {{-- Duration --}}
         <td>
             {{ $meeting->duration }} mins
         </td>

         {{-- Activity Type --}}
         <td>
             {{ $meeting->activityType->type ?? '-' }}
         </td>

         {{-- Status --}}
         <td>
             @php
                 $status = $meeting->zoom->status ?? $meeting->status;
             @endphp

             <span class="badge bg-secondary">
                 {{ ucfirst($status) }}
             </span>
         </td>

         {{-- Location / Join Link --}}
         <td>
             @if ($meeting->meeting_type === 'zoom' && $meeting->zoom?->join_url)
                 <a href="{{ $meeting->zoom->join_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                     Join Zoom
                 </a>
             @else
                 {{ $meeting->location }}
             @endif
         </td>

         {{-- Actions --}}
         <td>
             <button type="button" class="btn btn-sm btn-outline-primary edit-meeting" data-id="{{ $meeting->id }}">
                 <i class="fa fa-edit"></i>
             </button>

             <button type="button" class="btn btn-sm btn-outline-danger delete-meeting" data-id="{{ $meeting->id }}">
                 <i class="fa fa-trash"></i>
             </button>
         </td>
     </tr>
 @empty
     <tr>
         <td colspan="9" class="text-center text-muted">
             No meetings scheduled.
         </td>
     </tr>
 @endforelse
