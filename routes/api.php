<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MatakuliahController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum']);

Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->middleware(['auth:sanctum']);
Route::get('/mahasiswa/{id}', [MahasiswaController::class, 'show'])->middleware(['auth:sanctum']);
Route::post('/mahasiswa', [MahasiswaController::class, 'store'])->middleware(['auth:sanctum']);

Route::get('/matakuliah', [MatakuliahController::class, 'index'])->middleware(['auth:sanctum']);
Route::get('/matakuliah/{id}', [MatakuliahController::class, 'show'])->middleware(['auth:sanctum']);
Route::post('/matakuliah', [MatakuliahController::class, 'store'])->middleware(['auth:sanctum']);
Route::put('/matakuliah/{id}', [MatakuliahController::class, 'update'])->middleware(['auth:sanctum']);
Route::delete('/matakuliah/{id}', [MatakuliahController::class, 'destroy'])->middleware(['auth:sanctum']);

Route::get('/tugas', [TugasController::class, 'index'])->middleware(['auth:sanctum']);
Route::get('/tugas/{identifier}', [TugasController::class, 'show'])->middleware(['auth:sanctum']);
Route::post('/tugas', [TugasController::class, 'store'])->middleware(['auth:sanctum']);
