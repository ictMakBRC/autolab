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

    // Count variables
    public $batchesCount              = 0;
    public $participantCount          = 0;
    public $samplesCount              = 0;
    public $testAssignedCount         = 0;
    public $AliquotingAssignedCount   = 0;
    public $rejectedResultsCount      = 0;
    public $testRequestsCount         = 0;
    public $testsPendindReviewCount   = 0;
    public $testsPendindApprovalCount = 0;
    public $testReportsCount          = 0;
    public $testsRejectedCount        = 0;
    public $testsPerformedCount       = 0;

    public $usersCount        = 0;
    public $rolesCount        = 0;
    public $permissionsCount  = 0;
    public $laboratoryCount   = 0;
    public $designationCount  = 0;
    public $facilityCount     = 0;
    public $studyCount        = 0;
    public $requesterCount    = 0;
    public $collectorCount    = 0;
    public $courierCount      = 0;
    public $platformCount     = 0;
    public $kitCount          = 0;
    public $sampleTypeCount   = 0;
    public $testCategoryCount = 0;
    public $testCount         = 0;

    protected $listeners = ['updateNav', 'loadCounts'];

    public function sampleData()
    {
        return Sample::where('creator_lab', auth()->user()->laboratory_id);
    }
    public function mount()
    {
        $this->navItem = 'samplemgt';
        $this->link    = 'dashboard';
        // $this->loadCounts();
    }
    public function mounted()
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
            $this->samplesCount     = $this->sampleData()->count();
        }

        if (Auth::user()->hasPermission(['enter-results'])) {
            $this->testAssignedCount       = TestAssignment::where('assignee', auth()->user()->id)->whereIn('status', ['Assigned'])->count();
            $this->AliquotingAssignedCount = AliquotingAssignment::where('assignee', auth()->user()->id)->whereIn('status', ['Assigned'])->count();
            $this->rejectedResultsCount    = TestResult::where(['status' => 'Rejected', 'performed_by' => auth()->user()->id, 'creator_lab' => auth()->user()->laboratory_id])->count();
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
            $this->testsRejectedCount      = TestResult::where('creator_lab', auth()->user()->laboratory_id)->where('status', 'Rejected')->count();
        }

        if (Auth::user()->hasPermission(['approve-results'])) {
            $this->testsPendindApprovalCount = TestResult::where('creator_lab', auth()->user()->laboratory_id)->where('status', 'Reviewed')->count();
        }

        if (Auth::user()->hasPermission(['view-result-reports'])) {
            $this->testReportsCount    = TestResult::where('creator_lab', auth()->user()->laboratory_id)->where('status', 'Approved')->count();
            $this->testsPerformedCount = TestResult::where('creator_lab', auth()->user()->laboratory_id)->count();
        } else {
            $this->testReportsCount    = 0;
            $this->testsPerformedCount = 0;
        }

        if (Auth::user()->hasPermission(['manage-users'])) {
            $this->usersCount       = User::where(['is_active' => 1])->count();
            $this->rolesCount       = Role::count();
            $this->permissionsCount = Permission::count();
            $this->laboratoryCount  = Laboratory::where('is_active', 1)->count();
        }

        if (Auth::user()->hasPermission(['access-settings'])) {
            $this->designationCount = Designation::where('is_active', 1)->count();
            $this->facilityCount    = Facility::where('is_active', 1)->whereIn('id', auth()->user()->laboratory->associated_facilities ?? [])->count();           //depends
            $this->studyCount       = Study::where('is_active', 1)->whereIn('id', auth()->user()->laboratory->associated_studies ?? [])->count();                 //depends
            $this->requesterCount   = Requester::where('is_active', 1)->whereIn('study_id', auth()->user()->laboratory->associated_studies ?? [])->count();       //depends
            $this->collectorCount   = Collector::where('is_active', 1)->whereIn('facility_id', auth()->user()->laboratory->associated_facilities ?? [])->count(); //depends
            $this->courierCount     = Courier::where('is_active', 1)->whereIn('facility_id', auth()->user()->laboratory->associated_facilities ?? [])->count();   //depends

            $this->platformCount     = Platform::where('creator_lab', auth()->user()->laboratory_id)->where('is_active', 1)->count();
            $this->kitCount          = Kit::where('creator_lab', auth()->user()->laboratory_id)->where('is_active', 1)->count();
            $this->sampleTypeCount   = SampleType::where('creator_lab', auth()->user()->laboratory_id)->where('status', 1)->count();
            $this->testCategoryCount = TestCategory::where('creator_lab', auth()->user()->laboratory_id)->count();
            $this->testCount         = Test::where('creator_lab', auth()->user()->laboratory_id)->where('status', 1)->count();
        }
    }

    public function loadCounts()
    {

        $user  = auth()->user();
        $labId = $user->laboratory_id;

        if ($user->hasPermission(['accession-samples'])) {
            $this->batchesCount = SampleReception::where('creator_lab', $labId)
                ->where(function (Builder $query) {
                    $query->whereRaw('samples_accepted != samples_handled')
                        ->orWhereHas('sample', function (Builder $query) {
                            $query->whereNull('tests_requested')->orWhere('test_count', 0);
                        });
                })->count();
        }

        if ($user->hasPermission(['view-participant-info'])) {
            $this->participantCount = $this->sampleData()->distinct()->count('participant_id');
            $this->samplesCount     = $this->sampleData()->count();
        }

        if ($user->hasPermission(['enter-results'])) {
            $this->testAssignedCount       = TestAssignment::where('assignee', $user->id)->where('status', 'Assigned')->count();
            $this->AliquotingAssignedCount = AliquotingAssignment::where('assignee', $user->id)->where('status', 'Assigned')->count();
        }

        if ($user->hasPermission(['assign-test-requests'])) {
            $this->testRequestsCount = $this->sampleData()
                ->whereIn('sample_is_for', ['Testing', 'Aliquoting', 'Storage'])
                ->whereIn('status', ['Accessioned', 'Processing'])
                ->where(function ($query) {
                    $query->whereNotNull('tests_requested')->where('test_count', '>', 0)
                        ->orWhere(function ($query) {
                            $query->where('sample_is_for', 'Storage')->whereNull('tests_requested');
                        });
                })->count();
        }

        // Grouped query for TestResult status counts
        if ($user->hasPermission(['enter-results', 'review-results', 'approve-results', 'view-result-reports'])) {
            $results = TestResult::selectRaw("
                COUNT(*) as total,
                SUM(CASE WHEN status = 'Rejected' THEN 1 ELSE 0 END) as rejected,
                SUM(CASE WHEN status = 'Pending Review' THEN 1 ELSE 0 END) as pending_review,
                SUM(CASE WHEN status = 'Reviewed' THEN 1 ELSE 0 END) as pending_approval,
                SUM(CASE WHEN status = 'Approved' THEN 1 ELSE 0 END) as approved
            ")->where('creator_lab', $labId)->first();

            $this->testsRejectedCount        = $results->rejected;
            $this->testsPendindReviewCount   = $results->pending_review;
            $this->testsPendindApprovalCount = $results->pending_approval;
            $this->testReportsCount          = $results->approved;
            $this->testsPerformedCount       = $results->total;

            if ($user->hasPermission(['enter-results'])) {
                $this->rejectedResultsCount = TestResult::where([
                    'status'       => 'Rejected',
                    'performed_by' => $user->id,
                    'creator_lab'  => $labId,
                ])->count();
            }
        }

        // Management and settings counts (cache these where possible)
        if ($user->hasPermission(['manage-users'])) {
            $this->usersCount       = User::where('is_active', 1)->count();
            $this->rolesCount       = cache()->remember('roles_count', 600, fn() => Role::count());
            $this->permissionsCount = cache()->remember('permissions_count', 600, fn() => Permission::count());
            $this->laboratoryCount  = cache()->remember('labs_count', 600, fn() => Laboratory::where('is_active', 1)->count());
        }

        if ($user->hasPermission(['access-settings'])) {
            $facilities = $user->laboratory->associated_facilities ?? [];
            $studies    = $user->laboratory->associated_studies ?? [];

            $this->designationCount = cache()->remember('designation_count', 600, fn() => Designation::where('is_active', 1)->count());
            $this->facilityCount    = Facility::where('is_active', 1)->whereIn('id', $facilities)->count();
            $this->studyCount       = Study::where('is_active', 1)->whereIn('id', $studies)->count();
            $this->requesterCount   = Requester::where('is_active', 1)->whereIn('study_id', $studies)->count();
            $this->collectorCount   = Collector::where('is_active', 1)->whereIn('facility_id', $facilities)->count();
            $this->courierCount     = Courier::where('is_active', 1)->whereIn('facility_id', $facilities)->count();

            $this->platformCount     = Platform::where('creator_lab', $labId)->where('is_active', 1)->count();
            $this->kitCount          = Kit::where('creator_lab', $labId)->where('is_active', 1)->count();
            $this->sampleTypeCount   = SampleType::where('creator_lab', $labId)->where('status', 1)->count();
            $this->testCategoryCount = TestCategory::where('creator_lab', $labId)->count();
            $this->testCount         = Test::where('creator_lab', $labId)->where('status', 1)->count();
        }
    }

    public function updateNav($target)
    {
        if ($target == 'testsPendindReviewCount') {
            $this->testsPendindReviewCount--;
            $this->navItem = 'samplemgt';
            $this->link    = 'review';
        } elseif ($target == 'testsPendindApprovalCount') {
            $this->testsPendindApprovalCount--;
            $this->testReportsCount++;
            $this->navItem = 'samplemgt';
            $this->link    = 'approve';
        }
    }

    public function render()
    {
        return view('livewire.layout.navigation-component');
    }
}
