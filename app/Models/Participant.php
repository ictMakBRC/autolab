<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = ['sample_reception_id', 'participant_no', 'identity', 'age', 'gender', 'contact', 'address', 'nok_contact', 'nok_address',

        'clinical_notes', 'title', 'nin_number', 'surname', 'first_name', 'other_name', 'nationality', 'district', 'dob', 'email', 'birth_place', 'religious_affiliation', 'occupation', 'civil_status', 'nok', 'nok_relationship',
        'created_by', 'creator_lab', ];

    public function sampleReception()
    {
        return $this->belongsTo(SampleReception::class, 'sample_reception_id', 'id');
    }

    public function sample()
    {
        return $this->hasOne(Sample::class, 'participant_id', 'id');
    }

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->title.' '.$this->surname.' '.$this->first_name.' '.$this->other_name,
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
