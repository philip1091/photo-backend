<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Voyager\CustomMediaController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });



Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
    // Route::post('media', [CustomMediaController::class, 'store'])->name('voyager.media.store');
    // Route::post('media/upload', [CustomMediaController::class, 'store'])->name('voyager.media.upload');

});

//App\Http\Controllers\Voyager\CustomMediaController
