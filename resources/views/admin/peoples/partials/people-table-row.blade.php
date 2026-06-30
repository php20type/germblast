@forelse ($peoples as $people)
    <tr>
        <td><input type="checkbox" class="form-check-input row-checkbox">
        </td>
        <td>
            <div class="person-name">
                @can('people.detail.view')
                    <a href="{{ route('admin.people.show', $people->id) }}" class="text-decoration-none text-dark">
                        {{ $people->name ?? 'N/A' }}
                    </a>
                @else
                    <span class="text-dark">
                        {{ $people->name ?? 'N/A' }}
                    </span>
                @endcan
            </div>
            <div class="company-name">
                {{ $people->companies->first()->name ?? 'N/A' }}
            </div>
            @if(!empty($people->contact_types))
                <div class="contact-types-list mt-1 d-flex flex-wrap gap-1">
                    @foreach($people->contact_types as $type)
                        <span class="badge bg-light text-dark border px-1 py-0.5" style="font-size: 0.65rem; font-weight: 500; text-transform: uppercase; border-radius: 3px;">
                            {{ $type }}
                        </span>
                    @endforeach
                </div>
            @endif
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
            @if ($people->tags->isNotEmpty())
                @foreach ($people->tags as $tag)
                    <span class="badge-customer">{{ $tag->name }}</span>
                @endforeach
            @else
                <span>N/A</span>
            @endif
        </td>
    </tr>
@empty
    <tr>
        <td colspan="9" class="text-center">No peoples found</td>
    </tr>
@endforelse
