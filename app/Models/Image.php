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
                $compressedFileName = "images/compressed/{$timestamp}.webp"; // Store as WebP

                $img = ImageProcessor::make($uploadedImage);

                $maxFileSize = 80 * 1024; // Target file size: 80 KB
                $quality = 85; // Start with a high quality (85)

                // Compress the image and reduce the quality to fit the target file size
                do {
                    // Compress and convert to WebP
                    $compressedImage = $img->encode('webp', $quality);
                    $quality -= 5;
                } while (strlen($compressedImage) > $maxFileSize && $quality > 10); // Reduce quality until the size is acceptable

                // Store the compressed WebP image in the 'public' storage disk
                Storage::disk('public')->put($compressedFileName, (string) $compressedImage);

                // Store the path of the compressed WebP image
                $image->compressed_image = $compressedFileName;
            }
        });

        static::deleting(function ($image) {
            if ($image->compressed_image && Storage::disk('public')->exists($image->compressed_image)) {
                Storage::disk('public')->delete($image->compressed_image); // Delete compressed image when record is deleted
            }
        });
    }

    // This method is used to return the URL of the compressed image.
    public function getImagePathAttribute()
    {
        return Storage::url($this->compressed_image);
    }
}
