@forelse($types as $type)
    <tr>
        <td>
            <span class="fw-semibold text-dark">{{ $type->type->name ?? '-' }}</span>
        </td>
        <td>{{ $type->barcode }}</td>
        <td>{{ $type->serial_number ?? 'N/A' }}</td>
        <td>
            @php
                $statusSlug = strtolower($type->status);
                $pillClass = 'status-pill-' . $statusSlug;
            @endphp
            <span class="status-pill {{ $pillClass }} cursor-pointer" data-id="{{ $type->id }}"
                data-status="{{ $type->status }}" onclick="openStatusModal(this)">
                {{ ucfirst($type->status) }}
            </span>
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