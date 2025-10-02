@extends('admin.includes.layout')

@section('title', 'Leads')

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
                                    <h3 class="mb-1">Leads i'm watching <i class="fas fa-thumbtack pinned-icon"></i></h3>
                                    <p class="text-muted mb-0">Business deals with your companies and people</p>
                                </div>
                                <button class="btn btn-export">EXPORT</button>
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
                                            <span class="company-count">{{ $leadCount }} leads</span>
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
                                                <select class="form-select" name="people_id"
                                                    aria-label="Assigned to select">
                                                    <option value="">Assigned to</option>
                                                    @foreach ($peoples as $people)
                                                        <option value="{{ $people->id }}">{{ $people->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <button class="btn btn-primary me-2"><img
                                                    src="{{ asset('img/icons/filter.svg') }}" alt="" /></button>
                                            <button class="btn btn-primary"><img src="{{ asset('img/icons/bar.svg') }}"
                                                    alt="" /></button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="filter-value">
                                <div class="row">
                                    <div class="col-lg-3 col-md-6">
                                        <div class="filter-card">
                                            {{-- <h5>Total value:<span>${{ $formattedTotalValue }}</span></h5> --}}
                                            <h5>Total value:<span>$45908</span></h5>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="filter-card">
                                            {{-- <h5>Avg value:<span>${{ $formattedAvgValue }}k</span></h5> --}}
                                            <h5>Avg value:<span>$2.5k</span></h5>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="filter-card">
                                            <h5>Avg time open:<span>161.5 Days</span></h5>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <div class="filter-card">
                                            {{-- <h5>Win rate:<span>{{ $formattedAvgConfidence }}%</span></h5> --}}
                                            <h5>Win rate:<span>100%</span></h5>
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
                                                <th>
                                                    <img src="{{ asset('img/icons/down-vector.svg') }}" alt="" />
                                                    Lead name
                                                    </i>
                                                </th>
                                                <th>
                                                    <img src="{{ asset('img/icons/down-vector.svg') }}" alt="" />Age
                                                    </i>
                                                </th>
                                                <th>
                                                    <img src="{{ asset('img/icons/down-vector.svg') }}"
                                                        alt="" />Value </i>
                                                </th>
                                                <th>
                                                    <img src="{{ asset('img/icons/down-vector.svg') }}"
                                                        alt="" />Assignee
                                                    </i>
                                                </th>
                                                <th>
                                                    <img src="{{ asset('img/icons/down-vector.svg') }}"
                                                        alt="" />Stage </i>
                                                </th>
                                                <th>
                                                    <img src="{{ asset('img/icons/down-vector.svg') }}"
                                                        alt="" />Confidence
                                                    </i>
                                                </th>
                                                <th>
                                                    <img src="{{ asset('img/icons/down-vector.svg') }}"
                                                        alt="" />Close date
                                                    </i>
                                                </th>
                                                <th>
                                                    <img src="{{ asset('img/icons/down-vector.svg') }}"
                                                        alt="" />Sources
                                                    </i>
                                                </th>
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
                                                    <td>Proposal Approval</td>
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
                                    <button class="btn btn-edit btn-action">EDIT</button>
                                    <button class="btn btn-merge btn-action">MERGE</button>
                                    <button class="btn btn-add-audience btn-action">ADD TO AUDIENCE</button>
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
                let hot = $('#checkDefault').is(':checked') ? 'hot' : '';

                $.ajax({
                    url: "{{ route('admin.leads.watching_leads') }}",
                    method: "GET",
                    data: {
                        search: search,
                        status: status,
                        hot: hot,
                    },
                    success: function(data) {
                        $('table tbody').html(data);
                    }
                });
            }

            $('#lead-search').on('keyup', fetchLeads);
            $('#checkDefault, select[name="status"]').on('change', fetchLeads);
        });
    </script>
@endpush
