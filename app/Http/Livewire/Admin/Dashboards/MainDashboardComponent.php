<?php

namespace App\Http\Livewire\Admin\Dashboards;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Study;
use App\Models\Sample;
use App\Models\Courier;
use Livewire\Component;
use App\Models\Facility;
use App\Models\Collector;
use App\Models\Requester;
use App\Models\Laboratory;
use App\Models\TestResult;
use App\Models\SampleReception;
use Illuminate\Support\Facades\DB;

class MainDashboardComponent extends Component
{
    public $batchesCount;

    public $participantCount;

    public $samplesCount;

    public $samplesTodayCount;

    public $samplesThisWeekCount;

    public $samplesThisMonthCount;

    public $samplesThisYearCount;

    public $testsPerformedCount;

    public $testsTodayCount;

    public $testsThisWeekCount;

    public $testsThisMonthCount;

    public $testsThisYearCount;

    public $usersActiveCount;

    public $usersSuspendedCount;

    public $laboratoryCount;

    public $facilityActiveCount;

    public $facilitySuspendedCount;

    public $studyActiveCount;

    public $studySuspendedCount;

    public $requesterSuspendedCount;

    public $requesterActiveCount;

    public $collectorSuspendedCount;

    public $collectorActiveCount;

    public $courierSuspendedCount;

    public $courierActiveCount;

    public $labels=[];
    public $currentYearSampleData=[];
    public $previousYearSampleData=[];

    public function mount()
    {
        //SAMPLES
        $this->participantCount = Sample::where('creator_lab', auth()->user()->laboratory_id)->distinct()->count('participant_id');
        $this->batchesCount = SampleReception::where('creator_lab', auth()->user()->laboratory_id)->whereRaw('samples_accepted=samples_handled')->count();
        $this->samplesCount = Sample::where('creator_lab', auth()->user()->laboratory_id)->count();
        $this->samplesTodayCount = Sample::where('creator_lab', auth()->user()->laboratory_id)->where('status', 'Tests Done')->whereDay('updated_at', '=', date('d'))->count();
        $this->samplesThisWeekCount = Sample::where('creator_lab', auth()->user()->laboratory_id)->where('status', 'Tests Done')->whereBetween('updated_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $this->samplesThisMonthCount = Sample::where('creator_lab', auth()->user()->laboratory_id)->where('status', 'Tests Done')->whereMonth('updated_at', '=', date('m'))->count();
        $this->samplesThisYearCount = Sample::where('creator_lab', auth()->user()->laboratory_id)->where('status', 'Tests Done')->whereYear('updated_at', '=', date('Y'))->count();

        //TESTS
        $this->testsPerformedCount = TestResult::where('creator_lab', auth()->user()->laboratory_id)->where('status', 'Approved')->count();
        $this->testsTodayCount = TestResult::where('creator_lab', auth()->user()->laboratory_id)->where('status', 'Approved')->whereDay('created_at', '=', date('d'))->count();
        $this->testsThisWeekCount = TestResult::where('creator_lab', auth()->user()->laboratory_id)->where('status', 'Approved')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $this->testsThisMonthCount = TestResult::where('creator_lab', auth()->user()->laboratory_id)->where('status', 'Approved')->whereMonth('created_at', '=', date('m'))->count();
        $this->testsThisYearCount = TestResult::where('creator_lab', auth()->user()->laboratory_id)->where('status', 'Approved')->whereYear('created_at', '=', date('Y'))->count();

        //USERS
        $this->usersActiveCount = User::where(['is_active' => 1, 'laboratory_id' => auth()->user()->laboratory_id])->count();
        $this->usersSuspendedCount = User::where(['is_active' => 0, 'laboratory_id' => auth()->user()->laboratory_id])->count();

        //LABS
        $this->laboratoryCount = Laboratory::where('is_active', 1)->count();

        //FACILITIES
        $this->facilityActiveCount = Facility::whereIn('id', auth()->user()->laboratory->associated_facilities ?? [])->where('is_active',1)->count();
        $this->facilitySuspendedCount = Facility::whereIn('id', auth()->user()->laboratory->associated_facilities ?? [])->where('is_active',0)->count();

        //STUDIES
        $this->studyActiveCount = Study::where('is_active', 1)->whereIn('id', auth()->user()->laboratory->associated_studies ?? [])->count();
        $this->studySuspendedCount = Study::where('is_active', 0)->whereIn('id', auth()->user()->laboratory->associated_studies ?? [])->count();

        //REQUESTERS
        $this->requesterActiveCount = Requester::where('is_active', 1)->whereIn('study_id', auth()->user()->laboratory->associated_studies ?? [])->count();
        $this->requesterSuspendedCount = Requester::where('is_active', 0)->whereIn('study_id', auth()->user()->laboratory->associated_studies ?? [])->count();

        //PHLEBOTOMISTS
        $this->collectorActiveCount = Collector::where('is_active', 1)->whereIn('facility_id', auth()->user()->laboratory->associated_facilities ?? [])->count();
        $this->collectorSuspendedCount = Collector::where('is_active', 0)->whereIn('facility_id', auth()->user()->laboratory->associated_facilities ?? [])->count();

        //COURIERS
        $this->courierActiveCount = Courier::where('is_active', 1)->whereIn('facility_id', auth()->user()->laboratory->associated_facilities ?? [])->count();
        $this->courierSuspendedCount = Courier::where('is_active', 0)->whereIn('facility_id', auth()->user()->laboratory->associated_facilities ?? [])->count();
    }

    // public function chartData()
    // {
    //     $samples = Sample::select(DB::raw("COUNT(*) as count"), DB::raw("MONTHNAME(created_at) as month_name"))
    //                 ->whereYear('created_at', date('Y'))
    //                 ->groupBy(DB::raw("Month(created_at)"))->orderBy('created_at','asc')
    //                 ->pluck('count', 'month_name');
 
    //     // return $users;
    //     $labels = $samples->keys();
    //     $data = $samples->values();
              
    //     return view('chart', compact('labels', 'data'));
    // }

    public function render()
    {
        $currentYearSamples = Sample::select(DB::raw("COUNT(*) as count"), DB::raw("MONTHNAME(created_at) as month_name"))
                    ->whereYear('created_at', date('Y'))
                    ->groupBy(DB::raw("Month(created_at)"))->orderBy('created_at','asc')
                    ->pluck('count', 'month_name');
        $previousYearSamples = Sample::select(DB::raw("COUNT(*) as count"), DB::raw("MONTHNAME(created_at) as month_name"))
        ->whereYear('created_at', date('Y')-1)
        ->groupBy(DB::raw("Month(created_at)"))->orderBy('created_at','asc')
        ->pluck('count', 'month_name');

        $this->labels = array_merge($currentYearSamples->keys()->toArray(),$previousYearSamples->keys()->toArray()) ;
        $this->currentYearSampleData = $currentYearSamples->values();
        $this->previousYearSampleData = $previousYearSamples->values();

        return view('livewire.admin.dashboards.main-dashboard-component');
    }
}
