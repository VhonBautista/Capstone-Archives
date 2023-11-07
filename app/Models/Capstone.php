<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capstone extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'title',
        'description',
        'authors',
        'panels',
        'adviser',
        'year_published',
        'pdf_name',
        'type',
        'view_count',
        'saved_count',
    ];    

    public function images()
    {
        return $this->hasMany(Image::class);
    }
    
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites', 'capstone_id', 'user_id')->withTimestamps();
    }

    public function capstoneRequest()
    {
        return $this->hasOne(CapstoneRequest::class);
    }
}
