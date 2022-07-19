<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $fillable = ['imagePath', 'title', 'description', 'latitude', 'longitude'];
    
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
