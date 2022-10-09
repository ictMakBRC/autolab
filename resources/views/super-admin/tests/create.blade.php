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
                    <h5 class="card-title">{{ __('Create New Test') }}</h5>
                </div>
                <form method="POST" action="{{ route('tests.store') }}" id="test_form">
                    <!-- /.card-header -->
                    <div class="card-body">
                        @csrf
                        @include('super-admin.tests._form')
                    </div>
                    <!-- /.card-body -->

                    <div class="text-end float-right me-4 mb-4 mt-2">
                        <x-button class="btn-success">{{ __('Save') }}</x-button>
                    </div>
                </form>

            </div>
        </div><!-- end col-->
    </div>
    <!-- end row-->

    @push('scripts')
        <script src="{{ asset('autolab-assets/js/select2.script.js') }}" type="text/javascript"></script>
    @endpush

</x-app-layout>
