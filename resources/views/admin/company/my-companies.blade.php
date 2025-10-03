@extends('admin.includes.layout')

@section('title', 'Companies')

@section('content')

    <!-- All Companies Section start  -->
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                @include('admin.company.sidebar')

                <!-- Main Content -->
                <div class="col-md-10 p-0">
                    <div class="main-content">

                        <!-- Header -->
                        <div class="heading-area-sec">
                            <div class="left-part-sec">
                                <h3 class="mb-1">MY COMPANIES <i class="fas fa-thumbtack pinned-icon"></i></h3>
                                <p class="text-muted mb-0">Accounts and organizations you do business with</p>
                            </div>
                            <button class="btn btn-export">EXPORT</button>
                        </div>

                        <!-- Filter Section -->
                        <div class="filter-section">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center position-relative">
                                        <div class="search-form">
                                            <input type="search" class="form-control" placeholder="" aria-label="Search"
                                                id="company-search">
                                        </div>
                                        <span class="company-count">{{ $totalMyCompanies }} Company Found</span>
                                    </div>
                                </div>
                                <div class="col-md-6 ">
                                    <div class="d-flex align-items-center justify-content-end dropdown">
                                        <div class="me-2">
                                            <select class="form-select" aria-label="Default select example"
                                                name="company_type_id">
                                                <option value="">Company Type</option>
                                                @foreach ($company_types as $company_type)
                                                    <option value="{{ $company_type->id }}">
                                                        {{ $company_type->type }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="me-2">
                                            <select class="form-select" aria-label="Default select example"
                                                name="people_id">
                                                <option value="">Assigned to</option>
                                                @foreach ($peoples as $people)
                                                    <option value="{{ $people->id }}">{{ $people->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button class="btn btn-primary me-2"><img src="{{ asset('img/icons/filter.svg') }}"
                                                alt="" /></button>
                                        <button class="btn btn-primary"><img src="{{ asset('img/icons/bar.svg') }}"
                                                alt="" /></button>
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
                                                Company name
                                                </i>
                                            </th>
                                            <th>
                                                <img src="{{ asset('img/icons/down-vector.svg') }}" alt="" /> People
                                                </i>
                                            </th>
                                            <th>
                                                <img src="{{ asset('img/icons/down-vector.svg') }}" alt="" /> Last
                                                contact
                                                </i>
                                            </th>
                                            <th>
                                                <img src="{{ asset('img/icons/down-vector.svg') }}" alt="" />
                                                Address </i>
                                            </th>
                                            <th>
                                                <img src="{{ asset('img/icons/down-vector.svg') }}" alt="" />
                                                Company type
                                                </i>
                                            </th>
                                            <th>
                                                <img src="{{ asset('img/icons/down-vector.svg') }}" alt="" /> Tags
                                                </i>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($companies as $company)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="form-check-input row-checkbox">
                                                </td>
                                                <td>
                                                    <div class="company-name">
                                                        <a href="{{ route('admin.companies.show', $company->id) }}"
                                                            class="text-decoration-none text-dark">
                                                            {{ $company->name ?? 'N/A' }}
                                                        </a>
                                                    </div>
                                                    <div class="company-name">
                                                        {{ $company->peoples->first()?->name ?? 'N/A' }}
                                                    </div>
                                                </td>
                                                <td>
                                                    {{ $company->peoples->pluck('name')->join(', ') ?: 'N/A' }}
                                                </td>
                                                {{-- peoples of that company info --}}
                                                <td>{{ \Carbon\Carbon::parse($company->created_at)->format('d F Y') }}</td>
                                                <td>
                                                    {{ $company->companyAddress->address ?? 'N/A' }}
                                                </td>
                                                <td><span class="badge-customer">
                                                        {{ $company->companyType->type ?? 'N/A' }}
                                                    </span></td>
                                                <td>
                                                    <span class="badge-customer">
                                                        {{ $company->tag->name ?? 'N/A' }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center">No Companies found</td>
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
        <!-- All Companies Section End  -->


    </div>


@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            function fetchCompanies() {
                let search = $('#company-search').val();
                let company_type_id = $('select[name="company_type_id"]').val();
                let people_id = $('select[name="people_id"]').val();
                let userId = '{{ auth()->user()->id }}';

                $.ajax({
                    url: `/admin/company/my_companies/${userId}`,
                    method: "GET",
                    data: {
                        search: search,
                        company_type_id: company_type_id,
                        people_id: people_id,
                    },
                    success: function(data) {
                        $('table tbody').html(data);
                    }
                });
            }

            $('#company-search').on('keyup', fetchCompanies);
            $('#checkDefault, select[name="company_type_id"] ,select[name="people_id"]').on('change',
                fetchCompanies);
        });
    </script>
@endpush
