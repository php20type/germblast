@forelse($types as $type)
    <div class="row align-items-center border-bottom py-3">

        <div class="col-3 fw-semibold">
            {{ $type->type->name ?? '-' }}
        </div>

        <div class="col-2">
            Barcode: {{ $type->barcode }}
        </div>

        <div class="col-2">
            Serial #: {{ $type->serial_number ?? 'N/A' }}
        </div>

        <div class="col-3">
            Status:
            <span class="text-primary cursor-pointer" data-id="{{ $type->id }}"
                data-status="{{ $type->status }}" onclick="openStatusModal(this)">
                {{ ucfirst($type->status) }}
            </span>
        </div>

        <div class="col-2 text-end">
            <button class="btn btn-sm btn-outline-dark" data-id="{{ $type->id }}" onclick="openHistoryModal(this)">
                View History
            </button>
        </div>

    </div>
@empty
    <div class="row border-bottom py-3">
        <div class="col-12 text-center text-muted">No equipment found.</div>
    </div>
@endforelse
