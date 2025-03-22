<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as ImageProcessor;

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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($image) {
            if (request()->hasFile('image')) {
                $uploadedImage = request()->file('image');

                $timestamp = time();
                $compressedFileName = "images/compressed/{$timestamp}.jpg";

                $img = ImageProcessor::make($uploadedImage);

                $maxFileSize = 80 * 1024;
                $quality = 85;

                do {
                    $compressedImage = $img->encode('jpg', $quality);
                    $quality -= 5;
                } while (strlen($compressedImage) > $maxFileSize && $quality > 10);

                Storage::disk('public')->put($compressedFileName, (string) $compressedImage);

                $image->compressed_image = $compressedFileName;
            }
        });

        static::deleting(function ($image) {
            if ($image->compressed_image && Storage::disk('public')->exists($image->compressed_image)) {
                Storage::disk('public')->delete($image->compressed_image);
            }
        });
    }

    public function getImagePathAttribute()
    {
        return Storage::url($this->compressed_image);
    }
}
