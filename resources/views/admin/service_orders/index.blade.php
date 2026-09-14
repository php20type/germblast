@extends('admin.includes.layout')

@section('title', 'Service Orders')

@push('styles')
<style>
    .section-card {
        background: #ffffff !important;
        border: 1px solid #e5e7eb !important;
        border-radius: 16px !important;
        padding: 25px !important;
        margin-bottom: 25px !important;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.02) !important;
        transition: all 0.3s ease !important;
    }

    .section-card:hover {
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.04) !important;
    }

    .status-pill {
        font-size: 11px !important;
        font-weight: 700 !important;
        padding: 4px 10px !important;
        border-radius: 20px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 4px !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
        border: 1px solid transparent !important;
    }
    
    .status-pill-info {
        background-color: rgba(59, 130, 246, 0.12) !important;
        color: #3b82f6 !important;
        border-color: rgba(59, 130, 246, 0.2) !important;
    }

</style>
@endpush

@section('content')
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">
                <!-- Main Content -->
                <div class="col-md-12 p-0">
                    <div class="main-content">
                        <!-- Header -->
                        <div class="heading-area-sec mb-3">
                            <div class="left-part-sec">
                                <h3 class="mb-1 text-uppercase">SERVICE ORDERS <span style="font-size: 24px;">📋</span></h3>
                                <p class="text-muted mb-0">View and manage all service orders and their associated slots.</p>
                            </div>
                        </div>

                        <!-- Cards Content -->
                        <div class="px-4 pb-4 text-start">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
