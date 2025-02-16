<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function imageCategory()
    {
        return $this->belongsToMany(ImageCategory::class);
    }
    public function sitePage()
    {
        return $this->belongsToMany(SitePage::class);
    }
}
