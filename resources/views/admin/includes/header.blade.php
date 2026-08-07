<!-- header start -->
<div class="header-1">
    <div class="header-content">

        <div class="top-header-rightmenu">
            <div class="search-bar position-relative">
                <form class="search-form" onsubmit="return false;">
                    <input type="search" id="globalSearchInput" class="form-control" placeholder="Search name..." aria-label="Search" autocomplete="off" data-search-url="{{ route('admin.global-search') }}">
                </form>
                <div class="search-results-dropdown" id="globalSearchResults"></div>
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
                <ul class="list-inline mb-0 d-flex align-items-center">
                    <li class="list-inline-item">
                        <a href="#" class="dropdown item-nav" data-bs-toggle="dropdown">
                            <div class="icon-round position-relative" title="Notifications">
                                <i class="fa-solid fa-bell"></i>
                                <span id="notificationBadge" class="badge bg-danger position-absolute top-0 start-100 translate-middle p-1"
                                    style="font-size: 0.6rem; min-width: 20px; display: none;">0</span>
                            </div>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow" style="width: 400px; border-radius: 10px; z-index: 9999 !important; background-color: #ffffff !important;">

                            <li class="px-3 py-2 d-flex justify-content-between align-items-center">
                                <strong>Notifications</strong>
                                <button class="btn btn-sm btn-link p-0" id="markAllAsReadBtn" style="font-size: 0.85rem;">Mark all as Read</button>
                            </li>

                            <li><hr class="dropdown-divider"></li>

                            <li id="notificationList" style="max-height:400px; overflow-y:auto;">
                                <div class="px-3 py-3 text-center text-muted">
                                    <i class="fa-solid fa-spinner fa-spin"></i> Loading notifications...
                                </div>
                            </li>

                            <li><hr class="dropdown-divider"></li>

                            <li class="px-3 py-2 text-center">
                                <a href="{{ route('admin.notifications.index') }}" class="text-decoration-none fw-bold" style="font-size: 0.9rem;">View All Notifications</a>
                            </li>
                        </ul>

                    </li>
                    <li class="list-inline-item ms-2">
                        <a href="#" data-bs-toggle="dropdown" class="dropdown item-nav d-flex align-items-center justify-content-center p-0 overflow-hidden">
                            @if(Auth::user()->profile_image)
                                <img src="{{ asset('storage/' . Auth::user()->profile_image) }}"
                                    alt="Profile"
                                    style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <i class="fa-solid fa-user"></i>
                            @endif
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
                                {{-- <a class="dropdown-item d-flex align-items-center py-2 px-3 rounded"
                                    href="{{ route('admin.profile.view') }}">
                                    <i class="fas fa-user-circle me-3 text-primary"></i>
                                    <span>View Profile</span>
                                </a> --}}
                                <a class="dropdown-item d-flex align-items-center py-2 px-3 rounded"
                                    href="{{ route('admin.profile.view') }}">
                                    @if(Auth::user()->profile_image)
                                        <img src="{{ asset('storage/' . Auth::user()->profile_image) }}"
                                            alt="Profile"
                                            style="width:35px; height:35px; object-fit:cover; border-radius:50%; margin-right:12px;">
                                    @else
                                        <i class="fas fa-user-circle text-primary" style="font-size: 24px; width: 35px; text-align: center; margin-right: 12px;"></i>
                                    @endif
                                    <span>View Profile</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center py-2 px-3 rounded"
                                    href="{{ route('admin.my-jobs.index') }}">
                                    <i class="fas fa-briefcase text-warning" style="font-size: 22px; width: 35px; text-align: center; margin-right: 12px;"></i>
                                    <span>My Jobs</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center py-2 px-3 rounded"
                                    href="{{ route('admin.employee-training.index') }}">
                                    <i class="fas fa-graduation-cap text-info" style="font-size: 20px; width: 35px; text-align: center; margin-right: 12px;"></i>
                                    <span>My Training</span>
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Load latest notifications
    function loadNotifications() {
        $.ajax({
            url: "{{ route('admin.notifications.latest') }}",
            type: "GET",
            success: function(response) {
                if (response.success) {
                    let badge = $('#notificationBadge');
                    if (response.unread_count > 0) {
                        badge.text(response.unread_count).show();
                    } else {
                        badge.hide();
                    }

                    let list = $('#notificationList');
                    list.empty();

                    if (response.notifications.length === 0) {
                        list.append('<div class="px-3 py-3 text-center text-muted">No notifications</div>');
                    } else {
                        response.notifications.forEach(function(notif) {
                            let unreadClass = notif.is_read ? '' : 'fw-bold bg-light';
                            let dot = notif.is_read ? '' : '<span class="badge bg-primary rounded-circle p-1 ms-2" style="width:8px;height:8px;"></span>';
                            list.append(`
                                <a href="#" class="dropdown-item py-2 px-3 border-bottom ${unreadClass}" onclick="markNotificationAsRead(${notif.id}); return false;" style="white-space: normal;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-1 text-dark" style="font-size: 0.9rem;">${notif.title} ${dot}</h6>
                                        <small class="text-muted" style="font-size: 0.75rem;">${notif.time_ago}</small>
                                    </div>
                                    <p class="mb-1 text-muted" style="font-size: 0.8rem;">${notif.message}</p>
                                    ${notif.module ? `<span class="badge bg-secondary" style="font-size: 0.65rem;">${notif.module}</span>` : ''}
                                </a>
                            `);
                        });
                    }
                }
            }
        });
    }

    // Call initially
    loadNotifications();

    // Mark all as read
    $('#markAllAsReadBtn').on('click', function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('admin.notifications.mark-all-read') }}",
            type: "POST",
            data: { _token: "{{ csrf_token() }}" },
            success: function(response) {
                if (response.success) {
                    loadNotifications();
                }
            }
        });
    });

    window.markNotificationAsRead = function(id) {
        $.ajax({
            url: "/admin/notifications/" + id + "/mark-read",
            type: "POST",
            data: { _token: "{{ csrf_token() }}" },
            success: function(response) {
                if (response.success) {
                    // Navigate to notifications page or module if needed. For now, just reload the list.
                    loadNotifications();
                }
            }
        });
    };
});
</script>
