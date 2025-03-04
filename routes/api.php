<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MatakuliahController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login']);

Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->middleware(['auth:sanctum']);
Route::get('/mahasiswa/{id}', [MahasiswaController::class, 'show']);
Route::post('/mahasiswa', [MahasiswaController::class, 'store']);

Route::get('/matakuliah', [MatakuliahController::class, 'index']);
Route::get('/matakuliah/{id}', [MatakuliahController::class, 'show']);
Route::post('/matakuliah', [MatakuliahController::class, 'store']);

Route::get('/tugas', [TugasController::class, 'index']);
Route::get('/tugas/{identifier}', [TugasController::class, 'show']);
Route::post('/tugas', [TugasController::class, 'store']);
