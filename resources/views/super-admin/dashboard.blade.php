<x-app-layout>
    <!-- start page title -->
    @section('title', 'Dashboard')
    @section('pagename', 'Dashboard')
    @section('linkname', 'Dashboard')
    <!-- end page title -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 row-cols-xxl-4">
           
        <div class="col">
          <div class="card radius-10 border-start border-purple border-3">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">Total Samples</p>
                        <h4 class="my-1">4805</h4>
                        <p class="mb-0 font-13 text-success"><i class="bi bi-caret-up-fill"></i> <br>Registered</p>
                    </div>
                    <div class="widget-icon-large bg-gradient-purple text-white ms-auto"><i class="bi bi-basket2-fill"></i>
                    </div>
                </div>
            </div>
          </div>
         </div>
         <div class="col">
            <div class="card radius-10 border-start border-success border-3">
              <div class="card-body">
                  <div class="d-flex align-items-center">
                      <div>
                          <p class="mb-0 text-secondary">Tested this Week</p>
                          <h4 class="my-1">$24K</h4>
                          <p class="mb-0 font-13 text-success"><i class="bi bi-caret-up-fill"></i> 4.6 from last week</p>
                      </div>
                      <div class="widget-icon-large bg-gradient-success text-white ms-auto"><i class="bi bi-currency-exchange"></i>
                      </div>
                  </div>
              </div>
          </div>
         </div>
         <div class="col">
          <div class="card radius-10 border-start border-danger border-3">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">Tested this Month</p>
                        <h4 class="my-1">5.8K</h4>
                        <p class="mb-0 font-13 text-danger"><i class="bi bi-caret-down-fill"></i> 2.7 from last month</p>
                    </div>
                    <div class="widget-icon-large bg-gradient-danger text-white ms-auto"><i class="bi bi-people-fill"></i>
                    </div>
                </div>
            </div>
         </div>
         </div>
         <div class="col">
          <div class="card radius-10 border-start border-info border-3">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">Tested this Year</p>
                        <h4 class="my-1">38.15%</h4>
                        <p class="mb-0 font-13 text-success"><i class="bi bi-caret-up-fill"></i> 12.2% from last year</p>
                    </div>
                    <div class="widget-icon-large bg-gradient-info text-white ms-auto"><i class="bi bi-bar-chart-line-fill"></i>
                    </div>
                </div>
            </div>
          </div>
         </div>
    </div><!--end row-->

    <!-- end row-->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <div class="text-sm-end mt-3">
                                <h4 class="header-title mb-3  text-center">System Users</h4>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="text-sm-end mt-3">
                                <a type="button" href="#" class="btn btn-success mb-2 me-1"
                                    data-bs-toggle="modal" data-bs-target="#addUser">Add User</a>
                            </div>
                        </div><!-- end col-->
                    </div>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table id="datableButtons" class="table w-100 nowrap">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Title</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Status</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $key => $user)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $user->title }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->contact }}</td>
                                    @if ($user->is_active == 1)
                                        <td><span class="badge bg-success">Active</span></td>
                                    @else
                                        <td><span class="badge bg-danger">Suspended</span></td>
                                    @endif
                                    <td class="table-action">
                                        <a href="#" class="action-icon" data-bs-toggle="modal"
                                            data-bs-target="#viewUser{{ $user->id }}"> <i
                                                class="mdi mdi-eye">view</i></a>
                                        <a href="#" class="action-icon" data-bs-toggle="modal"
                                            data-bs-target="#editUser{{ $user->id }}"> <i
                                                class="mdi mdi-pencil">edit</i></a>
                                       
                                    </td>
                                </tr>
                                @empty
                                    
                                @endforelse
                            </tbody>
                        </table>
                    </div> <!-- end preview-->

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <!-- end row-->
    {{-- @include('super-admin.addUserModal') --}}

</x-app-layout>
