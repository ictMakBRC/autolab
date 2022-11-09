<?php

namespace App\Http\Livewire\Lab\SampleManagement;

use App\Models\TestResult;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TestReviewComponent extends Component
{
    public $viewReport = false;

    public $resultId;

    public function markAsReviewed(TestResult $testResult)
    {
        $testResult->reviewed_by = Auth::id();
        $testResult->reviewed_at = now();
        $testResult->status = 'Reviewed';
        $testResult->update();
        $this->emit('updateNav', 'testsPendindReviewCount');

        $this->viewReport = false;
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Test Result Updated successfully.!']);
    }

    public function viewPreliminaryReport(TestResult $testResult)
    {
        $this->resultId = $testResult->id;
        $this->viewReport = true;
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function render()
    {
        if ($this->viewReport) {
            $testResults = TestResult::where('creator_lab', auth()->user()->laboratory_id)->with(['test', 'sample', 'sample.participant', 'sample.sampleReception', 'sample.sampleType:id,type', 'sample.study:id,name', 'sample.requester', 'sample.collector:id,name'])->where(['id' => $this->resultId, 'status' => 'Pending Review'])->first();
        } else {
            $testResults = TestResult::where('creator_lab', auth()->user()->laboratory_id)->with(['test', 'sample', 'sample.participant', 'sample.sampleReception', 'sample.sampleType:id,type', 'sample.study:id,name', 'sample.requester', 'sample.collector:id,name'])->where('status', 'Pending Review')->get();
        }

        return view('livewire.lab.sample-management.test-review-component', compact('testResults'));
    }
}
