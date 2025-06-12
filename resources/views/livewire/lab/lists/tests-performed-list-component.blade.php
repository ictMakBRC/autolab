<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-header pt-0">
                        <div class="row mb-2">
                            <div class="col-sm-12 mt-3">
                                <div class="d-sm-flex align-items-center">
                                    <h5 class="mb-2 mb-sm-0">
                                        Tests Performed (<strong class="text-danger">{{ count($resultIds) }}</strong>)
                                    </h5>
                                    <div class="ms-auto">
                                        @if (count($combinedResultsList) >= 2)
                                            <a href="javascript:void()" class="btn btn-sm btn-info me-2"
                                                wire:click='combinedTestResultsReport'><i class="bi bi-list"></i>
                                                Combined Test Report
                                            </a>
                                            <a class="btn btn-sm btn-info me-2" target="_blank" href="javascript:void()"
                                                wire:click ="printMultiple" {{-- href="{{ route('print-result-multi', ['session_id' => session()->getId()]) }}" --}}>
                                                <i class="bi bi-printer"></i> Multiple Test Report
                                            </a>
                                        @endif
                                        <a href="javascript:;" wire:click='export' class="btn btn-secondary me-2"><i
                                                class="bi bi-file-earmark-fill"></i> Export</a>
                                        <a type="button" class="btn btn-outline-info" wire:click="refresh()"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                            data-bs-original-title="Refresh Table"><i
                                                class="bi bi-arrow-clockwise"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row mb-0">
                            <form>
                                <div class="row">
                                    <div class="mb-3 col-md-2">
                                        <label for="facility_id" class="form-label">Facility</label>
                                        <select class="form-select" id="facility_id" wire:model="facility_id">
                                            <option selected value="0">All</option>
                                            @forelse ($facilities as $facility)
                                                <option value='{{ $facility->id }}'>{{ $facility->name }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-2">
                                        <label for="study" class="form-label">Study</label>
                                        <select class="form-select" id="study" wire:model="study_id">
                                            <option selected value="0">All</option>
                                            @forelse ($studies as $study)
                                                <option value='{{ $study->id }}'>{{ $study->name }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-2">
                                        <label for="sampleType" class="form-label">Sample Type</label>
                                        <select class="form-select" id="sampleType" wire:model='sampleType'>
                                            <option selected value="0">All</option>
                                            @foreach ($sampleTypes as $sampleType)
                                                <option value='{{ $sampleType->id }}'>
                                                    {{ $sampleType->type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-2">
                                        <label for="test_id" class="form-label">Test</label>
                                        <select class="form-select" id="test_id" wire:model='test_id'>
                                            <option selected value="0">All</option>
                                            @foreach ($tests as $test)
                                                <option value='{{ $test->id }}'>
                                                    {{ $test->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3 col-md-2">
                                        <label for="performed_by" class="form-label">Performed By</label>
                                        <select class="form-select" id="performed_by" wire:model='performed_by'>
                                            @if (Auth::user()->hasPermission('manager-access|master-access'))
                                                <option selected value="0">All</option>
                                                @foreach ($users as $user)
                                                    <option value='{{ $user->id }}'>
                                                        {{ $user->fullName }}</option>
                                                @endforeach
                                            @else
                                                <option selected value="{{ auth()->user()->id }}">
                                                    {{ auth()->user()->fullName }}</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-2">
                                        <label for="reviewed_by" class="form-label">Reviewed By</label>
                                        <select class="form-select" id="reviewed_by" wire:model='reviewed_by'>
                                            <option selected value="0">All</option>
                                            @foreach ($users as $user)
                                                <option value='{{ $user->id }}'>
                                                    {{ $user->fullName }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-2">
                                        <label for="approved_by" class="form-label">Approved By</label>
                                        <select class="form-select" id="approved_by" wire:model='approved_by'>
                                            <option selected value="0">All</option>
                                            @foreach ($users as $user)
                                                <option value='{{ $user->id }}'>
                                                    {{ $user->fullName }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-2">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-select" id="status" wire:model='status'>
                                            <option selected value="0">All</option>
                                            <option value="Approved">Approved</option>
                                            <option value="Reviewed">Reviewed</option>
                                            <option value="Rejected">Rejected</option>
                                            <option value="Pending Review">Pending Review</option>
                                        </select>
                                    </div>

                                    <div class="mb-3 col-md-2">
                                        <label for="from_date" class="form-label">Start Date</label>
                                        <input id="from_date" type="date" class="form-control"
                                            wire:model="from_date">
                                    </div>
                                    <div class="mb-3 col-md-2">
                                        <label for="to_date" class="form-label">End Date</label>
                                        <input id="to_date" type="date" class="form-control"
                                            wire:model="to_date">
                                    </div>
                                    <div class="mb-3 col-md-1">
                                        <label for="perPage" class="form-label">Per Page</label>
                                        <select wire:model="perPage" class="form-select" id="perPage">
                                            <option value="10">10</option>
                                            <option value="20">20</option>
                                            <option value="30">30</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                            <option value="200">200</option>
                                            <option value="500">500</option>
                                            <option value="1000">1000</option>
                                        </select>
                                    </div>

                                    <div class="mb-3 col-md-1">
                                        <label for="orderBy" class="form-label">OrderBy</label>
                                        <select wire:model="orderBy" class="form-select">
                                            <option value="id">Latest</option>
                                            <option value="approved_at">Date Approved</option>
                                            <option value="reviewed_at">Date Reviewed</option>
                                            <option value="created_at">Result Date</option>
                                        </select>
                                    </div>

                                    <div class="mb-3 col-md-2">
                                        <label for="orderAsc" class="form-label">Order</label>
                                        <select wire:model="orderAsc" class="form-select" id="orderAsc">
                                            <option value="1">Asc</option>
                                            <option value="0">Desc</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- end row-->
                            </form>
                        </div>
                        @if (count($combinedResultsList) >= 2)
                            You have selected <strong class="text-success">{{ count($combinedResultsList) }}</strong>
                            Test Results(s) for the combined Result report (<a href="javascript:;"
                                class="text-danger fw-bold" wire:click="$set('combinedResultsList',[])">Clear All</a>)
                        @endif
                    </div>

                    <div class="tab-content">
                        <div class="table-responsive">
                            <table id="datableButton" class="table table-striped mb-0 w-100 sortable">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Sample</th>
                                        <th>Tracker</th>
                                        <th>Facility</th>
                                        <th>Study</th>
                                        <th>PID</th>
                                        <th>Sample</th>
                                        <th>Sample ID</th>
                                        <th>Lab No</th>
                                        <th>Test</th>
                                        <th>TAT(HR<->MIN)</th>
                                        <th>Requester</th>
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
                                                <a href="{{ URL::signedRoute('batch-search-results', ['sampleReception' => $testResult->sample->sampleReception->id]) }}"
                                                    class="text-secondary"
                                                    target="_blank">{{ $testResult->sample->sampleReception->batch_no }}
                                                </a>
                                            </td>
                                            <td>
                                                @if ($testResult->amended_state)
                                                    <a href="javascript:void(0)"
                                                        wire:click='viewAmended({{ $testResult->id }})'
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#amendedResults"><strong class="text-warning"
                                                            title="SHOW AMENDED">{{ $testResult->tracker }}</strong>
                                                    </a>
                                                @else
                                                    <a href="{{ URL::signedRoute('report-search-results', ['testResult' => $testResult->id]) }}"
                                                        target="_blank"><strong
                                                            class="text-info">{{ $testResult->tracker }}</strong>
                                                    </a>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $testResult->sample->sampleReception->facility->name ?? 'N/A' }}
                                            </td>
                                            <td>
                                                {{ $testResult->sample->study->name ?? 'N/A' }}
                                            </td>
                                            <td>
                                                <a href="{{ URL::signedRoute('participant-search-results', ['participant' => $testResult->sample->participant->id]) }}"
                                                    class="text-secondary"
                                                    target="_blank">{{ $testResult->sample->participant->identity }}
                                                </a>
                                            </td>

                                            <td>
                                                {{ $testResult->sample->sampleType->type }}
                                            </td>
                                            <td>
                                                {{ $testResult->sample->sample_identity }}
                                            </td>
                                            <td class="text-success fw-bold">
                                                {{ $testResult->sample->lab_no ?? 'N/A' }}
                                            </td>
                                            <td>
                                                {{ $testResult->test->name }}
                                                <input type="checkbox" value="{{ $testResult->id }}"
                                                    class="me-2 float-end" wire:model="combinedResultsList">
                                            </td>
                                            <td>
                                                <span
                                                    class="text-danger fw-bold">{{ $testResult->sample->sampleReception->date_delivered->diffInHours($testResult->created_at) }}</span>
                                                ({{ $testResult->sample->sampleReception->date_delivered->diffInMinutes($testResult->created_at) . 'min' }})
                                            </td>
                                            <td>
                                                {{ $testResult->sample->requester->name }}
                                            </td>
                                            <td>
                                                {{ $testResult->created_at }}
                                            </td>
                                            <td>
                                                <span class="badge bg-success">{{ $testResult->status }}</span>
                                            </td>
                                            <td class="action-ico">
                                                @if (Auth::user()->hasPermission(['view-participant-info']))
                                                    <a target="_blank"
                                                        href="{{ route('print-result-report', $testResult->id) }}"
                                                        type="button" data-bs-toggle="tooltip"
                                                        data-bs-placement="bottom" title=""
                                                        data-bs-original-title="Result Report"
                                                        class="action-ico btn btn-outline-info btn-sm"
                                                        wire:click='incrementDownloadCount({{ $testResult->id }})'><i
                                                            class="bi bi-printer"></i>
                                                        <small
                                                            class="badge bg-info">{{ $testResult->download_count }}</small>
                                                    </a>
                                                @else
                                                    NA
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div> <!-- end preview-->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="btn-group float-end">
                                    {{ $testResults->links() }}
                                </div>
                            </div>
                        </div>
                    </div> <!-- end tab-content-->
                </div> <!-- end card body-->
            </div> <!-- end card -->


            {{-- VIEW amendement details modal --}}
            @include('livewire.lab.lists.show-amended-results')
            <!-- end modal dialog-->
        </div> <!-- end modal-->


    </div><!-- end col-->

</div>
@push('scripts')
    <script>
        window.addEventListener('loadCombinedTestResultsReport', event => {
            window.open(`${event.detail.url}`, '_blank').focus();
        });
    </script>
@endpush
</div>
