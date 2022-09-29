<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\CodeCoverage\Report\Xml\Tests;

class TestResults extends Model
{
    use HasFactory;
    protected $fillable = [
        'test_id',
        'result_type',
        'possible_result',
        'uom',
        'user_id',
    ];

    public function test_type(){
        return $this->belongsTo(Tests::class);
    }
    
    public static function boot()
    {
        parent::boot();
        if(Auth::check()){
            self::creating(function ($model) 
            {
            $model->user_id = auth()->id();
            });
        }
    }
}
