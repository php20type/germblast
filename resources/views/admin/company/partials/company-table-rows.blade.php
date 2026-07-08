 @forelse ($companies as $company)
     <tr>
         <td>
             <input type="checkbox" class="form-check-input row-checkbox">
         </td>
         <td>
             <div class="company-name">
                 @can('company.detail.view')
                     <a href="{{ route('admin.company.show', $company->id) }}" class="text-decoration-none text-dark">
                         {{ $company->name ?? 'N/A' }}
                     </a>
                 @else
                     <span class="text-dark">
                         {{ $company->name ?? 'N/A' }}
                     </span>
                 @endcan
             </div>
             <div class="company-name">
                 {{ $company->assignee->name ?? 'N/A' }}
             </div>
         </td>
         <td>
             {{ $company->peoples->pluck('name')->join(', ') ?: 'N/A' }}
         </td>
         {{-- peoples of that company info --}}
         <td>{{ \Carbon\Carbon::parse($company->created_at)->format('d F Y') }}</td>
         <td>
             {{ $company->locations->first()->full_address ?? 'N/A' }}
         </td>
         <td><span class="badge-customer">
                 {{ $company->companyType->type ?? 'N/A' }}
             </span></td>
         <td>
             @if ($company->tags->isNotEmpty())
                 @foreach ($company->tags as $tag)
                     <span class="badge-customer">{{ $tag->name }}</span>
                 @endforeach
             @else
                 <span>N/A</span>
             @endif
         </td>
     </tr>
 @empty
     <tr>
         <td colspan="9" class="text-center">No Companies found</td>
     </tr>
 @endforelse
