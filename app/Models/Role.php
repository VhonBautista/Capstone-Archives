<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'manage_request',
        'manage_create',
        'manage_update',
        'manage_delete',
        'manage_approval',
        'manage_user',
        'manage_verification',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
