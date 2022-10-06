<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header pt-0">
                <div class="row mb-2">
                    <div class="col-sm-4">
                        <div class="text-sm-end mt-3">
                            <h4 class="header-title mb-3  text-center">Platforms</h4>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="text-sm-end mt-3">
                            <a type="button" href="#" class="btn btn-success mb-2 me-1" data-bs-toggle="modal"
                                data-bs-target="#addPlatform">Add Platform</a>
                        </div>
                    </div><!-- end col-->
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="table-responsive">
                        <table id="datableButton" class="table table-striped mb-0 w-100 ">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Platform</th>
                                    <th>Range</th>
                                    <th>Status</th>
                                    <th>Date created</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($platforms as $key => $platform)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $platform->name }}</td>
                                        <td>{{ $platform->range }}</td>
                                        @if ($platform->is_active == 0)
                                            <td><span class="badge bg-danger">Inactive</span></td>
                                        @else
                                            <td><span class="badge bg-success">Active</span></td>
                                        @endif
                                        <td>{{ date('d-m-Y', strtotime($platform->created_at)) }}</td>
                                        <td class="table-action">
                                            <a href="javascript: void(0);" class="action-ico"> <i
                                                    class="bi bi-pencil-square" data-bs-toggle="modal"
                                                    wire:click="editdata({{ $platform->id }})"
                                                    data-bs-target="#editplatform"></i></a>
                                            <a href="javascript: void(0);"
                                                wire:click="deleteConfirmation({{ $platform->id }})" class="action-ico">
                                                <i class="bi bi-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> <!-- end preview-->
                </div> <!-- end tab-content-->
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->

    {{-- ADD FACILITY --}}
    <div wire:ignore.self class="modal fade" id="addPlatform" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Add New Platform</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div> <!-- end modal header -->
                <div class="modal-body">
                    <form wire:submit.prevent="storeData">
                        {{-- @csrf --}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="platformName" class="form-label">Platform</label>
                                    <input type="text" id="platformName" class="form-control" name="name"
                                        wire:model="name">
                                    @error('name')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="platformRange" class="form-label">Range</label>
                                    <input type="text" id="platformRange" class="form-control"
                                        wire:model="range">
                                    @error('range')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="isActive" class="form-label">Status</label>
                                    <select class="form-select" id="isActive" name="is_active" wire:model="is_active">
                                        <option selected value="">Select</option>
                                        <option value='1'>Active</option>
                                        <option value='0'>Inactive</option>
                                    </select>
                                    @error('is_active')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row-->
                        <div class="d-grid mb-0 text-center">
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </form>
                </div>
            </div> <!-- end modal content-->
        </div> <!-- end modal dialog-->
    </div> <!-- end modal-->

    {{-- //DELETE CONFIRMATION MODAL --}}
    <div wire:ignore.self class="modal fade" id="delete_modal" tabindex="-1" data-backdrop="static"
        data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Platform</h5>
                    <button type="button" class="btn-close" wire:click="cancel()" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body pt-4 pb-4">
                    <h6>Are you sure you want to delete this Record?</h6>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-primary" wire:click="cancel()" data-bs-dismiss="modal"
                        aria-label="Close">Cancel</button>
                    <button class="btn btn-sm btn-danger" wire:click="deleteData()">Yes! Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- EDIT platform Modal -->
    <div wire:ignore.self class="modal fade" id="editplatform" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Update Platform</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true" wire:click="close()"></button>
                </div> <!-- end modal header -->
                <div class="modal-body">
                    <form wire:submit.prevent="updateData">
                              <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="platformName2" class="form-label">Platform</label>
                                    <input type="text" id="platformName2" class="form-control" name="name"
                                        wire:model="name">
                                    @error('name')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="platformRange2" class="form-label">Range</label>
                                    <input type="text" id="platformRange2" class="form-control"
                                        wire:model="range">
                                    @error('range')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="isActive2" class="form-label">Status</label>
                                    <select class="form-select" id="isActive2" name="is_active" wire:model="is_active">
                                        <option selected value="">Select</option>
                                        <option value='1'>Active</option>
                                        <option value='0'>Inactive</option>
                                    </select>
                                    @error('is_active')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row-->
                        <div class="modal-footer">
                            <x-button>{{ __('Update') }}</x-button>
                            <x-button type="button" class="btn btn-danger" wire:click="close()"
                                data-bs-dismiss="modal">{{ __('Close') }}</x-button>
                        </div>
                    </form>
                </div>
            </div> <!-- end modal content-->
        </div> <!-- end modal dialog-->
    </div> <!-- end modal-->

    @push('scripts')
        <script>
            window.addEventListener('close-modal', event => {
                $('#addPlatform').modal('hide');
                $('#editplatform').modal('hide');
                $('#delete_modal').modal('hide');
                $('#show-delete-confirmation-modal').modal('hide');
            });

            window.addEventListener('edit-modal', event => {
                $('#editplatform').modal('show');
            });
            window.addEventListener('delete-modal', event => {
                $('#delete_modal').modal('show');
            });
        </script>
    @endpush
</div>
