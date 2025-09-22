 @forelse ($companies as $company)
     <tr>
         <td>
             <input type="checkbox" class="form-check-input row-checkbox">
         </td>
         <td>
             <div class="company-name">
                 <a href="{{ route('admin.companies.show', $company->id) }}" class="text-decoration-none text-dark">
                     {{ $company->name ?? 'N/A' }}
                 </a>
             </div>
             <div class="company-name">
                 {{ $company->peoples->first()?->name ?? 'N/A' }}
             </div>
         </td>
         <td>
             {{ $company->peoples->pluck('name')->join(', ') ?: 'N/A' }}
         </td>
         {{-- peoples of that company info --}}
         <td>{{ \Carbon\Carbon::parse($company->created_at)->format('d F Y') }}</td>
         <td>
             {{ $company->companyAddress->address ?? 'N/A' }}
         </td>
         <td><span class="badge-customer">
                 {{ $company->companyType->type ?? 'N/A' }}
             </span></td>
         <td>
             <span class="badge-customer">
                 {{ $company->tag->name ?? 'N/A' }}
             </span>
         </td>
     </tr>
 @empty
     <tr>
         <td colspan="9" class="text-center">No Companies found</td>
     </tr>
 @endforelse
