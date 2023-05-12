<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::post('/sort/posts',[SortController::class, 'posts'])->name('api.sort.posts');
Route::post('comidas/deletemultiple', [DeleteController::class, 'DeleteMultiple'])->name('deletemultiple');
Route::post('/upload',[DropzoneController::class,'store'])->name('dropzone.store');

Route::post('/storedata',[CreateUser::class,'storeData'])->name('form.data');
Route::post('/storeimgae',[CreateUser::class,'storeImage'])->name('form.img');

Route::post('/storemultipleimage',[CreateUser::class,'storeMultipleImage'])->name('form.img2');

Route::post('/checkin', 'App\Http\Controllers\CheckinController@store')->name('checkin.store');
Route::get('/check', function () {
    return view('check');
});
