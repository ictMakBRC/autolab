<?php

namespace App\Models;

use App\Models\Study;
use App\Models\Collector;
use App\Models\Requester;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sample extends Model
{
    use HasFactory;

    protected $fillable = ['participant_id', 'sample_type_id', 'sample_no', 'sample_identity', 'lab_no', 'requested_by', 'date_requested', 'collected_by', 'date_collected',

        'study_id', 'sample_is_for', 'priority', 'tests_requested', 'created_by', 'creator_lab', ];

    protected $casts = [
        'tests_requested' => 'array',
    ];

    public function participant()
    {
        return $this->belongsTo(Participant::class, 'participant_id', 'id');
    }

    public function sampleType()
    {
        return $this->belongsTo(SampleType::class, 'sample_type_id', 'id');
    }

    public function study()
    {
        return $this->belongsTo(Study::class, 'study_id', 'id');
    }

    public function requester()
    {
        return $this->belongsTo(Requester::class, 'requested_by', 'id');
    }

    public function collector()
    {
        return $this->belongsTo(Collector::class, 'collected_by', 'id');
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