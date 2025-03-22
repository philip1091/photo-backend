<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\ImageCategory;
use App\Models\SitePage;
use App\Http\Resources\ImageResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\PageResource;

class ImageController extends Controller
{
    public function allImages() {
        $images = Image::all();
        return ImageResource::collection($images);
    }
    public function allCategories() {
        $categories = ImageCategory::all();
        return CategoryResource::collection($categories);
    }
    public function allPages() {
        $pages = SitePage::all();
        return PageResource::collection($pages);
    }

    public function singlePage($page) {
        $page = SitePage::where('page_name', $page)->first();
        if (!$page) {
            return response()->json(['message' => 'Page not found'], 404);
        }
        $images = $page->images;
        return new PageResource($page->load('images'));
    }
    public function singleCategory($category) {
        $page = ImageCategory::where('name', $category)->first();
        if (!$page) {
            return response()->json(['message' => 'Page not found'], 404);
        }
        $images = $page->images;
        return new CategoryResource($page->load('images'));
    }
}
