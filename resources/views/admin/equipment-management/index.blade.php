@extends('admin.includes.layout')

@section('title', 'Equipment Report')

@section('styles')
    <style>
        .cursor-pointer {
            cursor: pointer;
        }
    </style>
@endsection


@section('content')

<div class="companies-section my-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 p-0">

                <div class="sales-dashboard">

                    <!-- HEADER (same style usage) -->
                    <div class="dashboard-header section-card d-flex justify-content-between align-items-center"
                         style="background:#ffb400;">
                        <div class="container-fluid px-0">
                            <h1 class="display-6 mb-0 text-white">Equipment Report</h1>
                        </div>
                        {{-- <button class="btn text-white fs-4">+</button> --}}
                        <button class="btn text-white fs-4" data-bs-toggle="modal" data-bs-target="#addEquipmentModal">+</button>
                    </div>

                </div>

                <!-- TABS (EXACT fulfill order structure) -->
                <nav class="nav nav-fill w-100 nav-tabs border-bottom mb-3" role="tablist">

                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#dirty">Dirty <span class="badge bg-secondary">{{ $dirtyCount }}</span></button>

                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#ready">Ready <span class="badge bg-secondary">{{ $readyCount }}</span></button>

                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#inuse">In Use <span class="badge bg-secondary">{{ $inUseCount }}</span></button>

                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#broken">Broken <span class="badge bg-secondary">{{ $brokenCount }}</span></button>

                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#lost">Lost <span class="badge bg-secondary">{{ $lostCount }}</span></button>

                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#decommissioned">Decommissioned <span class="badge bg-secondary">{{ $decommissionedCount }}</span></button>

                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#all">All <span class="badge bg-secondary">{{ $allCount }}</span></button>

                </nav>

                <!-- TAB CONTENT (same pattern as fulfill order) -->
                <div class="tab-content">

                    <div class="tab-pane fade show" id="dirty">
                        <div class="sales-dashboard">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        @foreach($dirtyTypes as $type)
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
                                                    <span class="text-primary cursor-pointer" data-id="{{ $type->id }}" data-status="{{ $type->status }}" onclick="openStatusModal(this)">
                                                        {{ ucfirst($type->status) }}
                                                    </span>
                                                </div>

                                                <div class="col-2 text-end">
                                                    <button class="btn btn-sm btn-outline-dark">
                                                        View History
                                                    </button>
                                                </div>

                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="tab-pane fade show" id="ready">
                        <div class="sales-dashboard">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        @foreach($readyTypes as $type)
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
                                                    <span class="text-primary cursor-pointer" data-id="{{ $type->id }}" data-status="{{ $type->status }}" onclick="openStatusModal(this)">
                                                        {{ ucfirst($type->status) }}
                                                    </span>
                                                </div>

                                                <div class="col-2 text-end">
                                                    <button class="btn btn-sm btn-outline-dark">
                                                        View History
                                                    </button>
                                                </div>

                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="tab-pane fade show" id="inuse">
                        <div class="sales-dashboard">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        @foreach($inUseTypes as $type)
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
                                                    <span class="text-primary cursor-pointer" data-id="{{ $type->id }}" data-status="{{ $type->status }}" onclick="openStatusModal(this)">
                                                        {{ ucfirst($type->status) }}
                                                    </span>
                                                </div>

                                                <div class="col-2 text-end">
                                                    <button class="btn btn-sm btn-outline-dark">
                                                        View History
                                                    </button>
                                                </div>

                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="tab-pane fade show" id="broken">
                        <div class="sales-dashboard">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        @foreach($brokenTypes as $type)
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
                                                    <span class="text-primary cursor-pointer" data-id="{{ $type->id }}" data-status="{{ $type->status }}" onclick="openStatusModal(this)">
                                                        {{ ucfirst($type->status) }}
                                                    </span>
                                                </div>

                                                <div class="col-2 text-end">
                                                    <button class="btn btn-sm btn-outline-dark">
                                                        View History
                                                    </button>
                                                </div>

                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="tab-pane fade show" id="lost">
                        <div class="sales-dashboard">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        @foreach($lostTypes as $type)
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
                                                    <span class="text-primary cursor-pointer" data-id="{{ $type->id }}" data-status="{{ $type->status }}" onclick="openStatusModal(this)">
                                                        {{ ucfirst($type->status) }}
                                                    </span>
                                                </div>

                                                <div class="col-2 text-end">
                                                    <button class="btn btn-sm btn-outline-dark">
                                                        View History
                                                    </button>
                                                </div>

                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="tab-pane fade show" id="decommissioned">
                        <div class="sales-dashboard">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        @foreach($decommissionedTypes as $type)
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
                                                    <span class="text-primary cursor-pointer" data-id="{{ $type->id }}" data-status="{{ $type->status }}" onclick="openStatusModal(this)">
                                                        {{ ucfirst($type->status) }}
                                                    </span>
                                                </div>

                                                <div class="col-2 text-end">
                                                    <button class="btn btn-sm btn-outline-dark">
                                                        View History
                                                    </button>
                                                </div>

                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="tab-pane fade show active" id="all">
                        <div class="sales-dashboard">

                           <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">

                                        @foreach($allTypes as $type)
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
                                                    <span class="text-primary cursor-pointer" data-id="{{ $type->id }}" data-status="{{ $type->status }}" onclick="openStatusModal(this)">
                                                        {{ ucfirst($type->status) }}
                                                    </span>
                                                </div>

                                                <div class="col-2 text-end">
                                                    <button class="btn btn-sm btn-outline-dark">
                                                        View History
                                                    </button>
                                                </div>

                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addEquipmentModal" tabindex="-1" aria-labelledby="addEquipmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">

                {{-- HEADER --}}
                <div class="modal-header">
                    <h1 class="modal-title" id="addEquipmentModalLabel">Create New Equipment</h1>
                    <div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>

                {{-- BODY --}}
                <div class="modal-body">

                    <form action="{{ route('admin.equipment-management.store') }}" method="POST">
                        @csrf

                            <div class="row mx-0">

                                {{-- Barcode --}}
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label">Barcode</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" name="barcode" class="form-control"
                                            placeholder="Enter Barcode" required>
                                    </div>
                                </div>

                                {{-- Serial Number --}}
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label">Serial Number</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" name="serial_number" class="form-control"
                                            placeholder="Enter Serial Number" required>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label">Equipment Type</label>
                                        <span class="text-danger">*</span>
                                        <select name="type_id" class="form-control" required>
                                            <option value="">Select Type</option>
                                            @foreach($equipmentTypes as $type)
                                                <option value="{{ $type->id }}">
                                                    {{ $type->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>


                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>

                    </form>

                </div>
        </div>
    </div>
</div>


<div class="modal fade" id="cleaninspectModal" tabindex="-1"  aria-labelledby="cleaninspectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Clean and Inspect Equipment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" id="cleaninspectForm" action="{{ route('admin.equipment-management.store') }}">
                @csrf

                <div class="modal-body" id="cleaninspectModalBody">
                    <div>I am certifying that I have cleaned and inspected this unit for damage.</div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Confirm</button>
                </div>

            </form>

        </div>
    </div>
</div>

<div class="modal fade" id="readyChangeStatusModal" tabindex="-1" aria-labelledby="readyChangeStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">

                {{-- HEADER --}}
                <div class="modal-header">
                    <h1 class="modal-title" id="readyChangeStatusModalLabel">Change Equipment Status</h1>
                    <div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>

                {{-- BODY --}}
                <div class="modal-body">

                    <form action="{{ route('admin.equipment-management.store') }}" method="POST">
                        @csrf

                            <div class="row mx-0">

                                {{-- Barcode --}}
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label">Document the status change</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" name="reason" class="form-control"
                                            placeholder="Enter Reason" required>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label">Status</label>
                                        <span class="text-danger">*</span>
                                        <select name="type_id" class="form-control" required>
                                            <option value="">Select Status</option>
                                            @foreach($type->getAvailableStatusOptions() as $status)
                                            <option value="{{ $status }}">
                                                {{ \App\Models\Equipment::statusLabels()[$status] ?? ucfirst($status) }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>


                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>

                    </form>

                </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>

</script>
@endpush
