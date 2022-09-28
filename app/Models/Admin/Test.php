<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
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
}
