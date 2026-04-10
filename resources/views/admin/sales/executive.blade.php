@extends('admin.includes.layout')

@section('title', 'Executive Sales Dashboard')

@section('content')


    <!-- All Companies Section start  -->
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                @include('admin.sales.sidebar')

                <!-- Main Content -->
                <div class="col-md-10 p-0">
                    <div class="sales-dashboard">

                        {{-- HEADER BAR --}}
                        <div style="background:#ffb81c; padding:8px 10px; border-radius:4px 4px 0 0;">
                            <div class="d-flex justify-content-between align-items-center">

                                <a href="{{ route('admin.sales.executive', ['date' => $start->copy()->subMonth()->toDateString()]) }}"
                                class="btn btn-light btn-sm">
                                    << Previous Month
                                </a>

                                <div>
                                    Month of: {{ $start->format('F Y') }}
                                    <a href="{{ route('admin.sales.executive', ['date' => now()->toDateString()]) }}" class="btn btn-light btn-sm ms-2">
                                        Current Month
                                    </a>
                                </div>

                                <a href="{{ route('admin.sales.executive', ['date' => $start->copy()->addMonth()->toDateString()]) }}"
                                class="btn btn-light btn-sm">
                                    Next Month >>
                                </a>

                            </div>
                        </div>

                        {{-- MAIN GRID --}}
                        <div style="background:#e5e5e5; padding:10px; border:1px solid #999;">

                            <!-- Services This Month Section -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header">
                                            <div>
                                                <h3 class="section-title">SERVICES THIS MONTH</h3>
                                                <p class="section-subtitle">All active services for this month</p>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Client</th>
                                                        <th>Status</th>
                                                        <th>Service ID</th>
                                                        <th>Service Value</th>
                                                        <th>Assignee</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($servicesThisMonth as $service)
                                                        <tr>
                                                            {{-- CLIENT --}}
                                                            <td>
                                                                @if ($service->lead?->company)
                                                                    <a href="{{ route('admin.company.show', $service->lead->company->id) }}"
                                                                        class="text-decoration-none">
                                                                        {{ $service->lead->company->name }}
                                                                    </a>
                                                                @else
                                                                    {{ $service->lead?->name ?? 'N/A' }}
                                                                @endif
                                                            </td>

                                                            {{-- STATUS (dynamic based on lead) --}}
                                                            <td>
                                                                @php
                                                                    $status = $service->lead->lead_status ?? 'open';
                                                                    $badge = match($status) {
                                                                        'won' => 'success',
                                                                        'lost' => 'danger',
                                                                        default => 'primary'
                                                                    };
                                                                @endphp
                                                                <span class="badge bg-{{ $badge }}">
                                                                    {{ ucfirst($status) }}
                                                                </span>
                                                            </td>

                                                            {{-- SERVICE ID --}}
                                                            <td>{{ $service->id }}</td>

                                                            {{-- VALUE --}}
                                                            <td>
                                                                ${{ number_format($service->total_price ?? 0, 2) }}
                                                            </td>

                                                            {{-- ASSIGNEE --}}
                                                            <td>
                                                                {{ $service->lead?->assignee?->name ?? 'Unassigned' }}
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="5" class="text-center text-muted">
                                                                No services found for this month.
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Service Value Reports Row -->
                            <div class="row">
                                {{-- INDUSTRY --}}
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header">
                                            <div>
                                                <h3 class="section-title">SERVICE VALUE BY INDUSTRY TYPE</h3>
                                                <p class="section-subtitle">Industry breakdown</p>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Industry</th>
                                                        <th>Service Value</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($serviceValueByIndustry->sortDesc() as $industry => $value)
                                                        <tr>
                                                            <td>
                                                                {{ $industry && $industry !== 'Unknown' ? $industry : 'Unknown' }}
                                                            </td>
                                                            <td>
                                                                ${{ number_format($value ?? 0, 2) }}
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="2" class="text-center text-muted">
                                                                No data available.
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                {{-- ASSIGNEE --}}
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header">
                                            <div>
                                                <h3 class="section-title">SERVICE VALUE BY ASSIGNEE / SALES REP</h3>
                                                <p class="section-subtitle">Top assignees this month</p>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Assignee</th>
                                                        <th>Service Value</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($serviceValueByAssignee->sortDesc() as $assignee => $value)
                                                        <tr>
                                                            <td>
                                                                {{ $assignee ?? 'Unassigned' }}
                                                            </td>
                                                            <td>
                                                                ${{ number_format($value ?? 0, 2) }}
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="2" class="text-center text-muted">
                                                                No data available.
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Top 10 Clients and Contracts Won Row -->
                            <div class="row">

                                {{-- TOP CLIENTS --}}
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header">
                                            <div>
                                                <h3 class="section-title">TOP 10 CLIENTS BY SERVICE VALUE</h3>
                                                <p class="section-subtitle">Highest value clients this month</p>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Client</th>
                                                        <th>Total Services</th>
                                                        <th>Service Value</th>
                                                        <th>Assignee</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($topClients as $client)
                                                        <tr>
                                                            {{-- CLIENT --}}
                                                            <td>{{ $client['company'] ?? 'N/A' }}</td>

                                                            {{-- COUNT --}}
                                                            <td>{{ $client['services']->count() }}</td>

                                                            {{-- VALUE --}}
                                                            <td>${{ number_format($client['total_value'] ?? 0, 2) }}</td>

                                                            {{-- ASSIGNEE --}}
                                                            <td>
                                                                {{ $client['services']->first()?->lead?->assignee?->name ?? 'Unassigned' }}
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="4" class="text-center text-muted">
                                                                No clients found.
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                {{-- CONTRACTS WON --}}
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header">
                                            <div>
                                                <h3 class="section-title">CONTRACTS WON THIS MONTH</h3>
                                                <p class="section-subtitle">Won contracts summary</p>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Client</th>
                                                        <th># of Services</th>
                                                        <th>Service Value</th>
                                                        <th>Assignee</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($contractsWon as $contract)
                                                        <tr>
                                                            <td>{{ $contract['company'] ?? 'N/A' }}</td>
                                                            <td>{{ $contract['count'] }}</td>
                                                            <td>${{ number_format($contract['total_value'] ?? 0, 2) }}</td>
                                                            <td>{{ $contract['assignee'] ?? 'Unassigned' }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="4" class="text-center text-muted">
                                                                No contracts found.
                                                            </td>
                                                        </tr>
                                                    @endforelse

                                                    {{-- TOTAL --}}
                                                    <tr>
                                                        <td colspan="4" class="text-center fw-bold">
                                                            NEW CONTRACT VALUE: ${{ number_format($newContractValue ?? 0, 2) }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
        <!-- All Companies Section End  -->
    </div>

@endsection


@push('scripts')
    <script>
        $(document).ready(function() {

        });

    </script>
@endpush
