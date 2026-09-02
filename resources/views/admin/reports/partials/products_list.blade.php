                            <!-- TOP PRODUCTS CHART SECTION -->
                            <div class="corp-section-card mt-3 bg-white p-4 rounded border">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="fw-bold m-0" style="color: #1f2937;">Top products</h5>
                                    
                                    <!-- Toggle -->
                                    <div class="d-flex bg-white rounded-pill border p-1">
                                        <a href="{{ route('admin.reports.products', ['period' => request('period', 'year'), 'offset' => $offset, 'sort' => 'revenue', 'status' => $status]) }}" 
                                            class="btn btn-sm px-3 rounded-pill text-decoration-none {{ $sort == 'revenue' ? 'text-primary fw-bold active-toggle' : 'text-muted fw-bold' }}" 
                                            style="{{ $sort == 'revenue' ? 'background: rgba(255, 184, 28, 0.1);' : '' }}">
                                            <i class="fas fa-dollar-sign me-1"></i> Value
                                        </a>
                                        <a href="{{ route('admin.reports.products', ['period' => request('period', 'year'), 'offset' => $offset, 'sort' => 'quantity', 'status' => $status]) }}" 
                                            class="btn btn-sm px-3 rounded-pill text-decoration-none {{ $sort == 'quantity' ? 'text-primary fw-bold active-toggle' : 'text-muted fw-bold' }}"
                                            style="{{ $sort == 'quantity' ? 'background: rgba(255, 184, 28, 0.1);' : '' }}">
                                            <i class="fas fa-hashtag me-1"></i> Quantity
                                        </a>
                                    </div>
                                </div>

                                @php
                                    $metric = $sort == 'revenue' ? 'revenue' : 'quantity';
                                    $totalMetricValue = $sort == 'revenue' ? $totalValue : $totalQuantity;
                                @endphp

                                <!-- STACKED BAR -->
                                <div class="stacked-bar-container">
                                    @if($totalMetricValue > 0)
                                        @foreach($chartData['top'] as $index => $item)
                                            @php
                                                $pct = ($item[$metric] / $totalMetricValue) * 100;
                                            @endphp
                                            @if($pct > 0)
                                                <div class="stacked-segment segment-{{ $index }}" style="width: {{ $pct }}%;"
                                                     data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"
                                                     title="<div class='text-start'><strong>{{ $item['name'] }}</strong><br>Revenue: US${{ number_format($item['revenue'], 0) }}<br>Quantity: {{ number_format($item['quantity']) }}<br>Leads: {{ $item['leads_count'] }}</div>">
                                                    @if($pct > 5)
                                                        <span>{{ number_format($pct, 0) }}%</span>
                                                        <span>
                                                            {{ $sort == 'revenue' ? 'US$' . number_format($item['revenue'] / 1000, 1) . 'k' : number_format($item['quantity']) }}
                                                        </span>
                                                    @endif
                                                </div>
                                            @endif
                                        @endforeach

                                        @if($chartData['other']['count'] > 0 && $chartData['other'][$metric] > 0)
                                            @php
                                                $otherPct = ($chartData['other'][$metric] / $totalMetricValue) * 100;
                                            @endphp
                                            <div class="stacked-segment segment-other" style="width: {{ $otherPct }}%;"
                                                 data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"
                                                 title="<div class='text-start'><strong>Other ({{ $chartData['other']['count'] }} products)</strong><br>Revenue: US${{ number_format($chartData['other']['revenue'], 0) }}<br>Quantity: {{ number_format($chartData['other']['quantity']) }}</div>">
                                                @if($otherPct > 5)
                                                    <span>{{ number_format($otherPct, 0) }}%</span>
                                                    <span>
                                                        {{ $sort == 'revenue' ? 'US$' . number_format($chartData['other']['revenue'] / 1000, 1) . 'k' : number_format($chartData['other']['quantity']) }}
                                                    </span>
                                                @endif
                                            </div>
                                        @endif
                                    @else
                                        <div class="stacked-segment segment-other w-100 text-muted">No data available</div>
                                    @endif
                                </div>

                                <!-- LEGEND -->
                                <div class="legend-container">
                                    @foreach($chartData['top'] as $index => $item)
                                        <div class="legend-item">
                                            <div class="legend-color segment-{{ $index }}"></div>
                                            <span>{{ $item['name'] }}</span>
                                        </div>
                                    @endforeach
                                    @if($chartData['other']['count'] > 0)
                                        <div class="legend-item">
                                            <div class="legend-color segment-other"></div>
                                            <span>Other ({{ $chartData['other']['count'] }} products)</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- KPI Row -->
                                <div class="row mt-4 pt-4 border-top mx-0">
                                    <div class="col-md-3 kpi-card">
                                        <div class="kpi-label mb-1">Total quantity</div>
                                        <div class="kpi-value">{{ number_format($totalQuantity) }}</div>
                                    </div>
                                    <div class="col-md-3 kpi-card">
                                        <div class="kpi-label mb-1">Unique products</div>
                                        <div class="kpi-value">{{ $uniqueProductsCount }}</div>
                                    </div>
                                    <div class="col-md-3 kpi-card">
                                        <div class="kpi-label mb-1">Total value</div>
                                        <div class="kpi-value">US${{ number_format($totalValue, 0) }}</div>
                                    </div>
                                    <div class="col-md-3 kpi-card border-0">
                                        <div class="kpi-label mb-1">Number of leads</div>
                                        <div class="kpi-value">{{ number_format($totalLeadsCount) }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- PRODUCTS TABLE -->
                            <div class="table-responsive mt-4">
                                <div class="table-container p-0">
                                    <table class="table table-hover mb-0 product-table">
                                        <thead>
                                            <tr>
                                                <th style="width: 30%;">Product</th>
                                                <th style="width: 20%;">Category</th>
                                                <th style="width: 15%;">SKU</th>
                                                <th class="text-end" style="width: 15%;">
                                                    @if($sort == 'revenue') <i class="fas fa-arrow-down text-primary me-1"></i> @endif Revenue
                                                </th>
                                                <th class="text-end" style="width: 10%;">
                                                    @if($sort == 'quantity') <i class="fas fa-arrow-down text-primary me-1"></i> @endif Quantity
                                                </th>
                                                <th class="text-end" style="width: 10%;">Leads</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($paginatedProducts as $product)
                                            <tr>
                                                <td class="text-dark fw-semibold">{{ $product['name'] }}</td>
                                                <td class="text-muted">{{ $product['category'] }}</td>
                                                <td class="text-muted">{{ $product['sku'] }}</td>
                                                <td class="text-end text-muted fw-semibold">US${{ number_format($product['revenue'], 0) }}</td>
                                                <td class="text-end text-muted">{{ number_format($product['quantity']) }}</td>
                                                <td class="text-end">
                                                    <a href="#" class="text-primary text-decoration-none">{{ $product['leads_count'] }} leads</a>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-4 text-muted">No products found for this period.</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            <!-- Pagination Links -->
                            @if($paginatedProducts->hasPages())
                                <div class="row m-3">
                                    <div class="col-12 mt-3">
                                        {{ $paginatedProducts->links('pagination::bootstrap-5') }}
                                    </div>
                                </div>
                            @endif
