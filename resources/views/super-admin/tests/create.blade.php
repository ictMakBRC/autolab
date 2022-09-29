<x-app-layout>
    <!-- start page title -->
    @section('title', 'Test List')
    @section('pagename', 'Test List')
    @section('linkname', 'Test')
    <!-- end page title -->
  
    <!-- end row-->
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">{{__('Create')}}</h3>
                </div>
                <form method="POST" action="{{route('tests.store')}}" id="test_form">
                    <!-- /.card-header -->
                    <div class="card-body">
                        @csrf
                        @include('super-admin.tests._form')
                    </div>
                    <!-- /.card-body -->
            
                    <div class="card-footer text-end float-right">
                        <x-button>{{__('Save')}}</x-button>                       
                    </div>
                </form>
            
            </div>
        </div><!-- end col-->
    </div>
    <!-- end row-->
    {{-- @include('super-admin.addUserModal') --}}

</x-app-layout>
