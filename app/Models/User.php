<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'surname',
        'first_name',
        'other_name',
        'name',
        'email',
        'password',
        'laboratory_id',
        'designation_id',
        'contact',
        'title',
        'avatar',
        'signature',
        'is_active',
        'color_scheme',
        'created_by',
        'emp_id',
    ];

    public function laboratory()
    {
        return $this->belongsTo(Laboratory::class, 'laboratory_id', 'id');
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id', 'id');
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->title.' '.$this->surname.' '.$this->first_name.' '.$this->other_name,
        );
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
