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
                                    <div class="d-none right-part">
                                        <button class="btn btn-email">Email</button>
                                        <button class="btn btn-export">EXPORT</button>
                                    </div>
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
                                                        <span class="company-count">{{ $peoplesCount }} People Found</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center justify-content-end dropdown">
                                                        <div class="me-2">
                                                            <select class="form-select" aria-label="Default select example"
                                                                name="company_id">
                                                                <option value="">Company</option>
                                                                @foreach ($companies as $company)
                                                                    <option value="{{ $company->id }}">{{ $company->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="me-2">
                                                            <select class="form-select" aria-label="Default select example"
                                                                name="user_id">
                                                                <option value="">Assingee</option>
                                                                @foreach ($users as $user)
                                                                    <option value="{{ $user->id }}">{{ $user->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <button class="d-none btn btn-primary me-2"><img
                                                                src="{{ asset('img/icons/filter.svg') }}"
                                                                alt=""></button>
                                                        <button class="d-none btn btn-primary"><img
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
                                                            <th>People name</th>
                                                            <th>Last contact</th>
                                                            <th>Email</th>
                                                            <th>Phone</th>
                                                            <th>Address</th>
                                                            <th>Tags</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($peoples as $people)
                                                            <tr>
                                                                <td>
                                                                    <input type="checkbox"
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
                                                                        {{ $people->companiesAlt->first()?->name ?? 'N/A' }}
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
                                                                    @if ($people->tags->isNotEmpty())
                                                                        @foreach ($people->tags as $tag)
                                                                            <span
                                                                                class="badge-customer">{{ $tag->name }}</span>
                                                                        @endforeach
                                                                    @else
                                                                        <span>N/A</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="7" class="text-center">No People found</td>
                                                            </tr>
                                                        @endforelse


                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <!-- Action Bar -->
                                <div class="action-bar" id="actionBar">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <span class="me-3"><strong id="selectedCount">1</strong> Selected</span>
                                        <button class="btn btn-edit btn-action">CREATE LEAD</button>
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
                    let user_id = $('select[name="user_id"]').val();
                    let company_id = $('select[name="company_id"]').val();

                    $.ajax({
                        url: "{{ route('admin.peoples.index') }}",
                        method: "GET",
                        data: {
                            search: search,
                            user_id: user_id,
                            company_id: company_id,
                        },
                        success: function(response) {
                            $('table tbody').html(response.table);
                            $('.company-count').text(response.count + ' People Found');
                        },
                        error: function(err) {
                            console.error('Error fetching people data', err);
                        }
                    });
                }

                $('#people-search').on('keyup', fetchPeoples);
                $('#checkDefault,select[name="user_id"], select[name="company_id"]').on(
                    'change',
                    fetchPeoples);
            });
        </script>
    @endpush
