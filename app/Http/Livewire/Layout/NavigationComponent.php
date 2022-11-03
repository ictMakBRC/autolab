<?php

namespace App\Http\Livewire\Layout;

use App\Models\Admin\Test;
use App\Models\Collector;
use App\Models\Courier;
use App\Models\Designation;
use App\Models\Facility;
use App\Models\Kit;
use App\Models\Laboratory;
use App\Models\Participant;
use App\Models\Permission;
use App\Models\Platform;
use App\Models\Requester;
use App\Models\Role;
use App\Models\Sample;
use App\Models\SampleReception;
use App\Models\SampleType;
use App\Models\Study;
use App\Models\TestCategory;
use App\Models\TestResult;
use App\Models\User;
use Livewire\Component;

class NavigationComponent extends Component
{
    public $navActive = false;

    protected $listeners = ['refresh-nav' => 'refreshNav'];

    public function refreshNav()
    {
        $this->navActive = true;
        $this->render();
    }

    public function render()
    {
        $batchesCount = SampleReception::where('creator_lab', auth()->user()->laboratory_id)->whereRaw('samples_accepted>samples_handled')->count();
        $participantCount = Participant::count();//depends
        $testRequestsCount = Sample::where('creator_lab', auth()->user()->laboratory_id)->whereIn('status', ['Accessioned', 'Processing'])->count();
        $testsPendindReviewCount = TestResult::where('creator_lab', auth()->user()->laboratory_id)->where('status', 'Pending Review')->count();
        $testsPendindApprovalCount = TestResult::where('creator_lab', auth()->user()->laboratory_id)->where('status', 'Reviewed')->count();
        $testReportsCount = TestResult::where('creator_lab', auth()->user()->laboratory_id)->where('status', 'Approved')->count();

        $usersCount = User::where(['is_active'=>1,'laboratory_id'=>auth()->user()->laboratory_id])->count();
        $rolesCount = Role::count();
        $permissionsCount = Permission::count();

        $laboratoryCount = Laboratory::where('is_active', 1)->count();
        $designationCount = Designation::where('is_active', 1)->count();
        $facilityCount = Facility::where('is_active', 1)->whereIn('id',auth()->user()->laboratory->associated_facilities)->count();//depends
        $studyCount = Study::where('is_active', 1)->whereIn('id',auth()->user()->laboratory->associated_facilities)->count();//depends
        $requesterCount = Requester::where('is_active', 1)->whereIn('study_id',auth()->user()->laboratory->associated_studies)->count();//depends
        $collectorCount = Collector::where('is_active', 1)->whereIn('facility_id', auth()->user()->laboratory->associated_facilities)->count();//depends
        $courierCount = Courier::where('is_active', 1)->whereIn('facility_id', auth()->user()->laboratory->associated_facilities)->count();//depends
        $platformCount = Platform::where('creator_lab', auth()->user()->laboratory_id)->where('is_active', 1)->count();
        $kitCount = Kit::where('creator_lab', auth()->user()->laboratory_id)->where('is_active', 1)->count();
        $sampleTypeCount = SampleType::where('creator_lab', auth()->user()->laboratory_id)->where('status', 1)->count();
        $testCategoryCount = TestCategory::where('creator_lab', auth()->user()->laboratory_id)->count();
        $testCount = Test::where('creator_lab', auth()->user()->laboratory_id)->where('status', 1)->count();

        return view('livewire.layout.navigation-component',
            compact(
                'batchesCount', 'rolesCount', 'permissionsCount', 'usersCount',
                'participantCount', 'testsPendindReviewCount',
                'testsPendindApprovalCount', 'testReportsCount',
                'testRequestsCount', 'laboratoryCount', 'designationCount',
                'facilityCount', 'studyCount', 'requesterCount', 'collectorCount',
                'courierCount', 'platformCount', 'kitCount', 'sampleTypeCount',
                'testCategoryCount', 'testCount', ));
    }
}
