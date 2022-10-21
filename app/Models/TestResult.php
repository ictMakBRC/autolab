<?php

namespace App\Models;

use App\Models\Admin\Test;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
        return $this->belongsTo(Sample::class, 'sample_id', 'id');
    }

    public function test()
    {
        return $this->belongsTo(Test::class, 'test_id', 'id');
    }

    public function performer()
    {
        return $this->belongsTo(User::class, 'performed_by', 'id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by', 'id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by', 'id');
    }

    protected function createdAt(): Attribute
    {
        return new Attribute(
            get: fn ($value) => Carbon::parse($value)->format('d-m-Y H:i'),
            // set: fn ($value) =>  Carbon::parse($value)->format('Y-m-d'),
        );
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
