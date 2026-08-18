<!-- Sidebar -->
<div class="col-md-2">
    <div class="sidebar">
        <div class="mt-2">
            <h6 class="text-uppercase text-light mb-3">Corporate Tools ⚙️</h6>
        </div>
        <div class="my-3">
            <input type="text" class="form-control search-box" placeholder="🔍">
        </div>
        <hr>

        <div id="corporate-tools-list">
            @can('change_control.view')
            <a class="nav-link {{ request()->routeIs('admin.change-control.*') ? 'active' : '' }}" href="{{ route('admin.change-control.index') }}">
                Change Control
            </a>
            @endcan

            @can('consumable_report.view')
            <a class="nav-link {{ request()->routeIs('admin.consumable-reports.*') ? 'active' : '' }}" href="{{ route('admin.consumable-reports.index') }}">
                Consumable Reports
            </a>
            @endcan

            @can('expense_report.view')
            <a class="nav-link {{ request()->routeIs('admin.expense-report.*') ? 'active' : '' }}" href="{{ route('admin.expense-report.index') }}">
                Expense Report
            </a>
            @endcan

            @can('inventory_reporting.view')
            <a class="nav-link {{ request()->routeIs('admin.inventory-report.*') ? 'active' : '' }}" href="{{ route('admin.inventory-report.index') }}">
                Inventory Reporting
            </a>
            @endcan

            @can('job_profitability.view')
            <a class="nav-link {{ request()->routeIs('admin.job-profitability.*') ? 'active' : '' }}" href="{{ route('admin.job-profitability.index') }}">
                Job Profitability
            </a>
            @endcan

            <a class="nav-link {{ request()->routeIs('admin.quickbooks.*') ? 'active' : '' }}" href="{{ route('admin.quickbooks.index') }}">
                QuickBooks Export
            </a>

            @can('office_duties.view')
            <a class="nav-link {{ request()->routeIs('admin.office-duties.*') ? 'active' : '' }}" href="{{ route('admin.office-duties.index') }}">
                Office Duties
            </a>
            @endcan


            <div id="nothing-found" style="display:none; color: rgba(255,255,255,0.6); padding: 10px 0;">Nothing found.</div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchBox = document.querySelector('.search-box');
        const toolsList = document.querySelectorAll('#corporate-tools-list a');
        const nothingFound = document.getElementById('nothing-found');

        if (searchBox) {
            searchBox.addEventListener('input', function() {
                const query = this.value.toLowerCase();
                let visibleCount = 0;

                toolsList.forEach(function(link) {
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
