<!-- Sidebar -->
<div class="col-md-2">
    <div class="sidebar">
        <div class="">
            <a class="nav-link {{ request()->routeIs('admin.company.index') ? 'active' : '' }}" href="{{ route('admin.company.index') }}">
                All companies
                <span class="badge bg-light text-dark">{{ $formattedTotalCompanies }}</span>
            </a>
        </div>
        <div class="my-3">
            <input type="text" class="form-control search-box" placeholder="🔍">
        </div>
        <!-- <hr>
        <div class="mt-4">
            <h6 class="text-uppercase text-light mb-1">YOUR LISTS</h6>
            <p class="text-light mb-1" style="opacity: 0.8;">You haven't saved any
                lists.</p>
        </div> -->
        <hr>

        <div id="shared-lists">
            <div class="mt-4">
                <h6 class="text-uppercase text-light mb-2 text-nowrap">SHARED LISTS ⚙️</h6>
                @can('company.list.my.view')
                <a class="nav-link company-filter {{ request()->routeIs('admin.company.my_companies') ? 'active' : '' }}"
                    href="{{ route('admin.company.my_companies', auth()->id()) }}">
                    My companies
                    <span class="badge bg-light text-dark">{{ $formattedMyCompanies }}</span>
                </a>
                @endcan

                @can('company.list.all.view')
                <a class="nav-link company-filter {{ request()->routeIs('admin.company.assigned_companies') ? 'active' : '' }}"
                    href="{{ route('admin.company.assigned_companies', auth()->id()) }}">
                    Assigned companies
                    <span class="badge bg-light text-dark">{{ $formattedAssignedCompanies }}</span>
                </a>
                @endcan

                <div id="nothing-found" style="display:none;">Nothing found.</div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchBox = document.querySelector('.search-box');
        const sharedLists = document.querySelectorAll('#shared-lists a');
        const nothingFound = document.getElementById('nothing-found');

        searchBox.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            let visibleCount = 0;

            sharedLists.forEach(function(link) {
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
    });
</script>
