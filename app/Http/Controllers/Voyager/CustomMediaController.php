<?php

namespace App\Http\Controllers\Voyager;

use TCG\Voyager\Http\Controllers\VoyagerMediaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CustomMediaController extends VoyagerMediaController
{
    public function store(Request $request)
    {
        $response = parent::store($request);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $compressedPath = 'images/compressed/' . time() . '.jpg';

            $compressedImage = Image::make($image)->encode('jpg', 60);
            Storage::disk('public')->put($compressedPath, (string) $compressedImage);
        }

        return $response;
    }
}
