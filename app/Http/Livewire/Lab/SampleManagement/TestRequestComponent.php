<?php

namespace App\Http\Livewire\Lab\SampleManagement;

use App\Models\Sample;
use Livewire\Component;

class TestRequestComponent extends Component
{
    public function render()
    {
        $samples = Sample::with(['participant', 'sampleType:id,type', 'study:id,name', 'requester:id,name', 'collector:id,name'])->get();

        return view('livewire.lab.sample-management.test-request-component', compact('samples'));
    }
}
