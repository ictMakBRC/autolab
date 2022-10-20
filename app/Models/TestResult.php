<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\CodeCoverage\Report\Xml\Tests;

class TestResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'sample_id',
        'test_id',
        'result',
        'attachment',
        'performed_by',
        'comment',
        'reviewed_by',
        'approved_by',
        'reviewed_at',
        'approved_at',
        'status',
        'created_by',
        'creator_lab',
    ];

    public function sample()
    {
        return $this->belongsTo(Sample::class,'sample_id','id');
    }

    public static function boot()
    {
        parent::boot();
        if (Auth::check()) {
            self::creating(function ($model) {
                $model->created_by = auth()->id();
                $model->creator_lab = auth()->user()->laboratory_id;
            });

            self::updating(function ($model) {
                $model->creator_lab = auth()->user()->laboratory_id;
            });
        }
    }
}
