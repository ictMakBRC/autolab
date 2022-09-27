<div>
    <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class ="card">
                        <div class="card-body">
                        
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0">Test Category Table</h5>
                                 <div class="ms-auto position-relative float-right ">
                                    <button data-bs-toggle="modal" data-bs-target="#exampleModal"  class="btn btn-success btn-sm">Add New</button>
                                 </div>
                             </div>
                            <div class="table-responsive">
                                <table id="example1" class="table w-100 nowrap">
                                    <thead>
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
                                                    <a href="javascript:;" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"><i class="bi bi-pencil-fill"></i></a>
                                                    <a href="javascript:;" class="text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete"><i class="bi bi-trash-fill"></i></a>
                                                    <button type="button" data-toggle="modal" wire:click="editStudents({{$item->id}})" data-target="#editstudent_modal" class="btn btn-sm btn info">Edit</button>
                                                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" wire:click="deleteConfirm({{$item->id}})" >Delete</button>
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
            <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"  role="dialog">
                <div class="modal-dialog">
            
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
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
                    <button type="submit" class="btn btn-success" >Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
                </div>
            
                </div>
            </div>
                    
              
            <!-- Modal -->
            <div wire:ignore.self id="editstudent_modal" class="modal fade" role="dialog">
                <div class="modal-dialog">
              
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Edit Student</h4>
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
                      <button type="submit" class="btn btn-success" >Save</button>
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
                  </div>
              
                
                    
                </div>
            </div>

                        <!-- Modal -->
<div wire:ignore.self id="deletestudent_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
  
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Delete Record</h4>
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
    window.addEventListener('close-modal', event =>{
        $('#addstudent_modal').modal('hide');
        $('#editstudent_modal').modal('hide');
        $('#deletestudent_modal').modal('hide');
    });
    window.addEventListener('edit-modal', event =>{
        $('#editstudent_modal').modal('show');
    });
    window.addEventListener('delete-modal', event =>{
        $('#deletestudent_modal').modal('show');
    });
</script>
@endpush
