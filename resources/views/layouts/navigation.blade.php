<!--start sidebar -->
<aside class="sidebar-wrapper">
    <div class="iconmenu">
        <div class="nav-toggle-box">
            <div class="nav-toggle-icon"><i class="bi bi-list"></i></div>
        </div>
        <ul class="nav nav-pills flex-column">
            <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Dashboard">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-dashboards"
                    type="button"><i class="bi bi-house-door-fill"></i></button>
            </li>
            <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Patient Management">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-patients" type="button"><i
                        class="bi bi-person-workspace"></i></button>
            </li>
            <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Sample Management">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-samples" type="button"><i
                        class="bi bi-prescription"></i><i class='bx bxs-vial'></i></button>
            </li>
            <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Sample Referral">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-referrals"
                    type="button"><i class="bi bi-airplane-fill"></i></button>
            </li>
            <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Sample Storage">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-storage" type="button"><i
                        class="bi bi-archive-fill"></i></button>
            </li>
            <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Test management">
                <button class="nav-link {{ request()->is('Admin/test*') ? 'active' : '' }}" data-bs-toggle="pill"
                    data-bs-target="#pills-tests" type="button">
                    <i class='bx bxs-flask'></i></button>
            </li>
            <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Logistic Management">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-logistics"
                    type="button"><i class="bi bi-bar-chart-line-fill"></i></button>
            </li>

            <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Trainings">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-trainings"
                    type="button"><i class="bi bi-easel2-fill"></i></button>
            </li>
            <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Documents/Resources">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-resources"
                    type="button"><i class="bi bi-file-earmark-medical-fill"></i></button>
            </li>
            <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Engagements">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-engagements"
                    type="button"><i class="bi bi-file-earmark-easel-fill"></i></button>
            </li>
            <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Help Desk">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-helpdesk"
                    type="button"><i class="bi bi-question-square-fill"></i></button>
            </li>
            <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right"
                title="General Management">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-management"
                    type="button"><i class="bi bi-file-earmark-spreadsheet-fill"></i></button>
            </li>

        </ul>
    </div>
    <div class="textmenu">
        <div class="brand-logo">
            <img src="{{ asset('autolab-assets/images/brand-logo-2.png') }}" width="140" alt="" />
        </div>
        <div class="tab-content">
            <div class="tab-pane fade" id="pills-dashboards">
                <div class="list-group list-group-flush">
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-0">HOME</h5>
                        </div>
                    </div>
                    <a href="{{ route('super.dashboard') }}" class="list-group-item"><i
                            class="bi bi-house-door-fill"></i>Dashboard</a>
                    <a href="{{ route('facilityInformation.index') }}" class="list-group-item"><i
                            class="bi bi-cast"></i>Facility Profile</a>
                    <a href="{{ route('usermanagement') }}" class="list-group-item"><i
                            class="bi bi-wallet"></i>User Management</a>
                    <a href="{{ route('user-roles.index') }}" class="list-group-item"><i
                            class="bi bi-bar-chart-line"></i>User Roles</a>
                    <a href="{{ route('user-permissions.index') }}" class="list-group-item"><i
                            class="bi bi-archive"></i>User Permissions</a>
                    <a href="{{ route('user-roles-assignment.index') }}" class="list-group-item"><i
                            class="bi bi-cast"></i>Role Assiginment</a>
                    <a href="{{ route('logs') }}" class="list-group-item"><i class="bi bi-cast"></i>User
                        Logs</a>
                    <a href="#" class="list-group-item"><i class="bi bi-cast"></i>User Activity</a>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-patients">
                <div class="list-group list-group-flush">
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-0">PATIENTS</h5>
                        </div>
                    </div>
                    <a href="#" class="list-group-item"><i class="bi bi-house-door-fill"></i>Create
                        New</a>
                    <a href="#" class="list-group-item"><i class="bi bi-cast"></i>Today</a>
                    <a href="#" class="list-group-item"><i class="bi bi-wallet"></i>This Week</a>
                    <a href="#" class="list-group-item"><i class="bi bi-bar-chart-line"></i>This
                        Month</a>
                    <a href="#" class="list-group-item"><i class="bi bi-archive"></i>This Year</a>
                    <a href="#" class="list-group-item"><i class="bi bi-cast"></i>All Patients</a>
                </div>
            </div>

            <div class="tab-pane fade {{ request()->segment(2) == 'batch' ? 'active show' : '' }}" id="pills-samples">
                <div class="list-group list-group-flush">
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-0">SAMPLES</h5>
                        </div>
                    </div>
                    <a href="{{ route('samplereception') }}" class="list-group-item"><i
                            class="bi bi-house-door-fill"></i>Sample Reception</a>
                    <a href="#" class="list-group-item {{ Request::routeIs('specimen-request') ? 'active' : '' }}"><i class="bi bi-cast"></i>Specimen Request</a>
                    <a href="{{route('test-request')}}" class="list-group-item"><i class="bi bi-wallet"></i>Test Requests</a>
                    <a href="#" class="list-group-item"><i class="bi bi-bar-chart-line"></i>This
                        Month</a>
                    <a href="#" class="list-group-item"><i class="bi bi-archive"></i>This Year</a>
                    <a href="#" class="list-group-item"><i class="bi bi-cast"></i>All Patients</a>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-referrals">
                <div class="list-group list-group-flush">
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-0">REFERRAL</h5>
                        </div>
                    </div>
                    <a href="#" class="list-group-item"><i
                            class="bi bi-house-door-fill"></i>Outgoing</a>
                    <a href="#" class="list-group-item"><i
                            class="bi bi-house-door-fill"></i>Incoming</a>
                    <a href="#" class="list-group-item"><i class="bi bi-cast"></i>Sequence Data</a>
                    <a href="#" class="list-group-item"><i class="bi bi-wallet"></i>Track Sample</a>
                    <a href="#" class="list-group-item"><i class="bi bi-bar-chart-line"></i>Equipment
                        Profiling</a>
                    <a href="#" class="list-group-item"><i class="bi bi-archive"></i>Reports</a>

                </div>
            </div>
            <div class="tab-pane fade" id="pills-storage">
                <div class="list-group list-group-flush">
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-0">STORAGE</h5>
                        </div>
                    </div>
                    <a href="#" class="list-group-item"><i class="bi bi-house-door-fill"></i>Search
                        Sample</a>
                    <a href="#" class="list-group-item"><i class="bi bi-house-door-fill"></i>Store
                        New</a>
                    <a href="#" class="list-group-item"><i class="bi bi-cast"></i>Today</a>
                    <a href="#" class="list-group-item"><i class="bi bi-wallet"></i>This Week</a>
                    <a href="#" class="list-group-item"><i class="bi bi-bar-chart-line"></i>This
                        Month</a>
                    <a href="#" class="list-group-item"><i class="bi bi-archive"></i>This Year</a>
                    <a href="#" class="list-group-item"><i class="bi bi-cast"></i>All stored</a>
                </div>
            </div>
            <div class="tab-pane fade {{ request()->segment(2) == 'test' ? 'active show' : '' }}"
                id="pills-tests">
                <div class="list-group list-group-flush">
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-0">TEST MGT</h5>
                        </div>
                    </div>
                    <a href="{{ route('categories') }}" class="list-group-item"><i
                            class="bi bi-house-door-fill"></i>Test Categories</a>
                    <a href="{{ route('sampletypes') }}" class="list-group-item"><i
                            class="bi bi-house-door-fill"></i>Sample Types</a>
                    <a href="{{ route('tests.index') }}"
                        class="list-group-item {{ Request::routeIs('editTest') ? 'active' : '' }}"><i
                            class="bi bi-house-door-fill"></i>Test Types</a>
                    <a href="{{ route('tests.create') }}" class="list-group-item"><i
                            class="bi bi-cast"></i>New Test Type</a>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-logistics">
                <div class="list-group list-group-flush">
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-0">LOGISTICS</h5>
                        </div>
                    </div>
                    <a href="#" class="list-group-item"><i
                            class="bi bi-house-door-fill"></i>Inventory</a>
                    <a href="#" class="list-group-item"><i
                            class="bi bi-house-door-fill"></i>Suppliers</a>
                    <a href="#" class="list-group-item"><i class="bi bi-cast"></i>Couriers</a>
                    <a href="#" class="list-group-item"><i class="bi bi-wallet"></i>Dry Ice Sources</a>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-management">
                <div class="list-group list-group-flush">
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-0">MANAGE</h5>
                        </div>
                    </div>
                    <a href="{{ route('laboratories') }}" class="list-group-item"><i
                            class="bi bi-house-door-fill"></i>Laboratories</a>
                    <a href="{{ route('designations') }}" class="list-group-item"><i
                            class="bi bi-house-door-fill"></i>Designations</a>
                    <a href="{{ route('facilities') }}" class="list-group-item"><i
                            class="bi bi-house-door-fill"></i>Facilities</a>
                    <a href="{{ route('studies') }}" class="list-group-item"><i
                            class="bi bi-house-door-fill"></i>Studies/Projects</a>
                    <a href="{{ route('requesters') }}" class="list-group-item"><i
                            class="bi bi-house-door-fill"></i>Requesters</a>
                    <a href="{{ route('collectors') }}" class="list-group-item"><i
                            class="bi bi-house-door-fill"></i>Sample Collectors</a>
                    <a href="{{ route('couriers') }}" class="list-group-item"><i
                            class="bi bi-house-door-fill"></i>Couriers</a>
                    <a href="{{ route('platforms') }}" class="list-group-item"><i
                            class="bi bi-house-door-fill"></i>Platforms</a>
                    <a href="{{ route('kits') }}" class="list-group-item"><i
                            class="bi bi-house-door-fill"></i>Kits</a>

                </div>
            </div>
            <div class="tab-pane fade" id="pills-resources">
                <div class="list-group list-group-flush">
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-0">RESOURCES</h5>
                        </div>
                    </div>
                    <a href="#" class="list-group-item"><i class="bi bi-house-door-fill"></i>General
                        Documents</a>
                    <a href="#" class="list-group-item"><i class="bi bi-house-door-fill"></i>Shipment
                        Documents</a>
                </div>
            </div>

            <div class="tab-pane fade" id="pills-trainings">
                <div class="list-group list-group-flush">
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-0">TRAININGS</h5>
                        </div>
                    </div>
                    <a href="#" class="list-group-item"><i
                            class="bi bi-house-door-fill"></i>Trainers</a>
                    <a href="#" class="list-group-item"><i
                            class="bi bi-house-door-fill"></i>Trainees</a>
                    <a href="#" class="list-group-item"><i class="bi bi-house-door-fill"></i>Training
                        Materials</a>
                </div>
            </div>

            <div class="tab-pane fade" id="pills-engagements">
                <div class="list-group list-group-flush">
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-0">ENGAGEMENTS</h5>
                        </div>
                    </div>
                    <a href="#" class="list-group-item"><i class="bi bi-house-door-fill"></i>Minutes</a>
                    <a href="#" class="list-group-item"><i class="bi bi-house-door-fill"></i>Other</a>
                    <a href="#" class="list-group-item"><i class="bi bi-house-door-fill"></i>Reports</a>
                </div>
            </div>

            <div class="tab-pane fade" id="pills-helpdesk">
                <div class="list-group list-group-flush">
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-0">HELP DESK</h5>
                        </div>
                    </div>
                    <a href="#" class="list-group-item"><i class="bi bi-house-door-fill"></i>Tickets</a>
                    <a href="#" class="list-group-item"><i class="bi bi-house-door-fill"></i>Resolved
                        Issues</a>
                    <a href="#" class="list-group-item"><i class="bi bi-house-door-fill"></i>Reports</a>
                </div>
            </div>

            <div class="tab-pane fade" id="pills-helpdesk">
                <div class="list-group list-group-flush">
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-0">HELP DESK</h5>
                        </div>
                    </div>
                    <a href="#" class="list-group-item"><i class="bi bi-house-door-fill"></i>Tickets</a>
                    <a href="#" class="list-group-item"><i class="bi bi-house-door-fill"></i>Resolved
                        Issues</a>
                    <a href="#" class="list-group-item"><i class="bi bi-house-door-fill"></i>Reports</a>
                </div>
            </div>

        </div>
    </div>
</aside>
<!--end start sidebar -->
