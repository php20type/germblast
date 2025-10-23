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
                                <h3 class="mb-1">All COMPANIES <i class="fas fa-thumbtack pinned-icon"></i></h3>
                                <p class="text-muted mb-0">Accounts and organizations you do business with</p>
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
                                            <input type="search" class="form-control" placeholder="" aria-label="Search"
                                                id="company-search">
                                        </div>
                                        <span class="company-count">{{ $companiesCount }} Company Found</span>
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
                                            <select class="form-select" aria-label="Default select example" name="user_id">
                                                <option value="">Assignee</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="me-2">
                                            <select class="form-select" aria-label="Default select example"
                                                name="people_id">
                                                <option value="">People</option>
                                                @foreach ($peoples as $people)
                                                    <option value="{{ $people->id }}">{{ $people->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button class="d-none btn btn-primary me-2"><img
                                                src="{{ asset('img/icons/filter.svg') }}" alt="" /></button>
                                        <button class="d-none btn btn-primary"><img src="{{ asset('img/icons/bar.svg') }}"
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
                                            <th>Company name</th>
                                            <th>People</th>
                                            <th>Last contact</th>
                                            <th>Address</th>
                                            <th>Company type</th>
                                            <th>Tags</th>
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
                                                    @if ($company->tags->isNotEmpty())
                                                        @foreach ($company->tags as $tag)
                                                            <span class="badge-customer">{{ $tag->name }}</span>
                                                        @endforeach
                                                    @else
                                                        <span>N/A</span>
                                                    @endif
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
                                <button class="btn btn-edit btn-action">CREATE LEAD</button>
                                {{-- <button class="btn btn-merge btn-action">MERGE</button>
                                <button class="btn btn-add-audience btn-action">ADD TO AUDIENCE</button> --}}
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

                    function fetchCompanies() {
                        let search = $('#company-search').val();
                        let company_type_id = $('select[name="company_type_id"]').val();
                        let user_id = $('select[name="user_id"]').val();
                        let people_id = $('select[name="people_id"]').val();

                        $.ajax({
                            url: "{{ route('admin.company.index') }}",
                            method: "GET",
                            data: {
                                search: search,
                                company_type_id: company_type_id,
                                user_id: user_id,
                                people_id: people_id,
                            },
                            success: function(response) {
                                $('table tbody').html(response.table);
                                $('.company-count').text(response.count + ' Company Found');
                            },
                            error: function() {
                                console.error('Error fetching company data');
                            }
                        });
                    }

                    // Trigger AJAX on typing or filter change
                    $('#company-search').on('keyup', fetchCompanies);
                    $('select[name="company_type_id"], select[name="user_id"], select[name="people_id"]').on('change',
                        fetchCompanies);
                });
            </script>
        @endpush
