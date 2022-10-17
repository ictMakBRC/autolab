ia<x-app-layout>
    <!-- start page title -->
    {{-- <x-page-title>
        Roles Assignment
    </x-page-title> --}}

    <!-- end row-->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <div class="text-sm-end mt-3">
                                <h4 class="header-title mb-3  text-center">Roles Assignment</h4>
                            </div>
                        </div>
                        <div class="col-sm-8">
                        </div><!-- end col-->
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datableButtons" class="table w-100 nowrap">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th class="th">Name</th>
                                    <th class="th">Roles</th>
                                    <th class="th">Permissions</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $key => $user)
                                    <tr>
                                        <td>
                                            {{ $key + 1 }}
                                        </td>
                                        <td>
                                            {{ $user->name ?? 'The model doesn\'t have a `name` attribute' }}
                                        </td>
                                        <td>
                                            {{ $user->roles_count }}
                                        </td>
                                        @if (config('laratrust.panel.assign_permissions_to_user'))
                                            <td>
                                                {{ $user->permissions_count }}
                                            </td>
                                        @endif
                                        <td>
                                            <a href="{{ route('user-roles-assignment.edit', $user->id) }}"
                                                class="action-icon"> <i class="mdi mdi-pencil">Assign</i></a>
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
</x-app-layout>
