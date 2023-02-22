<?php

namespace App\Http\Livewire\Lab\SampleManagement;

use App\Models\Admin\Test;
use App\Models\AliquotingAssignment;
use App\Models\Sample;
use App\Models\SampleType;
use App\Models\TestAssignment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class AssignTestsComponent extends Component
{
    use WithPagination;

    public $perPage = 50;

    public $search = '';

    public $orderBy = 'lab_no';

    public $orderAsc = true;

    public $sample;

    public $sample_is_for = 'Testing';

    public $tests_requested;

    public $aliquots_requested;

    public $request_acknowledged_by;

    public $sample_id;

    public $test_id;

    public $assignee;

    public $assignedTests;

    public $backlog;

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->tests_requested = collect([]);
        $this->aliquots_requested = collect([]);
        $this->assignedTests = [];
    }

    public function activateTest($id)
    {
        $this->test_id = $id;
    }

    public function UpdatedAssignee()
    {
        $this->backlog = TestAssignment::where(['assignee' => $this->assignee, 'status' => 'Assigned'])->count();
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function viewTests(Sample $sample)
    {
        $this->reset(['tests_requested']);
        $this->sample = null;
        $this->sample = $sample;
        $this->assignedTests = TestAssignment::where('sample_id', $sample->id)->get()->pluck('test_id')->toArray();
        $tests = Test::whereIn('id', array_diff($sample->tests_requested, $this->assignedTests ?? []))->get();
        $this->tests_requested = $tests;
        $this->test_id = $tests[0]->id;
        $this->sample_id = $sample->id;
        $this->request_acknowledged_by=$sample->request_acknowledged_by;

        $this->dispatchBrowserEvent('view-tests');
    }

    public function viewAliquots(Sample $sample)
    {
        $this->reset(['aliquots_requested']);
        $this->sample = $sample;
        $aliquots = SampleType::whereIn('id', (array) $sample->tests_requested)->orderBy('type', 'asc')->get();
        $this->aliquots_requested = $aliquots;
        $this->sample_id = $sample->id;
        $this->request_acknowledged_by=$sample->request_acknowledged_by;

        $this->dispatchBrowserEvent('view-aliquots');
    }

    public function assignTest()
    {
        $this->validate([
            'assignee' => 'required|integer',
        ]);
        
        $isExist = TestAssignment::select('*')
        ->where('sample_id', $this->sample_id)
        ->where('test_id', $this->test_id)
        ->exists();

        if ($isExist) {
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => 'Test already Assigned to someone!']);
        } else {
            $test_assignment = new TestAssignment();
            $test_assignment->sample_id = $this->sample_id;
            $test_assignment->test_id = $this->test_id;
            $test_assignment->assignee = $this->assignee;
            $test_assignment->save();

            array_push($this->assignedTests,$this->test_id);
            if (array_diff($this->sample->tests_requested, $this->assignedTests) == []) {
                $this->sample->update(['status' => 'Assigned']);
                $this->dispatchBrowserEvent('close-modal');
                $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Test Assignment completed successfully!']);
            } else {
                $this->tests_requested = $this->tests_requested->where('id','!=',$this->test_id)->values();
                $this->test_id = $this->tests_requested[0]->id;
                $this->reset(['assignee', 'backlog']);
                $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Test Assigned successfully!']);
            }
        }
    }

    public function assignAllTests()
    {
        $this->validate([
            'assignee' => 'required|integer',
        ]);

        foreach ($this->tests_requested  as $test) {
            TestAssignment::updateOrCreate(
                ['sample_id'=>$this->sample_id,'test_id'=>$test->id],
                ['assignee'=>$this->assignee]
            );
            array_push($this->assignedTests,$test->id);
        }

        if (array_diff($this->sample->tests_requested, $this->assignedTests) == []) {
            $this->sample->update(['status' => 'Assigned']);
            $this->reset(['assignee', 'backlog']);
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Test Assignment completed successfully!']);
        } else {
            $this->tests_requested = $this->tests_requested->where('id','!=',$this->test_id)->values();
            $this->test_id = $this->tests_requested[0]->id;
            $this->reset(['assignee', 'backlog']);
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Test Assigned successfully!']);
        }

    }

    public function assignAliquotingTasks()
    {
        $this->validate([
            'assignee' => 'required|integer',
        ]);
        $isExist = AliquotingAssignment::select('*')
        ->where('sample_id', $this->sample_id)
        ->exists();

        if ($isExist) {
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => 'Aliquoting Task already Assigned to someone!']);
        } else {
            $aliquoting_assignment = new AliquotingAssignment();
            $aliquoting_assignment->sample_id = $this->sample_id;
            $aliquoting_assignment->assignee = $this->assignee;
            $aliquoting_assignment->save();

            $sample = Sample::where('id', $this->sample_id)->first();
            $sample->update(['status' => 'Assigned']);

            $this->reset(['assignee', 'backlog']);
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Aliquoting Task assigned successfully!']);
        }
    }

    public function acknowledgeRequest()
    {
        // $this->sample->request_acknowledged_by = Auth::id();
        // $this->sample->date_acknowledged = now();
        // $this->sample->status = 'Processing';
        $this->sample->update([
        'request_acknowledged_by'=>Auth::id(),
        'date_acknowledged'=>now(),
        'status'=>'Processing']);
        $this->request_acknowledged_by=$this->sample->request_acknowledged_by;

        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Sample Updated successfully!']);
    }

    public function close()
    {
        $this->reset(['sample_id','assignee', 'test_id']);
        $this->tests_requested = collect([]);
        $this->aliquots_requested = collect([]);
    }

    public function getSamples()
    {
        $samples = Sample::search($this->search, ['Accessioned', 'Processing'])
        ->whereIn('status', ['Accessioned', 'Processing'])
        ->when($this->sample_is_for != 'Storage', function ($query) {
            $query->where('test_count', '>', 0)
            ->whereNotNull('tests_requested');
        }, function ($query) {
            return $query;
        })
        ->where(['creator_lab' => auth()->user()->laboratory_id, 'sample_is_for' => $this->sample_is_for])
        ->with(['participant', 'sampleType:id,type', 'study:id,name', 'requester:id,name', 'collector:id,name', 'sampleReception'])
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);
        return $samples;
    }

    public function getSampleTasks()
    {
        $sampleTasks= Sample::where(['creator_lab' => auth()->user()->laboratory_id])
        ->whereIn('status', ['Accessioned', 'Processing'])->get();

        $counts['forTestingCount'] = $sampleTasks->filter(function ($sample) {
            return $sample->sample_is_for === 'Testing';
        })->count();
        
        $counts['forAliquotingCount'] = $sampleTasks->filter(function ($sample) {
            return $sample->sample_is_for == 'Aliquoting';
        })->count();

        $counts['forStorageCount'] = $sampleTasks->filter(function ($sample) {
            return $sample->sample_is_for == 'Storage';
        })->count();

        return $counts;
    }


    public function render()
    {
        
        $samples=$this->getSamples();
        $users = User::where(['is_active' => 1, 'laboratory_id' => auth()->user()->laboratory_id])->get();
        $tests = $this->tests_requested;
        $aliquots = $this->aliquots_requested;
        $forTestingCount = $this->getSampleTasks()['forTestingCount'];
        $forAliquotingCount = $this->getSampleTasks()['forAliquotingCount'];
        $forStorageCount = $this->getSampleTasks()['forStorageCount'];

        return view('livewire.lab.sample-management.assign-tests-component', compact('samples', 'users', 'tests', 'aliquots','forTestingCount','forAliquotingCount','forStorageCount'));
    }
}
