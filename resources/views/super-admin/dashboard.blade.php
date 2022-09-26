<x-app-layout>
    <!-- start page title -->
    {{-- <x-page-title>
        Dashboard
    </x-page-title> --}}
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card widget-inline">
                <div class="card-body p-0">
                    <div class="row g-0">
                        {{-- <div class="col-sm-6 col-xl-3">
                            <div class="card shadow-none m-0">
                                <div class="card-body text-center">
                                    <i class="dripicons-user-group text-muted" style="font-size: 24px;"></i>
                                    <h3><span>{{ $users->count() }}</span></h3>
                                    <p class="text-muted font-15 mb-0">Users</p>
                                </div>
                            </div>
                        </div> --}}

                        {{-- <div class="col-sm-6 col-xl-3">
                            <div class="card shadow-none m-0 border-start">
                                <div class="card-body text-center">
                                    <i class=" uil-table text-muted" style="font-size: 24px;"></i>
                                    <h3><span>{{ $deptCount }}</span></h3>
                                    <p class="text-muted font-15 mb-0">Departments</p>
                                </div>
                            </div>
                        </div> --}}

                        {{-- <div class="col-sm-6 col-xl-3">
                            <div class="card shadow-none m-0 border-start">
                                <div class="card-body text-center">
                                    <i class="uil-apps text-muted" style="font-size: 24px;"></i>

                                    <h3><span>{{ $stationCount }}</span></h3>
                                    <p class="text-muted font-15 mb-0">Stations</p>

                                </div>
                            </div>
                        </div> --}}

                        {{-- <div class="col-sm-6 col-xl-3">
                            <div class="card shadow-none m-0 border-start">
                                <div class="card-body text-center">
                                    <i class="mdi mdi-list-status text-muted" style="font-size: 24px;"></i>
                                    <h3><span>{{ $logs }}</span></h3>
                                    <p class="text-muted font-15 mb-0">User Logs</p>
                                </div>
                            </div>
                        </div> --}}

                    </div> <!-- end row -->
                </div>
            </div> <!-- end card-box-->
        </div> <!-- end col-->
    </div>
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

    @push('scripts')
        {{-- <script type="text/javascript">
            $(document).ready(function() {
                $('#emp_id').change(function() {
                    if ($('#emp_id').val().length = 9) {
                        // $('#emp_id').prop('readonly',true);
                        var emp_id = $(this).val();
                        var url = "{{ route('employee.get', ':emp_id') }}";
                        url = url.replace(':emp_id', emp_id);

                        $.ajax({
                            url: url,
                            method: "GET",
                            dataType: "json",
                            success: function(response) {
                                if (!jQuery.isEmptyObject(response)) {

                                    let titleElement =
                                        `<option value="${response.prefix}" selected>${response.prefix}</option>`
                                    $('#title').empty();
                                    $('#employee_id').val(response.id);
                                    $('#title').append(titleElement);
                                    $('#name').val(response.surname + ' ' + response.first_name);
                                    $('#email').val(response.email);
                                    $('#contact').val(response.contact);
                                    $('#notFound').hide(1000);
                                    $('#found').show(1000);
                                    $('#submitBtn').prop('disabled', false);
                                    // $('#notFound').prop('disabled',false);
                                }
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                $('#title').empty();
                                $('#employee_id').val("");
                                $('#title').append("");
                                $('#name').val("");
                                $('#email').val("");
                                $('#contact').val("");
                                $('#found').hide(1000);
                                $('#notFound').show(1000);
                                $('#submitBtn').prop('disabled', true);
                                // console.log(xhr.status);
                                // console.log(thrownError);
                            }
                        })
                    } else {
                        alert('oops! Invalid Emp-No Length or Format');
                    }
                });

            });
        </script> --}}
    @endpush
</x-app-layout>
