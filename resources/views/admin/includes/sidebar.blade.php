<!-- Aside section start -->
<aside class="app-sidebar">
    {{-- <div id="close"><a href="javascript:void(0)"><i class="fa-regular fa-xmark"></i></a></div> --}}
    <div class="logo-sec">
        <a href="{{ route('admin.dashboard') }}" class="d-block"><img src={{ asset("img/logo/logo.svg") }}
                alt="logo" /></a>
    </div>
    <nav class="sidebar-nav">
        <ul class="list-inline">
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
            <!-- <li class="">
                <a href="#">
                    <div class="icon-round">
                        <img src={{ asset("img/icons/menu-icon19.svg") }} alt="icon" />
                    </div>
                    <div class="nav-text ms-3">
                        Reports
                    </div>
                </a>
            </li> -->
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
            @php
                $isOperationsActive = request()->routeIs([
                    'admin.all_schedules.*',
                    'admin.failures.*',
                    'admin.hr.driver-report.*',
                    'admin.equipment-management.*',
                    'admin.scheduling_calendar.*',
                    'admin.team.availability',
                    'admin.vehicle.planning',
                    'admin.warehouse.maintenance',
                    'admin.warehouse.calendar',
                ]);
            @endphp
            <li class="{{ $isOperationsActive ? 'active' : '' }}">
                <a href="{{ route('admin.all_schedules.index') }}">
                    <div class="icon-round">
                        <img src={{ asset("img/icons/menu-icon6.svg") }} alt="icon" />
                    </div>
                    <div class="nav-text ms-3">
                        Operations
                    </div>
                </a>
            </li>
            @php
                $isCorporateToolsActive = request()->routeIs([
                    'admin.change-control.*',
                    'admin.consumable-reports.*',
                    'admin.expense-report.*',
                    'admin.inventory-report.*',
                    'admin.office-duties.*',
                    'admin.job-profitability.*'
                ]);
            @endphp
            <li class="{{ $isCorporateToolsActive ? 'active' : '' }}">
                <a href="{{ route('admin.change-control.index') }}">
                    <div class="icon-round">
                        <img src={{ asset("img/icons/menu-icon15.svg") }} alt="icon" />
                    </div>
                    <div class="nav-text ms-3">
                        Corporate Tools
                    </div>
                </a>
            </li>





            @php
                $isHRActive = request()->routeIs([
                    'admin.employee.*',
                    'admin.hr.time-off.*',
                    'admin.hr.praise.*',
                    'admin.hr.rewards.*',
                    'admin.hr.feedback.*'
                ]);
            @endphp
            <li class="{{ $isHRActive ? 'active' : '' }}">
                <a href="{{ auth()->user()->isSuperAdmin() ? route('admin.employee.index') : route('admin.hr.time-off.index') }}">
                    <div class="icon-round">
                        <img src={{ asset("img/icons/menu-icon2.svg") }} alt="icon" />
                    </div>
                    <div class="nav-text ms-3">
                        Human Resources
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
            <li>
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
            </li>
        </ul>
    </nav>
</aside>
