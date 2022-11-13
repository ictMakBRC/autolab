<?php

namespace App\Http\Livewire\Lab\SampleManagement;

use App\Models\TestResult;
use Livewire\Component;
use Livewire\WithPagination;

class TestReportsComponent extends Component
{
    use WithPagination;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'approved_at';

    public $orderAsc = true;

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function render()
    {
        $testResults = TestResult::search($this->search)
            ->where('creator_lab', auth()->user()->laboratory_id)->with(['test', 'sample', 'sample.participant', 'sample.sampleType:id,type', 'sample.study:id,name', 'sample.requester:id,name', 'sample.collector:id,name', 'sample.sampleReception'])->where('status', 'Approved')
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->simplePaginate($this->perPage);

        return view('livewire.lab.sample-management.test-reports-component', compact('testResults'));
    }
}
