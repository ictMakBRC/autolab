<div>
    <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class ="card">
                        <div class="card-body">
                        
                            <div class="d-flex align-items-center mb-4">
                                <h5 class="mb-0">Test Category Table</h5>
                                 <div class="ms-auto position-relative float-right ">
                                    <button data-bs-toggle="modal" data-bs-target="#modalAdd"  class="btn btn-success btn-sm">Add New</button>
                                 </div>
                             </div>
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead class="table-light">
                                        <tr>
                                        <td>Nema</td>
                                        <td>Description</td>
                                        <td>Action</td>
                                        </tr>
                                    </thead>
                                        <tbody>
                                            @foreach ($categories as $item)
                                            <tr>
                                                <td>{{$item->category_name}}</td>
                                                <td>{{$item->description}}</td>
                                                <td>
                                                    <a href="javascript:;" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" wire:click="editdata({{$item->id}})" data-target="#edit_modal"  title="Edit"><i class="bi bi-pencil-fill"></i></a>
                                                    <a href="javascript:;" class="text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" wire:click="deleteConfirm({{$item->id}})"  title="Delete"><i class="bi bi-trash-fill"></i></a>
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
            <div wire:ignore.self class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="exampleModalLabel"  role="dialog">
                <div class="modal-dialog">            
                <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add a new category</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form wire:submit.prevent="storeData">
                            <div class="modal-body">                      
                                <div class="form-group">
                                    <label for="name">Category name</label>
                                    <input type="text" name="category_name" id="category_name" wire:model="category_name" class="form-control">
                                    @error('category_name')
                                        <div class="text-danger text-small">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="email">Description</label>
                                    <input type="text" name="description" id="description" wire:model="description" class="form-control">
                                    @error('description')
                                        <div class="text-danger text-small">{{$message}}</div>
                                    @enderror
                                </div>
                            
                            </div>
                        <div class="modal-footer">
                        <x-button>{{__('Save')}}</x-button>
                        <x-button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{__('Close')}}</x-button>
                        </div>
                    </form>
                    </div>
            
                </div>
            </div>
                    
              
            <!-- Modal -->
            <div wire:ignore.self id="edit_modal" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel"  role="dialog">
                <div class="modal-dialog">
              
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form wire:submit.prevent="editData">
                        <div class="modal-body">                      
                            <div class="form-group">
                                <label for="name">Category name</label>
                                <input type="text" name="category_name" id="category_name" wire:model="category_name" class="form-control">
                                @error('category_name')
                                    <div class="text-danger text-small">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email">Description</label>
                                <input type="text" name="description" id="description" wire:model="description" class="form-control">
                                @error('description')
                                    <div class="text-danger text-small">{{$message}}</div>
                                @enderror
                            </div>
                        
                        </div>
                    <div class="modal-footer">
                        <x-button>{{__('Save')}}</x-button>
                        <x-button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{__('Close')}}</x-button>
                    </div>
                </form>
                  </div>
              
                
                    
                </div>
            </div>

                        <!-- Modal -->
            <div wire:ignore.self id="delete_modal" class="modal fade" role="dialog">
                <div class="modal-dialog">
            
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form wire:submit.prevent="storeStudentData">
                    <div class="modal-body">
                        Are you sure you want to delete this Record?
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger" wire:click="deleteStudentData()">Delete</button>
                        <button type="button" class="btn btn-success" wire:model="cancel()">Close</button>
                    </div>
                    </form>
                </div>
            
                </div>
            </div>
                    
                </div>
            </div>
        </div>
    </div>

@push('scripts')
   <script>
    $(document).ready(
        function(){
            $('#modalAdd').modal('show');
        }
    );
   </script>
<script>
    window.addEventListener('close-modal', event =>{
        $('#modalAdd').modal('hide');
        $('#edit_modal').modal('hide');
        $('#delete_modal').modal('hide');
    });
    window.addEventListener('edit-modal', event =>{
        $('#edit_modal').modal('show');
    });
    window.addEventListener('delete-modal', event =>{
        $('#delete_modal').modal('show');
    });
</script>
@endpush
