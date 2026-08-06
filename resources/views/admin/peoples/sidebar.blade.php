<!-- Sidebar -->
<div class="col-md-2">
    <div class="sidebar">
        <div class="">
            <a class="nav-link {{ request()->routeIs('admin.people.index') ? 'active' : '' }}" href="{{ route('admin.people.index') }}">
                All peoples
                <span class="badge bg-light text-dark">{{ $formattedTotalPeoples }}</span>
            </a>
        </div>
        <div class="my-3">
            <input type="text" class="form-control search-box" placeholder="🔍">
        </div>
        <!-- <hr>
        <div class="mt-4">
            <h6 class="text-uppercase text-light mb-1">YOUR
                LISTS
                🔒</h6>
            <p class="text-light mb-1" style="opacity: 0.8;">You haven't saved any
                lists.</p>
        </div> -->
        <hr>
        <div id="shared-lists">
            <div class="mt-4">
                <h6 class="text-uppercase text-light mb-2 text-nowrap">SHARED LISTS ⚙️</h6>

                @can('people.list.my.view')
                <a class="nav-link people-filter {{ request()->routeIs('admin.people.my_peoples') ? 'active' : '' }}"
                    href="{{ route('admin.people.my_peoples', auth()->id()) }}">
                    My people
                    <span class="badge bg-light text-dark">{{ $formattedMyPeopleCount }}</span>
                </a>
                @endcan

                @can('people.list.all.view')
                <a class="nav-link people-filter {{ request()->routeIs('admin.people.assigned_peoples') ? 'active' : '' }}"
                    href="{{ route('admin.people.assigned_peoples', auth()->id()) }}">
                    Assigned people
                    <span class="badge bg-light text-dark">{{ $formattedAssignedPeopleCount }}</span>
                </a>
                @endcan

                @can('people.list.marketing_contacts.view')
                <a class="d-none nav-link people-filter {{ request()->routeIs('admin.peoples.marketing_contacts') ? 'active' : '' }}"
                    href="{{ route('admin.people.marketing_contacts') }}">
                    Marketing contacts
                    <span class="badge bg-light text-dark">13.8K</span>
                </a>
                @endcan

            </div>
            {{-- <hr> --}}
            <div class="mt-4 d-none">
                <h6 class="text-uppercase text-light mb-2">Audiences </h6>

                @can('people.list.animal_care.view')
                <a class="nav-link people-filter {{ request()->routeIs('admin.peoples.animal_care') ? 'active' : '' }}"
                    href="{{ route('admin.people.animal_care') }}">
                    Pet/Animal care
                    <span class="badge bg-light text-dark">3</span>
                </a>
                @endcan

                @can('people.list.sequence_healthcare.view')
                <a class="nav-link people-filter {{ request()->routeIs('admin.peoples.sequence_healthcare') ? 'active' : '' }}"
                    href="{{ route('admin.people.sequence_healthcare') }}">
                    1st drip sequence..
                    <span class="badge bg-light text-dark">76</span>
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
