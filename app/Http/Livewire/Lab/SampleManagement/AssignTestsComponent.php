<?php

namespace App\Http\Livewire\Lab\SampleManagement;

use App\Models\User;
use App\Models\Sample;
use Livewire\Component;
use App\Models\Admin\Test;
use App\Models\TestAssignment;
use Illuminate\Support\Facades\Auth;

class AssignTestsComponent extends Component
{
    public $tests_requested;

    public $request_acknowledged_by;

    public $sample_identity;

    public $clinical_notes;

    public $lab_no;

    public $sample_id;
    
    public $test_id;

    public $assignee;

    public $assignedTests;

    public function mount()
    {
        $this->tests_requested = collect([]);
        $this->assignedTests = [];
    }

    public function activateTest($id)
    {
        $this->test_id = $id;
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function viewTests(Sample $sample)
    {
        $this->reset(['tests_requested']);
        $this->assignedTests=TestAssignment::where('sample_id',$sample->id)->get()->pluck('test_id')->toArray();
        $tests=Test::whereIn('id',array_diff($sample->tests_requested, $this->assignedTests??[]))->get();
        $this->tests_requested = $tests;
        $this->test_id = $tests[0]->id;
        $this->sample_identity = $sample->sample_identity;
        $this->lab_no = $sample->lab_no;
        $this->clinical_notes = $sample->participant->clinical_notes;
        $this->sample_id = $sample->id;

        $this->dispatchBrowserEvent('view-tests');
    }

    public function assignTest()
    {
        $this->validate([
            'assignee' => 'required|integer',
        ]);

        $test_assignment= new TestAssignment();
        $test_assignment->sample_id = $this->sample_id;
        $test_assignment->test_id = $this->test_id;
        $test_assignment->assignee = $this->assignee;
        $test_assignment->save();

        $sample=Sample::where('id',$this->sample_id )->first();
        $this->assignedTests=TestAssignment::where('sample_id',$this->sample_id)->get()->pluck('test_id')->toArray();
        if (array_diff($sample->tests_requested, $this->assignedTests)==[]) {
            $sample->update(['status'=>'Assigned']);
            $this->refresh();
        } else {
            $this->tests_requested=Test::whereIn('id',array_diff($sample->tests_requested, $this->assignedTests))->get();
            $this->test_id = $this->tests_requested[0]->id;
            $this->reset(['assignee']);
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Test Assigned successfully!']);
        }
        
    }

    public function close()
    {
        $this->reset(['sample_id', 'sample_identity', 'lab_no','assignee','test_id','clinical_notes']);
        $this->tests_requested = collect([]);
    }

    public function render()
    {
        $samples = Sample::where('creator_lab', auth()->user()->laboratory_id)->with(['participant', 'sampleType:id,type', 'study:id,name', 'requester:id,name', 'collector:id,name', 'sampleReception'])->whereIn('status', ['Accessioned', 'Processing'])->get();
        $users = User::where(['is_active'=>1,'laboratory_id'=>auth()->user()->laboratory_id])->get();
        $tests=$this->tests_requested;
        return view('livewire.lab.sample-management.assign-tests-component', compact('samples','users','tests'));
    }
}