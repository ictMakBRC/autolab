<?php

namespace App\Models\Admin;

use App\Models\TestCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Test extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'short_code',
        'price',
        'reference_range_min',
        'reference_range_max',
        'precautions',
        'result_type',
        'absolute_results',
        'measurable_result_uom',
        'comments',
        'status',
        'created_by',
        'creator_lab',
    ];

    protected $casts = ['absolute_results' => 'array', 'comments' => 'array'];

    public function category()
    {
        return $this->belongsTo(TestCategory::class, 'category_id', 'id');
    }

    public $guarded = [];

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
