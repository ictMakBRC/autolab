<?php

namespace App\Http\Livewire\Admin\Dashboards;

use App\Models\Admin\Test;
use App\Models\Collector;
use App\Models\Laboratory;
use App\Models\Participant;
use App\Models\Requester;
use App\Models\Sample;
use App\Models\SampleReception;
use App\Models\SampleType;
use App\Models\Study;
use App\Models\TestAssignment;
use App\Models\TestResult;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Livewire\Component;

class UserDashboardComponent extends Component
{
    public $search;

    public $view;

    // public function mount()
    // {
    //     $value = $this->view;
    //     // $this->day = whereDay('created_at', '=', date('d'))->count();
    //     // $this->week = whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
    //     // $this->month = whereMonth('created_at', '=', date('m'))->count();
    //     // $this->year = whereYear('created_at', '=', date('Y'))->count();

    //     $this->samplesAccepted = SampleReception::where('created_by', auth()->user()->id)
    //     ->when($value != '', function ($query) {
    //         $query->whereDay('created_at', '=', date('d'));
    //     })->sum('samples_accepted');

    //     $this->sampleAandled = SampleReception::where('created_by', auth()->user()->id)
    //     ->when($value != '', function ($query) {
    //         $query->whereDay('created_at', '=', date('d'));
    //     })->sum('samples_handled');

    //     $this->sampleAccessioned = Sample::where('created_by', auth()->user()->id)
    //     ->when($value != '', function ($query) {
    //         $query->whereDay('created_at', '=', date('d'));
    //     })->count();

    //     $this->testAssigned = Sample::search($this->search, ['Assigned'])
    //     ->where('creator_lab', auth()->user()->laboratory_id)
    //     ->with(['participant', 'sampleType:id,type', 'study:id,name', 'requester:id,name', 'collector:id,name', 'sampleReception'])
    //     ->whereHas('testAssignment', function (Builder $query) {
    //         $query->where(['assignee' => auth()->user()->id, 'status' => 'Assigned']);
    //     })->latest()->limit(5)->get();

    //     $this->testAssignedCount = TestAssignment::where('assignee', auth()->user()->id)->count();
    //     $this->testDoneAssignedCount = TestAssignment::where('assignee', auth()->user()->id)->whereIn('status', ['Test Done'])->count();

    //     $this->testRequestsCount = Sample::where('creator_lab', auth()->user()->laboratory_id)->whereIn('status', ['Accessioned', 'Processing'])->count();
    //     $this->testRequestsUrgentCount = Sample::where('creator_lab', auth()->user()->laboratory_id)->whereIn('status', ['Accessioned', 'Processing'])->where('priority','Urgent')->count();

    //     $this->testsPendindReviewCount = TestResult::where('performed_by', auth()->user()->laboratory_id)->where('status', 'Pending Review')->count();
    //     $this->testsPendindApprovalCount = TestResult::where('performed_by', auth()->user()->laboratory_id)->where('status', 'Reviewed')->count();
    //     $this->testReportsCount = TestResult::where('performed_by', auth()->user()->id)->count();

    // }

    public function render()
    {
        $data['samplesAccepted'] = SampleReception::where('created_by', auth()->user()->id)
        ->when($this->view == 'today', function ($query) {
            $query->whereDay('created_at', '=', date('d'));
        })
        ->when($this->view == 'week', function ($query) {
            $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        })
        ->when($this->view == 'month', function ($query) {
            $query->whereMonth('created_at', '=', date('m'))->count();
        })
        ->when($this->view == 'year', function ($query) {
            $query->whereYear('created_at', '=', date('Y'))->count();
        })
        ->sum('samples_accepted');

        $data['sampleAandled'] = SampleReception::where('created_by', auth()->user()->id)
        ->when($this->view == 'today', function ($query) {
            $query->whereDay('created_at', '=', date('d'));
        })
        ->when($this->view == 'week', function ($query) {
            $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        })
        ->when($this->view == 'month', function ($query) {
            $query->whereMonth('created_at', '=', date('m'))->count();
        })
        ->when($this->view == 'year', function ($query) {
            $query->whereYear('created_at', '=', date('Y'))->count();
        })
        ->sum('samples_handled');

        $data['sampleAccessioned'] = Sample::where('created_by', auth()->user()->id)
        ->when($this->view == 'today', function ($query) {
            $query->whereDay('created_at', '=', date('d'));
        })
        ->when($this->view == 'week', function ($query) {
            $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        })
        ->when($this->view == 'month', function ($query) {
            $query->whereMonth('created_at', '=', date('m'))->count();
        })
        ->when($this->view == 'year', function ($query) {
            $query->whereYear('created_at', '=', date('Y'))->count();
        })
        ->count();

        $data['testAssigned'] = Sample::search($this->search, ['Assigned'])
        ->where('creator_lab', auth()->user()->laboratory_id)
        ->with(['participant', 'sampleType:id,type', 'study:id,name', 'requester:id,name', 'collector:id,name', 'sampleReception'])
        ->whereHas('testAssignment', function (Builder $query) {
            $query->where(['assignee' => auth()->user()->id, 'status' => 'Assigned']);
        })
        ->when($this->view == 'today', function ($query) {
            $query->whereDay('created_at', '=', date('d'));
        })
        ->when($this->view == 'week', function ($query) {
            $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        })
        ->when($this->view == 'month', function ($query) {
            $query->whereMonth('created_at', '=', date('m'))->count();
        })
        ->when($this->view == 'year', function ($query) {
            $query->whereYear('created_at', '=', date('Y'))->count();
        })
        ->latest()->limit(5)->get();

        $data['testChart'] = TestAssignment::where('assignee', auth()->user()->id)
        ->selectRaw('COUNT(id) as total, status')->groupBy('status')->get();

        $data['testAssignedCount'] = TestAssignment::where('assignee', auth()->user()->id)
        ->when($this->view == 'today', function ($query) {
            $query->whereDay('created_at', '=', date('d'));
        })
        ->when($this->view == 'week', function ($query) {
            $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        })
        ->when($this->view == 'month', function ($query) {
            $query->whereMonth('created_at', '=', date('m'))->count();
        })
        ->when($this->view == 'year', function ($query) {
            $query->whereYear('created_at', '=', date('Y'))->count();
        })
        ->count();

        $data['testDoneAssignedCount'] = TestAssignment::where('assignee', auth()->user()->id)->whereIn('status', ['Test Done'])
        ->when($this->view == 'today', function ($query) {
            $query->whereDay('created_at', '=', date('d'));
        })
        ->when($this->view == 'week', function ($query) {
            $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        })
        ->when($this->view == 'month', function ($query) {
            $query->whereMonth('created_at', '=', date('m'))->count();
        })
        ->when($this->view == 'year', function ($query) {
            $query->whereYear('created_at', '=', date('Y'))->count();
        })
        ->count();

        $data['testRequestsCount'] = Sample::where('creator_lab', auth()->user()->laboratory_id)->whereIn('status', ['Accessioned', 'Processing'])
        ->when($this->view == 'today', function ($query) {
            $query->whereDay('created_at', '=', date('d'));
        })
        ->when($this->view == 'week', function ($query) {
            $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        })
        ->when($this->view == 'month', function ($query) {
            $query->whereMonth('created_at', '=', date('m'))->count();
        })
        ->when($this->view == 'year', function ($query) {
            $query->whereYear('created_at', '=', date('Y'))->count();
        })
        ->count();

        $data['testRequestsUrgentCount'] = Sample::where('creator_lab', auth()->user()->laboratory_id)->whereIn('status', ['Accessioned', 'Processing'])->where('priority', 'Urgent')
        ->when($this->view == 'today', function ($query) {
            $query->whereDay('created_at', '=', date('d'));
        })
        ->when($this->view == 'week', function ($query) {
            $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        })
        ->when($this->view == 'month', function ($query) {
            $query->whereMonth('created_at', '=', date('m'))->count();
        })
        ->when($this->view == 'year', function ($query) {
            $query->whereYear('created_at', '=', date('Y'))->count();
        })
        ->count();

        $data['testsPendindReviewCount'] = TestResult::where('performed_by', auth()->user()->laboratory_id)->where('status', 'Pending Review')
        ->when($this->view == 'today', function ($query) {
            $query->whereDay('created_at', '=', date('d'));
        })
        ->when($this->view == 'week', function ($query) {
            $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        })
        ->when($this->view == 'month', function ($query) {
            $query->whereMonth('created_at', '=', date('m'))->count();
        })
        ->when($this->view == 'year', function ($query) {
            $query->whereYear('created_at', '=', date('Y'))->count();
        })
        ->count();

        $data['testsPendindApprovalCount'] = TestResult::where('performed_by', auth()->user()->laboratory_id)->where('status', 'Reviewed')
        ->when($this->view == 'today', function ($query) {
            $query->whereDay('created_at', '=', date('d'));
        })
        ->when($this->view == 'week', function ($query) {
            $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        })
        ->when($this->view == 'month', function ($query) {
            $query->whereMonth('created_at', '=', date('m'))->count();
        })
        ->when($this->view == 'year', function ($query) {
            $query->whereYear('created_at', '=', date('Y'))->count();
        })
        ->count();

        $data['testReportsCount'] = TestResult::where('performed_by', auth()->user()->id)
        ->when($this->view == 'today', function ($query) {
            $query->whereDay('created_at', '=', date('d'));
        })
        ->when($this->view == 'week', function ($query) {
            $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        })
        ->when($this->view == 'month', function ($query) {
            $query->whereMonth('created_at', '=', date('m'))->count();
        })
        ->when($this->view == 'year', function ($query) {
            $query->whereYear('created_at', '=', date('Y'))->count();
        })
        ->count();

        // public function index()
        // {
        //     $users = User::select(DB::raw("COUNT(*) as count"), DB::raw("MONTHNAME(created_at) as month_name"))
        //                 ->whereYear('created_at', date('Y'))
        //                 ->groupBy(DB::raw("Month(created_at)"))
        //                 ->pluck('count', 'month_name');

        //     $labels = $users->keys();
        //     $data = $users->values();

        //     return view('chart', compact('labels', 'data'));
        // }

        return view('livewire.admin.dashboards.user-dashboard-component', $data);
    }
}
