<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="mb-2 mb-sm-0">
                                    <h6 class="modal-title" id="staticBackdropLabel">Attach Test Results For Sample (<span
                                            class="text-info">{{ $sample_identity }}</span>) with Lab_No <span
                                            class="text-info">{{ $lab_no }}</span></h6>
                                </h5>
                                <div class="ms-auto">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-outline-info">More...</button>
                                        <button type="button"
                                            class="btn btn-outline-info split-bg-primary dropdown-toggle dropdown-toggle-split"
                                            data-bs-toggle="dropdown"> <span class="visually-hidden">Toggle
                                                Dropdown</span>
                                        </button>

                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
                                            <a class="dropdown-item" href="javascript:;" wire:click="close()">Reset
                                                form</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if (!$testsRequested->isEmpty())
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped mb-0 w-100">
                                    <thead>
                                        <tr>
                                            <th>{{ auth()->user()->laboratory->laboratory_name }}</th>
                                            <th>SOURCE FACILITY</th>
                                            <th>SAMPLE DATA</th>
                                            <th>PARTICIPANT</th>
                                            @if ($active_referral)
                                                <th>REFERRED TO</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <strong class="text-inverse">Entry Type: </strong>
                                                {{ $sample->participant->entry_type }}<br>
                                                <strong class="text-inverse">Entry Date:
                                                </strong>{{ date('d-m-Y H:i', strtotime($sample->participant->created_at ?? 'NA')) }}<br>
                                                <strong class="text-inverse">Sample Count:
                                                </strong>{{ $sample->participant->sample_count ?? 'N/A' }}<br>
                                                <strong class="text-inverse">Test Count:
                                                </strong>{{ $sample->participant->test_result_count ?? 'N/A' }}
                                            </td>
                                            <td>
                                                <strong class="text-inverse">Name: </strong>
                                                {{ $sample->participant->facility->name ?? 'N/A' }}<br>
                                                <strong class="text-inverse">Study: </strong>
                                                {{ $sample->participant->study->name ?? 'N/A' }}
                                            </td>
                                            <td>
                                                <strong class="text-inverse">Sample Id: </strong>
                                                {{ $sample->sample_identity ?? 'N/A' }}<br>
                                                <strong class="text-inverse">Lab No: </strong>
                                                {{ $sample->lab_no ?? 'N/A' }}<br>
                                                <strong class="text-inverse">Collection Date: </strong>
                                                {{ $sample->date_collected ?? 'N/A' }}<br>
                                                <strong class="text-inverse">Request Date: </strong>
                                                {{ $sample->date_requested ?? 'N/A' }}
                                            </td>
                                            <td>
                                                <strong class="text-inverse">Participant ID:
                                                </strong>{{ $sample->participant->identity ?? 'N/A' }}<br>
                                                <strong class="text-inverse">Age:
                                                </strong>
                                                @if ($sample->participant->age != null)
                                                    {{ $sample->participant->age }}yrs &nbsp;
                                                @elseif ($sample->participant->months != null)
                                                    {{ $sample->participant->months }}months
                                                @else
                                                    N/A
                                                @endif
                                                </strong>{{ $sample->participant->gender ?? 'N/A' }}<br>
                                                <strong class="text-inverse">Contact:
                                                </strong>{{ $sample->participant->contact ?? 'N/A' }}<br>
                                                <strong class="text-inverse">Address:
                                                </strong>{{ $sample->participant->address ?? 'N/A' }}<br>
                                                <strong class="text-inverse">Kin Contact:
                                                </strong>{{ $sample->participant->nok_contact ?? 'N/A' }}
                                            </td>

                                            @if ($active_referral)
                                                <td>
                                                    <strong class="text-inverse">Name: </strong>
                                                    {{ $active_referral->referralable->name ?? ($active_referral->referralable->laboratory_name ?? 'N/A') }}<br>
                                                </td>
                                            @endif
                                        </tr>
                                        @if ($sample->participant->clinical_notes)
                                            <tr>
                                                <td colspan="5">
                                                    <strong class="text-inverse">Clinical Notes
                                                    </strong>
                                                    <p>{{ $sample->participant->clinical_notes }}</p>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-12 mb-0">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0 w-100">
                                        <thead>
                                            <tr>
                                                <th>Test Requested</th>
                                                <th>Results and Comments</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($testsRequested as $test)
                                                <tr>
                                                    <td>
                                                        <a href="javascript: void(0);" class="action-ico"
                                                            wire:click="activateResultInput({{ $test->id }})"><strong
                                                                class="text-success">{{ $test->name }}
                                                            </strong></a>
                                                    </td>
                                                    <td>
                                                        @if ($test->id === $test_id)
                                                            <form wire:submit.prevent="storeTestResults('Main')"
                                                                class="me-2">

                                                                {{-- PRELIMINARY TESTS SECTION --}}
                                                           {{-- PRELIMINARY TESTS SECTION with Individual Save --}}
@if ($showPreliminarySection && $preliminaryTests->count() > 0)
    <div class="row">
        <hr>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="text-primary mb-0">
                <i class="bi bi-clipboard-check"></i> Preliminary Tests (Optional)
            </h6>
            @if($savedPreliminaryResults->count() > 0)
                <span class="badge bg-success">
                    {{ $savedPreliminaryResults->count() }} Saved
                </span>
            @endif
        </div>

        <div class="col-md-12">
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> Select and enter results for preliminary tests.
                <strong>Each test can be saved independently</strong> as soon as it's completed.
            </div>
        </div>

        {{-- Show Already Saved Preliminary Tests --}}
        @if($savedPreliminaryResults->count() > 0)
            <div class="col-md-12 mb-3">
                <div class="card border-success">
                    <div class="card-header bg-success text-white">
                        <i class="bi bi-check-circle"></i> Saved Preliminary Tests
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Test Name</th>
                                        <th>Result</th>
                                        <th>Comment</th>
                                        <th>Performed By</th>
                                        <th>Saved At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($savedPreliminaryResults as $saved)
                                        <tr>
                                            <td>
                                                <i class="bi bi-check-circle-fill text-success"></i>
                                                <strong>{{ $saved->test->name }}</strong>
                                            </td>
                                            <td><span class="badge bg-info">{{ $saved->result }}</span></td>
                                            <td>{{ $saved->comment ?? '-' }}</td>
                                            <td>{{ $saved->performer->fullName ?? 'N/A' }}</td>
                                            <td>{{ $saved->created_at }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Select Available Preliminary Tests --}}
        <div class="col-md-12 mb-3">
            <label class="form-label fw-bold">Select Preliminary Tests to Perform</label>
            <div class="row">
                @foreach ($preliminaryTests as $prelimTest)
                    @php
                        $isAlreadySaved = in_array($prelimTest->id, $savedPreliminaryTests ?? []);
                    @endphp
                    <div class="col-md-3 mb-2">
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                value="{{ $prelimTest->id }}"
                                wire:model="selectedPreliminaryTests"
                                id="prelim_{{ $prelimTest->id }}"
                                {{ $isAlreadySaved ? 'disabled' : '' }}>
                            <label class="form-check-label {{ $isAlreadySaved ? 'text-muted' : '' }}"
                                   for="prelim_{{ $prelimTest->id }}">
                                {{ $prelimTest->name }}
                                @if($isAlreadySaved)
                                    <i class="bi bi-check-circle-fill text-success ms-1"></i>
                                @endif
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Enter Results for Selected Tests --}}
        @if (!empty($selectedPreliminaryTests))
            <div class="col-md-12">
                <h6 class="text-secondary mb-3">
                    <i class="bi bi-pencil-square"></i> Enter Results for Selected Tests
                </h6>

                @foreach ($selectedPreliminaryTests as $prelimTestId)
                    @php
                        $prelimTest = $preliminaryTests->firstWhere('id', $prelimTestId);
                        $isAlreadySaved = in_array($prelimTestId, $savedPreliminaryTests ?? []);
                    @endphp

                    @if(!$isAlreadySaved)
                        <div class="card mb-3 border-primary">
                            <div class="card-header bg-light">
                                <strong class="text-primary">
                                    <i class="bi bi-flask"></i> {{ $prelimTest->name }}
                                </strong>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    {{-- Result Input --}}
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Result <span class="text-danger">*</span></label>
                                        @if ($prelimTest->result_type == 'Absolute')
                                            <select class="form-select"
                                                wire:model="preliminaryTestResults.{{ $prelimTestId }}.result" required>
                                                <option value="">Select Result</option>
                                                @foreach ($prelimTest->absolute_results as $result)
                                                    <option value="{{ $result }}">{{ $result }}</option>
                                                @endforeach
                                            </select>
                                        @elseif($prelimTest->result_type == 'Measurable')
                                            <div class="input-group">
                                                <input type="number" step="0.001" class="form-control"
                                                    wire:model="preliminaryTestResults.{{ $prelimTestId }}.result"
                                                    placeholder="Enter value" required>
                                                <span class="input-group-text">{{ $prelimTest->measurable_result_uom }}</span>
                                            </div>
                                        @else
                                            <input type="text" class="form-control"
                                                wire:model="preliminaryTestResults.{{ $prelimTestId }}.result"
                                                placeholder="Enter result" required>
                                        @endif
                                    </div>

                                    {{-- Comment --}}
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Comment</label>
                                        <textarea class="form-control" rows="2"
                                            wire:model="preliminaryTestResults.{{ $prelimTestId }}.comment"
                                            placeholder="Optional comment"></textarea>
                                    </div>

                                    {{-- Performed By --}}
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Performed By <span class="text-danger">*</span></label>
                                        <select class="form-select"
                                            wire:model="preliminaryTestResults.{{ $prelimTestId }}.performed_by" required>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->fullName }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Supporting Document --}}
                                    <div class="col-md-12 mt-3">
                                        <label class="form-label fw-semibold">
                                            <i class="bi bi-paperclip"></i> Supporting Document <span class="text-muted small">(Optional)</span>
                                        </label>
                                        <input type="file" class="form-control"
                                            wire:model="preliminaryTestResults.{{ $prelimTestId }}.result_supporting_document"
                                            accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                        <div class="form-text small">Upload any supporting evidence for this preliminary test</div>
                                    </div>

                                    {{-- Save Button --}}
                                    <div class="col-md-12 mt-3">
                                        <div class="d-flex justify-content-end">
                                            <button type="button"
                                                class="btn btn-success"
                                                wire:click="savePreliminaryTest({{ $prelimTestId }})"
                                                wire:loading.attr="disabled">
                                                <span wire:loading.remove wire:target="savePreliminaryTest({{ $prelimTestId }})">
                                                    <i class="bi bi-save"></i> Save {{ $prelimTest->name }} Result
                                                </span>
                                                <span wire:loading wire:target="savePreliminaryTest({{ $prelimTestId }})">
                                                    <span class="spinner-border spinner-border-sm" role="status"></span>
                                                    Saving...
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif

        {{-- Warning if unsaved tests --}}
        @if(!empty($selectedPreliminaryTests))
            <div class="col-md-12">
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle"></i>
                    <strong>Important:</strong> Please save each preliminary test individually before submitting the main test result.
                </div>
            </div>
        @endif
    </div>
    <hr>
@endif

                                                                {{-- MAIN TEST RESULTS --}}
                                                                <div class="row">
                                                                    <hr>
                                                                    <h6 class="text-primary">Main Test Result</h6>

                                                                    @if ($test->result_type == 'Multiple')
                                                                        <div class="col-12">
                                                                            <div class="row">
                                                                                @foreach ($test->sub_tests as $key => $sub_test)
                                                                                    <div class="col-md-3">
                                                                                        <div class="mb-2">
                                                                                            <input class="form-label"
                                                                                                type="text"
                                                                                                style="border: none; outline: none; background-color: transparent;"
                                                                                                readonly
                                                                                                wire:model="testResults.{{ $key }}.test"
                                                                                                required
                                                                                                value="{{ $sub_test }}">
                                                                                            <input type="text"
                                                                                                required
                                                                                                class="form-control"
                                                                                                wire:model="testResults.{{ $key }}.result"
                                                                                                placeholder="{{ $sub_test }} results">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-2">
                                                                                        <div class="mb-2">
                                                                                            <label
                                                                                                class="form-label">Ct
                                                                                                Value</label>
                                                                                            <input type="text"
                                                                                                class="form-control"
                                                                                                wire:model="testResults.{{ $key }}.CtValue"
                                                                                                placeholder="Ct Value">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-7">
                                                                                        <div class="mb-2">
                                                                                            <label
                                                                                                class="form-label">{{ $sub_test }}
                                                                                                Comment</label>
                                                                                            <textarea type="text" class="form-control" wire:model="testResults.{{ $key }}.comment"
                                                                                                placeholder="Enter {{ $sub_test }} comments"></textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                        <div class="col-md-5">
                                                                            @if ($test->result_type == 'Absolute')
                                                                                <div class="mb-2">
                                                                                    <label
                                                                                        class="form-label">Result</label>
                                                                                    <select class="form-select"
                                                                                        id="result"
                                                                                        wire:model.lazy="result">
                                                                                        <option selected
                                                                                            value="">Select
                                                                                        </option>
                                                                                        @foreach ($test->absolute_results as $result)
                                                                                            <option
                                                                                                value='{{ $result }}'>
                                                                                                {{ $result }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                    @error('result')
                                                                                        <div
                                                                                            class="text-danger text-small">
                                                                                            {{ $message }}</div>
                                                                                    @enderror
                                                                                </div>
                                                                            @elseif($test->result_type == 'Text')
                                                                                <div class="mb-2">
                                                                                    <label
                                                                                        class="form-label">Result</label>
                                                                                    <textarea rows="2" class="form-control" placeholder="{{ __('Enter Free text Results') }}"
                                                                                        wire:model.lazy="result"></textarea>
                                                                                    @error('result')
                                                                                        <div
                                                                                            class="text-danger text-small">
                                                                                            {{ $message }}</div>
                                                                                    @enderror
                                                                                </div>
                                                                            @elseif($test->result_type == 'Measurable')
                                                                                <div class="mb-2">
                                                                                    <div class="form-group">
                                                                                        <label
                                                                                            class="form-label">Result</label>
                                                                                        <div
                                                                                            class="input-group form-group mb-2">
                                                                                            <input type="number"
                                                                                                step="0.001"
                                                                                                class="form-control"
                                                                                                id="result"
                                                                                                wire:model.lazy='result'>
                                                                                            <div
                                                                                                class="input-group-append">
                                                                                                <span
                                                                                                    class="input-group-text">
                                                                                                    {{ $test->measurable_result_uom }}
                                                                                                </span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    @error('result')
                                                                                        <div
                                                                                            class="text-danger text-small">
                                                                                            {{ $message }}</div>
                                                                                    @enderror
                                                                                </div>
                                                                            @elseif($test->result_type == 'File')
                                                                                <div class="mb-2">
                                                                                    <label class="form-label">Result
                                                                                        Attachment</label>
                                                                                    <input type="file"
                                                                                        class="form-control"
                                                                                        wire:model="attachment"
                                                                                        placeholder="Attach file">
                                                                                    @error('attachment')
                                                                                        <div
                                                                                            class="text-danger text-small">
                                                                                            {{ $message }}</div>
                                                                                    @enderror
                                                                                </div>
                                                                            @elseif($test->result_type == 'Link')
                                                                                <div class="mb-2">
                                                                                    <label class="form-label">Result
                                                                                        Link(URL)</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        wire:model.lazy="link"
                                                                                        placeholder="Enter valid link">
                                                                                    @error('link')
                                                                                        <div
                                                                                            class="text-danger text-small">
                                                                                            {{ $message }}</div>
                                                                                    @enderror
                                                                                </div>
                                                                            @endif

                                                                        </div>

                                                                        <div class="col-md-4">
                                                                            <div class="mb-2">
                                                                                <label
                                                                                    class="form-label">Comment</label>
                                                                                @if ($test->comments != null)
                                                                                    <select class="form-select"
                                                                                        id="comment"
                                                                                        wire:model="comment">
                                                                                        <option selected
                                                                                            value="">Select
                                                                                        </option>
                                                                                        @foreach ($test->comments as $comment)
                                                                                            <option
                                                                                                value='{{ $comment }}'>
                                                                                                {{ $comment }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                @else
                                                                                    <textarea wire:model.lazy="comment" rows="2" class="form-control" placeholder="{{ __('comment') }}"></textarea>
                                                                                @endif
                                                                                @error('comment')
                                                                                    <div class="text-danger text-small">
                                                                                        {{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                    @endif

                                                                    <div class="col-md-3">
                                                                        <div class="mb-2">
                                                                            <label class="form-label">Performed
                                                                                By</label>
                                                                            <select class="form-select"
                                                                                wire:model="performed_by">
                                                                                <option selected value="">Select
                                                                                </option>
                                                                                @foreach ($users as $user)
                                                                                    <option
                                                                                        value='{{ $user->id }}'>
                                                                                        {{ $user->fullName }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            @error('performed_by')
                                                                                <div class="text-danger text-small">
                                                                                    {{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                {{-- PARAMETERS --}}
                                                                @if ($test->parameters != null)
                                                                    <div class="row">
                                                                        <hr>
                                                                        <h6>Parameters</h6>
                                                                        @foreach ($test->parameters as $parameter)
                                                                            <div class="col-md-4">
                                                                                <div class="mb-2">
                                                                                    <label
                                                                                        class="form-label">{{ $parameter }}</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        wire:model.lazy="testParameters.{{ $parameter }}"
                                                                                        placeholder="Enter parameter value">
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                        @error('testParameters')
                                                                            <div class="text-danger text-small">
                                                                                {{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                @endif

                                                                <div class="row">
                                                                    <!-- QC Attachment Section -->
                                                                    @if ($test->result_type != 'File')
                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label fw-semibold">
                                                                                <i
                                                                                    class="bi bi-paperclip me-1"></i>Result
                                                                                Supporting Document
                                                                                <span
                                                                                    class="text-muted small">(Optional)</span>
                                                                            </label>
                                                                            <div class="input-group">
                                                                                <input type="file"
                                                                                    class="form-control @error('result_supporting_document') is-invalid @enderror"
                                                                                    wire:model="result_supporting_document"
                                                                                    accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png"
                                                                                    aria-label="Upload QC document">
                                                                                <button
                                                                                    class="btn btn-outline-secondary"
                                                                                    type="button"
                                                                                    data-bs-toggle="tooltip"
                                                                                    title="Upload QC evidence or supporting documents">
                                                                                    <i
                                                                                        class="bi bi-question-circle"></i>
                                                                                </button>
                                                                            </div>
                                                                            <div class="form-text small">Upload QC
                                                                                charts, calibration certificates, or
                                                                                other supporting documents</div>
                                                                            @error('result_supporting_document')
                                                                                <div class="invalid-feedback d-block">
                                                                                    <i
                                                                                        class="bi bi-exclamation-triangle"></i>
                                                                                    {{ $message }}
                                                                                </div>
                                                                            @enderror
                                                                        </div>
                                                                    @endif

                                                                    <!-- QC First-Pass Performance -->
                                                                    <div class="col-md-6 mb-3">
                                                                        <label
                                                                            class="form-label fw-semibold d-flex align-items-center">
                                                                            <i
                                                                                class="bi bi-check-circle me-2"></i>First-Pass
                                                                            QC Acceptance
                                                                            <span class="badge bg-info ms-2"
                                                                                data-bs-toggle="tooltip"
                                                                                title="Indicates if QC passed on initial attempt">?</span>
                                                                        </label>
                                                                        <div class="btn-group w-100" role="group">
                                                                            <input type="radio" class="btn-check"
                                                                                wire:model="qc_first_pass_accepted"
                                                                                id="qc_first_pass_accepted_yes"
                                                                                value="1" autocomplete="off">
                                                                            <label class="btn btn-outline-success"
                                                                                for="qc_first_pass_accepted_yes">
                                                                                <i
                                                                                    class="bi bi-check-lg me-1"></i>Accepted
                                                                            </label>

                                                                            <input type="radio" class="btn-check"
                                                                                wire:model="qc_first_pass_accepted"
                                                                                id="qc_first_pass_accepted_no"
                                                                                value="0" autocomplete="off">
                                                                            <label class="btn btn-outline-danger"
                                                                                for="qc_first_pass_accepted_no">
                                                                                <i class="bi bi-x-lg me-1"></i>Rejected
                                                                            </label>
                                                                        </div>
                                                                        <div class="form-text small">
                                                                            <span class="text-success"
                                                                                wire:loading.remove
                                                                                wire:target="qc_first_pass_accepted">
                                                                                <span wire:loading.class="d-none">
                                                                                    @if ($qc_first_pass_accepted == 1)
                                                                                        <i
                                                                                            class="bi bi-check-circle-fill text-success"></i>
                                                                                        QC accepted on first attempt
                                                                                    @elseif($qc_first_pass_accepted == 0)
                                                                                        <i
                                                                                            class="bi bi-exclamation-triangle-fill text-warning"></i>
                                                                                        QC required re-analysis
                                                                                    @endif
                                                                                </span>
                                                                            </span>
                                                                            <span class="text-muted" wire:loading
                                                                                wire:target="qc_first_pass_accepted">
                                                                                <i class="bi bi-arrow-repeat spin"></i>
                                                                                Updating...
                                                                            </span>
                                                                        </div>
                                                                    </div>

                                                                    <!-- QC Application Scope -->
                                                                    <div class="col-md-6 mb-3">
                                                                        <label class="form-label fw-semibold">
                                                                            <i class="bi bi-layers me-1"></i>QC
                                                                            Application Scope
                                                                        </label>
                                                                        <select
                                                                            class="form-select @error('qc_application_scope') is-invalid @enderror"
                                                                            wire:model="qc_application_scope">
                                                                            <option value="">
                                                                                Select QC scope...</option>
                                                                                <option value="sample">Sample Level QC</option>
                                                                            <option value="batch">Batch Level QC</option>
                                                                            <option value="run">Run Level QC
                                                                            </option>
                                                                            <option value="instrument">Instrument QC
                                                                            </option>
                                                                        </select>
                                                                        <div class="form-text small">Defines whether QC
                                                                            applies to entire batch or individual
                                                                            samples</div>
                                                                        @error('qc_application_scope')
                                                                            <div class="invalid-feedback d-block">
                                                                                {{ $message }}</div>
                                                                        @enderror
                                                                    </div>

                                                                    <!-- Conditional Field: QC Attempt Count -->
                                                                    @if ($qc_first_pass_accepted == 0)
                                                                        <div class="col-md-6 mb-3">
                                                                            <div class="card border-warning">
                                                                                <div class="card-body">
                                                                                    <label
                                                                                        class="form-label fw-semibold text-warning">
                                                                                        <i
                                                                                            class="bi bi-exclamation-triangle me-1"></i>QC
                                                                                        Attempt Details
                                                                                    </label>
                                                                                    <div class="row">
                                                                                        <div class="col-6">
                                                                                            <label
                                                                                                class="form-label small">Total
                                                                                                Attempts</label>
                                                                                            <input type="number"
                                                                                                class="form-control form-control-sm @error('qc_total_attempts') is-invalid @enderror"
                                                                                                wire:model="qc_total_attempts"
                                                                                                min="2"
                                                                                                max="10"
                                                                                                placeholder="e.g., 2">
                                                                                            @error('qc_total_attempts')
                                                                                                <div
                                                                                                    class="invalid-feedback">
                                                                                                    {{ $message }}
                                                                                                </div>
                                                                                            @enderror
                                                                                        </div>
                                                                                        <div class="col-6">
                                                                                            <label
                                                                                                class="form-label small">Final
                                                                                                Attempt Time</label>
                                                                                            <div
                                                                                                class="input-group input-group-sm">
                                                                                                <input type="number"
                                                                                                    class="form-control @error('qc_final_attempt_time') is-invalid @enderror"
                                                                                                    wire:model="qc_final_attempt_time"
                                                                                                    min="1"
                                                                                                    placeholder="Minutes">
                                                                                                <span
                                                                                                    class="input-group-text">min</span>
                                                                                            </div>
                                                                                            <div
                                                                                                class="form-text small">
                                                                                                Time when QC finally
                                                                                                passed</div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="mt-2">
                                                                                        <label
                                                                                            class="form-label small">QC
                                                                                            Failure Reason</label>
                                                                                        <select
                                                                                            class="form-select form-select-sm"
                                                                                            wire:model="qc_failure_reason">
                                                                                            <option value=""
                                                                                                selected>Select
                                                                                                reason...</option>
                                                                                            <option
                                                                                                value="out_of_range">
                                                                                                Out of Control Range
                                                                                            </option>
                                                                                            <option
                                                                                                value="instrument_error">
                                                                                                Instrument Error
                                                                                            </option>
                                                                                            <option
                                                                                                value="operator_error">
                                                                                                Operator Error</option>
                                                                                            <option
                                                                                                value="reagent_issue">
                                                                                                Reagent Issue</option>
                                                                                            <option
                                                                                                value="calibration">
                                                                                                Calibration Required
                                                                                            </option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endif

                                                                    <!-- Conditional Field: Batch Information -->
                                                                    @if ($qc_application_scope == 'batch')


                                                                        <!-- Batch QC Details -->
                                                                        <div class="col-12">
                                                                            <div class="card">
                                                                                <div class="card-header bg-light">
                                                                                    <h6 class="mb-0">
                                                                                        <i
                                                                                            class="bi bi-clipboard-data me-2"></i>Batch
                                                                                        QC Summary
                                                                                    </h6>
                                                                                </div>
                                                                                <div class="card-body">
                                                                                    <div class="row">
                                                                                           <div class="col-md-6 mb-3">
                                                                            <label class="form-label fw-semibold">
                                                                                <i
                                                                                    class="bi bi-upc-scan me-1"></i>Batch
                                                                                Identification
                                                                            </label>
                                                                            <div class="input-group">
                                                                                <span class="input-group-text">
                                                                                    <i class="bi bi-tags"></i>
                                                                                </span>
                                                                                <input type="text"
                                                                                    class="form-control @error('batch_identifier') is-invalid @enderror"
                                                                                    wire:model="batch_identifier"
                                                                                    placeholder="Enter batch ID or number">
                                                                                <button
                                                                                    class="btn btn-outline-secondary"
                                                                                    type="button"
                                                                                    wire:click="$emit('generateBatchId')"
                                                                                    data-bs-toggle="tooltip"
                                                                                    title="Generate batch ID">
                                                                                    <i class="bi bi-arrow-repeat"></i>
                                                                                </button>
                                                                            </div>
                                                                            <div class="form-text small">
                                                                                @if ($batch_identifier)
                                                                                    <span class="text-success">
                                                                                        <i
                                                                                            class="bi bi-check-circle-fill"></i>
                                                                                        Batch ID:
                                                                                        {{ $batch_identifier }}
                                                                                    </span>
                                                                                @else
                                                                                    Enter or generate batch identifier
                                                                                @endif
                                                                            </div>
                                                                            @error('batch_identifier')
                                                                                <div class="invalid-feedback d-block">
                                                                                    {{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                                        <div class="col-md-6">
                                                                                            <label
                                                                                                class="form-label small">QC
                                                                                                Samples in Batch</label>
                                                                                            <input type="number"
                                                                                                class="form-control form-control-sm"
                                                                                                wire:model="batch_qc_samples_count"
                                                                                                min="1"
                                                                                                placeholder="# of QC samples">
                                                                                        </div>

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endif

                                                                    <!-- QC Status Summary -->
                                                                    <div class="col-12">
                                                                        <div
                                                                            class="alert
                                                                    @if ($qc_first_pass_accepted == 1) alert-success
                                                                    @elseif($qc_first_pass_accepted == 0) alert-warning
                                                                    @else alert-light @endif">
                                                                            <div class="d-flex align-items-center">
                                                                                <div class="flex-grow-1">
                                                                                    <h6 class="alert-heading mb-1">
                                                                                        @if ($qc_first_pass_accepted == 1)
                                                                                            <i
                                                                                                class="bi bi-check-circle-fill me-2"></i>QC
                                                                                            Status: Accepted
                                                                                        @elseif($qc_first_pass_accepted == 0)
                                                                                            <i
                                                                                                class="bi bi-exclamation-triangle-fill me-2"></i>QC
                                                                                            Status: Requires Attention
                                                                                        @else
                                                                                            <i
                                                                                                class="bi bi-info-circle-fill me-2"></i>QC
                                                                                            Status: Pending
                                                                                        @endif
                                                                                    </h6>
                                                                                    <p class="mb-0 small">
                                                                                        @if ($qc_application_scope)
                                                                                            QC applied at
                                                                                            <strong>{{ ucfirst($qc_application_scope) }}</strong>
                                                                                            level
                                                                                        @endif
                                                                                        @if ($qc_first_pass_accepted == 0 && $qc_total_attempts)
                                                                                            • Required
                                                                                            {{ $qc_total_attempts }}
                                                                                            attempt(s)
                                                                                        @endif
                                                                                    </p>
                                                                                </div>
                                                                                {{-- <div>
                                                                                    <button type="button" class="btn btn-sm btn-outline-secondary"
                                                                                            data-bs-toggle="modal" data-bs-target="#qcHistoryModal">
                                                                                        <i class="bi bi-clock-history me-1"></i>View History
                                                                                    </button>
                                                                                </div> --}}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <hr class="my-4">
                                                                {{-- KIT USED INFO --}}

                                                                <div class="row">

                                                                    <h6>Kit Used</h6>

                                                                    <div class="col-md-4">
                                                                        <div class="mb-2">
                                                                            <label class="form-label">Kit</label>
                                                                            <select class="form-select select2"
                                                                                data-model="kit_id" id="kit_id"
                                                                                wire:model="kit_id">
                                                                                <option selected value="">Select
                                                                                </option>
                                                                                @foreach ($kits as $kit)
                                                                                    <option
                                                                                        value='{{ $kit->id }}'>
                                                                                        {{ $kit->name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            @error('kit_id')
                                                                                <div class="text-danger text-small">
                                                                                    {{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <div class="mb-2">
                                                                            <label class="form-label">Verified Kit
                                                                                Lot</label>
                                                                            <input wire:model.lazy="verified_lot"
                                                                                class="form-control"
                                                                                placeholder="{{ __('verified lot') }}">
                                                                            @error('verified_lot')
                                                                                <div class="text-danger text-small">
                                                                                    {{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <div class="mb-2">
                                                                            <label class="form-label">Kit Expiry
                                                                                Date</label>
                                                                            <input type="date"
                                                                                name="kit_expiry_date"
                                                                                class="form-control"
                                                                                id="kit_expiry_date"
                                                                                wire:model="kit_expiry_date">
                                                                            @error('kit_expiry_date')
                                                                                <div class="text-danger text-small">
                                                                                    {{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                    </div>

                                                                    @if ($test->tat > 0 && $tatHours > $test->tat)
                                                                        <div class="col-md-12">
                                                                            <div class="mb-2">
                                                                                <label class="form-label">Reason why
                                                                                    the result is outside the TAT
                                                                                    <small class="text-danger">
                                                                                        The test was requested on
                                                                                        {{ $sample->sampleReception->date_delivered ?? $sample->date_requested }}
                                                                                        and the TAT for this test is
                                                                                        {{ $test->tat }} hours but
                                                                                        the current TAT is
                                                                                        {{ $tatHours }} hours
                                                                                    </small>
                                                                                </label>
                                                                                <textarea wire:model.lazy="tat_comment" id="tat_comment" required class="form-control"></textarea>
                                                                                @error('tat_comment')
                                                                                    <div class="text-danger text-small">
                                                                                        {{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                    @endif

                                                                    @if ($active_referral)
                                                                        <div class="row">
                                                                            <hr>
                                                                            <h6>Referral Information</h6>
                                                                            @if ($test->result_type != 'File')
                                                                                <div class="col-md-4">
                                                                                    <div class="mb-2">
                                                                                        <label
                                                                                            class="form-label">Result
                                                                                            File</label>
                                                                                        <input type="file"
                                                                                            wire:model="ref_result_file"
                                                                                            class="form-control">
                                                                                        @error('ref_result_file')
                                                                                            <div
                                                                                                class="text-danger text-small">
                                                                                                {{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                            <div class="col-md-4">
                                                                                <div class="mb-2">
                                                                                    <label class="form-label">Received
                                                                                        On</label>
                                                                                    <input type="date"
                                                                                        wire:model.lazy="received_date"
                                                                                        class="form-control">
                                                                                    @error('received_date')
                                                                                        <div
                                                                                            class="text-danger text-small">
                                                                                            {{ $message }}</div>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md">
                                                                                <div class="mb-2">
                                                                                    <label class="form-label">Referral
                                                                                        Comments</label>
                                                                                    <textarea wire:model="ref_comments" id="ref_comments" class="form-control"></textarea>
                                                                                    @error('ref_comments')
                                                                                        <div
                                                                                            class="text-danger text-small">
                                                                                            {{ $message }}</div>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <x-button
                                                                        class="me-0">{{ __('Save') }}</x-button>
                                                                </div>
                                                            </form>
                                                        @else
                                                            <p>Please click Test to enter Result</p>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <hr>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> No pending tests for this sample
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        @include('livewire.layout.select-2')
    @endpush
</div>
