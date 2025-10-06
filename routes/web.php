<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SensorLaravel;

Route::get('/', [SensorLaravel::class, 'index']); // halaman utama monitoring
Route::get('/getSuhu', [SensorLaravel::class, 'getSuhu']);
Route::get('/getKelembapan', [SensorLaravel::class, 'getKelembapan']);
Route::get('/getSensorData', [SensorLaravel::class, 'getSensorData']);
Route::get('/simpan/{nilaisuhu}/{nilaikelembapan}', [SensorLaravel::class, ' simpansensor']);