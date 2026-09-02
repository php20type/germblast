<!-- Sidebar -->
<div class="col-md-2">
    <div class="sidebar">
        <div class="mt-2">
            <h6 class="text-uppercase text-light mb-3">Reports 📊</h6>
        </div>
        <div class="my-3">
            <input type="text" class="form-control search-box" placeholder="🔍">
        </div>
        <hr>

        <div id="reports-tools-list">
            
            <a class="nav-link {{ request()->routeIs('admin.reports.sales') ? 'active' : '' }}" href="{{ route('admin.reports.sales') }}">
                Sales
            </a>

            <a class="nav-link {{ request()->routeIs('admin.reports.losses*') ? 'active' : '' }}" href="{{ route('admin.reports.losses.leads') }}">
                Losses
            </a>

            <a class="nav-link {{ request()->routeIs('admin.reports.new_leads') ? 'active' : '' }}" href="{{ route('admin.reports.new_leads') }}">
                New Leads
            </a>

            <a class="nav-link {{ request()->routeIs('admin.reports.products') ? 'active' : '' }}" href="{{ route('admin.reports.products') }}">
                Products
            </a>

            <div id="nothing-found" style="display:none; color: rgba(255,255,255,0.6); padding: 10px 0;">Nothing found.</div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchBox = document.querySelector('.search-box');
        const toolsList = document.querySelectorAll('#reports-tools-list a');
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
