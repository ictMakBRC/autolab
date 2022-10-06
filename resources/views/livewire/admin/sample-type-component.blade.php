@section('title', 'Test categories')
@section('pagename', 'Test Categories')
@section('linkname', 'Categories')
<div>
    {{-- @include('layouts.messages') --}}
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">

                        <div class="d-flex align-items-center mb-4">
                            <h5 class="mb-0">Samples/Specimens</h5>
                            <div class="ms-auto position-relative float-right ">
                                <button data-bs-toggle="modal" data-bs-target="#modalAdd"
                                    class="btn btn-success btn-sm">Add New</button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-middle" id="datableButtons">
                                <thead class="table-light">
                                    <tr>
                                        <td>Sample</td>
                                        <td>Status</td>
                                        <td>Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sampletypes as $item)
                                        <tr>
                                            <td>{{ $item->sample_name }}</td>
                                            <td>
                                                @if ($item->status == 1)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Suspended</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="javascript:;" class="text-warning" data-bs-toggle="tooltip"
                                                    data-bs-placement="bottom"
                                                    wire:click="editdata({{ $item->id }})" data-target="#edit_modal"
                                                    title="Edit"><i class="bi bi-pencil-fill"></i></a>
                                                <a href="javascript:;" class="text-danger" data-bs-toggle="tooltip"
                                                    wire:click="deleteConfirmation({{ $item->id }})"
                                                    title="Delete"><i class="bi bi-trash-fill"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div wire:ignore.self class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="exampleModalLabel"
            role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add a new Sample</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form wire:submit.prevent="storeData">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Sample name</label>
                                <input type="text" name="sample_name" id="sample_name" wire:model="sample_name"
                                    class="form-control">
                                @error('sample_name')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                        <div class="modal-footer">
                            <x-button>{{ __('Save') }}</x-button>
                            <x-button type="button" class="btn btn-danger" wire:click="close()"
                                data-bs-dismiss="modal">{{ __('Close') }}</x-button>
                        </div>
                    </form>
                </div>

            </div>
        </div>


        <!-- Modal -->
        <div wire:ignore.self id="edit_modal" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel"
            role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Sample</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form wire:submit.prevent="updateData">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Sample name</label>
                                <input type="text" name="sample_name" id="sample_name" wire:model="sample_name"
                                    class="form-control">
                                @error('sample_name')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" wire:model="status" name="status" required>
                                    <option value="">select</option>
                                    <option value="1" style="color: green" selected>Active</option>
                                    <option value="0" style="color: red">Suspended</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <x-button>{{ __('Save') }}</x-button>
                            <x-button type="button" class="btn btn-danger" wire:click="close()"
                                data-bs-dismiss="modal">{{ __('Close') }}</x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal -->

        <div wire:ignore.self class="modal fade" id="delete_modal" tabindex="-1" data-backdrop="static"
            data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Sample</h5>
                        <button type="button" class="btn-close" wire:click="cancel()" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-4 pb-4">
                        <h6>Are you sure? You want to delete this data!</h6>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-sm btn-primary" wire:click="cancel()" data-bs-dismiss="modal"
                            aria-label="Close">Cancel</button>
                        <button class="btn btn-sm btn-danger" wire:click="deleteData()">Yes! Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>

@push('scripts')
    <script>
        window.addEventListener('close-modal', event => {
            $('#modalAdd').modal('hide');
            $('#edit_modal').modal('hide');
            $('#delete_modal').modal('hide');
            $('#show-delete-confirmation-modal').modal('hide');
        });
        window.addEventListener('edit-modal', event => {
            $('#edit_modal').modal('show');
        });
        window.addEventListener('delete-modal', event => {
            $('#delete_modal').modal('show');
        });
    </script>
@endpush
