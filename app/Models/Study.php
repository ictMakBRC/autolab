<?php

namespace App\Models;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Study extends Model
{
    use HasFactory;

    protected $fillable = ['name','description','facility_id','is_active','created_by'];
    
    public function facility(){
        return $this->belongsTo(Facility::class,'facility_id','id');
    }

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
