<!-- Sidebar -->
<div class="col-md-2">
    <div class="sidebar">
        <div class="mt-2">
            <h6 class="text-uppercase text-light mb-3">Human Resources 👥</h6>
        </div>
        <div class="my-3">
            <input type="text" class="form-control search-box" placeholder="🔍">
        </div>
        <hr>

        <div id="hr-tools-list">
            @can('employee.view')
                <a class="nav-link {{ request()->routeIs('admin.employee.*') ? 'active' : '' }}" href="{{ route('admin.employee.index') }}">
                    Employee List & Management
                </a>
            @endcan
            
            <a class="nav-link {{ request()->routeIs('admin.hr.timecards.*') ? 'active' : '' }}" href="{{ route('admin.hr.timecards.index') }}">
                Timecards
            </a>

            <a class="nav-link {{ request()->routeIs('admin.service.labor_analysis') ? 'active' : '' }}" href="{{ route('admin.service.labor_analysis') }}">
                Labor Analysis
            </a>


            @can('time_off_request.view')
            <a class="nav-link {{ request()->routeIs('admin.hr.time-off.*') ? 'active' : '' }}" href="{{ route('admin.hr.time-off.index') }}">
                Time Off Request
            </a>
            @endcan

            @can('team_praise.view')
            <a class="nav-link {{ request()->routeIs('admin.hr.praise.*') ? 'active' : '' }}" href="{{ route('admin.hr.praise.index') }}">
                Team Praise
            </a>
            @endcan

            @can('gb_reward.view')
            <a class="nav-link {{ request()->routeIs('admin.hr.rewards.*') ? 'active' : '' }}" href="{{ route('admin.hr.rewards.index') }}">
                GB Rewards
            </a>
            @endcan

            @canany(['anonymous_feedback.add', 'anonymous_feedback.view'])
            <a class="nav-link {{ request()->routeIs('admin.hr.feedback.*') ? 'active' : '' }}" href="{{ route('admin.hr.feedback.create') }}">
                Anonymous Feedback
            </a>
            @endcanany

            <div id="nothing-found" style="display:none; color: rgba(255,255,255,0.6); padding: 10px 0;">Nothing found.</div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchBox = document.querySelector('.search-box');
        const toolsList = document.querySelectorAll('#hr-tools-list a');
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
