@forelse ($peoples as $people)
    <tr>
        <td><input type="checkbox" class="form-check-input row-checkbox">
        </td>
        <td>
            <div class="person-name">
                <a href="{{ route('admin.peoples.show', $people->id) }}" class="text-decoration-none text-dark">
                    {{ $people->name ?? 'N/A' }}
                </a>
            </div>
            <div class="company-name">
                {{ $people->companiesAlt->first()->name ?? 'N/A' }}
            </div>
        </td>
        <td>
            {{ \Carbon\Carbon::parse($people->created_at)->format('j F Y') }}
        </td>
        <td>
            {{ $people->peopleEmail->email ?? 'N/A' }}
        </td>
        <td>
            {{ $people->peoplePhone->phone ?? 'N/A' }}
        </td>
        <td>
             {{ $people->peopleAddress->address ?? 'N/A' }}
        </td>
        <td>
            <span class="badge-customer">
                {{ $people->tag->name ?? 'N/A' }}
            </span>
        </td>
        <td class="company-count">
             {{ $people->marketing_status ?? 'N/A' }}
        </td>
    </tr>
@empty
    <tr>
        <td colspan="9" class="text-center">No peoples found</td>
    </tr>
@endforelse
