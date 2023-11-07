<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'capstone_id',
        'img_path',
    ];    

    public function capstone()
    {
        return $this->belongsTo(Capstone::class);
    }
}
