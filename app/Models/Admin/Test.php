<?php

namespace App\Models\Admin;

use App\Models\TestCategory;
use App\Models\TestComment;
use App\Models\TestSampleType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Test extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $fillable = [
        'category_id',
        'parent_id',
        'name',
        'short_code',
        'code',
        'unit',
        'reference_range_min',
        'reference_range_max',
        'price',
        'status',
        'precautions',
        'extra_details',
       'created_by',
    ];
    protected $casts = ['status' => 'boolean', 'code' => 'string', 'extra_details' => 'object'];
    public function comments()
    {
        return $this->hasMany(TestComment::class,'test_id','id')->orderBy('id','asc');
    }
    public function samples()
    {
        return $this->hasMany(TestSampleType::class,'test_id','id');
    }
    public function category()
    {
        return $this->belongsTo(TestCategory::class,'category_id','id');
    }
    public $guarded=[];
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
