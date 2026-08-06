 <!-- Sidebar -->
 <div class="col-md-2">
     <div class="sidebar">
         <div class="">
             <a class="nav-link {{ request()->routeIs('admin.lead.index') ? 'active' : '' }}"
                 href="{{ route('admin.lead.index') }}">
                 All leads
                 <span class="badge bg-light text-dark">{{ $totalLeads }}</span>
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
         <div class="mt-4">
             <h6 class="text-uppercase text-light mb-2">SHARED
                 LISTS ⚙️</h6>

             <div id="shared-lists">

                 @can('lead.list.my.view')
                     <a class="nav-link lead-filter {{ request()->routeIs('admin.lead.my_leads') ? 'active' : '' }}"
                         href="{{ route('admin.lead.my_leads', auth()->id()) }}">
                         My leads
                         <span class="badge bg-light text-dark">{{ $myLeadsCount }}</span>
                     </a>
                 @endcan

                 @can('lead.list.all.view')
                     <a class="nav-link lead-filter {{ request()->routeIs('admin.lead.assigned_leads') ? 'active' : '' }}"
                         href="{{ route('admin.lead.assigned_leads', auth()->id()) }}">
                         Assigned leads
                         <span class="badge bg-light text-dark">{{ $assignedLeadsCount }}</span>
                     </a>
                 @endcan

                 @can('lead.list.added_this_week.view')
                     <a class="nav-link lead-filter {{ request()->routeIs('admin.lead.added_this_week') ? 'active' : '' }}"
                         href="{{ route('admin.lead.added_this_week') }}">
                         Added this week
                         <span class="badge bg-light text-dark">{{ $addedThisWeekCount }}</span>
                     </a>
                 @endcan

                 @can('lead.list.closing_this_week.view')
                     <a class="nav-link lead-filter {{ request()->routeIs('admin.lead.closing_this_week') ? 'active' : '' }}"
                         href="{{ route('admin.lead.closing_this_week') }}">
                         Closing this week
                         <span class="badge bg-light text-dark">{{ $closingThisWeekCount }}</span>
                     </a>
                 @endcan


                 @can('lead.list.watching.view')
                     <a class="nav-link lead-filter {{ request()->routeIs('admin.lead.watching_leads') ? 'active' : '' }}"
                         href="{{ route('admin.lead.watching_leads', auth()->id()) }}">
                         Leads I’m watching
                         <span class="badge bg-light text-dark">{{ $myWatchingLeadsCount }}</span>
                     </a>
                 @endcan

                 @can('lead.list.open.view')
                     <a class="nav-link lead-filter {{ request()->routeIs('admin.lead.open_leads') ? 'active' : '' }}"
                         href="{{ route('admin.lead.open_leads', auth()->id()) }}">
                         My open leads
                         <span class="badge bg-light text-dark">{{ $myLeadOpenStatusCount }}</span>
                     </a>
                 @endcan

                 @can('lead.list.hot.view')
                     <a class="nav-link lead-filter {{ request()->routeIs('admin.lead.hot_leads') ? 'active' : '' }}"
                         href="{{ route('admin.lead.hot_leads') }}">
                         Hot leads
                         <span class="badge bg-light text-dark">{{ $hotLeadsCount }}</span>
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
