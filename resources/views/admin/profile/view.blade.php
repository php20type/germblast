@extends('admin.includes.layout')

@section('title', 'View Profile')

@push('styles')
    <style>
        /* Section Card Refinement */
        .section-card {
            background: #ffffff !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 16px !important;
            padding: 25px !important;
            margin-bottom: 25px !important;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.02) !important;
            transition: all 0.3s ease !important;
        }

        .section-card:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.04) !important;
        }

        .section-title {
            font-size: 18px !important;
            font-weight: 600 !important;
            color: #374151 !important;
            margin-bottom: 0 !important;
        }

        .section-header {
            border-bottom: 1px solid #f3f4f6 !important;
            padding-bottom: 15px !important;
            margin-bottom: 20px !important;
        }

        /* Custom Premium Status Badges & Selectors */
        .status-pill {
            font-size: 12px !important;
            font-weight: 600 !important;
            padding: 6px 14px !important;
            border-radius: 30px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 6px !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
            border: 1px solid transparent !important;
        }

        .status-pill-role {
            background-color: rgba(255, 184, 28, 0.12) !important;
            color: #d39100 !important;
            border-color: rgba(255, 184, 28, 0.25) !important;
        }

        .form-control[readonly], .form-control[disabled] {
            background-color: #f9fafb !important;
            color: #6b7280 !important;
            cursor: not-allowed;
            border-color: #f3f4f6 !important;
        }

        .input-group-text {
            background-color: #f3f4f6 !important;
            border-color: #e5e7eb !important;
            color: #9ca3af !important;
        }
    </style>
@endpush

@section('content')
    <div class="companies-section my-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 p-0">

                    @if (session('status') === 'profile-updated')
                        <div class="alert alert-success alert-dismissible fade show mx-4" role="alert">
                            Profile updated successfully.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="main-content">
                        <!-- Header -->
                        <div class="heading-area-sec px-4 pt-4 mb-3">
                            <div class="left-part-sec">
                                <h3 class="mb-1">MY PROFILE <span style="font-size: 24px;">👤</span></h3>
                                <p class="text-muted mb-0">View and manage your personal information and roles</p>
                            </div>
                        </div>

                        <div class="px-4 pb-4">
                            <div class="row">
                                <!-- Left Column: User Card -->
                                <div class="col-md-4 mb-4">
                                    <div class="section-card text-center h-100">
                                        <div class="position-relative d-inline-block">
                                            @if($user->profile_image)
                                                <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Avatar" class="profile-avatar-circle mx-auto mb-3" style="width: 110px; height: 110px; border-radius: 50%; object-fit: cover; box-shadow: 0 4px 10px rgba(0,0,0,0.1); border: 3px solid #fff;">
                                            @else
                                                <div class="profile-avatar-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 110px; height: 110px; border-radius: 50%; background: linear-gradient(135deg, #FFB81C 0%, #e6a200 100%); color: #fff; font-size: 40px; font-weight: 700; box-shadow: 0 4px 15px rgba(255, 184, 28, 0.25); border: 3px solid #fff;">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                            @endif
                                        </div>

                                        <h4 class="fw-bold text-dark mb-1">{{ $user->name }}</h4>
                                        <p class="text-muted mb-0">{{ $user->email }}</p>

                                        <div class="mb-4">
                                            <span class="status-pill status-pill-role">
                                                {{ strtoupper(str_replace('_', ' ', $user->role ?? $user->getRoleNames()->first() ?? 'User')) }}
                                            </span>
                                        </div>

                                        <div class="border-top pt-3 text-start">
                                            <h6 class="text-uppercase fw-bold text-muted mb-3" style="font-size: 11px; letter-spacing: 0.5px;">System details</h6>
                                            
                                            <div class="d-flex justify-content-between mb-2 pb-2 border-bottom" style="font-size: 13px;">
                                                <span class="text-muted">Account Status</span>
                                                <span class="badge {{ $user->active ? 'bg-success' : 'bg-danger' }}" style="font-size: 11px; font-weight: 500; padding: 4px 8px;">{{ $user->active ? 'Active' : 'Inactive' }}</span>
                                            </div>
                                            
                                            <div class="d-flex justify-content-between mb-2 pb-2 border-bottom" style="font-size: 13px;">
                                                <span class="text-muted">Territory</span>
                                                <span class="fw-semibold text-dark">{{ $user->territory?->name ?? 'N/A' }}</span>
                                            </div>

                                            <div class="d-flex justify-content-between mb-2 pb-2 border-bottom" style="font-size: 13px;">
                                                <span class="text-muted">Staff Type</span>
                                                <span class="fw-semibold text-dark">{{ $user->staff_type ? ucfirst(str_replace('_', ' ', $user->staff_type)) : 'N/A' }}</span>
                                            </div>

                                            <div class="d-flex justify-content-between mb-2 pb-2 border-bottom" style="font-size: 13px;">
                                                <span class="text-muted">Employee Type</span>
                                                <span class="fw-semibold text-dark">
                                                    @if($user->employee_type === 1 || $user->employee_type === '1')
                                                        Full Time
                                                    @elseif($user->employee_type === 0 || $user->employee_type === '0')
                                                        Part Time
                                                    @else
                                                        N/A
                                                    @endif
                                                </span>
                                            </div>

                                            <div class="d-flex justify-content-between" style="font-size: 13px;">
                                                <span class="text-muted">Schedulable</span>
                                                <span class="badge {{ $user->schedulable ? 'bg-info text-dark' : 'bg-secondary' }}" style="font-size: 11px; font-weight: 500; padding: 4px 8px;">{{ $user->schedulable ? 'Yes' : 'No' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Column: Edit Profile Form -->
                                <div class="col-md-8 mb-4">
                                    <div class="section-card h-100">
                                        <div class="section-header">
                                            <h3 class="section-title">Account Details</h3>
                                        </div>

                                        <form action="{{ route('admin.profile.admin.update') }}" method="POST">
                                            @csrf

                                            <div class="row g-3">
                                                <div class="col-md-12">
                                                    <label for="name" class="form-label fw-semibold text-dark" style="font-size: 14px;">Full Name</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                        <input type="text" id="name" name="name" class="form-control" value="{{ $user->name }}" placeholder="Your full name" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="email" class="form-label fw-semibold text-dark" style="font-size: 14px;">Email Address</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                                        <input type="email" id="email" class="form-control" value="{{ $user->email }}" readonly disabled>
                                                        <span class="input-group-text" title="Email cannot be changed"><i class="fas fa-lock text-muted"></i></span>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="cell_phone" class="form-label fw-semibold text-dark" style="font-size: 14px;">Cell Phone</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                        <input type="text" id="cell_phone" class="form-control" value="{{ $user->cell_phone ?? 'N/A' }}" readonly disabled>
                                                        <span class="input-group-text" title="Phone number cannot be changed here"><i class="fas fa-lock text-muted"></i></span>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="user_role" class="form-label fw-semibold text-dark" style="font-size: 14px;">User Role</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="fas fa-shield-halved"></i></span>
                                                        <input type="text" id="user_role" class="form-control" value="{{ strtoupper(str_replace('_', ' ', $user->role ?? $user->getRoleNames()->first() ?? 'User')) }}" readonly disabled>
                                                        <span class="input-group-text" title="Role cannot be changed"><i class="fas fa-lock text-muted"></i></span>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="user_territory" class="form-label fw-semibold text-dark" style="font-size: 14px;">Assigned Territory</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                                        <input type="text" id="user_territory" class="form-control" value="{{ $user->territory?->name ?? 'N/A' }}" readonly disabled>
                                                        <span class="input-group-text" title="Territory cannot be changed"><i class="fas fa-lock text-muted"></i></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mt-4 pt-3 border-top d-flex justify-content-end">
                                                <button type="submit" class="btn btn-export">
                                                    Save Changes
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection