<?php

use App\Http\Controllers\Api\SearchController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\LocationController;
use Illuminate\Support\Facades\Artisan;

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

Route::get('/dashboard', function () {
    return redirect('/');
});
// Route::get('/', function () {

//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::middleware(['auth:sanctum', 'verified'])->get('/', [DeviceController::class, 'index'])->name('dashboard');

Route::get('/device/show/{id}', [DeviceController::class, 'show'])->name('Device.show');
Route::post('/device/create', [DeviceController::class, 'create'])->name('Device.create');
Route::delete('/device/delete/{id}', [DeviceController::class, 'delete'])->name('Device.delete');
Route::put('/device/rename/{id}', [DeviceController::class, 'rename'])->name('Device.rename');
Route::put('/device/hidden/{id}', [DeviceController::class, 'hidden'])->name('Device.hidden');

Route::get('/location/show', [LocationController::class, 'show'])->name('Location.show');
Route::post('/location/create', [LocationController::class, 'create'])->name('Location.create');
Route::delete('/location/delete/{id}', [LocationController::class, 'delete'])->name('Location.delete');
Route::put('/location/rename/{id}', [LocationController::class, 'rename'])->name('Location.rename');
Route::put('/location/hidden/{id}', [LocationController::class, 'hidden'])->name('Location.hidden');

Route::get('/search-devices/{q}',[SearchController::class,'searchDevices'])->name('searchDevices');


// Artisan
Route::get('art/migrate', function () {
    Artisan::call('php artisan migrate');
});
