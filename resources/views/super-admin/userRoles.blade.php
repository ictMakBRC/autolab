<x-app-layout>
    <!-- start page title -->
    {{-- <x-page-title>
        Roles
    </x-page-title> --}}

    <!-- end row-->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <div class="text-sm-end mt-3">
                                <h4 class="header-title mb-3  text-center">User Roles</h4>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="text-sm-end mt-3">
                                <a type="button" href="#" class="btn btn-info mb-2 me-1"
                                    data-bs-toggle="modal" data-bs-target="#addRole">Create Role</a>
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
                                    <th class="th">Display Name</th>
                                    <th class="th">Name</th>
                                    <th class="th"># Permissions</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $key => $role)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $role->display_name }}</td>
                                        <td> {{ $role->name }}</td>
                                        <td>{{ $role->permissions_count }}</td>
                                        <td class="table-action d-flex">
                                            @if (\Laratrust\Helper::roleIsEditable($role))
                                                <a href="{{ route('user-roles.edit', $role->id) }}" class="action-icon">
                                                    <i class="mdi mdi-pencil">edit</i></a>
                                            @else
                                                <a href="{{ route('user-roles.show', $role->id) }}" class="action-icon">
                                                    <i class="mdi mdi-eye">view</i></a>
                                            @endif

                                            <form action="{{ route('user-roles.destroy', $role->id) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                @if (\Laratrust\Helper::roleIsDeletable($role))
                                                    <a href="#" class="action-icon"
                                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                                        <i class="mdi mdi-delete"></i></a>
                                                @else
                                                    {{-- <i class="uil-padlock"></i> --}}
                                                @endif
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> <!-- end preview-->

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <!-- end row-->
    @include('super-admin.createRoleModal')

</x-app-layout>
