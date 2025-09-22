    @extends('admin.includes.layout')

    @section('title', 'Peoples')

    @section('content')


        <main class="app-wrapper">


            <!-- All Companies Section start  -->
            <div class="companies-section my-4">
                <div class="container-fluid">
                    <div class="row">
                        <!-- Sidebar -->
                        @include('admin.peoples.sidebar')

                        <!-- Main Content -->
                        <div class="col-md-10 p-0">
                            <div class="main-content">
                                <!-- Header -->
                                <div class="heading-area-sec">
                                    <div class="left-part-sec">
                                        <h3 class="mb-1">All people <i class="fas fa-thumbtack pinned-icon"></i></h3>
                                        <p class="text-muted mb-0">Contacts (or the individuals) you do business with
                                        </p>
                                    </div>
                                    <div class="right-part">
                                        <button class="btn btn-email">Email</button>
                                        <button class="btn btn-export">EXPORT</button>
                                    </div>
                                </div>

                                <!-- Tabs Navigation -->
                                <div class="navbar-tabs">
                                    <ul class="nav nav-tabs" id="viewTabs" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="list-tab" data-bs-toggle="tab"
                                                data-bs-target="#list-content" type="button" role="tab"
                                                aria-controls="list-content" aria-selected="true">LIST</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="map-tab" data-bs-toggle="tab"
                                                data-bs-target="#map-content" type="button" role="tab"
                                                aria-controls="map-content" aria-selected="false">MAP</button>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Tabs Content -->
                                <div class="tab-content" id="viewTabsContent">
                                    <!-- LIST Tab Content -->
                                    <div class="tab-pane fade show active" id="list-content" role="tabpanel"
                                        aria-labelledby="list-tab">
                                        <!-- Filter Section -->
                                        <div class="filter-section mt-3">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center position-relative">
                                                        <div class="search-form">
                                                            <input type="search" class="form-control" placeholder=""
                                                                aria-label="Search" id="people-search">
                                                        </div>
                                                        <span class="company-count">{{ $totalPeoples }} people</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center justify-content-end dropdown">
                                                        <div class="me-2">
                                                            <select class="form-select" name="marketing_status">
                                                                <option value="">Marketing Status</option>
                                                                <option value="Bouncing">Bouncing</option>
                                                                <option value="Unsubscribed">Unsubscribed</option>
                                                                <option value="No Email Address">No Email Address</option>
                                                                <option value="Marketable">Marketable</option>
                                                            </select>
                                                        </div>
                                                        <button class="btn btn-primary me-2"><img
                                                                src="{{ asset('img/icons/filter.svg') }}"
                                                                alt=""></button>
                                                        <button class="btn btn-primary"><img
                                                                src="{{ asset('img/icons/bar.svg') }}"
                                                                alt=""></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Table Section -->
                                        <div class="table-responsive">
                                            <div class="table-container mt-3 px-3">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th class="checkbox-cell">
                                                                <input type="checkbox" class="form-check-input"
                                                                    id="selectAll">
                                                            </th>
                                                            <th>
                                                                <img src="{{ asset('img/icons/down-vector.svg') }}"
                                                                    alt="" /> Person
                                                                name </i>
                                                            </th>
                                                            <th>
                                                                <img src="{{ asset('img/icons/down-vector.svg') }}"
                                                                    alt="" /> Last
                                                                contact </i>
                                                            </th>
                                                            <th>
                                                                <img src="{{ asset('img/icons/down-vector.svg') }}"
                                                                    alt="" /> Email
                                                                </i>
                                                            </th>
                                                            <th>
                                                                <img src="{{ asset('img/icons/down-vector.svg') }}"
                                                                    alt="" /> Phone
                                                                </i>
                                                            </th>
                                                            <th>
                                                                <img src="{{ asset('img/icons/down-vector.svg') }}"
                                                                    alt="" /> Address </i>
                                                            </th>
                                                            <th>
                                                                <img src="{{ asset('img/icons/down-vector.svg') }}"
                                                                    alt="" /> Tags
                                                                </i>
                                                            </th>
                                                            <th>
                                                                <img src="{{ asset('img/icons/down-vector.svg') }}"
                                                                    alt="" /> Marketing Status
                                                                </i>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($peoples as $people)
                                                            <tr>
                                                                <td><input type="checkbox"
                                                                        class="form-check-input row-checkbox">
                                                                </td>
                                                                <td>
                                                                    <div class="person-name">
                                                                        <a href="{{ route('admin.peoples.show', $people->id) }}"
                                                                            class="text-decoration-none text-dark">
                                                                            {{ $people->name ?? 'N/A' }}
                                                                        </a>
                                                                    </div>
                                                                    <div class="company-name">
                                                                        {{ $people->companiesAlt->first()->name ?? 'N/A' }}
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    {{ \Carbon\Carbon::parse($people->created_at)->format('j F Y') }}
                                                                </td>
                                                                <td>
                                                                    {{ $people->peopleEmail->email ?? 'N/A' }}
                                                                </td>
                                                                <td>
                                                                    {{ $people->peoplePhone->phone ?? 'N/A' }}
                                                                </td>
                                                                <td>
                                                                    {{ $people->peopleAddress->address ?? 'N/A' }}
                                                                </td>
                                                                <td>
                                                                    <span class="badge-customer">
                                                                        {{ $people->tag->name ?? 'N/A' }}
                                                                    </span>
                                                                </td>
                                                                <td class="company-count">
                                                                    {{ $people->marketing_status ?? 'N/A' }}
                                                                </td>
                                                            </tr>
                                                        @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- MAP Tab Content -->
                                    <div class="tab-pane fade" id="map-content" role="tabpanel"
                                        aria-labelledby="map-tab">
                                        <div class="mx-3">
                                            <div id="google-map" class="mt-3 w-100 border rounded">
                                                <iframe
                                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12043.443952636168!2d-78.48005627730406!3d41.006415734414446!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89cc680ea3110bad%3A0x314ee726c077f6b9!2sHyde%2C%20PA%2C%20USA!5e0!3m2!1sen!2sin!4v1750664745416!5m2!1sen!2sin"
                                                    width="100%" height="450" style="border:0;" allowfullscreen=""
                                                    loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <!-- Action Bar -->
                                <div class="action-bar" id="actionBar">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <span class="me-3"><strong id="selectedCount">1</strong> Selected</span>
                                        <button class="btn btn-edit btn-action">CREATE LEAD</button>
                                        <button class="btn btn-edit btn-action">EDIT</button>
                                        <button class="btn btn-merge btn-action">MERGE</button>
                                        <button class="btn btn-merge btn-action">SEND TO MAILCHIMP</button>
                                        <button class="btn btn-add-audience btn-action">ADD TO AUDIENCE</button>
                                        <button class="btn btn-delete btn-action">DELETE</button>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                    <!-- All Companies Section End  -->


        </main>

    @endsection
    @push('scripts')
        <script>
            $(document).ready(function() {
                function fetchPeoples() {
                    let search = $('#people-search').val();
                    let marketing_status = $('select[name="marketing_status"]').val();

                    $.ajax({
                        url: "{{ route('admin.peoples.index') }}",
                        method: "GET",
                        data: {
                            search: search,
                            marketing_status: marketing_status,
                        },
                        success: function(data) {
                            $('table tbody').html(data);
                        }
                    });
                }

                $('#people-search').on('keyup', fetchPeoples);
                $('#checkDefault, select[name="marketing_status"]').on('change',
                    fetchPeoples);
            });
        </script>
    @endpush
