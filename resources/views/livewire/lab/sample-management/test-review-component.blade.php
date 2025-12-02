<div>
    <div class="row">
        @if (!$viewReport)
            <div class="col-12">
                <div class="card">
                    <div class="card-header pt-0">
                        <div class="row mb-2">
                            <div class="col-sm-12 mt-3">
                                <div class="d-sm-flex align-items-center">
                                    <h5 class="mb-2 mb-sm-0">
                                        Test Result Reviews
                                    </h5>
                                    <div class="ms-auto">
                                        <a type="button" class="btn btn-outline-info" wire:click="refresh()"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                            data-bs-original-title="Refresh Table"><i
                                                class="bi bi-arrow-clockwise"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @include('livewire.partials.filter-tests')
                        <x-table-utilities display='d-block'>
                            <div>
                                <div class="d-flex align-items-center ml-4 me-2">
                                    <label for="orderBy" class="text-nowrap mr-2 mb-0">OrderBy</label>
                                    <select wire:model="orderBy" class="form-select">
                                        <option value="id">Latest</option>
                                    </select>
                                </div>
                            </div>
                        </x-table-utilities>
                        <div class="tab-content">
                            <div class="table-responsive">
                                <table id="datableButton" class="table table-striped mb-0 w-100 sortable">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Batch</th>
                                            <th>Tracker</th>
                                            <th>Study</th>
                                            <th>PID</th>
                                            <th>Sample</th>
                                            <th>Lab No.</th>
                                            <th>Test</th>
                                            <th>TAT(HR<->MIN)</th>
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
                                            @php
                                                $preliminaryResults = $testResult->getPreliminaryTestResults();
                                                $hasPreliminary = $preliminaryResults->isNotEmpty();
                                            @endphp
                                            
                                            <tr class="
                                                @if (
                                                    $testResult->test->tat != 0 &&
                                                    $testResult->sample->created_at->diffInHours($testResult->created_at) > $testResult->test->tat
                                                ) bg-light-danger @endif
                                            ">
                                                <td>
                                                    {{ $key + 1 }}
                                                    @if($hasPreliminary)
                                                        <button type="button" 
                                                                class="btn btn-xs btn-link p-0 ms-1 toggle-preliminary" 
                                                                data-target="preliminary-{{ $testResult->id }}"
                                                                title="Click to show/hide preliminary tests">
                                                            <i class="bi bi-chevron-down"></i>
                                                        </button>
                                                    @endif
                                                </td>

                                                <td>
                                                    <a href="{{ URL::signedRoute('batch-search-results', ['sampleReception' => $testResult->sample->sampleReception->id]) }}"
                                                        class="text-secondary"
                                                        target="_blank">{{ $testResult->sample->sampleReception->batch_no }}
                                                    </a>
                                                </td>
                                                <td>
                                                    @if ($testResult->amended_state)
                                                        <a href="{{ route('print-original-report', $testResult->id) }}"
                                                            target="_blank"><strong class="text-warning"
                                                                title="AMENDED">{{ $testResult->tracker }}</strong>
                                                        </a>
                                                    @else
                                                        <a href="{{ URL::signedRoute('report-search-results', ['testResult' => $testResult->id]) }}"
                                                            target="_blank"><strong
                                                                class="text-info">{{ $testResult->tracker }}</strong>
                                                        </a>
                                                    @endif
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
                                                    {{ $testResult->sample->lab_no ?? '' }}
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        <a href="{{ route('result-report', $testResult->id) }}"
                                                            type="button" 
                                                            class="text-info fw-bold">{{ $testResult->test->name }}</a>
                                                        
                                                        @if($hasPreliminary)
                                                            <small class="text-muted">
                                                                <i class="bi bi-clipboard-check text-primary"></i> 
                                                                {{ $preliminaryResults->count() }} preliminary
                                                            </small>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <span
                                                        class="text-danger fw-bold">{{ $testResult->sample->created_at->diffInHours($testResult->created_at) }}</span>
                                                    ({{ $testResult->sample->created_at->diffInMinutes($testResult->created_at) . 'min' }})
                                                </td>
                                                <td>
                                                    {{ $testResult->sample?->requester?->name ?? 'N/A' }}
                                                </td>
                                                <td>
                                                    {{ date('d-m-Y', strtotime($testResult->sample->date_requested)) }}
                                                </td>
                                                <td>
                                                    {{ date('d-m-Y H:i', strtotime($testResult->sample->sampleReception->date_delivered)) }}
                                                </td>
                                                <td>
                                                    {{ $testResult->created_at->format('d-m-Y H:i') }}
                                                </td>

                                                <td>
                                                    <span class="badge bg-success">{{ $testResult->status }}</span>
                                                </td>
                                                <td>
                                                    <a href="javascript: void(0);" type="button"
                                                        wire:click="viewPreliminaryReport({{ $testResult->id }})"
                                                        class="action-ico btn btn-outline-info">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            
                                            {{-- Collapsible preliminary results row --}}
                                            @if($hasPreliminary)
                                                <tr class="preliminary-row" id="preliminary-{{ $testResult->id }}" style="display: none;">
                                                    <td colspan="15" class="p-0">
                                                        <div class="bg-light border-start border-primary border-4 p-3">
                                                            <h6 class="text-primary mb-2">
                                                                <i class="bi bi-clipboard-check"></i> Preliminary Tests
                                                            </h6>
                                                            <div class="row">
                                                                @foreach($preliminaryResults as $prelim)
                                                                    <div class="col-md-4 mb-2">
                                                                        <div class="card border-0 shadow-sm">
                                                                            <div class="card-body p-2">
                                                                                <div class="d-flex justify-content-between align-items-start mb-1">
                                                                                    <strong class="text-dark small">{{ $prelim->test->name }}</strong>
                                                                                    <span class="badge bg-info small">{{ $prelim->result }}</span>
                                                                                </div>
                                                                                <small class="text-muted d-block">
                                                                                    <i class="bi bi-person"></i> {{ $prelim->performer->fullName ?? 'N/A' }}
                                                                                </small>
                                                                                <small class="text-muted d-block">
                                                                                    <i class="bi bi-clock"></i> {{ $prelim->created_at->format('d-m-Y H:i') }}
                                                                                </small>
                                                                                @if($prelim->comment)
                                                                                    <small class="text-muted d-block mt-1">
                                                                                        <i class="bi bi-chat-text"></i> {{ $prelim->comment }}
                                                                                    </small>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @empty
                                            <tr>
                                                <td colspan="15" class="text-center text-muted py-4">
                                                    <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                                    <p class="mb-0">No test results found</p>
                                                </td>
                                            </tr>
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
            </div><!-- end col-->
        @else
            <div class="col-12">
                @include('reports.sample-management.preliminary-report')
            </div>
        @endif
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle preliminary results
            document.addEventListener('click', function(e) {
                const toggleBtn = e.target.closest('.toggle-preliminary');
                if (toggleBtn) {
                    const targetId = toggleBtn.dataset.target;
                    const prelimRow = document.getElementById(targetId);
                    const icon = toggleBtn.querySelector('i');
                    
                    if (prelimRow) {
                        if (prelimRow.style.display === 'none') {
                            prelimRow.style.display = 'table-row';
                            icon.classList.remove('bi-chevron-down');
                            icon.classList.add('bi-chevron-up');
                        } else {
                            prelimRow.style.display = 'none';
                            icon.classList.remove('bi-chevron-up');
                            icon.classList.add('bi-chevron-down');
                        }
                    }
                }
            });

            // Initialize tooltips
            initializeTooltips();
        });

        // Reinitialize tooltips after Livewire updates
        document.addEventListener('livewire:load', function () {
            Livewire.hook('message.processed', (message, component) => {
                initializeTooltips();
            });
        });

        function initializeTooltips() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }
    </script>
    @endpush
</div>