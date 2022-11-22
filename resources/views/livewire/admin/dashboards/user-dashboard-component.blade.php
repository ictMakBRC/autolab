<div>
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Dashboards</div>
            <div class="ps-3">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                  <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                  </li>
                  <li class="breadcrumb-item active" aria-current="page">User Dashboard</li>
                </ol>
              </nav>
            </div>
            <div class="ms-auto">
                <div class="d-flex align-items-center ml-4 me-2">
                    <label for="view" class="text-nowrap mr-2 mb-0">View</label>
                    <select wire:model="view" class="form-select">
                        <option value="all">All</option>
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
                        <h2 class="text-center fw-light">{{$samplesAccepted}}</h2>
                        <div id="chart1"></div>
                      </div>
                      <div class="card-footer bg-transparent border-top">
                         <div class="d-flex align-items-center justify-content-between">
                           <div class="text-center">
                              <p class="font-13 mb-0">Handled</p>
                              <p class="mb-0">{{$sampleAandled}}</p>
                           </div>
                           <div class="text-center">
                            <p class="font-13 mb-0">Accessioned</p>
                            <p class="mb-0">{{$sampleAccessioned}}</p>
                         </div>
                         </div>
                      </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class=" card radius-10 border-start border-primary border-3">
                      <div class="card-body">
                        <p>TOTAL TEST ASSIGNED</p>
                        <h2 class="text-center fw-light">{{$testAssignedCount}}</h2>
                        <div id="chart1"></div>
                      </div>
                      <div class="card-footer bg-transparent border-top">
                         <div class="d-flex align-items-center justify-content-between">
                           <div class="text-center text-success">
                              <p class="font-13 mb-0">Completed</p>
                              <p class="mb-0 fw-bold">{{$testDoneAssignedCount}}</p>
                           </div>
                           <div class="text-center text-warning">
                            <p class="font-13 mb-0">Pending</p>
                            <p class="mb-0 fw-bold">{{$testAssignedCount-$testDoneAssignedCount}}</p>
                         </div>
                         </div>
                      </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class=" card radius-10 border-start border-success border-3">
                      <div class="card-body">
                        <p>TEST PERFORMED</p>
                        <h2 class="text-center fw-light">{{$testReportsCount}}</h2>
                        <div id="chart1"></div>
                      </div>
                      <div class="card-footer bg-transparent border-top">
                         <div class="d-flex align-items-center justify-content-between">
                           <div class="text-center text-success">
                              <small class="font-13 mb-0">Pending Review</small>
                              <p class="mb-0 fw-bold">{{$testsPendindReviewCount}}</p>
                           </div>
                           <div class="text-center text-warning">
                            <small class="font-13 mb-0">Pending Approval</small>
                            <p class="mb-0 fw-bold">{{$testsPendindApprovalCount}}</p>
                         </div>
                         </div>
                      </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class=" card radius-10 border-start border-danger border-3">
                      <div class="card-body">
                        <p>PENDING REQUESTS</p>
                        <h2 class="text-center fw-light">{{$testRequestsCount}}</h2>
                        <div id="chart1"></div>
                      </div>
                      <div class="card-footer bg-transparent border-top">
                         <div class="d-flex align-items-center justify-content-between">
                           <div class="text-center text-info">
                              <small class="font-13 mb-0">Pending Normal</small>
                              <p class="mb-0 fw-bold">{{$testRequestsCount-$testRequestsUrgentCount}}</p>
                           </div>
                           <div class="text-center text-danger">
                            <small class="font-13 mb-0">Pending Urgent</small>
                            <p class="mb-0 fw-bold">{{$testRequestsUrgentCount}}</p>
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
                      <h3 class="text-success">{{$testRequestsCount}}</h3>
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
                      <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-horizontal-rounded font-22 text-option"></i>
                      </a>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="javascript:;">Action</a>
                        </li>
                        <li><a class="dropdown-item" href="javascript:;">Another action</a>
                        </li>
                        <li>
                          <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
               </div>
            </div>
            <div class="card-body">
               <div id="chart1"></div>
            </div>
          </div>
        </div>
      </div><!--end row-->

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
                      <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-horizontal-rounded font-22 text-option"></i>
                      </a>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('test-request') }}">View All</a>
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
                                                wire:click="viewTests({{ $sample->id }})" class="action-ico">
                                                <strong class="text-success">{{ $sample->lab_no }}</strong>
                                            </a>
                                        </td>
                                        <td>
                                            {{ $sample->study->name??'N/A' }}
                                        </td>
                                        <td>
                                            {{ $sample->requester->name }}
                                        </td>
                                        <td>
                                            {{ $sample->collector->name??'N/A' }}
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
                                  
                                        <td class="table-action">
                                            <a href="{{ route('attach-test-results', $sample->id) }}"
                                                 data-bs-toggle="tooltip"
                                                data-bs-placement="bottom" title=""
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
      
      </div><!--end row-->

  
</div>
