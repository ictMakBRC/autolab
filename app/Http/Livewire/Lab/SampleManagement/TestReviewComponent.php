<?php

namespace App\Http\Livewire\Lab\SampleManagement;

use App\Models\TestResult;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TestReviewComponent extends Component
{
    public function markAsReviewed(TestResult $testResult)
    {
        $testResult->reviewed_by = Auth::id();
        $testResult->reviewed_at = now();
        $testResult->status = 'Reviewed';
        $testResult->update();
        session()->flash('success', 'Test Request Updated successfully.');
    }

    public function render()
    {
        $testResults = TestResult::with(['test', 'sample', 'sample.participant', 'sample.participant.sampleReception', 'sample.sampleType:id,type', 'sample.study:id,name', 'sample.requester:id,name', 'sample.collector:id,name'])->where('status', 'Pending Review')->get();

        return view('livewire.lab.sample-management.test-review-component', compact('testResults'));
    }
}
