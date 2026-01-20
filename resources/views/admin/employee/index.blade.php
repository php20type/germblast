@extends('admin.includes.layout')

@section('title', 'Employees')

@section('content')

    <!-- All Companies Section start  -->
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">
                <!-- Main Content -->
                <div class="col-md-12 p-0">
                    <div class="main-content">
                        <!-- Header -->
                        <div class="heading-area-sec">
                            <div class="left-part-sec">
                                <h3 class="mb-1">All EMPLOYEES <i class="fas fa-thumbtack pinned-icon"></i></h3>
                                <p class="text-muted mb-0">Internal users excluding clients</p>
                            </div>
                            <div class="right-part">
                                <a href="{{ route('admin.employee.create') }}" class="btn btn-export">+ Add Employee</a>
                            </div>
                        </div>

                        <!-- Filter Section -->
                        <div class="filter-section">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center position-relative">
                                        <div class="search-form">
                                            <input type="search" class="form-control" placeholder="" aria-label="Search"
                                                id="employee-search">
                                        </div>
                                        <span class="company-count">{{ $employeesCount }} Employee Found</span>
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
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Joined</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($employees as $employee)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="form-check-input row-checkbox"
                                                        data-id="{{ $employee->id }}">
                                                </td>
                                                <td>
                                                    <div class="company-name">
                                                        <a href="{{ route('admin.employee.edit', $employee->id) }}"
                                                            class="text-decoration-none text-dark">
                                                            {{ $employee->name ?? 'N/A' }}
                                                        </a>
                                                    </div>
                                                </td>
                                                <td>
                                                    {{ $employee->email ?? 'N/A' }}
                                                </td>
                                                <td>
                                                    <span class="badge-customer">
                                                        {{ strtoupper(str_replace('_', ' ', $employee->role)) }}
                                                    </span>
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($employee->created_at)->format('d F Y') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center">No employees found</td>
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
            <!-- All Companies Section End  -->

        </div>

    @endsection

    @push('scripts')
    @endpush
