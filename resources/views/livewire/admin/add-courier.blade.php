    <div wire:ignore.self class="modal fade" id="addCourier" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Add New Courier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div> <!-- end modal header -->
                <div class="modal-body">
                    <form wire:submit.prevent="storeCourierData">
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label for="courierName" class="form-label">Name</label>
                                <input type="text" id="courierName" class="form-control" name="name"
                                    wire:model.lazy="name">
                                @error('name')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="couriercontact" class="form-label">Contact</label>
                                <input type="text" id="couriercontact" class="form-control"
                                    wire:model.lazy="contact">
                                @error('contact')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="courierEmail" class="form-label">Email</label>
                                <input type="email" id="courierEmail" class="form-control" name="email"
                                    wire:model.lazy="email">
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
                                <select class="form-select" id="isActive" name="is_active"
                                    wire:model="is_active">
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
    </div>
