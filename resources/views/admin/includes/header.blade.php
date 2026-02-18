<!-- header start -->
<div class="header-1">
    <div class="header-content">

        <div class="top-header-rightmenu">
            <div class="search-bar position-relative">
                <form class="search-form">
                    <input type="search" class="form-control" placeholder="Search name..." aria-label="Search">
                </form>
            </div>
            <div class="navigation-button">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item">
                        <a href="{{ route('admin.dashboard') }}" class="item-nav">
                            <div class="icon-round" title="Go to dashboard">
                                <i class="fa-solid fa-plus"></i>
                            </div>
                        </a>
                    </li>
                    {{-- <li class="list-inline-item">
                        <a href="#" class="item-nav">
                            <div class="icon-round" title="Notifications">
                                <i class="fa-solid fa-bell"></i>
                            </div>
                        </a>
                    </li> --}}
                </ul>
            </div>
        </div>

        <div class="top-header-rightmenu">
            <div class="sidemenu-toggle">
                <div class="d-flex align-items-center">
                    <a href="javascript:void(0)" id="menu-toggle">
                        <svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="1" y="1" width="44" height="44" rx="9" fill="#FFB81C" fill-opacity="0.15"
                                stroke="#FFB81C" stroke-width="2" />
                            <rect x="13" y="14" width="10" height="3" rx="1.5" fill="#FFB81C" />
                            <rect x="13" y="21" width="20" height="3" rx="1.5" fill="#FFB81C" />
                            <rect x="23" y="28" width="10" height="3" rx="1.5" fill="#FFB81C" />
                        </svg>
                    </a>
                </div>
            </div>
            <div class="navigation-button">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item">
                        <a href="#" data-bs-toggle="dropdown" class="dropdown item-nav">
                            <div class="icon-round" title="View Profile">
                                <i class="fa-solid fa-user"></i>
                            </div>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow" style="width: 220px; border-radius: 10px;">
                            <li class="px-3 py-2">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-dark">{{ Auth::user()->name }}</span>
                                    <small
                                        class="text-muted">{{ strtoupper(str_replace('_', ' ', Auth::user()->role ?? 'User')) }}</small>
                                </div>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center py-2 px-3 rounded"
                                    href="{{ route('admin.profile.view') }}">
                                    <i class="fas fa-user-circle me-3 text-primary"></i>
                                    <span>View Profile</span>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit"
                                        class="dropdown-item d-flex align-items-center py-2 px-3 rounded text-danger bg-transparent border-0 w-100">
                                        <i class="fas fa-sign-out-alt me-3"></i>
                                        <span>{{ __('Log Out') }}</span>
                                    </button>
                                </form>
                            </li>
                        </ul>

                    </li>
                </ul>
            </div>
        </div>


    </div>
</div>
<!-- header end -->
