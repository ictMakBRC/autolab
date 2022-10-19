<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="mb-2 mb-sm-0">

                                    Attach Test Results
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
                    <div class="row">
                        <div class="mb-0">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0 w-100">
                                    <thead>
                                        <tr>
                                            <th>Test Requested</th>
                                            <th>Result to Append</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @if (!$testrequest->request_detail->isEmpty())
                                            @foreach ($testrequest->request_detail as $detail)
                                                @if ($detail->test_type != null)
                                                    <tr>
                                                        <td><strong>{{ $detail->test_type->type }}
                                                            </strong>
                                                        </td>
                                                        <td>
                                                            <form method="POST"
                                                                action="{{ route('testresults.store') }}"
                                                                onsubmit="return confirm('{{ trans('Are you sure you want save this Result?') }}');"
                                                                enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="row">
                                                                    <div class="col-sm-8">
                                                                        <input type="text"
                                                                            class="form-control"
                                                                            name="request_detail_id"
                                                                            value="{{ $detail->id }}"
                                                                            hidden required>
                                                                        <input type="text"
                                                                            class="form-control"
                                                                            name="tracker"
                                                                            value="{{ $testrequest->tracker }}"
                                                                            hidden>
                                                                        
                                                                        @foreach ($detail->test_type->possible_results as $result)
                                                                            <input type="text"
                                                                                class="form-control"
                                                                                name="type"
                                                                                value="{{ $detail->test_type->type }}"
                                                                                hidden>
                                                                            @if ($result->result_type == 'Absolute')
                                                                                <div class="form-check">
                                                                                    <input type="radio"
                                                                                        id="customRadio1"
                                                                                        name="result"
                                                                                        class="form-check-input"
                                                                                        value="{{ $result->possible_result }}">
                                                                                    <label
                                                                                        class="form-check-label"
                                                                                        for="customRadio1">{{ $result->possible_result }}</label>
                                                                                </div>
                                                                            @elseif($result->result_type == 'Attachment')
                                                                                <div class="mb-2">
                                                                                    @if ($result->possible_result == 'Referred')
                                                                                        <input type="radio"
                                                                                            id="customRadio1"
                                                                                            name="result"
                                                                                            class="form-check-input"
                                                                                            value="{{ $result->possible_result }}">
                                                                                        <label
                                                                                            class="form-check-label"
                                                                                            for="customRadio1">{{ $result->possible_result }}</label>
                                                                                    @else
                                                                                        <div
                                                                                            class="mb-2">
                                                                                            <input
                                                                                                type="radio"
                                                                                                id="customRadio1"
                                                                                                name="result"
                                                                                                class="form-check-input"
                                                                                                value="{{ $result->possible_result }}">
                                                                                            <label
                                                                                                class="form-check-label"
                                                                                                for="customRadio1">{{ $result->possible_result }}</label>
                                                                                        </div>
                                                                                        <input type="file"
                                                                                            id="attachment"
                                                                                            class="form-control"
                                                                                            name="attachment"
                                                                                            accept=".pdf">
                                                                                    @endif
                                                                                </div>
                                                                            @elseif($result->result_type == 'Measurable')
                                                                                <div class="mb-2">
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        name="result"
                                                                                        placeholder="Include units Like 10 {{ $result->uom }}"
                                                                                        required>
                                                                                </div>
                                                                            @elseif($result->result_type == 'Free Text')
                                                                                <div class="mb-2">

                                                                                    @if ($detail->test_type->type == 'Urinalysis')
                                                                                        <blade
                                                                                            ___html_tags_0___ />
                                                                                    @else
                                                                                        <blade
                                                                                            ___html_tags_1___ />
                                                                                    @endif
                                                                                </div>
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <button type="submit"
                                                                            class="btn btn-success"><i
                                                                                class="mdi mdi-check"></i>Save
                                                                            Result</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @else
                                            <tr class="text-center">
                                                <td colspan="2">
                                                    <h3>No Data Available</h3>
                                                </td>
                                            </tr>

                                        @endif --}}
                                    </tbody>
                                </table>
                            </div> <!-- end preview-->
                        </div>
                        <hr>
                    </div>
                    <div class="tab-content">
                        <div class="table-responsive">
                            <table id="datableButton" class="table table-striped mb-0 w-100 ">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Batch No</th>
                                        <th>Participant ID</th>
                                        <th>Sample</th>
                                        <th>Sample ID</th>
                                        <th>Lab No</th>
                                        <th>Study</th>
                                        <th>Test</th>
                                        <th>Status</th>
                                        <th>Preliminary Report</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @forelse ($samples as $key => $sample)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                {{ $sample->participant->sampleReception->batch_no }}
                                            </td>
                                            <td>
                                                {{ $sample->participant->identity }}
                                            </td>
                                            <td>
                                                {{ $sample->sampleType->type }}
                                            </td>
                                            <td>
                                                {{ $sample->sample_identity }}
                                            </td>

                                            <td>
                                                <a href="javascript: void(0);"
                                                    wire:click="viewTests({{ $sample->id }})" class="action-ico">
                                                    <strong class="text-success">{{ $sample->lab_no }}</strong>
                                                </a>

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
                                            <td>
                                                {{ $sample->test_count }}
                                            </td>
                                            @if ($sample->priority == 'Normal')
                                                <td><span class="badge bg-info">{{ $sample->priority }}</span>
                                                </td>
                                            @else
                                                <td><span class="badge bg-danger">{{ $sample->priority }}</span>
                                                </td>
                                            @endif
                                            <td class="table-action">attach-test-results
                                                @if ($sample->request_acknowledged_by)
                                                <a href="{{route('attach-test-results',$sample->id )}}" type="button" class="btn btn-outline-success radius-30 px-3" data-bs-toggle="tooltip"
                                                data-bs-placement="bottom" title=""
                                                data-bs-original-title="Attach Results">Process</a>
                                                @else
                                                <a href="javascript: void(0);" data-bs-toggle="tooltip"
                                                data-bs-placement="bottom" title=""
                                                data-bs-original-title="Acknowledge Request"
                                                    wire:click="acknowledgeRequest({{ $sample->id }})"
                                                    class="action-ico">
                                                    <i class="bi bi-hand-thumbs-up"></i></a>
                                                @endif
                                                
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse --}}
                                </tbody>
                            </table>
                        </div> <!-- end preview-->
                    </div> <!-- end tab-content-->
                </div> <!-- end card body-->
                {{-- @endif --}}

            </div> <!-- end card -->
        </div><!-- end col-->

        @push('scripts')
            <script>
                // window.addEventListener('close-modal', event => {
                //     $('#view_tests').modal('hide');
                // });

                // window.addEventListener('view-tests', event => {
                //     $('#view-tests').modal('show');
                // });
            </script>
        @endpush
    </div>
</div>

