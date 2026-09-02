<!-- Aside section start -->
<aside class="app-sidebar">
    {{-- <div id="close"><a href="javascript:void(0)"><i class="fa-regular fa-xmark"></i></a></div> --}}
    <div class="logo-sec">
        <a href="{{ route('admin.dashboard') }}" class="d-block"><img src={{ asset("img/logo/logo.svg") }}
                alt="logo" /></a>
    </div>
    <nav class="sidebar-nav">
        <ul class="list-inline">
            @if(auth()->user()->isSalesManager() || auth()->user()->isSuperAdmin())
            <li class="{{ request()->routeIs('admin.sales.*', 'admin.equipment-loan.*') ? 'active' : '' }}">
                <a href="{{ route('admin.sales.index') }}">
                    <div class="icon-round">
                        <img src={{ asset("img/icons/menu-icon18.svg") }} alt="icon" />
                    </div>
                    <div class="nav-text ms-3">
                        Sales
                    </div>
                </a>
            </li>
            
            <!-- <li class="">
                <a href="#">
                    <div class="icon-round">
                        <img src={{ asset("img/icons/menu-icon1.svg") }} alt="icon" />
                    </div>
                    <div class="nav-text ms-3">
                        Marketing
                    </div>
                </a>
            </li>
            <li class="">
                <a href="">
                    <div class="icon-round">
                        <img src={{ asset("img/icons/menu-icon2.svg") }} alt="icon" />
                    </div>
                    <div class="nav-text ms-3">
                        Engagement
                    </div>
                </a>
            </li> -->
            <hr>
            @endif
            <li
                class="{{ request()->routeIs('admin.company.*') || request()->routeIs('admin.company.*') ? 'active' : '' }}">
                <a href="{{ route('admin.company.index') }}">
                    <div class="icon-round">
                        <img src={{ asset("img/icons/menu-icon3.svg") }} alt="icon" />
                    </div>
                    <div class="nav-text ms-3">
                        Companies
                    </div>
                </a>
            </li>
            <li class=" {{ request()->routeIs('admin.people.*') ? 'active' : '' }}">
                <a href="{{ route('admin.people.index') }}">
                    <div class="icon-round">
                        <img src={{ asset("img/icons/menu-icon4.svg") }} alt="icon" />
                    </div>
                    <div class="nav-text ms-3">
                        People
                    </div>
                </a>
            </li>
            <li
                class="{{ request()->routeIs('admin.lead.*') || request()->routeIs('admin.survey.proposal.*') ? 'active' : '' }}">
                <a href="{{ route('admin.lead.index') }}">
                    <div class="icon-round">
                        <img src={{ asset("img/icons/menu-icon5.svg") }} alt="icon" />
                    </div>
                    <div class="nav-text ms-3">
                        Leads
                    </div>
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                <a href="{{ route('admin.reports.new_leads') }}">
                    <div class="icon-round">
                        <img src={{ asset("img/icons/menu-icon19.svg") }} alt="icon" />
                    </div>
                    <div class="nav-text ms-3">
                        Reports
                    </div>
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.calendar.*') ? 'active' : '' }}">
                <a href="{{ route('admin.calendar.index') }}">
                    <div class="icon-round">
                        <img src={{ asset("img/icons/menu-icon6.svg") }} alt="icon" />
                    </div>
                    <div class="nav-text ms-3">
                        Calendar
                    </div>
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.my-jobs.*') ? 'active' : '' }}">
                <a href="{{ route('admin.my-jobs.index') }}">
                    <div class="icon-round">
                        <img src={{ asset("img/icons/menu-icon13.svg") }} alt="icon" />
                    </div>
                    <div class="nav-text ms-3">
                        My Jobs
                    </div>
                </a>
            </li>

            <hr>
            @can('operations.view')
            @php
                $isOperationsActive = request()->routeIs([
                    'admin.all_schedules.*',
                    'admin.isd-attendance.*',
                    'admin.timecards.*',
                    'admin.failures.*',
                    'admin.hr.driver-report.*',
                    'admin.equipment-management.*',
                    'admin.scheduling_calendar.*',
                    'admin.team.availability',
                    'admin.vehicle.planning',
                    'admin.warehouse.maintenance',
                    'admin.warehouse.calendar',
                    'admin.training-categories.*',
                    'admin.training-tests.*',
                    'admin.training-questions.*',
                    'admin.training-report.*',
                    'admin.operations.workforce-coverage',
                    'admin.operations.action-plan',
                    'admin.operations.audit-calendar',
                    'admin.operations.audits*',
                    'admin.employee-performance',
                    'admin.operations.evaluations*',
                    'admin.operations.evaluation_questions.*'
                ]);

                $user = auth()->user();
                $operationsDefaultRoute = route('admin.all_schedules.index');
                if ($user->can('all_schedules.view')) {
                    $operationsDefaultRoute = route('admin.all_schedules.index');
                } elseif ($user->can('business_failures.view')) {
                    $operationsDefaultRoute = route('admin.failures.index');
                } elseif ($user->can('driver_report.view')) {
                    $operationsDefaultRoute = route('admin.hr.driver-report.index');
                } elseif ($user->can('equipment_manager.view')) {
                    $operationsDefaultRoute = route('admin.equipment-management.index');
                } elseif ($user->can('scheduling_calendar.view')) {
                    $operationsDefaultRoute = route('admin.scheduling_calendar.index');
                } elseif ($user->can('team_availability.view')) {
                    $operationsDefaultRoute = route('admin.team.availability');
                } elseif ($user->can('vehicle_planning.view')) {
                    $operationsDefaultRoute = route('admin.vehicle.planning');
                } elseif ($user->can('warehouse.view')) {
                    $operationsDefaultRoute = route('admin.warehouse.maintenance');
                } elseif ($user->can('warehouse_calendar.view')) {
                    $operationsDefaultRoute = route('admin.warehouse.calendar');
                } elseif ($user->can('training.view')) {
                    $operationsDefaultRoute = route('admin.training-categories.index');
                }
            @endphp
            <li class="{{ $isOperationsActive ? 'active' : '' }}">
                <a href="{{ $operationsDefaultRoute }}">
                    <div class="icon-round">
                        <img src={{ asset("img/icons/menu-icon6.svg") }} alt="icon" />
                    </div>
                    <div class="nav-text ms-3">
                        Operations
                    </div>
                </a>
            </li>
            @endcan
            @can('corporate_tools.view')
            @php
                $isCorporateToolsActive = request()->routeIs([
                    'admin.change-control.*',
                    'admin.consumable-reports.*',
                    'admin.expense-report.*',
                    'admin.inventory-report.*',
                    'admin.office-duties.*',
                    'admin.job-profitability.*'
                ]);

                $user = auth()->user();
                $corpToolsDefaultRoute = route('admin.change-control.index');
                if ($user->can('change_control.view')) {
                    $corpToolsDefaultRoute = route('admin.change-control.index');
                } elseif ($user->can('consumable_report.view')) {
                    $corpToolsDefaultRoute = route('admin.consumable-reports.index');
                } elseif ($user->can('expense_report.view')) {
                    $corpToolsDefaultRoute = route('admin.expense-report.index');
                } elseif ($user->can('inventory_reporting.view')) {
                    $corpToolsDefaultRoute = route('admin.inventory-report.index');
                } elseif ($user->can('job_profitability.view')) {
                    $corpToolsDefaultRoute = route('admin.job-profitability.index');
                } elseif ($user->can('office_duties.view')) {
                    $corpToolsDefaultRoute = route('admin.office-duties.index');
                }
            @endphp
            <li class="{{ $isCorporateToolsActive ? 'active' : '' }}">
                <a href="{{ $corpToolsDefaultRoute }}">
                    <div class="icon-round">
                        <img src={{ asset("img/icons/menu-icon15.svg") }} alt="icon" />
                    </div>
                    <div class="nav-text ms-3">
                        Corporate Tools
                    </div>
                </a>
            </li>
            @endcan

            @can('hr.view')
            @php
                $isHRActive = request()->routeIs([
                    'admin.employee.*',
                    'admin.hr.timecards.*',
                    'admin.hr.time-off.*',
                    'admin.hr.praise.*',
                    'admin.hr.rewards.*',
                    'admin.hr.feedback.*',
                    'admin.service.labor_analysis'
                ]);

                $user = auth()->user();
                $hrDefaultRoute = route('admin.employee.index');
                if ($user->can('employee.view')) {
                    $hrDefaultRoute = route('admin.employee.index');
                } elseif ($user->can('time_off_request.view')) {
                    $hrDefaultRoute = route('admin.hr.time-off.index');
                } elseif ($user->can('team_praise.view')) {
                    $hrDefaultRoute = route('admin.hr.praise.index');
                } elseif ($user->can('gb_reward.view')) {
                    $hrDefaultRoute = route('admin.hr.rewards.index');
                } elseif ($user->can('anonymous_feedback.add') || $user->can('anonymous_feedback.view')) {
                    $hrDefaultRoute = route('admin.hr.feedback.create');
                }
            @endphp
            <li class="{{ $isHRActive ? 'active' : '' }}">
                <a href="{{ $hrDefaultRoute }}">
                    <div class="icon-round">
                        <img src={{ asset("img/icons/menu-icon2.svg") }} alt="icon" />
                    </div>
                    <div class="nav-text ms-3">
                        Human Resources
                    </div>
                </a>
            </li>
            @endcan

            <li class="{{ request()->routeIs('admin.forms.*') ? 'active' : '' }}">
                <a href="{{ route('admin.forms.index') }}">
                    <div class="icon-round">
                        <img src={{ asset("img/icons/menu-icon6.svg") }} alt="icon" />
                    </div>
                    <div class="nav-text ms-3">
                        Forms
                    </div>
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.imports.*') ? 'active' : '' }}">
                <a href="{{ route('admin.imports.index') }}">
                    <div class="icon-round">
                        <img src={{ asset("img/icons/menu-icon7.svg") }} alt="icon" />
                    </div>
                    <div class="nav-text ms-3">
                        Imports
                    </div>
                </a>
            </li>
            
            @if(auth()->user()->isSuperAdmin())
                <li class="{{ request()->routeIs('admin.roles.permissions') ? 'active' : '' }}">
                    <a href="{{ route('admin.roles.permissions') }}">
                        <div class="icon-round">
                            <img src={{ asset("img/icons/menu-icon4.svg") }} alt="icon" />
                        </div>
                        <div class="nav-text ms-3">
                            Role
                        </div>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.work-report.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.work-report.index') }}">
                        <div class="icon-round">
                            <img src={{ asset("img/icons/menu-icon15.svg") }} alt="icon" />
                        </div>
                        <div class="nav-text ms-3">
                            Employee Work Report
                        </div>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.settings.index') }}">
                        <div class="icon-round">
                            <img src={{ asset("img/icons/menu-icon16.svg") }} alt="icon" />
                        </div>
                        <div class="nav-text ms-3">
                            Settings
                        </div>
                    </a>
                </li>
            @endif
            {{-- <li>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <div class="icon-round">
                        <img src="{{ asset('img/icons/logout.svg') }}" alt="icon" />
                    </div>
                    <div class="nav-text ms-3">
                        Logout
                    </div>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li> --}}
        </ul>
    </nav>
</aside>
