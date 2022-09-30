<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SampleType extends Model
{
    use HasFactory;
    protected $fillable = ['sample_name', 'stauts'];
    public static function boot()
    {
        parent::boot();
        if(Auth::check()){
            self::creating(function ($model) 
            {
            $model->created_by = auth()->id();
            });
        }
    }
}
