<!-- Sidebar -->
<div class="col-md-2">
    <div class="sidebar">
        <div class="mt-2">
            <h6 class="text-uppercase text-light mb-3">Settings ⚙️</h6>
        </div>
        <div class="my-3">
            <input type="text" class="form-control search-box" placeholder="🔍">
        </div>
        <hr>

        <div id="settings-tools-list">
            
            <!-- <div class="mt-3 mb-2">
                <small class="text-uppercase text-light" style="font-size: 14px;">Your Settings</small>
            </div>
            <a class="nav-link" href="#">Profile</a>
            <a class="nav-link" href="#">Phone</a>
            <a class="nav-link" href="#">Calendar</a>
            <a class="nav-link" href="#">Notifications</a>
            <a class="nav-link" href="#">Tasks</a>
            <a class="nav-link" href="#">Email send</a>
            <a class="nav-link" href="#">Sync email</a>

            <div class="mt-4 mb-2">
                <small class="text-uppercase text-light" style="font-size: 14px">Administration</small>
            </div>
            <a class="nav-link" href="#">General</a>
            <a class="nav-link" href="#">AI features</a>
            <a class="nav-link" href="#">Security</a>
            <a class="nav-link" href="#">Billing</a>
            <a class="nav-link" href="#">Users & teams</a>
            <a class="nav-link" href="#">Email security</a>
            <a class="nav-link" href="#">Audit log</a>

            <div class="mt-4 mb-2">
                <small class="text-uppercase" style="font-size: 14px">Sales process</small>
            </div>
            <a class="nav-link" href="#">Pipelines & stages</a>
            <a class="nav-link" href="#">Processes</a>
            <a class="nav-link" href="#">Triggers</a>
            <a class="nav-link" href="#">Delays</a>
            <a class="nav-link" href="#">User assignment</a>

            <div class="mt-4 mb-2">
                <small class="text-uppercase text-light" style="font-size: 14px">Data</small>
            </div>
            <a class="nav-link" href="#">Import</a>
            <a class="nav-link" href="#">Export</a>
            <a class="nav-link" href="#">Integrations</a>
            <a class="nav-link" href="#">PeopleIQ</a>
            <a class="nav-link" href="#">Trash</a>
            <a class="nav-link" href="#">SQL access</a> -->

            <div class="mt-4 mb-2">
                <small class="text-uppercase" style="font-size: 14px">Organization</small>
            </div>
            <a class="nav-link {{ request()->routeIs('admin.settings.activity_type') ? 'active' : '' }}" href="{{ route('admin.settings.activity_type') }}">Activity types</a>
            <a class="nav-link {{ request()->routeIs('admin.settings.channel_source') ? 'active' : '' }}" href="{{ route('admin.settings.channel_source') }}">Channels & sources</a>
            <a class="nav-link {{ request()->routeIs('admin.settings.company_type') ? 'active' : '' }}" href="{{ route('admin.settings.company_type') }}">Company types</a>
            <a class="nav-link {{ request()->routeIs('admin.settings.competitor') ? 'active' : '' }}" href="{{ route('admin.settings.competitor') }}">Competitors</a>
            <a class="nav-link {{ request()->routeIs('admin.settings.industry') ? 'active' : '' }}" href="{{ route('admin.settings.industry') }}">Industries</a>
            <a class="nav-link {{ request()->routeIs('admin.settings.market') ? 'active' : '' }}" href="{{ route('admin.settings.market') }}">Markets</a>
            <a class="nav-link {{ request()->routeIs('admin.settings.product') ? 'active' : '' }}" href="{{ route('admin.settings.product') }}">Products</a>
            <a class="nav-link {{ request()->routeIs('admin.settings.tag') ? 'active' : '' }}" href="{{ route('admin.settings.tag') }}">Tags</a>
            <a class="nav-link {{ request()->routeIs('admin.settings.territory') ? 'active' : '' }}" href="{{ route('admin.settings.territory') }}">Territories</a>

            <!-- <div class="mt-4 mb-2">
                <small class="text-uppercase" style="font-size: 14px">Connections</small>
            </div>
            <a class="nav-link" href="#">API keys</a>
            <a class="nav-link" href="#">Mobile devices</a> -->
            
            <div id="nothing-found" style="display:none; color: rgba(255,255,255,0.6); padding: 10px 0;">Nothing found.</div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchBox = document.querySelector('.search-box');
        const settingsList = document.querySelectorAll('#settings-tools-list a');
        const nothingFound = document.getElementById('nothing-found');

        if (searchBox) {
            searchBox.addEventListener('input', function() {
                const query = this.value.toLowerCase();
                let visibleCount = 0;

                settingsList.forEach(function(link) {
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
@endpush
