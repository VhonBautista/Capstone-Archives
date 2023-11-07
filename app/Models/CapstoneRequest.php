<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CapstoneRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'capstone_id',
    ];  

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function capstone()
    {
        return $this->belongsTo(Capstone::class);
    }
}
