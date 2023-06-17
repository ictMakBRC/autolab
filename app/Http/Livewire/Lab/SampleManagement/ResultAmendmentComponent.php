<?php

namespace App\Http\Livewire\Lab\SampleManagement;

use Exception;
use App\Models\Kit;
use App\Models\User;
use App\Models\Study;
use App\Models\Courier;
use Livewire\Component;
use App\Models\Facility;
use App\Helpers\Generate;
use App\Models\TestResult;
use Livewire\WithPagination;
use App\Models\SampleReception;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class ResultAmendmentComponent extends Component
{
    public $result_tracker;
    public $participant;
    public $sample;
    public $studies;
    public $toggleEditForms=false;


    public $testResults;
    public $originalResults;

    public $testParameters;

    public $testResult;

    public $testResultId;

    public $reviewer_comment;

    public $approver_comment;

    public $test;

    public $comment;

    //PARTICIPANT INFORMATION
    public $identity;
    public $age;
    public $months;
    public $gender;
    public $address;
    public $facility_id;

    //SAMPLE INFORMATION
    public $date_collected;
    public $requested_by;
    public $study_id;
    public $sample_identity;
 

    //RESULTS
    public $result;
    public $link;
    public $attachment;
    public $attachmentPath;
    public $performed_by;
    public $kit_expiry_date, $verified_lot, $kit_id;
    public $amendment_type;
    public $amendment_comment;

     public function mount()
     {
        $this->studies=collect([]);
     }

    public function showEditForms()
    {
        $this->validate([
            'amendment_type' => 'required|string',
            'amendment_comment' => 'required|string',
        ]);
        $this->toggleEditForms=true;
    }

    public function getResultDetails()
    {
        if ($this->result_tracker) {
            $testResult = TestResult::where(['tracker'=>$this->result_tracker,'status'=>'approved','creator_lab'=>auth()->user()->laboratory_id,'amended_state'=>false])->with(['test', 'sample', 'kit','sample.participant', 'sample.sampleReception', 'sample.sampleType:id,type', 'sample.study:id,name', 'sample.requester', 'sample.collector:id,name', 'performer', 'reviewer', 'approver'])->first();
            if ($testResult) {

                $this->testResults=$testResult;
                $this->originalResults=$testResult;
                $this->testResult = $testResult;
                $this->testResultId = $testResult->id;
                $this->result = $testResult->result;
                $this->comment = $testResult->comment;
                $this->test = $testResult->test;
                $this->testParameters=$testResult->parameters??[];
                $this->kit_id=$testResult->kit_id;
                $this->verified_lot=$testResult->verified_lot;
                $this->kit_expiry_date=$testResult->kit_expiry_date;

                $this->participant = $testResult->sample->participant;
                $this->identity = $this->participant->identity;
                $this->age =  $this->participant->age;
                $this->months = $this->participant->months;
                $this->gender = $this->participant->gender;
                $this->address = $this->participant->address;
                $this->facility_id = $this->participant->facility_id;

                $this->sample=$testResult->sample;
                $this->date_collected=$this->sample->date_collected;
                $this->study_id=$this->sample->study_id;
                $this->sample_identity=$this->sample->sample_identity;

                $this->studies = Study::where(['facility_id' => $this->facility_id])->whereIn('id', auth()->user()->laboratory->associated_studies ?? [])->with('requester:id,name')->orderBy('name', 'asc')->get();

                $this->toggleEditForms=false;
            } else {
                $this->reset();
                $this->toggleEditForms=false;
                $this->dispatchBrowserEvent('not-found', ['type' => 'error',  'message' => 'No result found with the tracker submitted / Result is not amendable!']);
            }
        } else {
            $this->reset();
            $this->dispatchBrowserEvent('not-found', ['type' => 'error',  'message' => 'Please enter the tracker for the result you want to amend!']);
        }
        
    }

    public function amendResults()
    {   
        DB::transaction(function () {
            $this->updateParticipant();
            $this->updateSampleInformation();
            $this->updateResult();
            $this->reset();
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Results amended successfully!']);
        });


    }

    public function updateParticipant()
    {

        $this->validate([
            'identity' => 'required|string',
            'age' => 'nullable|integer|min:1',
            'months' => 'nullable|integer|min:1|max:11',
            'address' => 'required|string|max:40',
            'gender' => 'nullable|string|max:6',
        ]);

        $this->participant->identity = $this->identity;
        $this->participant->age = $this->age;
        $this->participant->months = $this->months;
        $this->participant->address = $this->address;
        $this->participant->gender = $this->gender;
        $this->participant->update();

        // $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Participant Data updated successfully!']);
    }

    public function updateSampleInformation()
    {
        $this->validate([
            'date_collected' => 'required|date',
            'sample_identity' => 'required|string',
            'study_id' => 'required|integer',
        ]);

        $this->sample->date_collected = $this->date_collected;
        $this->sample->study_id = $this->study_id ?? null;
        $this->sample->sample_identity = $this->sample_identity;
        $this->sample->update();

        // $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Sample Data updated successfully!']);
    }

    public function updateResult()
    {
        $this->testResults->reviewed_by = null;
        $this->testResults->reviewed_at = null;
        $this->testResults->approved_by = null;
        $this->testResults->approved_at = null;
        $this->testResults->reviewer_comment = null;
        $this->testResults->approver_comment = null;

        $this->testResults->amended_state = true;
        $this->testResults->amendment_type = $this->amendment_type;
        $this->testResults->amendment_comment = $this->amendment_comment;

        $this->testResults->original_results = $this->originalResults->toJson();
        $this->testResults->amended_by = auth()->user()->id;
        $this->testResults->amended_at = now();

        $this->testResults->status = 'Pending Review';
        $this->testResults->update();

        // $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Test Result Updated successfully!']);
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function render()
    {
        $kits = Kit::where('is_active', 1)->get();
        return view('livewire.lab.sample-management.result-amendment-component',compact('kits'))->layout('layouts.app');
    }
}
