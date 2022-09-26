       <!--start sidebar -->
       <aside class="sidebar-wrapper">
        <div class="iconmenu"> 
          <div class="nav-toggle-box">
            <div class="nav-toggle-icon"><i class="bi bi-list"></i></div>
          </div>
          <ul class="nav nav-pills flex-column">
            <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Dashboard">
              <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-dashboards" type="button"><i class="bi bi-house-door-fill"></i></button>
            </li>
          </ul>
        </div>
        <div class="textmenu">
          <div class="brand-logo">
            <img src="{{ asset('autolab-assets/images/brand-logo-2.png')}}" width="140" alt=""/>
          </div>
          <div class="tab-content">
            <div class="tab-pane fade" id="pills-dashboards">
              <div class="list-group list-group-flush">
                <div class="list-group-item">
                  <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-0">HOME</h5>
                  </div>
                  {{-- <small class="mb-0">Some placeholder content</small> --}}
                </div>
                <a href="{{route('super.dashboard')}}" class="list-group-item"><i class="bi bi-house-door-fill"></i>Dashboard</a>
                <a href="{{ route('facilityInformation.index') }}" class="list-group-item"><i class="bi bi-cast"></i>Facility Profile</a>
                <a href="{{ route('users.index') }}" class="list-group-item"><i class="bi bi-wallet"></i>User Management</a>
                <a href="{{ route('user-roles.index') }}" class="list-group-item"><i class="bi bi-bar-chart-line"></i>User Roles</a>
                <a href="{{ route('user-permissions.index') }}" class="list-group-item"><i class="bi bi-archive"></i>User Permissions</a>
                <a href="{{ route('user-roles-assignment.index') }}" class="list-group-item"><i class="bi bi-cast"></i>Role Assiginment</a>
                <a href="{{ route('logs') }}" class="list-group-item"><i class="bi bi-cast"></i>User Logs</a>
                <a href="#" class="list-group-item"><i class="bi bi-cast"></i>User Activity</a>
              </div>
            </div>

          </div>
        </div>
     </aside>
     <!--end start sidebar -->