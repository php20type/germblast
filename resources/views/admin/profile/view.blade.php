@extends('admin.includes.layout')

@section('title', 'View Profile')

@section('content')
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 p-0">

                    @if (session('status') === 'profile-updated')
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Profile updated successfully.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.profile.admin.update') }}" method="POST">
                        @csrf

                        <div class="sales-dashboard">

                            {{-- HEADER --}}
                            <div class="dashboard-header section-card d-flex justify-content-between align-items-center">
                                <div>
                                    <h1 class="display-6 mb-2 fw-bold">My Profile</h1>
                                    <p class="text-muted">Your personal information and role</p>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-success">Save Changes</button>
                                </div>
                            </div>

                            {{-- PROFILE INFORMATION --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-card">
                                        <div class="section-header">
                                            <h3 class="section-title">Account Details</h3>
                                        </div>

                                        <table class="table table-bordered align-middle">
                                            <tbody>
                                                <tr>
                                                    <th width="30%">Name</th>
                                                    <td>
                                                        <input type="text" name="name" class="form-control"
                                                            value="{{ $user->name }}" required>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Email</th>
                                                    <td>{{ $user->email }}</td>
                                                </tr>

                                                <tr>
                                                    <th>Role</th>
                                                    <td>
                                                        <span class="badge bg-primary">
                                                            {{ strtoupper(str_replace('_', ' ', $user->role ?? $user->getRoleNames()->first() ?? 'User')) }}
                                                        </span>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection