@forelse ($orders as $order)
    <div class="section-card mt-3">
        <div class="d-flex justify-content-between align-items-start border-bottom pb-3 mb-3">
            <div class="d-flex flex-column align-items-start">
                <div class="mb-2">
                    <span class="status-pill status-pill-info">{{ $order->status ?? 'Pending' }}</span>
                </div>
                <div class="text-muted small mt-1">
                    Created on <span class="fw-semibold text-dark">{{ $order->created_at->format('M d, Y') }}</span>
                </div>
            </div>
            <div>
                <a href="{{ route('admin.lead.service.service_dashboard', $order->id) }}" class="btn btn-outline-dark btn-sm fw-bold px-3">
                    View Dashboard
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-2">
                <h6 class="text-uppercase text-secondary fw-bold mb-2" style="font-size: 11px; letter-spacing: 0.5px;">Company</h6>
                <div class="text-dark fw-bold" style="font-size: 15px; color: #374151;">
                    {{ $order->service?->lead?->company?->name ?? $order->service?->lead?->companies?->pluck('name')?->join(', ') ?: 'N/A' }}
                </div>
            </div>
            <div class="col-md-4 mb-2">
                <h6 class="text-uppercase text-secondary fw-bold mb-2" style="font-size: 11px; letter-spacing: 0.5px;">Service Name</h6>
                <div class="text-dark fw-bold" style="font-size: 15px; color: #374151;">
                    {{ $order->service->service_name ?? 'N/A' }}
                </div>
            </div>
            <div class="col-md-4 mb-2">
                <h6 class="text-uppercase text-secondary fw-bold mb-2" style="font-size: 11px; letter-spacing: 0.5px;">Order No</h6>
                <div class="text-dark" style="font-size: 15px; color: #374151;">
                    {{ $order->order_no ?? 'N/A' }}
                </div>
            </div>
        </div>

        @if($order->orderSlots && $order->orderSlots->count() > 0)
            <div class="mt-4 pt-3 border-top">
                <h6 class="text-uppercase text-secondary fw-bold mb-3" style="font-size: 11px; letter-spacing: 0.5px;">Associated Slots</h6>
                <div class="table-responsive">
                    <table class="table table-hover w-100 equipment-report-table">
                        <thead>
                            <tr>
                                <th>Start Date/Time</th>
                                <th>End Date/Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderSlots as $slot)
                                <tr>
                                    <td>{{ $slot->scheduled_start_time ? \Carbon\Carbon::parse($slot->scheduled_start_time)->format('M d, Y h:i A') : 'N/A' }}</td>
                                    <td>{{ $slot->scheduled_end_time ? \Carbon\Carbon::parse($slot->scheduled_end_time)->format('M d, Y h:i A') : 'N/A' }}</td>
                                    <td>{{ $slot->status ?? 'Pending' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@empty
    <div class="text-center py-5 text-muted">
        <div class="mb-3" style="font-size: 40px;">📭</div>
        <h5 class="fw-semibold text-dark">No Service Orders Found</h5>
        <p>There are currently no active service orders.</p>
    </div>
@endforelse

@if($orders->hasPages())
    <div class="mt-4 pagination-container">
        {{ $orders->links('pagination::bootstrap-5') }}
    </div>
@endif
