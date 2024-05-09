<?php

namespace App\Http\Livewire\Lab\SampleManagement;

use Livewire\Component;
use App\Models\TestResult;
use Livewire\WithPagination;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendGeneralNotificationJob;

class TestReviewComponent extends Component
{
    use WithPagination;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = true;

    public $viewReport = false;

    public $testResult;

    public $reviewer_comment;

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function markAsReviewed(TestResult $testResult)
    {
        $this->validate([
            'reviewer_comment' => 'required',
        ]);
        $testResult->reviewed_by = Auth::id();
        $testResult->reviewed_at = now();
        $testResult->status = 'Reviewed';
        $testResult->reviewer_comment = $this->reviewer_comment;
        $testResult->approver_comment = null;
        $testResult->update();
        $this->emit('updateNav', 'testsPendindReviewCount');

        $this->reset('reviewer_comment');
        $this->viewReport = false;
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Test Result Updated successfully.!']);
        $details = [
            'subject' => 'Auto-Lab Test',
            'greeting' => 'Hello, I hope this email finds you well',
            'body' => 'You have a pending test Lab No#'.$testResult?->sample?->lab_no.' to Approve, please login and do the necessary action',
            'actiontext' => 'Click Here for more details',
            'actionurl' => URL::signedRoute('test-request'),
            'user_id' => $testResult->laboratory->test_approver??1,
        ];
        try {
            $email = SendGeneralNotificationJob::dispatch($details);
        } catch (\Throwable $th) {
        }
    }

    public function markAsDeclined(TestResult $testResult)
    {
        $this->validate([
            'reviewer_comment' => 'required',
        ]);

        $testResult->reviewed_by = Auth::id();
        $testResult->reviewed_at = now();
        $testResult->reviewer_comment = $this->reviewer_comment;
        $testResult->status = 'Rejected';
        $testResult->update();
        $this->emit('updateNav', 'testsPendindReviewCount');

        $this->reset('reviewer_comment');
        $this->viewReport = false;
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Test Result Updated successfully.!']);
        $details = [
            'subject' => 'Auto-Lab Test',
            'greeting' => 'Hello, I hope this email finds you well',
            'body' => 'Your test result Lab No#'.$testResult?->sample?->lab_no.' has been Rejected at review level, please login and do the necessary action',
            'actiontext' => 'Click Here for more details',
            'actionurl' => URL::signedRoute('test-request'),
            'user_id' =>  $testResult->created_by,
        ];
        try {
            $email = SendGeneralNotificationJob::dispatch($details);
        } catch (\Throwable $th) {
        }
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
            $testResults = TestResult::resultSearch($this->search, 'Pending Review')
            ->where(['status'=>'Pending Review','creator_lab'=>auth()->user()->laboratory_id])
            ->with(['test', 'sample', 'kit', 'sample.participant', 'sample.sampleReception', 'sample.sampleType:id,type', 'sample.study:id,name', 'sample.requester', 'sample.collector:id,name'])
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        }

        return view('livewire.lab.sample-management.test-review-component', compact('testResults'));
    }
}
