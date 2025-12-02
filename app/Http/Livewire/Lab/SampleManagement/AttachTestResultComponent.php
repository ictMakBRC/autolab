<?php
namespace App\Http\Livewire\Lab\SampleManagement;

use App\Models\Admin\Test;
use App\Models\Kit;
use App\Models\Lab\SampleManagent\SampleReferral;
use App\Models\Sample;
use App\Models\TestAssignment;
use App\Models\TestResult;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Livewire\Component;
use Livewire\WithFileUploads;

class AttachTestResultComponent extends Component
{
    use WithFileUploads;

    public $requestedTests;
    public $tests_performed = [];
    public $sample;
    public $sample_id;
    public $test_id;
    public $result;
    public $link;
    public $attachment;
    public $attachmentPath;
    public $performed_by;
    public $comment;
    public $testParameters = [];
    public $status;
    public $sample_identity;
    public $lab_no;
    public $kit_expiry_date;
    public $verified_lot;
    public $kit_id;
    public $activeTest;
    public $today;
    public $tat_comment;
    public $enterOnlyAssigned;
    public $referred_tests;
    public $active_referral;
    public $testResults = [];
    
    // Referral fields
    public $ref_result_file;
    public $received_date;
    public $ref_comments;
    public $ref_result_file_path;
    
    // Preliminary tests fields
    public $preliminaryTests = [];
    public $selectedPreliminaryTests = [];
    public $preliminaryTestResults = [];
    public $showPreliminarySection = false;

    public function mount($id)
    {
        $this->today = Carbon::now();
        $sample = Sample::with('participant')->findOrFail($id);
        $this->referred_tests = SampleReferral::with('referralable')
            ->where('sample_id', $id)
            ->whereIn('test_id', $sample->referred_tests)
            ->get();
        
        $this->sample = $sample;
        $this->sample_id = $sample->id;
        $this->sample_identity = $sample->sample_identity;
        $this->lab_no = $sample->lab_no;
        
        $testsPendingResults = array_diff($sample->tests_requested, $sample->tests_performed ?? []);

        if (auth()->user()->hasPermission('enter-unassigned-results')) {
            $this->enterOnlyAssigned = false;
        } else {
            $this->enterOnlyAssigned = true;
        }
        
        if (count($testsPendingResults) > 0) {
            $this->requestedTests = Test::whereIn('id', (array) $testsPendingResults)
                ->when($this->enterOnlyAssigned, function ($query) {
                    $query->whereHas('testAssignment', function (Builder $query) {
                        $query->where([
                            'assignee' => auth()->user()->id, 
                            'sample_id' => $this->sample_id, 
                            'status' => 'Assigned'
                        ]);
                    });
                })
                ->orderBy('name', 'asc')
                ->get();
            
            // Set the first test in the collection as active
            $this->test_id = $this->requestedTests[0]->id ?? null;
            $this->activeTest = $this->requestedTests->where('id', $this->test_id)->first();
            
            if (!$this->activeTest) {
                return redirect()->route('test-request')
                    ->with('error', 'No tests available for this sample or you do not have permission to enter results for unassigned tests.');
            }
            
            // Load active referral if exists
            if ($this->activeTest && count($this->referred_tests) > 0) {
                $this->active_referral = $this->referred_tests
                    ->where('sample_id', $this->sample_id)
                    ->where('test_id', $this->test_id)
                    ->first();
            }
            
            // Initialize test-specific data
            $this->initializeTestData();
        } else {
            $this->requestedTests = collect([]);
            $this->reset('test_id');
        }

        $this->tests_performed = (array) $sample->tests_performed;
        $this->performed_by = auth()->user()->id;
    }

    protected function initializeTestData()
    {
        if (!$this->activeTest) return;

        // Initialize sub-tests for Multiple result type
        if ($this->activeTest->result_type == 'Multiple' && $this->activeTest->sub_tests) {
            $this->testResults = [];
            foreach ($this->activeTest->sub_tests as $testName) {
                $this->testResults[] = [
                    'test' => $testName,
                    'result' => '',
                    'CtValue' => '',
                    'comment' => '',
                ];
            }
        }

        // Initialize parameters
        if ($this->activeTest->parameters != null) {
            $this->testParameters = [];
            foreach ($this->activeTest->parameters as $parameter) {
                $this->testParameters[$parameter] = '';
            }
        }

        // Initialize preliminary tests
        if ($this->activeTest->preliminary_tests && count($this->activeTest->preliminary_tests) > 0) {
            $this->showPreliminarySection = true;
        //  = array_map('intval', (array) $this->activeTest->preliminary_tests);
        $prelimIds = $this->activeTest->preliminary_tests->pluck('id')->toArray();
$this->preliminaryTests = Test::whereIn('id', array_filter($prelimIds))
    ->where('status', 1)
    ->get();
        } else {
            $this->showPreliminarySection = false;
            $this->preliminaryTests = collect([]);
        }

        // Reset preliminary selections
        $this->selectedPreliminaryTests = [];
        $this->preliminaryTestResults = [];
    }

    public function updatedSelectedPreliminaryTests()
    {
        // Initialize result arrays for selected preliminary tests
        $this->preliminaryTestResults = [];
        foreach ($this->selectedPreliminaryTests as $prelimTestId) {
            $prelimTest = $this->preliminaryTests->firstWhere('id', $prelimTestId);
            if ($prelimTest) {
                $this->preliminaryTestResults[$prelimTestId] = [
                    'test_name' => $prelimTest->name,
                    'result' => '',
                    'comment' => '',
                    'performed_by' => auth()->user()->id,
                ];
            }
        }
    }

    public function storeTestResults()
    {
        $this->validate([
            'performed_by' => 'required|integer',
        ]);

        // Validate main result entry
        if ($this->result == null && $this->link == null && $this->attachment == null && empty($this->testResults)) {
            $this->dispatchBrowserEvent('not-found', [
                'type' => 'error', 
                'message' => 'Please enter/attach results!'
            ]);
            return;
        }

        // Validate Multiple result type
        if ($this->activeTest->result_type == 'Multiple' && !empty($this->testResults)) {
            foreach ($this->testResults as $testResult) {
                if (empty($testResult['result'])) {
                    $this->dispatchBrowserEvent('not-found', [
                        'type' => 'error', 
                        'message' => 'Please fill all sub-test results!'
                    ]);
                    return;
                }
            }
        }

        // Validate preliminary test results if selected
        if (!empty($this->selectedPreliminaryTests)) {
            foreach ($this->selectedPreliminaryTests as $prelimTestId) {
                if (empty($this->preliminaryTestResults[$prelimTestId]['result'])) {
                    $this->dispatchBrowserEvent('not-found', [
                        'type' => 'error', 
                        'message' => 'Please fill all selected preliminary test results!'
                    ]);
                    return;
                }
            }
        }

        // Handle main attachment
        if ($this->attachment != null) {
            $this->validate([
                'attachment' => 'mimes:pdf,xls,xlsx,csv,doc,docx|max:5000',
            ]);
            $attachmentName = date('YmdHis') . '.' . $this->attachment->extension();
            $this->attachmentPath = $this->attachment->storeAs('attachmentResults', $attachmentName);
        } else {
            if ($this->activeTest->result_type == 'File') {
                $this->validate(['attachment' => ['required']]);
            } else {
                $this->attachmentPath = null;
            }
        }

        // Handle referral file upload
        if ($this->active_referral && $this->ref_result_file != null) {
            $this->validate([
                'ref_result_file' => 'mimes:pdf,xls,xlsx,csv,doc,docx|max:5000',
            ]);
            $refFileName = 'ref_' . date('YmdHis') . '.' . $this->ref_result_file->extension();
            $this->ref_result_file_path = $this->ref_result_file->storeAs('referralResults', $refFileName);
        }

        // Validate kit expiry date
        if ($this->kit_expiry_date && Carbon::parse($this->kit_expiry_date)->isPast()) {
            $this->dispatchBrowserEvent('not-found', [
                'type' => 'error', 
                'message' => 'Kit expiry date cannot be in the past!'
            ]);
            return;
        }

        // Filter empty parameters
        $this->testParameters = array_filter($this->testParameters, function ($value) {
            return $value != '';
        });

        // Validate required parameters
        if ($this->activeTest->parameters != null) {
            if (count($this->testParameters) != count($this->activeTest->parameters)) {
                $this->dispatchBrowserEvent('not-found', [
                    'type' => 'error', 
                    'message' => 'Please include parameter values for this result!'
                ]);
                return;
            }
        }

        $this->saveResults();
    }

    public function saveResults()
    {
        try {
            DB::transaction(function () {
                // Save preliminary test results first
                if (!empty($this->selectedPreliminaryTests)) {
                    foreach ($this->selectedPreliminaryTests as $prelimTestId) {
                        $prelimResult = new TestResult();
                        $prelimResult->sample_id = $this->sample_id;
                        $prelimResult->test_id = $prelimTestId;
                        $prelimResult->result = $this->preliminaryTestResults[$prelimTestId]['result'];
                        $prelimResult->comment = $this->preliminaryTestResults[$prelimTestId]['comment'] ?? null;
                        $prelimResult->performed_by = $this->preliminaryTestResults[$prelimTestId]['performed_by'];
                        $prelimResult->status = 'Preliminary';
                        $prelimResult->parent_test_id = $this->test_id; // Link to main test
                        $prelimResult->save();
                    }
                }

                // Save main test result
                $testResult = new TestResult();
                $testResult->sample_id = $this->sample_id;
                $testResult->test_id = $this->test_id;
                
                if ($this->link != null) {
                    $testResult->result = $this->link;
                } else {
                    $test = Test::findOrFail($this->test_id);
                    
                    if ($test->result_type == 'Measurable') {
                        $testResult->result = $this->result . '' . $test->measurable_result_uom;
                    } elseif ($test->result_type == 'Multiple') {
                        $testResult->result = json_encode($this->testResults);
                    } else {
                        $testResult->result = $this->result;
                    }
                }

                $testResult->attachment = $this->attachmentPath;
                $testResult->performed_by = $this->performed_by;
                $testResult->comment = $this->comment;
                $testResult->parameters = count($this->testParameters) ? $this->testParameters : null;
                $testResult->kit_id = $this->kit_id;
                $testResult->verified_lot = $this->verified_lot;
                $testResult->tat_comment = $this->tat_comment;
                $testResult->kit_expiry_date = $this->kit_expiry_date;
                $testResult->status = 'Pending Review';
                
                // Add preliminary test IDs to main result
                if (!empty($this->selectedPreliminaryTests)) {
                    $testResult->preliminary_test_ids = $this->selectedPreliminaryTests;
                }
                
                $testResult->save();

                // Update referral if exists
                if ($this->active_referral) {
                    $this->active_referral->update([
                        'result_file' => $this->ref_result_file_path,
                        'received_date' => $this->received_date,
                        'comments' => $this->ref_comments,
                        'status' => 'Results Received',
                    ]);
                }

                // Update sample and assignment
                array_push($this->tests_performed, "{$testResult->test_id}");
                
                $testAssignment = TestAssignment::where([
                    'sample_id' => $this->sample_id, 
                    'test_id' => $this->test_id
                ])
                ->when($this->enterOnlyAssigned, function ($query) {
                    $query->where('assignee', auth()->user()->id);
                })
                ->first();
                
                $this->sample->update(['tests_performed' => $this->tests_performed]);
                $testAssignment->update(['status' => 'Test Done']);

                // Check if all tests are done
                if (count(array_diff($this->sample->tests_requested, $this->sample->tests_performed)) == 0) {
                    $this->sample->update(['status' => 'Tests Done']);
                    redirect()->route('test-request');
                }

                // Check if user has more assigned tests
                if ($this->enterOnlyAssigned && 
                    TestAssignment::where([
                        'sample_id' => $this->sample_id, 
                        'assignee' => auth()->user()->id, 
                        'status' => 'Assigned'
                    ])->count() == 0) {
                    redirect()->route('test-request');
                }
            });

            // Move to next test
            $this->requestedTests = $this->requestedTests->where('id', '!=', $this->test_id)->values();
            $this->test_id = $this->requestedTests[0]->id ?? null;
            $this->activeTest = $this->requestedTests->where('id', $this->test_id)->first();
            
            if ($this->activeTest) {
                $this->initializeTestData();
            }

            // Send notification
            $details = [
                'subject' => 'Auto-Lab Test',
                'greeting' => 'Hello, I hope this email finds you well',
                'body' => 'You have a pending test Lab No#' . $this->sample->lab_no . ' to review, Please log in and take the necessary actions.',
                'actiontext' => 'Click Here for more details',
                'actionurl' => URL::signedRoute('test-request'),
                'user_id' => $this->sample->laboratory->test_reviewer ?? 1,
            ];

            $this->resetResultInputs();
            $this->dispatchBrowserEvent('alert', [
                'type' => 'success', 
                'message' => 'Test Results Recorded successfully!'
            ]);

        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('not-found', [
                'type' => 'error', 
                'message' => 'An error occurred while saving the test results: ' . $e->getMessage()
            ]);
        }
    }

    public function activateResultInput($id)
    {
        $this->resetResultInputs();
        $this->activeTest = $this->requestedTests->where('id', $id)->first();
        $this->test_id = $id;
        
        // Load active referral if exists
        if (count($this->referred_tests) > 0) {
            $this->active_referral = $this->referred_tests
                ->where('sample_id', $this->sample_id)
                ->where('test_id', $this->test_id)
                ->first();
        }
        
        $this->initializeTestData();
    }

    public function resetResultInputs()
    {
        $this->reset([
            'result', 
            'link', 
            'attachment', 
            'comment', 
            'attachmentPath', 
            'kit_id', 
            'verified_lot', 
            'kit_expiry_date',
            'testResults',
            'ref_result_file',
            'ref_result_file_path',
            'received_date',
            'ref_comments',
            'tat_comment',
            'selectedPreliminaryTests',
            'preliminaryTestResults'
        ]);
        $this->testParameters = [];
    }

    public function close()
    {
        $this->resetResultInputs();
    }

    public function getTatHours()
    {
        if (!$this->activeTest || !$this->sample) return 0;
        
        $dateRequested = Carbon::parse(
            $this->sample->sampleReception->date_delivered ?? $this->sample->date_requested
        );
        return $dateRequested->diffInHours($this->today);
    }

    public function render()
    {
        $data['users'] = User::where([
            'is_active' => 1, 
            'laboratory_id' => auth()->user()->laboratory_id
        ])->get();
        
        $data['testsRequested'] = $this->requestedTests ?? collect();
        $data['kits'] = Kit::where('is_active', 1)->get();
        $data['tatHours'] = $this->getTatHours();

        return view('livewire.lab.sample-management.attach-test-result-component', $data);
    }
}