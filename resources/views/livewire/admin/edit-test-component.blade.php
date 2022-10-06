<div>
    @include('layouts.messages')
    <div class="card">
        <div class="card-body">
            <form id="test_form">
                <!-- /.card-header -->
                <div class="card-body">
                    @csrf
                    @include('super-admin.tests._form')
                </div>
                <!-- /.card-body -->

                <div class="card-footer text-end float-right">
                    <x-button wire:click.prevent="store()">{{__('Update')}}</x-button>                       
                </div>
            </form>

        </div>
    </div>
     
    <div wire:ignore.self class="modal fade" id="delete_modal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Sample</h5>
                    <button type="button" class="btn-close" wire:click="cancel()" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-4 pb-4">
                    <h6>Are you sure? You want to delete this  data!</h6>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-primary" wire:click="cancel()" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                    <button class="btn btn-sm btn-danger" wire:click="deleteData()">Yes! Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
  
<script>
    window.addEventListener('close-modal', event =>{
        $('#modalAdd').modal('hide');
        $('#edit_modal').modal('hide');
        $('#delete_modal').modal('hide');
        $('#show-delete-confirmation-modal').modal('hide');
    });
    window.addEventListener('edit-modal', event =>{
        $('#edit_modal').modal('show');
    });
    window.addEventListener('delete-modal', event =>{
        $('#delete_modal').modal('show');
    });

</script>
@endpush
