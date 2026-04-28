 <!-- Aside section start -->
 <aside class="app-sidebar">
    {{-- <div id="close"><a href="javascript:void(0)"><i class="fa-regular fa-xmark"></i></a></div> --}}
    <div class="logo-sec">
        <a href="{{ route('admin.dashboard') }}" class="d-block"><img src={{ asset("img/logo/logo.svg") }} alt="logo" /></a>
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
            <li class="">
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
            </li>
            <hr>
            <li class="{{ request()->routeIs('admin.company.*') || request()->routeIs('admin.company.*') ? 'active' : '' }}">
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
            <li class="{{ request()->routeIs('admin.lead.*') || request()->routeIs('admin.survey.proposal.*') ? 'active' : '' }}">
                <a href="{{ route('admin.lead.index') }}">
                    <div class="icon-round">
                        <img src={{ asset("img/icons/menu-icon5.svg") }} alt="icon" />
                    </div>
                    <div class="nav-text ms-3">
                        Leads
                    </div>
                </a>
            </li>
            <li class="">
                <a href="#">
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
