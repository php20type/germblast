 @forelse ($groupedLeads as $lead)
     <tr>
         <td><input type="checkbox" class="form-check-input row-checkbox"></td>

         <td>
             <div class="company-name">
                 <a href="{{ route('admin.leads.show', $lead['id']) }}" class="text-decoration-none text-dark">
                     {{ $lead['name'] }}
                 </a>
             </div>
             <div class="company-name">{{ $lead['people_name'] }}</div>
         </td>

         <td>{{ $lead['created_at'] }}</td>
         <td>${{ number_format($lead['total_price'], 2) }}</td>
         <td>{{ $lead['assignee'] }}</td>
         <td>Proposal Approval</td>
         <td>{{ $lead['confidence'] }}%</td>
         <td>{{ $lead['close_date'] }}</td>
         <td>{{ $lead['sources'] }}</td>
     </tr>
 @empty
     <tr>
         <td colspan="9" class="text-center">No leads found</td>
     </tr>
 @endforelse
