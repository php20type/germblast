@extends('admin.includes.layout')

@section('title', 'Hot Leads')

@section('content')

    <main class="app-wrapper">
        <!-- All Companies Section start  -->
        <div class="companies-section my-4">
            <div class="container-fluid">
                <div class="row">
                    <!-- Sidebar -->
                    @include('admin.leads.sidebar')

                    <!-- Main Content -->
                    <div class="col-md-10 p-0">
                        <div class="main-content">
                            <!-- Header -->
                            <div class="heading-area-sec">
                                <div class="left-part-sec">
                                    <h3 class="mb-1">HOT LEADS <i class="fas fa-thumbtack pinned-icon"></i></h3>
                                    <p class="text-muted mb-0">Business deals with your companies and people</p>
                                </div>
                                 <div class="d-none right-part">
                                    <button class="btn btn-email">Email</button>
                                    <button class="btn btn-export">EXPORT</button>
                                </div>
                            </div>

                            <!-- Filter Section -->
                            <div class="filter-section">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center position-relative">
                                            <div class="search-form">
                                                <input type="search" class="form-control" placeholder=""
                                                    aria-label="Search" id="lead-search">
                                            </div>
                                            <span class="company-count">{{ $formattedTotalLeads }} Lead Found</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="d-flex align-items-center justify-content-end dropdown">
                                            <div class="me-2 form-check">
                                                <input class="form-check-input" type="checkbox" value="hot"
                                                    id="checkDefault" name="hot">
                                                <label class="form-check-label" for="checkDefault">Only Hot</label>
                                            </div>
                                            <div class="me-2">
                                                <select class="form-select" name="status" aria-label="Status select">
                                                    <option value="">Status</option>
                                                    <option value="open">Open</option>
                                                    <option value="lost">Lost</option>
                                                    <option value="won">Won</option>
                                                    <option value="cancelled">Cancelled</option>
                                                    <option value="pending">Pending</option>
                                                </select>
                                            </div>
                                            <div class="me-2">
                                                <select class="form-select" name="user_id" aria-label="Assigned to select">
                                                    <option value="">Assignee</option>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <button class="d-none btn btn-primary me-2"><img
                                                    src="{{ asset('img/icons/filter.svg') }}" alt="" /></button>
                                            <button class="d-none btn btn-primary"><img
                                                    src="{{ asset('img/icons/bar.svg') }}" alt="" /></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="filter-value">
                                <div class="row">
                                    <div class="col-lg-3 col-md-6">
                                        <div class="filter-card">
                                            <h5>Total value:<span>${{ $formattedTotalValue }}</span></h5>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="filter-card">
                                            <h5>Avg value:<span>${{ $formattedAvgValue }}</span></h5>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="filter-card">
                                            <h5>Avg time open:<span>16 Days</span></h5>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="filter-card">
                                            <h5>Win rate:<span>{{ $avgConfidence }}%</span></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- Table -->
                            <div class="table-responsive">
                                <div class="table-container mt-3">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th class="checkbox-cell">
                                                    <input type="checkbox" class="form-check-input" id="selectAll">
                                                </th>
                                                <th>Lead name</th>
                                                <th>Age</th>
                                                <th>Value</th>
                                                <th>Assignee</th>
                                                <th>Stage</th>
                                                <th>Confidence</th>
                                                <th>Close date</th>
                                                <th>Sources</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                             @forelse ($groupedLeads as $lead)
                                                <tr>
                                                    <td><input type="checkbox" class="form-check-input row-checkbox"></td>

                                                    <td>
                                                        <div class="company-name">
                                                            <a href="{{ route('admin.leads.show', $lead['id']) }}"
                                                                class="text-decoration-none text-dark">
                                                                {{ $lead['name'] }}
                                                            </a>
                                                        </div>
                                                        <div class="company-name">{{ $lead['people_name'] }}</div>
                                                    </td>

                                                    <td>{{ $lead['created_at'] }}</td>
                                                    <td>${{ number_format($lead['total_price'], 2) }}</td>
                                                    <td>{{ $lead['assignee'] }}</td>
                                                    <td>{{ $lead['stage_name'] }}</td>
                                                    <td>{{ $lead['confidence'] }}%</td>
                                                    <td>{{ $lead['close_date'] }}</td>
                                                    <td>{{ $lead['sources'] }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="9" class="text-center">No leads found</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Action Bar -->
                            <div class="action-bar" id="actionBar">
                                <div class="d-flex align-items-center justify-content-center">
                                    <span class="me-3"><strong id="selectedCount">1</strong> Selected</span>
                                    <button class="btn btn-delete btn-action">DELETE</button>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>

@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            function fetchLeads() {
                let search = $('#lead-search').val();
                let status = $('select[name="status"]').val();
                let user_id = $('select[name="user_id"]').val();
                let hot = $('#checkDefault').is(':checked') ? 'hot' : '';

                $.ajax({
                    url: "{{ route('admin.leads.hot_leads') }}",
                    method: "GET",
                    data: {
                        search: search,
                        status: status,
                        user_id: user_id,
                        hot: hot,
                    },
                    success: function(response) {
                        $('table tbody').html(response.table);
                        $('.company-count').text(response.count + ' Lead Found');
                    },
                    error: function() {
                        console.error('Error fetching lead data');
                    }
                });
            }

            $('#lead-search').on('keyup', fetchLeads);
           $('#checkDefault, select[name="status"], select[name="user_id"]').on('change', fetchLeads);
        });
    </script>
@endpush
