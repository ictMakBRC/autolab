<?php

namespace App\Http\Livewire\Lab\SampleManagement;

use App\Models\TestResult;
use Livewire\Component;

class TestReportsComponent extends Component
{
    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function render()
    {
        $testResults = TestResult::with(['test', 'sample', 'sample.participant', 'sample.sampleType:id,type', 'sample.study:id,name', 'sample.requester:id,name', 'sample.collector:id,name'])->where('status', 'Approved')->get();

        return view('livewire.lab.sample-management.test-reports-component', compact('testResults'));
    }
}
