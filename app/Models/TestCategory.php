<?php

namespace App\Models;

use App\Models\Admin\Test;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TestCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_name',
        'description',
        'user_id',
    ];

    protected $table = 'test_categories';

    public static function boot()
    {
        parent::boot();
        if (Auth::check()) {
            self::creating(function ($model) {
                $model->user_id = auth()->id();
            });
        }
    }

    public function tests()
    {
        return $this->hasMany(Test::class, 'category_id', 'id');
    }
}
