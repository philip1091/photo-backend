<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/images', [ImageController::class, 'allImages']);
Route::get('/categories', [ImageController::class, 'allCategories']);
Route::get('/pages', [ImageController::class, 'allPages']);

// Route::get('/images/{page}', function(){
//     return ['message' => 'hello'];
// });

// Route::get('/images/{category}', function(){
//     return ['message' => 'hello'];
// });
