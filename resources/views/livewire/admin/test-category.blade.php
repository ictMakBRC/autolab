@section('title', 'Test categories')
@section('pagename', 'Test Categories')
@section('linkname', 'Categories')
<div>
    {{-- @include('layouts.messages') --}}
    <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class ="card">
                        <div class="card-body">
                        
                            <div class="d-flex align-categorys-center mb-4">
                                <h5 class="mb-0">Test Categories</h5>
                                 <div class="ms-auto position-relative float-right ">
                                    <button data-bs-toggle="modal" data-bs-target="#modalAdd"  class="btn btn-success btn-sm">Add New</button>
                                 </div>
                             </div>
                            <div class="table-responsive">
                                <table class="table align-middle" id="datableButtons">
                                    <thead class="table-light">
                                        <tr>
                                        <td>Category</td>
                                        <td>Description</td>
                                        <td>Action</td>
                                        </tr>
                                    </thead>
                                        <tbody>
                                            @foreach ($categories as $category)
                                            <tr>
                                                <td>{{$category->category_name}}</td>
                                                <td>{{$category->description}}</td>
                                                <td>
                                                    <a href="javascript:;" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" wire:click="editdata({{$category->id}})" data-target="#edit_modal"  title="Edit"><i class="bi bi-pencil-fill"></i></a>
                                                    <a href="javascript:;" class="text-danger" data-bs-toggle="tooltip" wire:click="deleteConfirmation({{ $category->id }})"  title="Delete"><i class="bi bi-trash-fill"></i></a> 
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
            <div wire:ignore.self class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="exampleModalLabel"  role="dialog" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog">            
                <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add a new category</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="close()"></button>
                        </div>
                        <form wire:submit.prevent="storeData">
                            <div class="modal-body">                      
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Category name</label>
                                    <input type="text" name="category_name" id="category_name" wire:model="category_name" class="form-control">
                                    @error('category_name')
                                        <div class="text-danger text-small">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label">Description</label>
                                    <input type="text" name="description" id="description" wire:model="description" class="form-control">
                                    @error('description')
                                        <div class="text-danger text-small">{{$message}}</div>
                                    @enderror
                                </div>
                            
                            </div>
                        <div class="modal-footer">
                        <x-button>{{__('Save')}}</x-button>
                        <x-button type="button" class="btn btn-danger" wire:click="close()" data-bs-dismiss="modal">{{__('Close')}}</x-button>
                        </div>
                    </form>
                    </div>
            
                </div>
            </div>
                    
              
            <!-- Modal -->
            <div wire:ignore.self id="edit_modal" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel"  role="dialog" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog">
              
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form wire:submit.prevent="updateData">
                        <div class="modal-body">                      
                            <div class="form-group">
                                <label for="name" class="form-label">Category name</label>
                                <input type="text" name="category_name" id="category_name" wire:model="category_name" class="form-control">
                                @error('category_name')
                                    <div class="text-danger text-small">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email" class="form-label">Description</label>
                                <input type="text" name="description" id="description" wire:model="description" class="form-control">
                                @error('description')
                                    <div class="text-danger text-small">{{$message}}</div>
                                @enderror
                            </div>
                        
                        </div>
                    <div class="modal-footer">
                        <x-button>{{__('Save')}}</x-button>
                        <x-button type="button" class="btn btn-danger" wire:click="close()" data-bs-dismiss="modal">{{__('Close')}}</x-button>
                    </div>
                </form>
                  </div>
              
                
                    
                </div>
            </div>

                        <!-- Modal -->
        
            <div wire:ignore.self class="modal fade" id="delete_modal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Delete category</h5>
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
