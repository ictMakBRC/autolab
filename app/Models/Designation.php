<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Designation extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'status', 'created_by'];

    public function users()
    {
        return $this->hasMany(User::class);
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
