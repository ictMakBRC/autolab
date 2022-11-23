<div>
    <!--breadcrumb-->
    {{-- <div class="card">
        <div class="card-body"> --}}

            <div class="row">
                <div class="ms-auto col-md-12 mb-2 ">
                    <div class="form-group">
                        <select wire:model="view" class="form-select" style=" position: relative; width: 300px; float: right;">
                            <option value="all">View All</option>
                            <option value="today">Today</option>
                            <option value="week">This Week</option>
                            <option value="month">This Month</option>
                            <option value="year">This Year</option>
                        </select>
                    </div>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="row">
                <div class="col-12 col-lg-12 col-xl-6 d-flex">
                    <div class="card radius-10 w-100">
                        <div class="card-body">
                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-xl-3 row-cols-xxl-3 g-3">

                                <div class="col-6">
                                    <div class=" card radius-10 border-start border-info border-3">
                                        <div class="card-body">
                                            <p>TOTAL SAMPLES</p>
                                            <h2 class="text-center fw-light">{{ $samplesAccepted }}</h2>
                                            <div id="chart1"></div>
                                        </div>
                                        <div class="card-footer bg-transparent border-top">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="text-center">
                                                    <p class="font-13 mb-0">Handled</p>
                                                    <p class="mb-0">{{ $sampleAandled }}</p>
                                                </div>
                                                <div class="text-center">
                                                    <p class="font-13 mb-0">Accessioned</p>
                                                    <p class="mb-0">{{ $sampleAccessioned }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class=" card radius-10 border-start border-primary border-3">
                                        <div class="card-body">
                                            <p>TOTAL TEST ASSIGNED</p>
                                            <h2 class="text-center fw-light">{{ $testAssignedCount }}</h2>
                                            <div id="chart1"></div>
                                        </div>
                                        <div class="card-footer bg-transparent border-top">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="text-center text-success">
                                                    <p class="font-13 mb-0">Completed</p>
                                                    <p class="mb-0 fw-bold">{{ $testDoneAssignedCount }}</p>
                                                </div>
                                                <div class="text-center text-warning">
                                                    <p class="font-13 mb-0">Pending</p>
                                                    <p class="mb-0 fw-bold">
                                                        {{ $testAssignedCount - $testDoneAssignedCount }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class=" card radius-10 border-start border-success border-3">
                                        <div class="card-body">
                                            <p>TEST PERFORMED</p>
                                            <h2 class="text-center fw-light">{{ $testReportsCount }}</h2>
                                            <div id="chart1"></div>
                                        </div>
                                        <div class="card-footer bg-transparent border-top">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="text-center text-success">
                                                    <small class="font-13 mb-0">Pending Review</small>
                                                    <p class="mb-0 fw-bold">{{ $testsPendindReviewCount }}</p>
                                                </div>
                                                <div class="text-center text-warning">
                                                    <small class="font-13 mb-0">Pending Approval</small>
                                                    <p class="mb-0 fw-bold">{{ $testsPendindApprovalCount }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class=" card radius-10 border-start border-danger border-3">
                                        <div class="card-body">
                                            <p>PENDING REQUESTS</p>
                                            <h2 class="text-center fw-light">{{ $testRequestsCount }}</h2>
                                            <div id="chart1"></div>
                                        </div>
                                        <div class="card-footer bg-transparent border-top">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="text-center text-info">
                                                    <small class="font-13 mb-0">Pending Normal</small>
                                                    <p class="mb-0 fw-bold">
                                                        {{ $testRequestsCount - $testRequestsUrgentCount }}</p>
                                                </div>
                                                <div class="text-center text-danger">
                                                    <small class="font-13 mb-0">Pending Urgent</small>
                                                    <p class="mb-0 fw-bold">{{ $testRequestsUrgentCount }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 d-none">
                                    <div class="card radius-10 bg-light-success text-success mb-0">
                                        <div class="card-body text-center">
                                            <div class="widget-icon mx-auto mb-3 bg-white-1 ">
                                                <i class="bi bi-people-fill"></i>
                                            </div>
                                            <h3 class="text-success">{{ $testRequestsCount }}</h3>
                                            <div class="card-footer bg-transparent border-top">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="text-center text-success">
                                                        <p class="mb-0 text-success">Pending Test Requests</p>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-12 col-xl-6 d-flex">
                    <div class="card radius-10 w-100">
                        <div class="card-header bg-transparent">
                            <div class="row g-3 align-items-center">
                                <div class="col">
                                    <h5 class="mb-0">User Status</h5>
                                </div>
                                <div class="col">
                                    <div class="d-flex align-items-center justify-content-end gap-3 cursor-pointer">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle dropdown-toggle-nocaret" href="#"
                                                data-bs-toggle="dropdown" aria-expanded="false"><i
                                                    class="bx bx-dots-horizontal-rounded font-22 text-option"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="javascript:;">Action</a>
                                                </li>
                                                <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li><a class="dropdown-item" href="javascript:;">Something else
                                                        here</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="test-pie-chart" class="test-pie-chart" width="400" height="400"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->

            <div class="row">
                <div class="col-12 col-lg-12 col-xl-12 col-xxl-6 d-flex">
                    <div class="card radius-10 w-100">
                        <div class="card-header bg-transparent">
                            <div class="row g-3 align-items-center">
                                <div class="col">
                                    <h5 class="mb-0">Recent Test Assignment</h5>
                                </div>
                                <div class="col">
                                    <div class="d-flex align-items-center justify-content-end gap-3 cursor-pointer">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle dropdown-toggle-nocaret" href="#"
                                                data-bs-toggle="dropdown" aria-expanded="false"><i
                                                    class="bx bx-dots-horizontal-rounded font-22 text-option"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="{{ route('test-request') }}">View
                                                        All</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-lg-flex align-items-center justify-content-center gap-4">
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
                                                    <th>Requested By</th>
                                                    <th>Collected By</th>
                                                    <th>Test Count</th>
                                                    <th>Priority</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($testAssigned as $key => $sample)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>
                                                            <a href="{{ URL::signedRoute('batch-search-results', ['sampleReception' => $sample->sampleReception->id]) }}"
                                                                class="text-secondary"
                                                                target="_blank">{{ $sample->sampleReception->batch_no }}
                                                            </a>
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
                                                                wire:click="viewTests({{ $sample->id }})"
                                                                class="action-ico">
                                                                <strong
                                                                    class="text-success">{{ $sample->lab_no }}</strong>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            {{ $sample->study->name ?? 'N/A' }}
                                                        </td>
                                                        <td>
                                                            {{ $sample->requester->name }}
                                                        </td>
                                                        <td>
                                                            {{ $sample->collector->name ?? 'N/A' }}
                                                        </td>
                                                        <td>
                                                            {{ $sample->test_count }}
                                                        </td>
                                                        @if ($sample->priority == 'Normal')
                                                            <td><span
                                                                    class="badge bg-info">{{ $sample->priority }}</span>
                                                            </td>
                                                        @else
                                                            <td><span
                                                                    class="badge bg-danger">{{ $sample->priority }}</span>
                                                            </td>
                                                        @endif

                                                        <td class="table-action">
                                                            <a href="{{ route('attach-test-results', $sample->id) }}"
                                                                data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                                title=""
                                                                data-bs-original-title="Attach Results"><i
                                                                    class="bi bi-file-earmark-medical"></i></a>
                                                        </td>
                                                    </tr>
                                                @empty
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div> <!-- end preview-->

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->
        {{-- </div>
    </div> --}}



    
    <script src="{{ asset('autolab-assets/plugins/chartjs/js/Chart.min.js') }}"></script>
    {{-- <script src="{{ asset('autolab-assets/plugins/chartjs/js/Chart.extension.js') }}"></script> --}}
    <script>
        /* -- Chartjs - Pie Chart -- */
        var pieChartID = document.getElementById("test-pie-chart").getContext('2d');
        var pieChart = new Chart(pieChartID, {
            type: 'pie',
            data: {
                datasets: [{
                    data: [
                        @foreach ($testChart as $chart)
                            {{ $chart->total }},
                        @endforeach
                    ],
                    borderColor: 'transparent',
                    backgroundColor: planColors(),
                    label: 'Dataset 1'
                }],
                labels: [
                    @foreach ($testChart as $chart)
                        '{{ $chart->status }}',
                    @endforeach
                ]
            },
            
            options: {
                responsive: true,
                legend: {
                    display: true
                }
                
            }
            
        });

        var planPoints = $('.planPoint');
        planPoints.each(function(key, planPoint) {
            var planPoint = $(planPoint)
            planPoint.css('color', planColors()[key])
        })

        function planColors() {
            return [
                '#0DC043',
                '#FF7A00',
                '#ffa62b',
                '#ffeaa7',
                '#D980FA',
                '#fccbcb',
                '#45aaf2',
                '#05dfd7',
                '#FF00F6',
                '#1e90ff',
                '#2ed573',
                '#eccc68',
                '#ff5200',
                '#cd84f1',
                '#7efff5',
                '#7158e2',
                '#fff200',
                '#ff9ff3',
                '#08ffc8',
                '#3742fa',
                '#1089ff',
                '#70FF61',
                '#bf9fee',
                '#574b90'
            ]
        }
    </script>

 
</div>
