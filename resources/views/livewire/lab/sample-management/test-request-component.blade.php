<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="mb-2 mb-sm-0">

                                    Test Requests 
                                    {{-- <strong class="text-success">{{ $batch_no }}</strong>
                                    (<strong class="text-info">{{ $batch_samples_handled }}</strong>/<strong
                                        class="text-danger">{{ $batch_sample_count }}</strong>) --}}
                                </h5>
                                <div class="ms-auto">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-outline-primary">More...</button>


                                        <button type="button"
                                            class="btn btn-outline-primary split-bg-primary dropdown-toggle dropdown-toggle-split"
                                            data-bs-toggle="dropdown"> <span class="visually-hidden">Toggle
                                                Dropdown</span>
                                        </button>

                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
                                            {{-- @if ($tabToggleBtn)
                                                <a class="dropdown-item" href="javascript:;"
                                                    wire:click="toggleTab()">Toggle Tabs</a>
                                            @endif
                                            <a class="dropdown-item" href="javascript:;" wire:click="close()">Reset
                                                form</a> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <hr>
                    <div class="row mb-0">

                        
                    </div> --}}
                </div>

                {{-- @if (!$samples->isEmpty()) --}}
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="table-responsive">
                                <table id="datableButton" class="table table-striped mb-0 w-100 ">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            {{-- <th>Batch No</th> --}}
                                            <th>Participant ID</th>
                                            <th>Sample</th>
                                            <th>Sample ID</th>
                                            <th>Lab No</th>
                                            <th>Study</th>
                                            <th>Requested By</th>
                                            <th>Collected By</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($samples as $key => $sample)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    {{ $sample->participant->identity }}
                                                </td>
                                                <td>
                                                    {{$sample->sampleType->type}}
                                                </td>
                                                <td>
                                                    {{ $sample->sample_identity }}
                                                </td>
                              
                                                <td>
                                                    <strong class="text-success">{{ $sample->lab_no }}</strong>
                                                </td>
                                                <td>
                                                    {{ $sample->study->name }}
                                                </td>
                                                <td>
                                                    {{ $sample->requester->name }}
                                                </td>
                                                <td>
                                                    {{ $sample->collector->name }}
                                                </td>
                                                <td class="table-action">
                                                    <a href="javascript: void(0);"
                                                        wire:click="deleteConfirmation({{ $sample->id }})"
                                                        class="action-ico">
                                                        <i class="bi bi-trash"></i></a>
                                                </td>
                                            </tr>
                                        @empty
                                        @endforelse
                                    </tbody>
                                </table>
                            </div> <!-- end preview-->
                        </div> <!-- end tab-content-->
                    </div> <!-- end card body-->
                {{-- @endif --}}

            </div> <!-- end card -->
        </div><!-- end col-->

        {{-- //DELETE CONFIRMATION MODAL --}}
        <div wire:ignore.self class="modal fade" id="delete_modal" tabindex="-1" data-backdrop="static"
            data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Participant</h5>
                        <button type="button" class="btn-close" wire:click="cancel()" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-4 pb-4">
                        <h6>This will delete this <strong class="text-danger">Participant together with associated
                                Sample Data</strong> for this particular batch! Do you want to continue?</h6>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-sm btn-primary" wire:click="cancel()" data-bs-dismiss="modal"
                            aria-label="Close">Cancel</button>
                        <button class="btn btn-sm btn-danger" wire:click="deleteData()">Yes! Delete</button>
                    </div>
                </div>
            </div>
        </div>

        @push('scripts')
            <script>
                window.addEventListener('close-modal', event => {
                    $('#delete_modal').modal('hide');
                    $('#show-delete-confirmation-modal').modal('hide');
                });

                window.addEventListener('delete-modal', event => {
                    $('#delete_modal').modal('show');
                });

                window.addEventListener('maximum-reached', event => {
                    alert('Maximum number of samples in this batch already Recorded.');
                });

            </script>
        @endpush
    </div>
</div>

