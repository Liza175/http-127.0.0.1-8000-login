<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//    return view('dashboard');
// });
// Route::get('/mahasiswa', function() {
//    return view('mahasiswa');
// })->name('mahasiswa');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    });
});

Route::get('/mahasiswa', function () {
    return view('mahasiswa');
})->name('mahasiswa');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');



