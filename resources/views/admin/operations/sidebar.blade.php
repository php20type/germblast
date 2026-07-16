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
            <a class="nav-link {{ request()->routeIs('admin.all_schedules.*') ? 'active' : '' }}" href="{{ route('admin.all_schedules.index') }}">
                All Schedules
            </a>

            <a class="nav-link {{ request()->routeIs('admin.failures.*') ? 'active' : '' }}"
                href="{{ route('admin.failures.index') }}">
                Business Failure
            </a>

            <a class="nav-link {{ request()->routeIs('admin.hr.driver-report.*') ? 'active' : '' }}"
                href="{{ route('admin.hr.driver-report.index') }}">
                Driver Report
            </a>

            <a class="nav-link {{ request()->routeIs('admin.equipment-management.*') ? 'active' : '' }}"
                href="{{ route('admin.equipment-management.index') }}">
                Equipment Manager
            </a>

            <a class="nav-link {{ request()->routeIs('admin.scheduling_calendar.*') ? 'active' : '' }}"
                href="{{ route('admin.scheduling_calendar.index') }}">
                Scheduling Calendar
            </a>



            <a class="nav-link {{ request()->routeIs('admin.team.availability') ? 'active' : '' }}"
                href="{{ route('admin.team.availability') }}">
                Team Availability
            </a>

            <a class="nav-link {{ request()->routeIs('admin.vehicle.planning') ? 'active' : '' }}"
                href="{{ route('admin.vehicle.planning') }}">
                Vehicle Planning
            </a>

            <a class="nav-link {{ request()->routeIs('admin.warehouse.maintenance') ? 'active' : '' }}"
                href="{{ route('admin.warehouse.maintenance') }}">
                Warehouse
            </a>

            <a class="nav-link {{ request()->routeIs('admin.warehouse.calendar') ? 'active' : '' }}"
                href="{{ route('admin.warehouse.calendar') }}">
                Warehouse Calendar
            </a>

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
