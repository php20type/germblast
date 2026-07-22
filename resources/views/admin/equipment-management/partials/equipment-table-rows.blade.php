@forelse($types as $type)
    <tr>
        <td>
            <span class="fw-semibold text-dark">{{ $type->type->name ?? '-' }}</span>
        </td>
        <td>{{ $type->barcode }}</td>
        <td>{{ $type->serial_number ?? 'N/A' }}</td>
        <td>
            @php
                $mappedStatus = config("mapping.equipment_status.{$type->status}", 'unknown');
                $statusSlug = strtolower($mappedStatus);
                $pillClass = 'status-pill-' . $statusSlug;
            @endphp
            @can('equipment_manager.add')
                <span class="status-pill {{ $pillClass }} cursor-pointer" data-id="{{ $type->id }}"
                    data-status="{{ $mappedStatus }}" onclick="openStatusModal(this)">
                    {{ ucfirst($mappedStatus) }}
                </span>
            @else
                <span class="status-pill {{ $pillClass }}">
                    {{ ucfirst($mappedStatus) }}
                </span>
            @endcan
        </td>
        <td class="text-center">
            <button class="btn btn-sm btn-outline-dark me-2" style="border-radius: 6px; padding: 6px 14px;"
                data-id="{{ $type->id }}" onclick="openHistoryModal(this)">
                View History
            </button>
        </td>
    </tr>
@empty
    {{-- Empty state handled by DataTable --}}
@endforelse