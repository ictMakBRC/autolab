<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header pt-0">
                <div class="row mb-2">
                    <div class="col-sm-4">
                        <div class="text-sm-end mt-3">
                            <h4 class="header-title mb-3  text-center">Facilities</h4>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="text-sm-end mt-3">
                            <a type="button" href="#" class="btn btn-success mb-2 me-1" data-bs-toggle="modal"
                                data-bs-target="#addFacility">Add Facility</a>
                        </div>
                    </div><!-- end col-->
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="table-responsive">
                        <table id="datableButtons" class="table table-striped mb-0 w-100 ">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Facility</th>
                                    <th>Type</th>
                                    <th>Parent</th>
                                    <th>Status</th>
                                    <th>Date created</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($facilities as $key => $facility)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $facility->name }}</td>
                                        <td>{{ $facility->type }}</td>
                                        <td>{{ $facility->parent ? $facility->parent->name : 'N/A' }}</td>
                                        @if ($facility->is_active == 0)
                                            <td><span class="badge bg-danger">Inactive</span></td>
                                        @else
                                            <td><span class="badge bg-success">Active</span></td>
                                        @endif
                                        <td>{{ date('d-m-Y', strtotime($facility->created_at)) }}</td>
                                        <td class="table-action">
                                            <a href="javascript: void(0);" class="action-ico"> <i
                                                    class="bi bi-pencil-square" data-bs-toggle="modal"
                                                    wire:click="editdata({{ $facility->id }})"
                                                    data-bs-target="#editfacility"></i></a>
                                            <a href="javascript: void(0);"
                                                wire:click="deleteConfirmation({{ $facility->id }})" class="action-ico">
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
    <div wire:ignore.self class="modal fade" id="addFacility" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Add New Facility</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div> <!-- end modal header -->
                <div class="modal-body">
                    <form wire:submit.prevent="storeData">
                        {{-- @csrf --}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="facilityName" class="form-label">Facility Name</label>
                                    <input type="text" id="facilityName" class="form-control" name="name"
                                        wire:model="name">
                                    @error('name')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="type" class="form-label">Type</label>
                                    <select class="form-select" id="type" wire:model="type">
                                        <option selected value="">Select</option>
                                        <option value='Institution'>Institution</option>
                                        <option value='Health Facility'>Health Facility</option>
                                    </select>
                                    @error('type')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="parent" class="form-label">Parent</label>
                                    <select class="form-select" id="parent" wire:model="parent_id">
                                        <option selected value="">None</option>
                                        @forelse ($facilities as $facility)
                                            <option value='{{ $facility->id }}'>{{ $facility->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    @error('parent_id')
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
                        <div class="modal-footer">
                            <x-button class="btn-success">{{ __('Save') }}</x-button>
                            <x-button type="button" class="btn btn-danger" wire:click="close()"
                                data-bs-dismiss="modal">{{ __('Close') }}</x-button>
                        </div>
                        {{-- <div class="d-grid mb-0 text-center">
                            <button type="submit" class="btn btn-success">Save</button>
                        </div> --}}
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
                    <h5 class="modal-title" id="exampleModalLabel">Delete Facility</h5>
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

    <!-- EDIT facility Modal -->
    <div wire:ignore.self class="modal fade" id="editfacility" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Update Facility</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true" wire:click="close()"></button>
                </div> <!-- end modal header -->
                <div class="modal-body">
                    <form wire:submit.prevent="updateData">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="facilityName2" class="form-label">Facility Name</label>
                                    <input type="text" id="facilityName2" class="form-control" name="name"
                                        wire:model="name">
                                    @error('name')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="type2" class="form-label">Type</label>
                                    <select class="form-select" id="type2" wire:model="type">
                                        <option selected value="">Select</option>
                                        <option value='Institution'>Institution</option>
                                        <option value='Health Facility'>Health Facility</option>
                                    </select>
                                    @error('type')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="parent2" class="form-label">Parent</label>
                                    <select class="form-select" id="parent2" wire:model="parent_id">
                                        @if ($parent_id == '')
                                            <option selected value="">None</option>
                                            @forelse ($facilities as $facility)
                                                <option value='{{ $facility->id }}'>{{ $facility->name }}</option>
                                            @empty
                                            @endforelse
                                        @else
                                            @forelse ($facilities as $facility)
                                                <option value='{{ $facility->id }}'>{{ $facility->name }}</option>
                                            @empty
                                                <option selected value="">None</option>
                                            @endforelse
                                        @endif

                                    </select>
                                    @error('parent_id')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="isActive2" class="form-label">Status</label>
                                    <select class="form-select" id="isActive2" name="is_active"
                                        wire:model="is_active">
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
                $('#addFacility').modal('hide');
                $('#editfacility').modal('hide');
                $('#delete_modal').modal('hide');
                $('#show-delete-confirmation-modal').modal('hide');
            });

            window.addEventListener('edit-modal', event => {
                $('#editfacility').modal('show');
            });
            window.addEventListener('delete-modal', event => {
                $('#delete_modal').modal('show');
            });
        </script>
    @endpush
</div>
