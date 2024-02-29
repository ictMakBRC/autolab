<?php

namespace App\Models\Lab\SampleManagement;

use App\Models\TestResult;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TestResultAmendment extends Model
{
    use HasFactory;
    public function testResult() {
        return $this->belongsTo(TestResult::class, 'test_result_id', 'id');
    }
    public $fillable=[
        'test_result_id',
        'amendment_type',
        'original_results',
        'amendment_comment',
        'amended_by',
    ];
}
