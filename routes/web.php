<?php

use App\Http\Controllers\AutoController;
use App\Http\Controllers\HomeController;
use App\Models\Auto;
use Illuminate\Support\Arr;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
Auth::routes();

Route::get('/', function () {
    return view('index');
});

Route::get('/home', function () {
    if (auth()->check())
        return redirect('/autos');
    else
        return redirect('/');
});

Route::resource('/autos', AutoController::class);

Route::get('/catalogo', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/detalle/{id}', [App\Http\Controllers\HomeController::class, 'detalle']);

Route::get('/admin', function () {
    return redirect('/autos');
})->middleware('auth');

Route::post('/setactive/{id}', [App\Http\Controllers\AutoController::class, 'setActive'])->middleware('auth');
Route::post('/updatephoto', [App\Http\Controllers\AutoController::class, 'updatePhoto'])->middleware('auth');
Route::post('/reorderphotos', [App\Http\Controllers\AutoController::class, 'reorderPhotos'])->middleware('auth');
