@extends('admin.includes.layout')

@section('title', 'Assigned peoples')

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
                                    <h3 class="mb-1">Assigned PEOPLE <span style="font-size: 24px;">📌</span></h3>
                                    <p class="text-muted mb-0">Contacts (or the individuals) assigned to you
                                    </p>
                                </div>
                                @can('people.create')
                                <div class="right-part">
                                    <button class="btn btn-export" data-bs-toggle="modal" data-bs-target="#AddPerson">
                                        <i class="fa-solid fa-plus"></i> Add Person
                                    </button>
                                </div>
                                @endcan
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
                                                    <span class="company-count">{{ $assignedPeoplesCount }} People Found</span>
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
                                                            name="assignee_id">
                                                            <option value="">Assignee</option>
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}">{{ $user->name }}
                                                                    </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <button class="btn btn-primary me-2 position-relative"
                                                        onclick="addFilter()">
                                                        <img src="{{ asset('img/icons/filter.svg') }}" alt="" />

                                                        <!-- Active Filter Count -->
                                                        <span id="filterCount"
                                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger d-none">
                                                            0
                                                        </span>
                                                    </button>

                                                    <button class="d-none btn btn-primary"><img
                                                            src="{{ asset('img/icons/bar.svg') }}" alt=""></button>
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
                                                            <input type="checkbox" class="form-check-input" id="selectAll">
                                                        </th>
                                                        <th>People name</th>
                                                        <th>Created</th>
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
                                                                <input type="checkbox" class="form-check-input row-checkbox"
                                                                    data-id="{{ $people->id }}">
                                                            </td>
                                                            <td>
                                                                <div class="person-name">

                                                                    @can('people.detail.view')
                                                                        <a href="{{ route('admin.people.show', $people->id) }}"
                                                                            class="text-decoration-none text-dark">
                                                                            {{ $people->name ?? 'N/A' }}
                                                                        </a>
                                                                    @else
                                                                        <span class="text-dark">
                                                                            {{ $people->name ?? 'N/A' }}
                                                                        </span>
                                                                    @endcan

                                                                </div>
                                                                <div class="company-name">
                                                                    {{ $people->companies->first()?->name ?? 'N/A' }}
                                                                </div>
                                                                @if(!empty($people->contact_types))
                                                                    <div class="contact-types-list mt-1 d-flex flex-wrap gap-1">
                                                                        @foreach($people->contact_types as $type)
                                                                            <span class="badge bg-light text-dark border px-1 py-0.5" style="font-size: 0.65rem; font-weight: 500; text-transform: uppercase; border-radius: 3px;">
                                                                                {{ $type }}
                                                                            </span>
                                                                        @endforeach
                                                                    </div>
                                                                @endif
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

                                    @can('people.delete')
                                        <button class="btn btn-delete btn-action">
                                            DELETE
                                        </button>
                                    @endcan

                                </div>
                            </div>

                        </div>

                    </div>
                </div>

                <!-- All Companies Section End  -->
    </main>

    <!-- Add Lead Modal Start -->
    <div class="modal fade" id="AddFilter" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="exampleModalLabel">Extended Filters</h1>
                    <div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                </div>
                <div class="modal-body">


                    <div class="row mx-0" id="filter-section">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">People Tags</label>
                                <div class="checkbox-group">
                                    @foreach ($peopletags as $peopletag)
                                        <div class="form-check">
                                            <input type="checkbox" name="people_tags_filter_id[]"
                                                value="{{ $peopletag->id }}" class="form-check-input"
                                                id="peopletag_{{ $peopletag->id }}">
                                            <label class="form-check-label" for="peopletag_{{ $peopletag->id }}">
                                                {{ $peopletag->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Territory</label>
                                <div class="checkbox-group">
                                    @foreach ($territories as $territory)
                                        <div class="form-check">
                                            <input type="checkbox" name="territory_filter_id[]"
                                                value="{{ $territory->id }}" class="form-check-input"
                                                id="territory_{{ $territory->id }}">
                                            <label class="form-check-label" for="territory_{{ $territory->id }}">
                                                {{ $territory->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Leads Status</label>
                                <div class="checkbox-group">
                                    @php
                                        $lead_statuses = ['won', 'pending', 'open', 'lost', 'cancelled'];
                                    @endphp
                                    @foreach ($lead_statuses as $status)
                                        <div class="form-check">
                                            <input type="checkbox" name="leads_status[]" value="{{ $status }}"
                                                class="form-check-input" id="leadstatus_{{ $status }}">
                                            <label class="form-check-label" for="leadstatus_{{ $status }}">
                                                {{ ucfirst($status) }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Activity Types</label>
                                <div class="checkbox-group">
                                    @foreach ($activity_types as $activity_type)
                                        <div class="form-check">
                                            <input type="checkbox" name="activity_type_filter_id[]"
                                                value="{{ $activity_type->id }}" class="form-check-input"
                                                id="activitytype_{{ $activity_type->id }}">
                                            <label class="form-check-label" for="activitytype_{{ $activity_type->id }}">
                                                {{ $activity_type->type }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>

        </div>
        @include('admin.peoples.partials.add-person-modal')
    @endsection
    @push('scripts')
        <script>
            function addFilter() {
                $('#AddFilter').modal('show');
            }

            function updateFilterCount() {
                let count = $('#filter-section input[type="checkbox"]:checked').length;

                if (count > 0) {
                    $('#filterCount').text(count).removeClass('d-none');
                } else {
                    $('#filterCount').addClass('d-none');
                }
            }


            const userId = {{ auth()->id() }};
            $(document).ready(function() {
                function fetchPeoples() {
                    let search = $('#people-search').val();
                    let assignee_id = $('select[name="assignee_id"]').val();
                    let company_id = $('select[name="company_id"]').val();

                    // collect checkbox values
                    let people_tags_filter_id = [];
                    $('input[name="people_tags_filter_id[]"]:checked').each(function() {
                        people_tags_filter_id.push($(this).val());
                    });

                    let territory_filter_id = [];
                    $('input[name="territory_filter_id[]"]:checked').each(function() {
                        territory_filter_id.push($(this).val());
                    });

                    let leads_status = [];
                    $('input[name="leads_status[]"]:checked').each(function() {
                        leads_status.push($(this).val());
                    });

                    let activity_type_filter_id = [];
                    $('input[name="activity_type_filter_id[]"]:checked').each(function() {
                        activity_type_filter_id.push($(this).val());
                    });

                    $.ajax({
                        url: `/admin/people/my-peoples/${userId}`,
                        method: "GET",
                        data: {
                            search: search,
                            assignee_id: assignee_id,
                            company_id: company_id,
                            people_tags_filter_id: people_tags_filter_id,
                            territory_filter_id: territory_filter_id,
                            leads_status: leads_status,
                            activity_type_filter_id: activity_type_filter_id,
                        },
                        beforeSend: function() {
                            AppLoader.show();
                        },
                        success: function(response) {
                            $('table tbody').html(response.table);
                            $('.company-count').text(response.count + ' People Found');
                            $('#people-pagination').html(response.pagination);
                        },
                        error: function(err) {
                            console.error('Error fetching people data', err);
                        },
                        complete: function() {
                            AppLoader.hide();
                        }
                    });
                }

                $('#people-search').on('input', function () {
                    fetchPeoples();
                });
                $('#checkDefault, select[name="assignee_id"], select[name="company_id"]').on('change',
                    fetchPeoples);
                // catch all checkbox changes
                // $('#filter-section input[type="checkbox"]').on('change', fetchPeoples);
                $('#filter-section input[type="checkbox"]').on('change', function() {
                    fetchPeoples();
                    updateFilterCount();
                });



                // ==============================
                // Lead & Activities Form - Select2 Integration
                // ==============================




                $(document).on('click', '.btn-delete', function() {
                    let selectedPeoples = $('.row-checkbox:checked').map(function() {
                        return $(this).data('id');
                    }).get();

                    Swal.fire({
                        title: "Are you sure?",
                        text: "This action will permanently delete the selected people.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Yes, delete",
                        cancelButtonText: "Cancel"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{ route('admin.people.delete') }}",
                                type: "POST",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    ids: selectedPeoples
                                },
                                success: function(response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: response.message ||
                                            'People deleted successfully.',
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                    setTimeout(() => location.reload(), 2000);
                                },
                                error: function(xhr) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: xhr.responseJSON?.message ||
                                            'Something went wrong while deleting.',
                                    });
                                }
                            });
                        }
                    });
                });

            });
        </script>
        @include('admin.peoples.partials.add-person-scripts')
    @endpush


