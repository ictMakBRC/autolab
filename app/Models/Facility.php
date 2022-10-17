<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Facility extends Model
{
    use HasFactory;

    // protected $fillable = ['facility_name','facility_type','parent_id','requester_name','requester_contact','requester_email'];
    protected $fillable = ['name', 'type', 'parent_id', 'is_active', 'created_by', ''];

    public function parent()
    {
        return $this->belongsTo(Facility::class, 'parent_id', 'id');
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
