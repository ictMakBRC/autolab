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
        $batchesCount = SampleReception::whereRaw('samples_accepted>samples_handled')->count();
        $participantCount = Participant::count();
        $testRequestsCount = Sample::whereIn('status', ['Accessioned', 'Processing'])->count();
        $testsPendindReviewCount = TestResult::where('status', 'Pending Review')->count();
        $testsPendindApprovalCount = TestResult::where('status', 'Reviewed')->count();
        $testReportsCount = TestResult::where('status', 'Approved')->count();

        $usersCount = User::where('is_active', 1)->count();
        $rolesCount = Role::count();
        $permissionsCount = Permission::count();

        $laboratoryCount = Laboratory::where('is_active', 1)->count();
        $designationCount = Designation::where('is_active', 1)->count();
        $facilityCount = Facility::where('is_active', 1)->count();
        $studyCount = Study::where('is_active', 1)->count();
        $requesterCount = Requester::where('is_active', 1)->count();
        $collectorCount = Collector::where('is_active', 1)->count();
        $courierCount = Courier::where('is_active', 1)->count();
        $platformCount = Platform::where('is_active', 1)->count();
        $kitCount = Kit::where('is_active', 1)->count();
        $sampleTypeCount = SampleType::where('status', 1)->count();
        $testCategoryCount = TestCategory::count();
        $testCount = Test::where('status', 1)->count();

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
