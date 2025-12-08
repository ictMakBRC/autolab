<?php
namespace App\Models;

use App\Models\Admin\Test;
use App\Models\Lab\SampleManagement\TestResultAmendment;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class TestResult extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logFillable()
            ->useLogName('test_results')
            ->dontLogIfAttributesChangedOnly(['updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }

    protected $fillable = [
        'sample_id',
        'test_id',
        'result',
        'attachment',
        'parameters',
        'performed_by',
        'comment',
        'reviewed_by',
        'reviewer_comment',
        'approved_by',
        'approver_comment',
        'reviewed_at',
        'approved_at',
        'status',
        'tracker',
        'download_count',
        'created_by',
        'creator_lab',
        'kit_id',
        'platform_id',
        'verified_lot',
        'kit_expiry_date',
        'tat_comment',
        'amended_state',
        'amendment_type',
        'original_results',
        'amendment_comment',
        'amended_by',
        'amended_at',
        'preliminary_test_ids'
    ];

     protected $casts = [
        'parameters' => 'array',
        'preliminary_test_ids' => 'array', // New cast
        'kit_expiry_date' => 'date',
        'reviewed_at' => 'datetime',
        'approved_at' => 'datetime',
        'results'    => 'array',
    ];


    /**
     * Get the test that owns the test result
     */
    public function test()
    {
        return $this->belongsTo(Test::class, 'test_id');
    }

    /**
     * Get the parent test if this is a preliminary result
     */
    public function parentTest()
    {
        return $this->belongsTo(Test::class, 'parent_test_id');
    }

    /**
     * Get all preliminary test results for this main test result
     */
    public function preliminaryResults()
    {
        return $this->hasMany(TestResult::class, 'parent_test_id', 'test_id')
            ->where('sample_id', $this->sample_id)
            ->where('status', 'Preliminary');
    }

    /**
     * Get the kit used
     */
    public function kit()
    {
        return $this->belongsTo(Kit::class);
    }


    /**
     * Get the user who reviewed the test
     */


    /**
     * Scope for preliminary results
     */
    public function scopePreliminary($query)
    {
        return $query->where('status', 'Preliminary')
            ->whereNotNull('parent_test_id');
    }

    /**
     * Scope for main results (not preliminary)
     */
    public function scopeMainResults($query)
    {
        return $query->whereNull('parent_test_id')
            ->orWhere('status', '!=', 'Preliminary');
    }

    /**
     * Scope for pending review
     */
    public function scopePendingReview($query)
    {
        return $query->where('status', 'Pending Review');
    }

    /**
     * Scope for approved results
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'Approved');
    }

    /**
     * Check if this is a preliminary test result
     */
    public function isPreliminary(): bool
    {
        return $this->status === 'Preliminary' && $this->parent_test_id !== null;
    }

    /**
     * Check if this result has preliminary tests
     */
    public function hasPreliminaryResults(): bool
    {
        return !empty($this->preliminary_test_ids);
    }

    /**
     * Get preliminary test results
     */
    public function getPreliminaryTestResults()
    {
        if (!$this->hasPreliminaryResults()) {
            return collect([]);
        }

        return TestResult::where('sample_id', $this->sample_id)
            ->where('parent_test_id', $this->test_id)
            ->where('result_type', 'Preliminary')
            ->with('test', 'performer')
            ->get();
    }
    public function sample()
    {
        return $this->belongsTo(Sample::class, 'sample_id', 'id');
    }

    public function testResultAmendment()
    {
        return $this->hasMany(TestResultAmendment::class, 'test_result_id', 'id');
    }

    public function performer()
    {
        return $this->belongsTo(User::class, 'performed_by', 'id');
    }

    public function laboratory()
    {
        return $this->belongsTo(Laboratory::class, 'creator_lab', 'id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by', 'id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by', 'id');
    }
    public function amendedBy()
    {
        return $this->belongsTo(User::class, 'amended_by', 'id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    protected function createdAt(): Attribute
    {
        return new Attribute(
            get: fn($value) => Carbon::parse($value)->format('d-m-Y H:i'),
            // set: fn ($value) =>  Carbon::parse($value)->format('Y-m-d'),
        );
    }


    public static function boot()
    {
        parent::boot();
        if (Auth::check()) {
            self::creating(function ($model) {
                $model->created_by  = auth()->id();
                $model->creator_lab = auth()->user()->laboratory_id;
                $model->tracker     = '#' . time() . rand(10, 99);
            });

            self::updating(function ($model) {
                $model->creator_lab = auth()->user()->laboratory_id;
            });
        }
    }

    public function calculateTAT()
    {
        if (! $this->approved_at || ! $this->sample->date_collected) {
            return null;
        }

        $collectionDate = Carbon::parse($this->sample->date_collected);
        $approvalDate   = Carbon::parse($this->approved_at);

        return $approvalDate->diffInDays($collectionDate);
    }

    public static function resultSearch($search, $status=null)
    {
        return empty($search) ? static::query()
        : static::query()
            ->where('creator_lab', auth()->user()->laboratory_id)
            ->where(
                function ($query) use ($search, $status) {
                $query->when($status, function ($query) use ($status) {$query->where('status', $status); })
                        ->whereHas('sample.participant', function ($query) use ($search) {
                            $query->where('identity', 'like', '%' . $search . '%');
                        });
                }
            )
            ->where(
                function ($query) use ($search, $status) {
                    $query->when($status, function ($query) use ($status) {$query->where('status', $status); })
                        ->whereHas('sample', function ($query) use ($search) {
                            $query->where('sample_identity', 'like', '%' . $search . '%');
                        });
                }
            )
            ->where(
                function ($query) use ($search, $status) {
                    $query->when($status, function ($query) use ($status) {$query->where('status', $status); })
                        ->whereHas('sample', function ($query) use ($search) {
                            $query->where('sample_no', 'like', '%' . $search . '%');
                        });
                }
            )
            ->where(
                function ($query) use ($search, $status) {
                    $query->when($status, function ($query) use ($status) {$query->where('status', $status); })
                        ->whereHas('sample', function ($query) use ($search) {
                            $query->where('lab_no', 'like', '%' . $search . '%');
                        });
                }
            )
            ->orWhere(
                function ($query) use ($search, $status) {
                    $query->when($status, function ($query) use ($status) {$query->where('status', $status); })
                        ->whereDate('created_at', date('Y-m-d', strtotime($search)));
                }
            )
            ->orWhere(
                function ($query) use ($search, $status) {
                    $query->when($status, function ($query) use ($status) {$query->where('status', $status); })
                        ->where('tracker', 'like', '%' . $search . '%');
                }
            )
            ->orWhere(
                function ($query) use ($search, $status) {
                    $query->when($status, function ($query) use ($status) {$query->where('status', $status); })
                        ->whereHas('sample.study', function ($query) use ($search) {
                            $query->where('name', 'like', '%' . $search . '%');
                        });
                }
            )
            ->orWhere(
                function ($query) use ($search, $status) {
                    $query->when($status, function ($query) use ($status) {$query->where('status', $status); })
                        ->whereHas('sample.sampleReception', function ($query) use ($search) {
                            $query->where('batch_no', 'like', '%' . $search . '%');
                        });
                }
            )
            ->orWhere(
                function ($query) use ($search, $status) {
                    $query->when($status, function ($query) use ($status) {$query->where('status', $status); })
                        ->whereHas('sample', function ($query) use ($search) {
                            $query->where('lab_no', $search);
                        });
                }
            )
            ->orWhere(
                function ($query) use ($search, $status) {
                  $query->when($status, function ($query) use ($status) {$query->where('status', $status); })
                        ->whereHas('sample.requester', function ($query) use ($search) {
                            $query->where('name', 'like', '%' . $search . '%');
                        });
                }
            )
            ->orWhere(
                function ($query) use ($search, $status) {
                   $query->when($status, function ($query) use ($status) {$query->where('status', $status); })
                        ->whereHas('test', function ($query) use ($search) {
                            $query->where('name', 'like', '%' . $search . '%');
                        });
                }
            );
    }

    public static function targetSearch($search)
    {
        return empty(trim($search)) ? static::query()
        : static::query()
            ->where(['creator_lab' => auth()->user()->laboratory_id,
                'status'               => 'Approved',
                'tracker'              => trim($search),
            ]);
    }
}
