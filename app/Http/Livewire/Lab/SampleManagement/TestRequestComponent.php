<?php

namespace App\Http\Livewire\Lab\SampleManagement;

use App\Models\Admin\Test;
use App\Models\Sample;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TestRequestComponent extends Component
{
    public $tests_requested;

    public $request_acknowledged_by;

    public $sample_identity;

    public $clinical_notes;

    public $lab_no;

    public $sample_id;

    public function mount()
    {
        $this->tests_requested = collect([]);
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function viewTests(Sample $sample)
    {
        $this->reset(['tests_requested']);

        $tests = Test::whereIn('id', $sample->tests_requested)->get();
        $this->tests_requested = $tests;
        $this->sample_identity = $sample->sample_identity;
        $this->lab_no = $sample->lab_no;
        $this->request_acknowledged_by = $sample->request_acknowledged_by;
        $this->clinical_notes = $sample->participant->clinical_notes;
        $this->sample_id = $sample->id;

        $this->dispatchBrowserEvent('view-tests');
    }

    public function acknowledgeRequest(Sample $sample)
    {
        $sample->request_acknowledged_by = Auth::id();
        $sample->date_acknowledged = now();
        $sample->status = 'Processing';
        $sample->update();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Test Request Updated successfully!']);
    }

    public function close()
    {
        $this->tests_requested = collect([]);
        $this->reset(['sample_id', 'sample_identity', 'lab_no', 'request_acknowledged_by']);
    }

    public function render()
    {
        $samples = Sample::with(['participant', 'sampleType:id,type', 'study:id,name', 'requester:id,name', 'collector:id,name', 'sampleReception'])->whereIn('status', ['Accessioned', 'Processing'])->get();

        return view('livewire.lab.sample-management.test-request-component', compact('samples'));
    }
}
