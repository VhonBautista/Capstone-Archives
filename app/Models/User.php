<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'avatar',
        'firstname',
        'lastname',
        'middlename',
        'email',
        'gender',
        'type',
        'is_admin',
        'is_verified',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function role()
    {
        return $this->hasOne(Role::class);
    }

    public function verification()
    {
        return $this->hasOne(Verification::class);
    }

    public function logs()
    {
        return $this->hasMany(Log::class);
    }
    
    public function favorites()
    {
        return $this->belongsToMany(Capstone::class, 'favorites', 'user_id', 'capstone_id')->withTimestamps();
    }

    public function capstoneRequest()
    {
        return $this->hasOne(CapstoneRequest::class);
    }
}
