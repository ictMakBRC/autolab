<?php

namespace App\Http\Livewire\Lab\SampleManagement;

use App\Models\TestResult;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TestApprovalComponent extends Component
{
    public function markAsApproved(TestResult $testResult)
    {
        $testResult->approved_by = Auth::id();
        $testResult->approved_at = now();
        $testResult->status = 'Approved';
        $testResult->update();
        session()->flash('success', 'Test Request Updated successfully.');
    }

    public function render()
    {
        $testResults = TestResult::with(['test', 'sample', 'sample.participant', 'sample.sampleType:id,type', 'sample.study:id,name', 'sample.requester:id,name', 'sample.collector:id,name'])->where('status', 'Reviewed')->get();

        return view('livewire.lab.sample-management.test-approval-component', compact('testResults'));
    }
}
