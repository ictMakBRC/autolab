<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header pt-0">
                <div class="row mb-2">
                    <div class="col-sm-12 mt-3">
                        <div class="d-sm-flex align-items-center">
                            <h5 class="mb-2 mb-sm-0">Sample Reception</h5>
                            <div class="ms-auto">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-outline-primary">More...</button>
                                    <button type="button" class="btn btn-outline-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">	<span class="visually-hidden">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
                                      <a class="dropdown-item" href="javascript:;">Add Facility</a>
                                      <a class="dropdown-item" href="javascript:;">Add Courier</a>
                                    </div>
                                  </div>
                            </div>
                          </div>
                    </div>
                </div>
                <hr>
                <div class="row mb-2">
                    <form wire:submit.prevent="storeData">
                        <div class="row">
                            <div class="mb-3 col-md-2">
                                <label for="date_delivered" class="form-label">Date/Time Delivered</label>
                                <input id="date_delivered" type="datetime-local" class="form-control"
                                    wire:model="date_delivered">
                                @error('date_delivered')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-2">
                                <label for="delivered" class="form-label">Samples Delivered</label>
                                <input type="number" id="delivered" class="form-control" wire:model="delivered">
                                @error('delivered')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="facility" class="form-label">Facility</label>
                                <select class="form-select" id="facility" wire:model="facility_id">
                                    <option selected value="">Select</option>
                                    @forelse ($facilities as $facility)
                                        <option value='{{ $facility->id }}'>{{ $facility->name }}</option>
                                    @empty
                                    @endforelse
                                </select>
                                @error('facility_id')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-3">
                                <label for="courier_id" class="form-label">Courier</label>
                                <select class="form-select" id="courier_id" wire:model="courier_id">
                                    <option selected value="">Select</option>
                                    @forelse ($couriers as $courier)
                                        <option value='{{ $courier->id }}'>{{ $courier->name }}</option>
                                    @empty
                                    @endforelse
                                </select>
                                @error('courier_id')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-2">
                                <label for="accepted" class="form-label">Verified & Accepted</label>
                                <input type="number" id="accepted" class="form-control" wire:model="accepted">
                                @error('accepted')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-2">
                                <label for="rejected" class="form-label">Rejected</label>
                                <input type="number" id="rejected" class="form-control" wire:model="rejected">
                                @error('rejected')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="received_by" class="form-label">Received By</label>
                                <select class="form-select" id="received_by" wire:model="received_by">
                                    <option selected value="">Select</option>
                                    @forelse ($users as $user)
                                        <option value='{{ $user->id }}'>{{ $user->fullName }}</option>
                                    @empty
                                    @endforelse
                                </select>
                                @error('received_by')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                          
                            <div class="mb-3 col-md-1">
                                <div class="form-check mt-4">
                                    <input class="form-check-input" type="checkbox" value="1" id="courier_signed" checked wire:model="courier_signed">
                                    <label class="form-check-label" for="courier_signed">Did Courier Sign?</label>
                                </div>
                                @error('courier_signed')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="rejection_reason" class="form-label">Reason for Rejection</label>
                                <textarea type="text" id="rejection_reason" class="form-control" wire:model="rejection_reason"></textarea>
                                @error('rejection_reason')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                           
                            <div class="col-md-2 text-start mt-4">
                              <button type="submit" class="btn btn-success">Save</button>
                          </div>
                            
                        </div>
                        <!-- end row-->
                        
                    </form>
                </div>
            </div>
            <hr>
            <div class="card-body">
                <div class="tab-content">
                    <div class="table-responsive">
                        <table id="datableButton" class="table table-striped mb-0 w-100 ">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Batch No</th>
                                    <th>Date Delivered</th>
                                    <th>Delivered</th>
                                    <th>Reffering Facility</th>
                                    <th>Courier</th>
                                    <th>Courier Signed?</th>
                                    <th>Accepted</th>
                                    <th>Rejected</th>
                                    <th>Received By</th>
                                    <th>Date Received</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div> <!-- end preview-->
                </div> <!-- end tab-content-->

            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->

    {{-- ADD FACILITY --}}
    {{-- <div wire:ignore.self class="modal fade" id="addRequester" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Add New Requester</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div> <!-- end modal header -->
                <div class="modal-body">
                    <form wire:submit.prevent="storeData">
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label for="requesterName" class="form-label">Name</label>
                                <input type="text" id="requesterName" class="form-control" name="name"
                                    wire:model="name">
                                @error('name')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="requestercontact" class="form-label">Contact</label>
                                <input type="text" id="requestercontact" class="form-control" wire:model="contact">
                                @error('contact')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="requesterEmail" class="form-label">Email</label>
                                <input type="email" id="requesterEmail" class="form-control" name="email"
                                    wire:model="email">
                                @error('email')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-5">
                                <label for="facility" class="form-label">Facility</label>
                                <select class="form-select" id="facility" wire:model="facility_id"
                                    wire:change="getStudies">
                                    <option selected value="">Select</option>
                                    @forelse ($facilities as $facility)
                                        <option value='{{ $facility->id }}'>{{ $facility->name }}</option>
                                    @empty
                                    @endforelse
                                </select>
                                @error('facility_id')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-5">
                                <label for="study_id" class="form-label">Study/project</label>
                                <select class="form-select" id="study_id" wire:model="study_id">
                                    @if ($facility_id && !$studies->isEmpty())
                                        <option selected value="">Select/None</option>
                                        @foreach ($studies as $study)
                                            <option value='{{ $study->id }}'>{{ $study->name }}</option>
                                        @endforeach
                                    @else
                                        <option selected value="">None</option>
                                    @endif
                                </select>
                                @error('study_id')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-2">
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
                        </div>
                        <!-- end row-->
                        <div class="d-grid mb-0 text-center">
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </form>
                </div>
            </div> <!-- end modal content-->
        </div> <!-- end modal dialog-->
    </div> <!-- end modal--> --}}

    {{-- //DELETE CONFIRMATION MODAL --}}
    {{-- <div wire:ignore.self class="modal fade" id="delete_modal" tabindex="-1" data-backdrop="static"
        data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Requester</h5>
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
    </div> --}}

    <!-- EDIT requester Modal -->
    {{-- <div wire:ignore.self class="modal fade" id="editrequester" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Update Requester</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true" wire:click="close()"></button>
                </div> <!-- end modal header -->
                <div class="modal-body">
                    <form wire:submit.prevent="updateData">
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label for="requesterName2" class="form-label">Name</label>
                                <input type="text" id="requesterName2" class="form-control" name="name"
                                    wire:model="name">
                                @error('name')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="requestercontact2" class="form-label">Contact</label>
                                <input type="text" id="requestercontact2" class="form-control"
                                    wire:model="contact">
                                @error('contact')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="requesterEmail2" class="form-label">Email</label>
                                <input type="email" id="requesterEmail2" class="form-control" name="email"
                                    wire:model="email">
                                @error('email')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-5">
                                <label for="facility2" class="form-label">Facility</label>
                                <select class="form-select" id="facility2" wire:model="facility_id"
                                    wire:change="getStudies">
                                    @if ($facility_id == '')
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
                                @error('facility_id')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-5">
                                <label for="study_id2" class="form-label">Study/project</label>
                                <select class="form-select" id="study_id2" wire:model="study_id">
                                    @if ($facility_id && !$studies->isEmpty())
                                        <option value="">Select/None</option>
                                        @foreach ($studies as $study)
                                            <option value='{{ $study->id }}'>{{ $study->name }}</option>
                                        @endforeach
                                    @else
                                        <option selected value="">None</option>
                                    @endif
                                </select>
                                @error('study_id')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-2">
                                <label for="isActive2" class="form-label">Status</label>
                                <select class="form-select" id="isActive2" name="is_active" wire:model="is_active">
                                    <option value='1'>Active</option>
                                    <option value='0'>Inactive</option>
                                </select>
                                @error('is_active')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
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
    </div> <!-- end modal--> --}}

    {{-- @push('scripts')
        <script>
            window.addEventListener('close-modal', event => {
                $('#addRequester').modal('hide');
                $('#editrequester').modal('hide');
                $('#delete_modal').modal('hide');
                $('#show-delete-confirmation-modal').modal('hide');
            });

            window.addEventListener('edit-modal', event => {
                $('#editrequester').modal('show');
            });
            window.addEventListener('delete-modal', event => {
                $('#delete_modal').modal('show');
            });
        </script>
    @endpush --}}
</div>
