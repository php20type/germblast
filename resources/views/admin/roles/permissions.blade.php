@extends('admin.includes.layout')
@section('title', 'Roles')

@push('styles')
    <style>
        /* Equipment Management Modal Design Matching Styles */
        .role-perm-modal .modal-content {
            border-radius: 24px !important;
            border: none !important;
            overflow: hidden !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
        }

        .role-perm-modal .modal-header {
            padding: 35px 40px 20px 40px !important;
            border-bottom: none !important;
        }

        .btn-close-circle {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: #fff8e8;
            border: none;
            color: #ffb400;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            transition: all 0.2s ease;
        }

        .btn-close-circle:hover {
            background: #ffb400;
            color: #fff;
        }

        .btn-yellow-rounded {
            background: #ffb400;
            color: #fff;
            border-radius: 12px;
            padding: 12px 40px;
            font-weight: 700;
            font-size: 16px;
            border: none;
            transition: all 0.2s ease;
        }

        .btn-yellow-rounded:hover {
            background: #e6a200;
            color: #fff;
        }

        .perm-module-card {
            background: #fff;
            border: 1px solid #f3f4f6;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 25px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.02);
        }

        .perm-module-card:hover {
            border-color: #ffb400;
            box-shadow: 0 5px 15px rgba(255, 180, 0, 0.08);
        }

        .perm-module-header {
            background: #fff8e8;
            border-radius: 12px;
            padding: 16px 22px;
            color: #111827;
            font-weight: 700;
            font-size: 18px;
            border-left: 5px solid #ffb400;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .perm-sub-header {
            font-size: 16px;
            font-weight: 700;
            color: #374151;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding-bottom: 8px;
            border-bottom: 1px solid #f3f4f6;
            margin-bottom: 16px;
        }

        .perm-item-box {
            background: #fafafa;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 14px 18px;
            height: 100%;
            transition: all 0.2s ease;
        }

        .perm-item-box.active-granted {
            background: #fffdf5;
            border-color: #ffb400;
        }

        .perm-item-box:hover {
            border-color: #ffb400;
        }

        .role-perm-modal .form-check-input {
            width: 1.25em;
            height: 1.25em;
            margin-top: 0.15em;
        }

        .role-perm-modal .form-check-input:checked {
            background-color: #ffb400 !important;
            border-color: #ffb400 !important;
        }

        .cursor-pointer {
            cursor: pointer;
        }
    </style>
@endpush

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
                        <div class="card-module cursor-pointer" data-bs-toggle="modal" data-bs-target="#rolePermissionModal{{ $role->id }}">
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

    @php
        // Sub-categories mapping per module section
        $groupSubCategories = [
            'Company' => [
                'Management' => ['company.create', 'company.delete'],
                'List Access' => ['company.list.all.view', 'company.list.my.view'],
                'Company Details' => ['company.detail.view', 'company.detail.edit'],
                'Company Dashboard' => ['company.dashboard.view', 'company.dashboard.edit'],
            ],
            'People' => [
                'Management' => ['people.create', 'people.delete'],
                'List Access' => ['people.list.all.view', 'people.list.my.view', 'people.list.animal_care.view', 'people.list.marketing_contacts.view', 'people.list.sequence_healthcare.view'],
                'Person Details' => ['people.detail.view', 'people.detail.edit'],
            ],
            'Lead' => [
                'Management' => ['lead.create', 'lead.delete'],
                'List Access' => ['lead.list.all.view', 'lead.list.my.view', 'lead.list.hot.view', 'lead.list.added_this_week.view', 'lead.list.closing_this_week.view', 'lead.list.open.view', 'lead.list.watching.view'],
                'Lead Details' => ['lead.detail.view', 'lead.detail.edit'],
            ],
            'Survey Proposal' => [
                'Survey Proposals' => ['survey.proposal.view', 'survey.proposal.create', 'survey.proposal.edit', 'survey.proposal.delete'],
            ],
            'Pricing Proposal' => [
                'Pricing Proposals' => ['pricing.proposal.view', 'pricing.proposal.create', 'pricing.proposal.edit', 'pricing.proposal.delete'],
            ],
            'Service' => [
                'Service Dashboard' => ['service.dashboard.view', 'service.dashboard.edit'],
                'Fulfill Order' => ['service.fulfill_order.view', 'service.fulfill_order.edit'],
            ],
            'HR Module' => [
                'General Module Access' => ['hr.view'],
                'Employee List & Management' => ['employee.view', 'employee.edit'],
                'Time Off Request' => ['time_off_request.view', 'time_off_request.edit'],
                'Team Praise' => ['team_praise.view', 'team_praise.add'],
                'GB Rewards' => ['gb_reward.view', 'gb_reward.add'],
                'Anonymous Feedback' => ['anonymous_feedback.view', 'anonymous_feedback.add'],
            ],
            'Corporate Tools Module' => [
                'General Module Access' => ['corporate_tools.view'],
                'Change Control' => ['change_control.view', 'change_control.add', 'change_control.edit'],
                'Consumable Reports' => ['consumable_report.view', 'consumable_report.add', 'consumable_report.edit'],
                'Expense Report' => ['expense_report.view', 'expense_report.add', 'expense_report.edit'],
                'Inventory Reporting' => ['inventory_reporting.view', 'inventory_reporting.add', 'inventory_reporting.edit'],
                'Job Profitability' => ['job_profitability.view'],
                'Office Duties' => ['office_duties.view', 'office_duties.add', 'office_duties.edit'],
            ]
        ];

        // Friendly Human-Readable Permission Labels
        $permLabels = [
            // Company
            'company.create' => 'Create Company',
            'company.delete' => 'Delete Company',
            'company.list.all.view' => 'View All Companies',
            'company.list.my.view' => 'View My Companies',
            'company.detail.view' => 'View Company Details',
            'company.detail.edit' => 'Edit Company Details',
            'company.dashboard.view' => 'View Company Dashboard',
            'company.dashboard.edit' => 'Edit Company Dashboard',

            // People
            'people.create' => 'Create Person',
            'people.delete' => 'Delete Person',
            'people.list.all.view' => 'View All People',
            'people.list.my.view' => 'View My People',
            'people.list.animal_care.view' => 'View Animal Care Contacts',
            'people.list.marketing_contacts.view' => 'View Marketing Contacts',
            'people.list.sequence_healthcare.view' => 'View Healthcare Contacts',
            'people.detail.view' => 'View Person Details',
            'people.detail.edit' => 'Edit Person Details',

            // Lead
            'lead.create' => 'Create Lead',
            'lead.delete' => 'Delete Lead',
            'lead.list.all.view' => 'View All Leads',
            'lead.list.my.view' => 'View My Leads',
            'lead.list.hot.view' => 'View Hot Leads',
            'lead.list.added_this_week.view' => 'View Leads Added This Week',
            'lead.list.closing_this_week.view' => 'View Leads Closing This Week',
            'lead.list.open.view' => 'View Open Leads',
            'lead.list.watching.view' => 'View Watching Leads',
            'lead.detail.view' => 'View Lead Details',
            'lead.detail.edit' => 'Edit Lead Details',

            // Survey Proposal
            'survey.proposal.view' => 'View Survey Proposal',
            'survey.proposal.create' => 'Create Survey Proposal',
            'survey.proposal.edit' => 'Edit Survey Proposal',
            'survey.proposal.delete' => 'Delete Survey Proposal',

            // Pricing Proposal
            'pricing.proposal.view' => 'View Pricing Proposal',
            'pricing.proposal.create' => 'Create Pricing Proposal',
            'pricing.proposal.edit' => 'Edit Pricing Proposal',
            'pricing.proposal.delete' => 'Delete Pricing Proposal',

            // Service
            'service.dashboard.view' => 'View Service Dashboard',
            'service.dashboard.edit' => 'Edit Service Dashboard',
            'service.fulfill_order.view' => 'View Fulfill Order',
            'service.fulfill_order.edit' => 'Edit Fulfill Order',

            // HR Module
            'hr.view' => 'Access HR Module',
            'employee.view' => 'View Employee List',
            'employee.edit' => 'Edit Employee List',
            'time_off_request.view' => 'View & Request Time Off',
            'time_off_request.edit' => 'Manage & Approve Time Off Requests',
            'team_praise.view' => 'View Team Praise',
            'team_praise.add' => 'Add Team Praise',
            'gb_reward.view' => 'View GB Rewards',
            'gb_reward.add' => 'Add GB Reward',
            'anonymous_feedback.view' => 'View Anonymous Feedback',
            'anonymous_feedback.add' => 'Add Anonymous Feedback',

            // Corporate Tools Module
            'corporate_tools.view' => 'Access Corporate Tools',
            'change_control.view' => 'View Change Control',
            'change_control.add' => 'Add Change Control',
            'change_control.edit' => 'Edit Change Control',
            'consumable_report.view' => 'View Consumable Reports',
            'consumable_report.add' => 'Add Consumable Report',
            'consumable_report.edit' => 'Edit Consumable Report',
            'expense_report.view' => 'View Expense Reports',
            'expense_report.add' => 'Add Expense Report',
            'expense_report.edit' => 'Edit Expense Report',
            'inventory_reporting.view' => 'View Inventory Reporting',
            'inventory_reporting.add' => 'Add Inventory Reporting',
            'inventory_reporting.edit' => 'Edit Inventory Reporting',
            'job_profitability.view' => 'View Job Profitability',
            'office_duties.view' => 'View Office Duties',
            'office_duties.add' => 'Add Office Duties',
            'office_duties.edit' => 'Edit Office Duties',
        ];
    @endphp

    {{-- ROLE PERMISSION MODALS --}}
    @foreach ($roles as $role)
        @php
            // Groups allowed for this role
            $allowedGroups = $rolePermissionMap[$role->name] ?? [];
        @endphp

        <div class="modal fade role-perm-modal" id="rolePermissionModal{{ $role->id }}" tabindex="-1" aria-labelledby="rolePermissionModalLabel{{ $role->id }}" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content">

                    <form method="POST" action="{{ route('admin.roles.permissions.update') }}">
                        @csrf

                        <div class="modal-header d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="modal-title fw-bold" id="rolePermissionModalLabel{{ $role->id }}" style="color: #111827; font-size: 24px;">
                                    Permissions – {{ strtoupper(str_replace('_', ' ', $role->name)) }}
                                </h3>
                                <span style="font-size: 16px; color: #6b7280;">Configure functional access and module privileges for this role.</span>
                            </div>
                            <button type="button" class="btn-close-circle" data-bs-dismiss="modal">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        <div class="modal-body" style="padding: 20px 40px; max-height: 70vh; overflow-y: auto;">
                            <input type="hidden" name="role_id" value="{{ $role->id }}">

                            {{-- MODULE SECTIONS --}}
                            @foreach ($permissionGroups as $groupName => $groupPermissions)

                                @continue(!in_array($groupName, $allowedGroups))

                                @php
                                    $subCats = $groupSubCategories[$groupName] ?? [
                                        $groupName => $groupPermissions->pluck('name')->toArray()
                                    ];
                                @endphp

                                <div class="perm-module-card">
                                    <div class="perm-module-header">
                                        <div class="d-flex align-items-center">
                                            <span>{{ $groupName }}</span>
                                        </div>
                                        <span class="badge" style="background: #ffb400; color: #fff; border-radius: 20px; font-weight: 600; font-size: 13px; padding: 7px 16px;">
                                            {{ count($groupPermissions) }} Permissions
                                        </span>
                                    </div>

                                    @foreach ($subCats as $subTitle => $subPermKeys)
                                        @php
                                            $subPermObjs = $groupPermissions->filter(function($p) use ($subPermKeys) {
                                                return in_array($p->name, $subPermKeys);
                                            });
                                        @endphp

                                        @if ($subPermObjs->count() > 0)
                                            <div class="mb-3">
                                                <div class="perm-sub-header">
                                                    {{ $subTitle }}
                                                </div>
                                                <div class="row g-3 mb-3">
                                                    @foreach ($subPermObjs as $permission)
                                                        @php
                                                            $isGranted = $role->hasPermissionTo($permission->name);
                                                            $label = $permLabels[$permission->name] ?? ucwords(str_replace(['.', '_'], ' ', $permission->name));
                                                        @endphp
                                                        <div class="col-lg-4 col-md-6">
                                                            <div class="perm-item-box {{ $isGranted ? 'active-granted' : '' }}">
                                                                <div class="form-check mb-0 d-flex align-items-start">
                                                                    <input class="form-check-input me-2" type="checkbox" name="permissions[]"
                                                                        value="{{ $permission->name }}" id="perm_{{ $role->id }}_{{ $permission->id }}"
                                                                        {{ $isGranted ? 'checked' : '' }}>
                                                                    <label class="form-check-label d-block cursor-pointer" for="perm_{{ $role->id }}_{{ $permission->id }}">
                                                                        <span class="fw-bold d-block text-dark" style="font-size: 15px;">{{ $label }}</span>
                                                                        <code class="text-muted" style="font-size: 0.85rem;">{{ $permission->name }}</code>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endforeach
                        </div>

                        <div class="modal-footer border-0 pt-2 pb-4 px-5">
                            <button type="button" class="btn btn-secondary px-4 me-2" style="border-radius: 12px; font-weight: 600; font-size: 16px; padding: 12px 30px;" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn-yellow-rounded">Save Permissions</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    @endforeach

@endsection