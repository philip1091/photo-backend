<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SitePage extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function images(){
      return $this->belongsToMany(Image::class);
    }
}
