<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class FacilityInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'facility_name',
        'slogan',
        'about',
        'facility_type',
        'physical_address',
        'address2',
        'contact',
        'contact2',
        'email',
        'email2',
        'tin',
        'logo',
        'website',
        'fax',
        'created_by',
    ];

    public static function boot()
    {
        parent::boot();
        if (Auth::check()) {
            self::creating(function ($model) {
                $model->created_by = auth()->id();
            });
        }
    }
}
