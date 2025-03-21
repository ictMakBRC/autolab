<?php

namespace App\Http\Livewire\Layout;

use App\Models\Admin\Test;
use App\Models\AliquotingAssignment;
use App\Models\Collector;
use App\Models\Courier;
use App\Models\Designation;
use App\Models\Facility;
use App\Models\Kit;
use App\Models\Laboratory;
use App\Models\Permission;
use App\Models\Platform;
use App\Models\Requester;
use App\Models\Role;
use App\Models\Sample;
use App\Models\SampleReception;
use App\Models\SampleType;
use App\Models\Study;
use App\Models\TestAssignment;
use App\Models\TestCategory;
use App\Models\TestResult;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NavigationComponent extends Component
{
    public $navItem;

    public $link;

    public $batchesCount;

    public $participantCount;

    public $samplesCount;

    public $testAssignedCount;

    public $testRequestsCount;

    public $testsPendindReviewCount;

    public $testsPendindApprovalCount;

    public $testReportsCount;

    public $usersCount;

    public $rolesCount;

    public $permissionsCount;

    public $laboratoryCount;

    public $designationCount;

    public $facilityCount;

    public $studyCount;

    public $requesterCount;

    public $collectorCount;

    public $courierCount;

    public $platformCount;

    public $kitCount;

    public $sampleTypeCount;

    public $testCategoryCount;

    public $testCount;

    public $rejectedResultsCount;

    public $testsRejectedCount;
    public $testsPerformedCount;
    public $AliquotingAssignedCount;

    protected $listeners = ['updateNav'];

    public function sampleData()
    {
        return Sample::where('creator_lab', auth()->user()->laboratory_id);
    }
    public function mount()
    {
        if (Auth::user()->hasPermission(['accession-samples'])) {
            $this->batchesCount = SampleReception::where('creator_lab', auth()->user()->laboratory_id)->where(function (Builder $query) {
                $query->whereRaw('samples_accepted != samples_handled')
                    ->orWhereHas('sample', function (Builder $query) {
                        $query->whereNull('tests_requested')
                            ->orWhere('test_count', 0);
                    });
            })->count();
        }

        if (Auth::user()->hasPermission(['view-participant-info'])) {
            $this->participantCount = $this->sampleData()->distinct()->count('participant_id');
            $this->samplesCount = $this->sampleData()->count();
        }

        if (Auth::user()->hasPermission(['enter-results'])) {
            $this->testAssignedCount = TestAssignment::where('assignee', auth()->user()->id)->whereIn('status', ['Assigned'])->count();
            $this->AliquotingAssignedCount = AliquotingAssignment::where('assignee', auth()->user()->id)->whereIn('status', ['Assigned'])->count();
            $this->rejectedResultsCount = TestResult::where(['status' => 'Rejected', 'performed_by' => auth()->user()->id, 'creator_lab' => auth()->user()->laboratory_id])->count();
        }

        if (Auth::user()->hasPermission(['assign-test-requests'])) {
            $this->testRequestsCount = $this->sampleData()->whereIn('sample_is_for', ['Testing', 'Aliquoting', 'Storage'])->whereIn('status', ['Accessioned', 'Processing'])->where(function ($query) {
                $query->whereNotNull('tests_requested')
                    ->where('test_count', '>', 0)
                    ->orWhere(function ($query) {
                        $query->where('sample_is_for', 'Storage')
                            ->whereNull('tests_requested');
                    });
            })
                ->count();
        }

        if (Auth::user()->hasPermission(['review-results'])) {
            $this->testsPendindReviewCount = TestResult::where('creator_lab', auth()->user()->laboratory_id)->where('status', 'Pending Review')->count();
            $this->testsRejectedCount = TestResult::where('creator_lab', auth()->user()->laboratory_id)->where('status', 'Rejected')->count();
        }

        if (Auth::user()->hasPermission(['approve-results'])) {
            $this->testsPendindApprovalCount = TestResult::where('creator_lab', auth()->user()->laboratory_id)->where('status', 'Reviewed')->count();
        }

        if (Auth::user()->hasPermission(['view-result-reports'])) {
            $this->testReportsCount = TestResult::where('creator_lab', auth()->user()->laboratory_id)->where('status', 'Approved')->count();
            $this->testsPerformedCount = TestResult::where('creator_lab', auth()->user()->laboratory_id)->count();
        } else {
            $this->testReportsCount = 0;
            $this->testsPerformedCount = 0;
        }

        if (Auth::user()->hasPermission(['manage-users'])) {
            $this->usersCount = User::where(['is_active' => 1])->count();
            $this->rolesCount = Role::count();
            $this->permissionsCount = Permission::count();
            $this->laboratoryCount = Laboratory::where('is_active', 1)->count();
        }

        if (Auth::user()->hasPermission(['access-settings'])) {
            $this->designationCount = Designation::where('is_active', 1)->count();
            $this->facilityCount = Facility::where('is_active', 1)->whereIn('id', auth()->user()->laboratory->associated_facilities ?? [])->count(); //depends
            $this->studyCount = Study::where('is_active', 1)->whereIn('id', auth()->user()->laboratory->associated_studies ?? [])->count(); //depends
            $this->requesterCount = Requester::where('is_active', 1)->whereIn('study_id', auth()->user()->laboratory->associated_studies ?? [])->count(); //depends
            $this->collectorCount = Collector::where('is_active', 1)->whereIn('facility_id', auth()->user()->laboratory->associated_facilities ?? [])->count(); //depends
            $this->courierCount = Courier::where('is_active', 1)->whereIn('facility_id', auth()->user()->laboratory->associated_facilities ?? [])->count(); //depends

            $this->platformCount = Platform::where('creator_lab', auth()->user()->laboratory_id)->where('is_active', 1)->count();
            $this->kitCount = Kit::where('creator_lab', auth()->user()->laboratory_id)->where('is_active', 1)->count();
            $this->sampleTypeCount = SampleType::where('creator_lab', auth()->user()->laboratory_id)->where('status', 1)->count();
            $this->testCategoryCount = TestCategory::where('creator_lab', auth()->user()->laboratory_id)->count();
            $this->testCount = Test::where('creator_lab', auth()->user()->laboratory_id)->where('status', 1)->count();
        }
    }

    public function updateNav($target)
    {
        if ($target == 'testsPendindReviewCount') {
            $this->testsPendindReviewCount--;
            $this->navItem = 'samplemgt';
            $this->link = 'review';
        } elseif ($target == 'testsPendindApprovalCount') {
            $this->testsPendindApprovalCount--;
            $this->testReportsCount++;
            $this->navItem = 'samplemgt';
            $this->link = 'approve';
        }
    }

    public function render()
    {
        return view('livewire.layout.navigation-component');
    }
}
