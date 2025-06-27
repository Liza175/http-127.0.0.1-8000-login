<?php

use App\Http\Controllers\MahasiswaController;
use Illuminate\Support\Facades\Route;

Route::apiResource('/mahasiswa', MahasiswaController::class);
