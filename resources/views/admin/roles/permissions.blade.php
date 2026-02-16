@extends('admin.includes.layout')
@section('title', 'Roles')

@section('content')

    <div class="dashboard-card my-4">
        <div class="container-fluid">

            {{-- Alerts --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row">
                {{-- ROLE CARDS --}}
                @foreach ($roles as $role)
                    <div class="col-lg-6 col-module">
                        <div class="card-module" data-bs-toggle="modal" data-bs-target="#rolePermissionModal{{ $role->id }}">
                            <div class="icon-wrapper icon-form">
                                <img src="{{ asset('img/icons/dashboard-app2.png') }}" alt="role icon" />
                                <h5 class="card-title">
                                    {{ strtoupper(str_replace('_', ' ', $role->name)) }}
                                </h5>
                            </div>
                            <p class="card-text">
                                Manage permissions for {{ strtoupper(str_replace('_', ' ', $role->name)) }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ROLE PERMISSION MODALS --}}
    @foreach ($roles as $role)
        @php
            // Groups allowed for this role
            $allowedGroups = $rolePermissionMap[$role->name] ?? [];
        @endphp

        <div class="modal fade" id="rolePermissionModal{{ $role->id }}" tabindex="-1">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">

                    <form method="POST" action="{{ route('admin.roles.permissions.update') }}">
                        @csrf

                        <div class="modal-header">
                            <h5 class="modal-title">
                                Permissions – {{ strtoupper(str_replace('_', ' ', $role->name)) }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <input type="hidden" name="role_id" value="{{ $role->id }}">

                            {{-- GROUPED & FILTERED PERMISSIONS --}}
                            @foreach ($permissionGroups as $groupName => $groupPermissions)

                                @continue(!in_array($groupName, $allowedGroups))

                                <div class="mb-4">
                                    <h6 class="fw-bold text-primary mb-3">
                                        {{ $groupName }}
                                    </h6>

                                    <div class="row">
                                        @foreach ($groupPermissions as $permission)
                                            <div class="col-lg-4 col-md-6 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                        value="{{ $permission->name }}" id="perm_{{ $role->id }}_{{ $permission->id }}"
                                                        {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="perm_{{ $role->id }}_{{ $permission->id }}">
                                                        {{ $permission->name }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                </div>
                            @endforeach
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Save Permissions
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    @endforeach

@endsection