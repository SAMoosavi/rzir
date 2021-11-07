<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\LocationController;

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

Route::middleware(['auth:sanctum', 'verified'])->get('/', [DeviceController::class,'index'])->name('dashboard');

Route::get('/device/show/{id}',[DeviceController::class,'show'])->name('Device.show');
Route::post('/device/create',[DeviceController::class,'create'])->name('Device.creat');
Route::delete('/device/delete/{id}',[DeviceController::class,'delete'])->name('Device.delete');
Route::put('/device/update/{id}',[DeviceController::class,'update'])->name('Device.update');

Route::get('/location/show/{id}',[LocationController::class,'show'])->name('Location.show');
Route::post('/location/create',[LocationController::class,'create'])->name('Location.creat');
Route::delete('/location/delete/{id}',[LocationController::class,'delete'])->name('Location.delete');
Route::put('/location/update/{id}',[LocationController::class,'update'])->name('Location.update');

Route::get('/test',function(){
    return view('test');
});
