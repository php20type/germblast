 <!-- Sidebar -->
 <div class="col-md-2">
     <div class="sidebar">
         <div class="settings-dropdown">
             <div class="p-3">
                 <div class="d-flex align-items-center text-white">
                     <i class="fas fa-cog me-2"></i>
                     <span>ICIMatrix</span>
                 </div>
             </div>
         </div>
         <hr class="text-white-50 mx-3">
         <nav class="nav flex-column">
             <a class="nav-link nav-dropdown" href="#" onclick="toggleDropdown('sales')">
                 <i class="fas fa-shield-alt"></i> Sales
                 <i class="fas fa-chevron-down ms-auto chevron-icon" id="salesChevron"></i>
             </a>

             <div class="nav-dropdown-content show" id="salesContent">
                 <a class="nav-link" href="#">Contract Exception Report</a>
                 <a class="nav-link" href="#">Equipement Loan</a>
                 <a class="nav-link" href="#">Leads</a>
                 <a class="nav-link" href="#">Product List</a>
                 <a class="nav-link" href="#">Purchasing Coop</a>
                 <a class="nav-link" href="#">Reference Lists</a>
                 <a class="nav-link" href="#">Sales Dashboard</a>
                 <a class="nav-link" href="#">Video Library</a>
             </div>

             <a class="nav-link nav-dropdown" href="#" onclick="toggleDropdown('operations')">
                 <i class="fas fa-chart-line"></i> Operations
                 <i class="fas fa-chevron-down ms-auto chevron-icon" id="operationsChevron"></i>
             </a>
             <div class="nav-dropdown-content" id="operationsContent">
                 <a class="nav-link" href="#">Action Plan Overview</a>
                 <a class="nav-link" href="#">All Schedules</a>
                 <a class="nav-link" href="#">Driver Report</a>
                 <a class="nav-link" href="#">Employees Performance</a>
                 <a class="nav-link" href="#">Equipment Manager</a>
                 <a class="nav-link" href="#">Scheduling Calendar</a>
                 <a class="nav-link" href="#">SIT Program</a>
                 <a class="nav-link" href="#">SIT Progress</a>
                 <a class="nav-link" href="#">SIT Training</a>
                 <a class="nav-link" href="#">Training Report</a>
                 <a class="nav-link" href="#">Vehicle Planning</a>
                 <a class="nav-link" href="#">Warehouse</a>
                 <a class="nav-link" href="#">Warehouse Calendar</a>
             </div>

             <a class="nav-link nav-dropdown" href="#" onclick="toggleDropdown('humanResources')">
                 <i class="fas fa-database"></i> Human Resources
                 <i class="fas fa-chevron-down ms-auto chevron-icon" id="humanResourcesChevron"></i>
             </a>
             <div class="nav-dropdown-content" id="humanResourcesContent">
                 <a class="nav-link" href="#">Anonymous Feedback</a>
                 <a class="nav-link" href="#">Employee List</a>
                 <a class="nav-link" href="#">Hourly Rate Report</a>
             </div>

             {{-- <a class="nav-link nav-dropdown" href="#" onclick="toggleDropdown('organization')">
                 <i class="fas fa-building"></i> Organization
                 <i class="fas fa-chevron-down ms-auto chevron-icon" id="organizationChevron"></i>
             </a>
             <div class="nav-dropdown-content show" id="organizationContent">
                 <a class="nav-link {{ request()->routeIs('admin.settings.activity_type') ? 'active' : '' }}"
                     href="{{ route('admin.settings.activity_type') }}">Activity types </a>
                 <a class="nav-link {{ request()->routeIs('admin.settings.channel_source') ? 'active' : '' }}"
                     href="{{ route('admin.settings.channel_source') }}"> Channels &
                     sources</a>
                 <a class="nav-link {{ request()->routeIs('admin.settings.company_type') ? 'active' : '' }}"
                     href="{{ route('admin.settings.company_type') }}"> Company
                     types</a>
                 <a class="nav-link {{ request()->routeIs('admin.settings.competitor') ? 'active' : '' }}"
                     href="{{ route('admin.settings.competitor') }}"> Competitors</a>
                 <a class="nav-link {{ request()->routeIs('admin.settings.industry') ? 'active' : '' }}"
                     href="{{ route('admin.settings.industry') }}"> Industries</a>
                 <a class="nav-link {{ request()->routeIs('admin.settings.market') ? 'active' : '' }}"
                     href="{{ route('admin.settings.market') }}"> Markets</a>
                 <a class="nav-link {{ request()->routeIs('admin.settings.product') ? 'active' : '' }}"
                     href="{{ route('admin.settings.product') }}"> Products</a>
                 <a class="nav-link {{ request()->routeIs('admin.settings.tag') ? 'active' : '' }}"
                     href="{{ route('admin.settings.tag') }}"> Tags</a>
                 <a class="nav-link {{ request()->routeIs('admin.settings.territory') ? 'active' : '' }}"
                     href="{{ route('admin.settings.territory') }}"> Territories</a>
             </div> --}}
         </nav>
     </div>
 </div>
