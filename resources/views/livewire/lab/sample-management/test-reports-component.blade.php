<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="mb-2 mb-sm-0">
                                    Test Result Reports
                                </h5>
                                <div class="ms-auto">
                                    <a type="button" class="btn btn-outline-info" wire:click="refresh()" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title=""
                                    data-bs-original-title="Refresh Table"><i class="bi bi-arrow-clockwise"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="tab-content">
                        <div class="table-responsive">
                            <table id="datableButtons" class="table table-striped mb-0 w-100 ">
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
                                                {{ $testResult->sample->sampleReception->batch_no }}
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
                                                {{ $testResult->test->name }}
                                            </td>
                                             
                                            <td>
                                                {{ $testResult->sample->requester->name }}
                                            </td>
                                            <td>
                                                {{date('d-m-Y', strtotime($testResult->sample->date_requested)) }}
                                            </td>
                                            <td>
                                                {{ date('d-m-Y H:i', strtotime($testResult->sample->sampleReception->date_delivered))}}
                                            </td>
                                            <td>
                                                {{ $testResult->created_at }}
                                            </td>
                                            <td>
                                                <span class="badge bg-success">{{ $testResult->status }}</span>
                                            </td>
                                            <td class="action-ico">
                                                <a href="{{route('result-report',$testResult->id)}}" type="button" data-bs-toggle="tooltip"
                                                data-bs-placement="bottom" title=""
                                                data-bs-original-title="Result Report" target="_blank"
                                                class="action-ico btn btn-outline-info"><i class="bi bi-arrow-down-square"></i></a>
                                            </td> 
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div> <!-- end preview-->
                    </div> <!-- end tab-content-->
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->

    </div>
</div>
