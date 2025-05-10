<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MatakuliahController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\AuthController;

// Auth routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/mahasiswa', [MahasiswaController::class, 'store']);


//routes with middleware for authentication
Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('mahasiswa', MahasiswaController::class)->except(['create', 'edit', 'store']);
    Route::apiResource('matakuliah', MatakuliahController::class)->except(['create', 'edit']);
    Route::apiResource('tugas', TugasController::class)->except(['create', 'edit']);
    Route::post('/mahasiswa/{id}/matakuliah', [MahasiswaController::class, 'tambahMatakuliah']);
});

// Public routes 
Route::get('/mahasiswa', [MahasiswaController::class, 'index']);
Route::get('/mahasiswa/{id}', [MahasiswaController::class, 'show']);
Route::get('/matakuliah', [MatakuliahController::class, 'index']);
Route::get('/matakuliah/{id}', [MatakuliahController::class, 'show']);
Route::get('/tugas', [TugasController::class, 'index']);
Route::get('/tugas/{identifier}', [TugasController::class, 'show']);


