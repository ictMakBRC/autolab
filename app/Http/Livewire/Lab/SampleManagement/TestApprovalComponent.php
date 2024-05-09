<?php

namespace App\Http\Livewire\Lab\SampleManagement;

use Livewire\Component;
use App\Models\TestResult;
use Livewire\WithPagination;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendGeneralNotificationJob;

class TestApprovalComponent extends Component
{
    use WithPagination;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'reviewed_at';

    public $orderAsc = true;

    public $viewReport = false;

    public $testResult;

    public $approver_comment;

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function markAsApproved(TestResult $testResult)
    {
        $this->validate([
            'approver_comment' => 'required',
        ]);
        $testResult->approved_by = Auth::id();
        $testResult->approved_at = now();
        $testResult->status = 'Approved';
        $testResult->approver_comment = $this->approver_comment;
        $testResult->update();
        $details = [
            'subject' => 'Auto-Lab Test',
            'greeting' => 'Hello, I hope this email finds you well',
            'body' => 'Your test Result Lab No#'.$testResult?->sample?->lab_no.' has been approved, please login and do the necessary action',
            'actiontext' => 'Click Here for more details',
            'actionurl' => URL::signedRoute('test-request'),
            'user_id' =>  $testResult->created_by,
        ];
        try {
            $email = SendGeneralNotificationJob::dispatch($details);
        } catch (\Throwable $th) {
        }
        $this->emit('updateNav', 'testsPendindApprovalCount');

        $this->reset('approver_comment');
        $this->viewReport = false;
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Test Result Updated successfully!']);
    }

    public function markAsDeclined(TestResult $testResult)
    {
        $this->validate([
            'approver_comment' => 'required',
        ]);

        $testResult->approved_by = Auth::id();
        $testResult->approved_at = now();
        $testResult->approver_comment = $this->approver_comment;
        $testResult->status = 'Rejected';
        $testResult->update();
        $this->emit('updateNav', 'testsPendindApprovalCount');

        $this->reset('approver_comment');
         $details = [
            'subject' => 'Auto-Lab Test',
            'greeting' => 'Hello, I hope this email finds you well',
            'body' => 'Your test result Lab No#'.$testResult?->sample?->lab_no.' has been Rejected, please login and do the necessary action',
            'actiontext' => 'Click Here for more details',
            'actionurl' => URL::signedRoute('test-request'),
            'user_id' =>  $testResult->created_by,
        ];
        try {
            $email = SendGeneralNotificationJob::dispatch($details);
        } catch (\Throwable $th) {
        }
        $this->viewReport = false;
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Test Result Updated successfully.!']);
    }

    public function viewPreliminaryReport(TestResult $testResult)
    {
        $this->testResult = $testResult;
        $this->viewReport = true;
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function render()
    {
        if ($this->viewReport) {
            $testResults = $this->testResult->load(['test', 'sample', 'sample.participant', 'sample.sampleReception', 'sample.sampleType:id,type', 'sample.study:id,name', 'sample.requester', 'sample.collector:id,name']);
        } else {
            $testResults = TestResult::resultSearch($this->search, 'Reviewed')
            ->where('creator_lab', auth()->user()->laboratory_id)->with(['test', 'sample', 'sample.participant', 'sample.sampleReception', 'sample.sampleType:id,type', 'sample.study:id,name', 'sample.requester', 'sample.collector:id,name'])->where('status', 'Reviewed')
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        }

        return view('livewire.lab.sample-management.test-approval-component', compact('testResults'));
    }
}
