<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="mb-2 mb-sm-0">
                                    Test Result Reviews
                                </h5>
                                {{-- <div class="ms-auto">

                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- @if (!$testResults->isEmpty()) --}}
                <div class="card-body">
                    <div class="tab-content">
                        <div class="table-responsive">
                            <table id="datableButton" class="table table-striped mb-0 w-100 ">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Sample Batch</th>
                                        <th>Study</th>
                                        <th>Participant ID</th>
                                        <th>Sample</th>
                                        <th>Test</th>
                                        <th>Requester</th>
                                        <th>Requested At</th>
                                        <th>Received At</th>
                                        <th>Result Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($testResults as $key => $testResult)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                           
                                            <td>
                                                {{ $testResult->sample->participant->sampleReception->batch_no }}
                                            </td>
                                            <td>
                                                {{ $testResult->sample->study->name }}
                                            </td>
                                            <td>
                                                {{ $testResult->sample->participant->identity }}
                                            </td>
                                           
                                            <td>
                                                {{ $testResult->sample->sampleType->type }}
                                            </td>
                                            
                                            <td>
                                                <a href="{{route('result-report',$testResult->id)}}" type="button" data-bs-toggle="tooltip"
                                                    data-bs-placement="bottom" title=""
                                                    data-bs-original-title="Preliminary Result Report" target="_blank"
                                                    class="text-info">{{ $testResult->test->name }}</a>
                                                
                                            </td>
                                             
                                            <td>
                                                {{ $testResult->sample->requester->name }}
                                            </td>
                                            <td>
                                                {{date('d-m-Y', strtotime($testResult->sample->date_requested)) }}
                                            </td>
                                            <td>
                                                {{ date('d-m-Y H:i', strtotime($testResult->sample->participant->sampleReception->date_delivered))}}
                                            </td>
                                            <td>
                                                {{ $testResult->created_at }}
                                            </td>
                                            
                                            <td>
                                                <span class="badge bg-success">{{ $testResult->status }}</span>
                                            </td>
                                            <td>
                                                <a href="javascript: void(0);" type="button" data-bs-toggle="tooltip"
                                                data-bs-placement="bottom" title=""
                                                data-bs-original-title="Mark As Review"
                                                wire:click="markAsReviewed({{ $testResult->id }})"
                                                class="action-ico btn btn-outline-success radius-30 px-3">Review</a>
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

        {{-- @push('scripts')
            <script>
                window.addEventListener('close-modal', event => {
                    $('#view_tests').modal('hide');
                });

                window.addEventListener('view-tests', event => {
                    $('#view-tests').modal('show');
                });
            </script>
        @endpush --}}
    </div>
</div>