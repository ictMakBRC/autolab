<?php
namespace App\Models\Admin;

use App\Models\SampleType;
use App\Models\TestResult;
use App\Models\TestCategory;
use App\Models\TestAssignment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Test extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'short_code',
        'price',
        'tat',
        'reference_range_min',
        'reference_range_max',
        'precautions',
        'result_type',
        'absolute_results',
        'measurable_result_uom',
        'comments',
        'parameters',
        'result_presentation',
        'parameter_uom',
        'status',
        'created_by',
        'creator_lab',
        'accreditation',
        'preliminary_tests',
    ];

    // protected $casts = ['absolute_results' => 'array', 'comments' => 'array', 'parameters' => 'array', 'sub_tests' => 'array'];

       protected $casts = [
        'absolute_results' => 'array',
        'sub_tests' => 'array',
        'parameters' => 'array',
        'preliminary_tests' => 'array', // New cast
        'comments' => 'array',
        'is_active' => 'boolean',
        'tat' => 'integer',
        'price' => 'decimal:2',
    ];

    /**
     * Get all preliminary tests for this test
     */
    public function preliminaryTestsList()
    {
        return $this->belongsToMany(
            Test::class,
            'test_id',
            'id'
        )->whereIn('id', $this->preliminary_tests ?? []);
    }

    /**
     * Get preliminary test models
     */
    public function getPreliminaryTestsAttribute()
    {
        if (!isset($this->attributes['preliminary_tests'])) {
            return collect([]);
        }

        $prelimIds = json_decode($this->attributes['preliminary_tests'], true);
        
        if (empty($prelimIds)) {
            return collect([]);
        }

        return Test::whereIn('id', $prelimIds)->get();
    }

    /**
     * Check if this test has preliminary tests
     */
    public function hasPreliminaryTests(): bool
    {
        $prelimTests = $this->attributes['preliminary_tests'] ?? null;
        
        if (is_string($prelimTests)) {
            $prelimTests = json_decode($prelimTests, true);
        }
        
        return !empty($prelimTests);
    }

    /**
     * Get test results
     */
    public function testResults()
    {
        return $this->hasMany(TestResult::class, 'test_id');
    }

    /**
     * Get test assignments
     */
    public function testAssignment()
    {
        return $this->hasMany(TestAssignment::class, 'test_id');
    }

    /**
     * Get category
     */
    public function category()
    {
        return $this->belongsTo(TestCategory::class, 'category_id');
    }

    /**
     * Get sample type
     */
    public function sampleType()
    {
        return $this->belongsTo(SampleType::class, 'sample_type_id');
    }

    /**
     * Scope for active tests
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for tests with preliminary tests
     */
    public function scopeHasPreliminary($query)
    {
        return $query->whereNotNull('preliminary_tests')
            ->where('preliminary_tests', '!=', '[]');
    }


    public $guarded = [];

    public static function boot()
    {
        parent::boot();
        if (Auth::check()) {
            self::creating(function ($model) {
                $model->created_by  = auth()->id();
                $model->creator_lab = auth()->user()->laboratory_id;
            });
        }
    }

    public static function search($search)
    {
        return empty($search) ? static::query()
        : static::query()
            ->where('creator_lab', auth()->user()->laboratory_id)
            ->where('name', 'like', '%' . $search . '%')
            ->orWhere('short_code', 'like', '%' . $search . '%')
            ->orWhere('price', 'like', '%' . $search . '%')
            ->orWhere('result_type', 'like', '%' . $search . '%')
            ->orWhereHas('category', function ($query) use ($search) {
                $query->where('category_name', 'like', '%' . $search . '%');
            });
    }
}
