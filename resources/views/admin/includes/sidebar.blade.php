 <!-- Aside section start -->
 <aside class="app-sidebar">
    <div id="close"><a href="javascript:void(0)"><i class="fa-regular fa-xmark"></i></a></div>
    <div class="logo-sec">
        <a href="#" class="d-block"><img src={{ asset("img/logo/logo.svg") }} alt="logo" /></a>
    </div>
    <nav class="sidebar-nav">
        <ul class="list-inline">
             <li class="{{ request()->routeIs('admin.sales.index') ? 'active' : '' }}">
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
            <li class="{{ request()->routeIs('admin.company.*') || request()->routeIs('admin.companies.*') ? 'active' : '' }}">
                <a href="{{ route('admin.company.index') }}">
                    <div class="icon-round">
                        <img src={{ asset("img/icons/menu-icon3.svg") }} alt="icon" />
                    </div>
                    <div class="nav-text ms-3">
                        Companies
                    </div>
                </a>
            </li>
            <li class=" {{ request()->routeIs('admin.peoples.*') ? 'active' : '' }}">
                <a href="{{ route('admin.peoples.index') }}">
                    <div class="icon-round">
                        <img src={{ asset("img/icons/menu-icon4.svg") }} alt="icon" />
                    </div>
                    <div class="nav-text ms-3">
                        People
                    </div>
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.leads.*') ? 'active' : '' }}">
                <a href="{{ route('admin.leads.index') }}">
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
            <hr>
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
        </ul>
    </nav>
</aside>
