 <!-- Sidebar -->
 <div class="col-md-2">
     <div class="sidebar">
         <div class="settings-dropdown">
             <div class="p-3">
                 <div class="d-flex align-items-center text-white" onclick="toggleSettings()">
                     <i class="fas fa-cog me-2"></i>
                     <span>Your settings</span>
                     <i class="fas fa-chevron-down ms-auto chevron-icon" id="settingsChevron"></i>
                 </div>
             </div>
             <div class="settings-content" id="settingsContent">
                 <nav class="nav flex-column">
                     <a class="nav-link active" href="#"> Profile</a>
                     <a class="nav-link" href="#"> Phone</a>
                     <a class="nav-link" href="#"> Calendar</a>
                     <a class="nav-link" href="#"> Notifications</a>
                     <a class="nav-link" href="#"> Tasks</a>
                     <a class="nav-link" href="#"> Email send</a>
                     <a class="nav-link" href="#"> Sync email</a>
                 </nav>
             </div>
         </div>
         <hr class="text-white-50 mx-3">
         <nav class="nav flex-column">
             <a class="nav-link nav-dropdown" href="#" onclick="toggleDropdown('administration')">
                 <i class="fas fa-shield-alt"></i> Administration
                 <i class="fas fa-chevron-down ms-auto chevron-icon" id="administrationChevron"></i>
             </a>

             <div class="nav-dropdown-content" id="administrationContent">
                 <a class="nav-link" href="#"> General</a>
                 <a class="nav-link" href="#"> AI features</a>
                 <a class="nav-link" href="#"> Security</a>
                 <a class="nav-link" href="#"> Billing</a>
                 <a class="nav-link" href="#"> Users & teams</a>
                 <a class="nav-link" href="#"> Email security</a>
                 <a class="nav-link" href="#"> Audit log</a>
             </div>

             <a class="nav-link nav-dropdown" href="#" onclick="toggleDropdown('sales')">
                 <i class="fas fa-chart-line"></i> Sales process
                 <i class="fas fa-chevron-down ms-auto chevron-icon" id="salesChevron"></i>
             </a>
             <div class="nav-dropdown-content" id="salesContent">
                 <a class="nav-link" href="#"> Pipelines & stages</a>
                 <a class="nav-link" href="#"> Processes</a>
                 <a class="nav-link" href="#"> Triggers</a>
                 <a class="nav-link" href="#"> Delays</a>
                 <a class="nav-link" href="#"> User assignment</a>
             </div>

             <a class="nav-link nav-dropdown" href="#" onclick="toggleDropdown('data')">
                 <i class="fas fa-database"></i> Data
                 <i class="fas fa-chevron-down ms-auto chevron-icon" id="dataChevron"></i>
             </a>
             <div class="nav-dropdown-content" id="dataContent">
                 <a class="nav-link" href="#"> Import</a>
                 <a class="nav-link" href="#"> Export</a>
                 <a class="nav-link" href="#"> Integrations</a>
                 <a class="nav-link" href="#"> PeopleIQ</a>
                 <a class="nav-link" href="#"> Trash</a>
                 <a class="nav-link" href="#"> SQL access</a>
             </div>

             <a class="nav-link nav-dropdown" href="#" onclick="toggleDropdown('organization')">
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
                 {{-- <a class="nav-link"
                     href="#"> Custom
                     fields</a> --}}
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
             </div>

             <a class="nav-link nav-dropdown" href="#" onclick="toggleDropdown('connections')">
                 <i class="fas fa-plug"></i> Connections
                 <i class="fas fa-chevron-down ms-auto chevron-icon" id="connectionsChevron"></i>
             </a>
             <div class="nav-dropdown-content" id="connectionsContent">
                 <a class="nav-link" href="#"> API keys</a>
                 <a class="nav-link" href="#"> Mobile devices</a>
             </div>
         </nav>
     </div>
 </div>
