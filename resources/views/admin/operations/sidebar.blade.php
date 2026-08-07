<!-- Sidebar -->
<div class="col-md-2">
    <div class="sidebar">
        <div class="mt-2">
            <h6 class="text-uppercase text-light mb-3">Operations 🔧</h6>
        </div>
        <div class="my-3">
            <input type="text" class="form-control search-box" placeholder="🔍">
        </div>
        <hr>

        <div id="operations-tools-list">
            @can('all_schedules.view')
            <a class="nav-link {{ request()->routeIs('admin.all_schedules.*') ? 'active' : '' }}" href="{{ route('admin.all_schedules.index') }}">
                All Schedules
            </a>
            @endcan

            <a class="nav-link {{ request()->routeIs('admin.isd-attendance.*') ? 'active' : '' }}" href="{{ route('admin.isd-attendance.index') }}">
                ISD Attendance
            </a>

            @can('business_failures.view')
            <a class="nav-link {{ request()->routeIs('admin.failures.*') ? 'active' : '' }}"
                href="{{ route('admin.failures.index') }}">
                Business Failure
            </a>
            @endcan

            @can('driver_report.view')
            <a class="nav-link {{ request()->routeIs('admin.hr.driver-report.*') ? 'active' : '' }}"
                href="{{ route('admin.hr.driver-report.index') }}">
                Driver Report
            </a>
            @endcan

            @can('equipment_manager.view')
            <a class="nav-link {{ request()->routeIs('admin.equipment-management.*') ? 'active' : '' }}"
                href="{{ route('admin.equipment-management.index') }}">
                Equipment Manager
            </a>
            @endcan

            @can('scheduling_calendar.view')
            <a class="nav-link {{ request()->routeIs('admin.scheduling_calendar.*') ? 'active' : '' }}"
                href="{{ route('admin.scheduling_calendar.index') }}">
                Scheduling Calendar
            </a>
            @endcan

            @can('team_availability.view')
            <a class="nav-link {{ request()->routeIs('admin.team.availability') ? 'active' : '' }}"
                href="{{ route('admin.team.availability') }}">
                Team Availability
            </a>
            @endcan

            <a class="nav-link {{ request()->routeIs('admin.operations.workforce-coverage') ? 'active' : '' }}"
                href="{{ route('admin.operations.workforce-coverage') }}">
                Workforce Coverage
            </a>

            @can('vehicle_planning.view')
            <a class="nav-link {{ request()->routeIs('admin.vehicle.planning') ? 'active' : '' }}"
                href="{{ route('admin.vehicle.planning') }}">
                Vehicle Planning
            </a>
            @endcan

            @can('warehouse.view')
            <a class="nav-link {{ request()->routeIs('admin.warehouse.maintenance') ? 'active' : '' }}"
                href="{{ route('admin.warehouse.maintenance') }}">
                Warehouse
            </a>
            @endcan

            @can('warehouse_calendar.view')
            <a class="nav-link {{ request()->routeIs('admin.warehouse.calendar') ? 'active' : '' }}"
                href="{{ route('admin.warehouse.calendar') }}">
                Warehouse Calendar
            </a>
            @endcan

            @can('training.view')
            <a class="nav-link {{ request()->routeIs('admin.training-categories.*') ? 'active' : '' }}"
                href="{{ route('admin.training-categories.index') }}">
                Training Categories
            </a>

            <a class="nav-link {{ request()->routeIs('admin.training-tests.*') ? 'active' : '' }}"
                href="{{ route('admin.training-tests.index') }}">
                Training Tests
            </a>

            <a class="nav-link {{ request()->routeIs('admin.training-questions.*') ? 'active' : '' }}"
                href="{{ route('admin.training-questions.index') }}">
                Training Questions
            </a>

            <a class="nav-link {{ request()->routeIs('admin.training-report.*') ? 'active' : '' }}"
                href="{{ route('admin.training-report.index') }}">
                Training Report
            </a>
            @endcan

            <div id="nothing-found" style="display:none; color: rgba(255,255,255,0.6); padding: 10px 0;">Nothing found.</div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchBox = document.querySelector('.search-box');
        const operationsList = document.querySelectorAll('#operations-tools-list a');
        const nothingFound = document.getElementById('nothing-found');

        if (searchBox) {
            searchBox.addEventListener('input', function() {
                const query = this.value.toLowerCase();
                let visibleCount = 0;

                operationsList.forEach(function(link) {
                    const text = link.textContent.toLowerCase();
                    if (text.includes(query)) {
                        link.style.display = 'block';
                        visibleCount++;
                    } else {
                        link.style.display = 'none';
                    }
                });

                nothingFound.style.display = visibleCount === 0 ? 'block' : 'none';
            });
        }
    });
</script>
