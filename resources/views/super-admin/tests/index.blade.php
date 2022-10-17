<x-app-layout>
    <!-- start page title -->
    @section('title', 'Test List')
    @section('pagename', 'Test List')
    @section('linkname', 'Test')
    <!-- end page title -->
  
    <!-- end row-->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <div class="text-sm-end mt-3">
                                <h4 class="header-title mb-3  text-center">Tests</h4>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="text-sm-end mt-3">
                                <a  href="{{route('tests.create')}}" class="btn btn-success mb-2 me-1">Add new</a>
                            </div>
                        </div><!-- end col-->
                    </div>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table id="datableButtons" class="table w-100 nowrap">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tests as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->category->category_name }}</td>
                                    <td>{{ $item->price }}</td>
                                    @if ($item->status == 1)
                                        <td><span class="badge bg-success">Active</span></td>
                                    @else
                                        <td><span class="badge bg-danger">Suspended</span></td>
                                    @endif
                                    <td class="table-action">
                                        <a href="{{ route('editTest',['id'=>$item->id]) }}" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom"  title="Edit"><i class="bi bi-pencil-fill"></i></a>
                                    </td>
                                </tr>
                                @empty
                                    
                                @endforelse
                            </tbody>
                        </table>
                    </div> <!-- end preview-->

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <!-- end row-->

</x-app-layout>
