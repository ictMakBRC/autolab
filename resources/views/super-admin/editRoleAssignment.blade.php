<x-app-layout>
    <!-- start page title -->
    {{-- <x-page-title>
        Edit Roles Assignment
    </x-page-title> --}}

    <!-- end row-->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <div class="text-sm-end mt-3">
                                <h4 class="header-title mb-3  text-center">Edit Roles Assignment</h4>
                            </div>
                        </div>
                        <div class="col-sm-8">
                        </div><!-- end col-->
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{route('user-roles-assignment.update',$user->id)}}">
                        @csrf
                            @method('PUT')

                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" id="name" class="form-control" name="name" value="{{ $user->name}}"
                                 required readonly>
                            </div>
                        </div>
                        @if(!$roles->isEmpty())
                        <div class="row mb-3">
                            <h3 class="text-success">Roles</h3>
                            @foreach ($roles as $role)
                            <div class="mb-3 col-md-2">
                               <div class="form-check form-check-inline">
                                   <input class="form-check-input" type="checkbox" id="role{{ $role->id }}"
                                       name="roles[]" value="{{ $role->id }}" {!! $role->assigned ? 'checked' : '' !!}
                                       {!! $role->assigned && !$role->isRemovable ? 'onclick="return false;"' : '' !!}>
                                   <label class="form-check-label"
                                       for="role{{ $role->id }}">{{$role->display_name ?? $role->name}}</label>
                               </div>
                            </div>
                                
                            @endforeach

                        </div>
                        @endif
                        @if(!$permissions->isEmpty())
                        <div class="row">
                            <h3 class="text-success">Permissions</h3>
                            @foreach ($permissions as $permission)
                            <div class="mb-3 col-md-2">
                               <div class="form-check form-check-inline">
                                   <input class="form-check-input" type="checkbox" id="permission{{ $permission->id }}"
                                       name="permissions[]" value="{{ $permission->id }}" {!! $permission->assigned ? 'checked' : '' !!}>
                                   <label class="form-check-label"
                                       for="permission{{ $permission->id }}">{{$permission->display_name ?? $permission->name}}</label>
                               </div>
                            </div>
                                
                            @endforeach

                        </div>
                        @endif
                        <!-- end row-->
                        <div class="row">
                            <div class="col-md-8">

                            </div>
                            <div class="col-md-4 text-end">
                                    <button class="btn btn-success" type="submit">Save</button>
                            </div>
                        </div>
                        
                    </form>


                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <!-- end row-->
</x-app-layout>
