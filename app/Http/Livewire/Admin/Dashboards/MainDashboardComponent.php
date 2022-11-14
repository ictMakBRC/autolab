<?php

namespace App\Http\Livewire\Admin\Dashboards;

use App\Models\Collector;
use App\Models\Courier;
use App\Models\Facility;
use App\Models\Laboratory;
use App\Models\Participant;
use App\Models\Requester;
use App\Models\Sample;
use App\Models\SampleReception;
use App\Models\Study;
use App\Models\TestResult;
use App\Models\User;
use Livewire\Component;

class MainDashboardComponent extends Component
{
    public $batchesCount;

    public $participantCount;

    public $samplesCount;

    public $testsPerformedCount;

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

    public function mount()
    {
        $this->batchesCount = SampleReception::where('creator_lab', auth()->user()->laboratory_id)->whereRaw('samples_accepted>samples_handled')->count();

        $this->participantCount = Participant::count(); //depends
        $this->samplesCount = Sample::where('creator_lab', auth()->user()->laboratory_id)->count(); //depends
        $this->testsPerformedCount = TestResult::where('creator_lab', auth()->user()->laboratory_id)->where('status', 'Approved')->count();

        $this->usersActiveCount = User::where(['is_active' => 1, 'laboratory_id' => auth()->user()->laboratory_id])->count();
        $this->usersSuspendedCount = User::where(['is_active' => 0, 'laboratory_id' => auth()->user()->laboratory_id])->count();

        $this->laboratoryCount = Laboratory::where('is_active', 1)->count();

        $this->facilityActiveCount = Facility::where('is_active', 1)->whereIn('id', auth()->user()->laboratory->associated_facilities ?? [])->count();
        $this->facilitySuspendedCount = Facility::where('is_active', 0)->whereIn('id', auth()->user()->laboratory->associated_facilities ?? [])->count();

        $this->studyActiveCount = Study::where('is_active', 1)->whereIn('id', auth()->user()->laboratory->associated_facilities ?? [])->count();
        $this->studySuspendedCount = Study::where('is_active', 0)->whereIn('id', auth()->user()->laboratory->associated_facilities ?? [])->count();

        $this->requesterActiveCount = Requester::where('is_active', 1)->whereIn('study_id', auth()->user()->laboratory->associated_studies ?? [])->count();
        $this->requesterSuspendedCount = Requester::where('is_active', 0)->whereIn('study_id', auth()->user()->laboratory->associated_studies ?? [])->count();

        $this->collectorActiveCount = Collector::where('is_active', 1)->whereIn('facility_id', auth()->user()->laboratory->associated_facilities ?? [])->count();
        $this->collectorSuspendedCount = Collector::where('is_active', 0)->whereIn('facility_id', auth()->user()->laboratory->associated_facilities ?? [])->count();

        $this->courierActiveCount = Courier::where('is_active', 1)->whereIn('facility_id', auth()->user()->laboratory->associated_facilities ?? [])->count();
        $this->courierSuspendedCount = Courier::where('is_active', 0)->whereIn('facility_id', auth()->user()->laboratory->associated_facilities ?? [])->count();
    }

    public function render()
    {
        return view('livewire.admin.dashboards.main-dashboard-component');
    }
}
