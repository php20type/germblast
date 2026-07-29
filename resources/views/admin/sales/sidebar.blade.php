<!-- Sidebar -->
<div class="col-md-2">
    <div class="sidebar">
        <div class="mt-2">
            <h6 class="text-uppercase text-light mb-3">Sales 💼</h6>
        </div>
        <div class="my-3">
            <input type="text" class="form-control search-box" placeholder="🔍">
        </div>
        <hr>

        <div id="sales-tools-list">
            <a class="nav-link {{ request()->routeIs('admin.sales.index') ? 'active' : '' }}" href="{{ route('admin.sales.index') }}">
                Dashboard
            </a>

            <a class="nav-link {{ request()->routeIs('admin.sales.executive') ? 'active' : '' }}" href="{{ route('admin.sales.executive') }}">
                Executive Dashboard
            </a>

            <a class="nav-link {{ request()->routeIs('admin.sales.schedule.meeting') ? 'active' : '' }}" href="{{ route('admin.sales.schedule.meeting') }}">
                Schedule Meetings
            </a>

            <a class="nav-link {{ request()->routeIs('admin.sales.invoices*') ? 'active' : '' }}" href="{{ route('admin.sales.invoices') }}">
                Invoice
            </a>

            <a class="nav-link {{ request()->routeIs('admin.equipment-loan.*') ? 'active' : '' }}" href="{{ route('admin.equipment-loan.index') }}">
                Equipment Loan
            </a>

            <a class="nav-link {{ request()->routeIs('admin.sales.contract_exception_report') ? 'active' : '' }}" href="{{ route('admin.sales.contract_exception_report') }}">
                Contract Exception Report
            </a>

            <a class="nav-link {{ request()->routeIs('admin.sales.purchasing_information') ? 'active' : '' }}" href="{{ route('admin.sales.purchasing_information') }}">
                Purchasing Information
            </a>

            <div id="nothing-found" style="display:none; color: rgba(255,255,255,0.6); padding: 10px 0;">Nothing found.</div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchBox = document.querySelector('.search-box');
        const toolsList = document.querySelectorAll('#sales-tools-list a');
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
