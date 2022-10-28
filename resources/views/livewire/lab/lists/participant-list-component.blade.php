<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="mb-2 mb-sm-0">
                                    Participant List
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
                                        <th>Participant ID</th>
                                        <th>Age</th>
                                        <th>Gender</th>
                                        <th>Contact</th>
                                        <th>Address</th>
                                        <th>Kin Contact</th>
                                        <th>Kin Address</th>
                                        <th>Facility</th>
                                        <th>Study</th>
                                        <th>Sample Count</th>
                                        <th>Test Count</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($participants as $key => $participant)
                                        <tr class="{{$activeRow==$participant->id?'bg-info':''}}" wire:click="$set('activeRow',{{$participant->id}})">
                                            <td>{{ $key + 1 }}</td>
                                           
                                            <td>
                                                {{ $participant->identity }}
                                            </td>
                                            <td>
                                                {{ $participant->age }}
                                            </td>
                                            <td>
                                                {{ $participant->gender }}
                                            </td>
                                           
                                            <td>
                                                {{ $participant->contact }}
                                            </td>
                                            
                                            <td>
                                                {{ $participant->address }}
                                            </td>
                                            <td>
                                         
                                                {{ $participant->nok_contact }}
                                            </td>
                                             
                                           
                                            <td>
                                                {{ $participant->nok_address }}
                                                
                                            </td>
                                        
                                            <td>
                                                {{ $participant->facility->name }}
                                            </td>
                                            <td>
                                                {{ $participant->study->name }}
                                            </td>
                                            {{-- <td>
                                                {{ $participant->sample->name }}
                                            </td> --}}
                                            <td>
                                                {{ $participant->sample_count }}
                                            </td>
                                            <td>
                                                {{ $participant->test_result_count}}
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

