<!-- Aside section start -->
<aside class="app-sidebar">
    {{-- <div id="close"><a href="javascript:void(0)"><i class="fa-regular fa-xmark"></i></a></div> --}}
    <div class="logo-sec">
        <a href="{{ route('admin.dashboard') }}" class="d-block"><img src={{ asset("img/logo/logo.svg") }}
                alt="logo" /></a>
    </div>
    <nav class="sidebar-nav">
        <ul class="list-inline">
            <li class="{{ request()->routeIs('admin.sales.*') ? 'active' : '' }}">
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
            <li class="{{ request()->routeIs('admin.scheduling_calendar.*') ? 'active' : '' }}">
                <a href="{{ route('admin.scheduling_calendar.index') }}">
                    <div class="icon-round">
                        <img src={{ asset("img/icons/menu-icon6.svg") }} alt="icon" />
                    </div>
                    <div class="nav-text ms-3">
                        Scheduling Calendar
                    </div>
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.all_schedules.*') ? 'active' : '' }}">
                <a href="{{ route('admin.all_schedules.index') }}">
                    <div class="icon-round">
                        <img src={{ asset("img/icons/menu-icon6.svg") }} alt="icon" />
                    </div>
                    <div class="nav-text ms-3">
                        All Schedules
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
            <li class="{{ request()->routeIs('admin.vehicle.planning') ? 'active' : '' }}">
                <a href="{{ route('admin.vehicle.planning') }}">
                    <div class="icon-round">
                        <img src={{ asset("img/icons/menu-icon13.svg") }} alt="icon" />
                    </div>
                    <div class="nav-text ms-3">
                        Vehicle Planning
                    </div>
                </a>
            </li>
            <hr>
            <li class="{{ request()->routeIs('admin.expense-report.*') ? 'active' : '' }}">
                <a href="{{ route('admin.expense-report.index') }}">
                    <div class="icon-round">
                        <img src={{ asset("img/icons/menu-icon2.svg") }} alt="icon" />
                    </div>
                    <div class="nav-text ms-3">
                        Expense Report
                    </div>
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.job-profitability.*') ? 'active' : '' }}">
                <a href="{{ route('admin.job-profitability.index') }}">
                    <div class="icon-round">
                        <img src={{ asset("img/icons/menu-icon18.svg") }} alt="icon" />
                    </div>
                    <div class="nav-text ms-3">
                        Job Profitability
                    </div>
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.equipment-management.*') ? 'active' : '' }}">
                <a href="{{ route('admin.equipment-management.index') }}">
                    <div class="icon-round">
                        <img src={{ asset("img/icons/menu-icon19.svg") }} alt="icon" />
                    </div>
                    <div class="nav-text ms-3">
                        Equipment Management
                    </div>
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.equipment-loan.*') ? 'active' : '' }}">
                <a href="{{ route('admin.equipment-loan.index') }}">
                    <div class="icon-round">
                        <img src={{ asset("img/icons/menu-icon19.svg") }} alt="icon" />
                    </div>
                    <div class="nav-text ms-3">
                        Equipment Loan
                    </div>
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.consumable-reports.*') ? 'active' : '' }}">
                <a href="{{ route('admin.consumable-reports.index') }}">
                    <div class="icon-round">
                        <img src={{ asset("img/icons/menu-icon15.svg") }} alt="icon" />
                    </div>
                    <div class="nav-text ms-3">
                        Consumable Reports
                    </div>
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.inventory-report.*') ? 'active' : '' }}">
                <a href="{{ route('admin.inventory-report.index') }}">
                    <div class="icon-round">
                        <img src={{ asset("img/icons/menu-icon15.svg") }} alt="icon" />
                    </div>
                    <div class="nav-text ms-3">
                        Inventory Report
                    </div>
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.office-duties.*') ? 'active' : '' }}">
                <a href="{{ route('admin.office-duties.index') }}">
                    <div class="icon-round">
                        <img src={{ asset("img/icons/menu-icon15.svg") }} alt="icon" />
                    </div>
                    <div class="nav-text ms-3">
                        Office Duties
                    </div>
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.warehouse.maintenance') ? 'active' : '' }}">
                <a href="{{ route('admin.warehouse.maintenance') }}">
                    <div class="icon-round">
                        <img src={{ asset("img/icons/menu-icon13.svg") }} alt="icon" />
                    </div>
                    <div class="nav-text ms-3">
                        Warehouse Maintenance
                    </div>
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.warehouse.calendar') ? 'active' : '' }}">
                <a href="{{ route('admin.warehouse.calendar') }}">
                    <div class="icon-round">
                        <img src={{ asset("img/icons/menu-icon8.svg") }} alt="icon" />
                    </div>
                    <div class="nav-text ms-3">
                        Warehouse Calendar
                    </div>
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.hr.feedback.*') ? 'active' : '' }}">
                <a href="{{ route('admin.hr.feedback.create') }}">
                    <div class="icon-round">
                        <img src={{ asset("img/icons/menu-icon2.svg") }} alt="icon" />
                    </div>
                    <div class="nav-text ms-3">
                        Anonymous Feedback
                    </div>
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.hr.time-off.*') ? 'active' : '' }}">
                <a href="{{ route('admin.hr.time-off.index') }}">
                    <div class="icon-round">
                        <img src={{ asset("img/icons/menu-icon15.svg") }} alt="icon" />
                    </div>
                    <div class="nav-text ms-3">
                        Time Off Requests
                    </div>
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.hr.praise.*') ? 'active' : '' }}">
                <a href="{{ route('admin.hr.praise.create') }}">
                    <div class="icon-round">
                        <img src={{ asset("img/icons/menu-icon2.svg") }} alt="icon" />
                    </div>
                    <div class="nav-text ms-3">
                        Core Value Praise
                    </div>
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.hr.rewards.*') ? 'active' : '' }}">
                <a href="{{ route('admin.hr.rewards.index') }}">
                    <div class="icon-round">
                        <img src={{ asset("img/icons/menu-icon15.svg") }} alt="icon" />
                    </div>
                    <div class="nav-text ms-3">
                        GB Rewards
                    </div>
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.hr.driver-report.*') ? 'active' : '' }}">
                <a href="{{ route('admin.hr.driver-report.index') }}">
                    <div class="icon-round">
                        <img src={{ asset("img/icons/menu-icon15.svg") }} alt="icon" />
                    </div>
                    <div class="nav-text ms-3">
                        Driver Report
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
                <li class="{{ request()->routeIs('admin.employee.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.employee.index') }}">
                        <div class="icon-round">
                            <img src={{ asset("img/icons/menu-icon4.svg") }} alt="icon" />
                        </div>
                        <div class="nav-text ms-3">
                            Employees
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