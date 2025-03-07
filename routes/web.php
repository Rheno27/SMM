<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MatakuliahController;
use App\Http\Controllers\TugasController;

// Route untuk halaman utama (bisa diakses tanpa login)
Route::get('/', function () {
    return view('layouts.app');
})->name('home');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/mahasiswa', function () {
    return view('mahasiswa.listmahasiswa');
})->name('mahasiswa');
Route::get('/matakuliah', function () {
    return view('matakuliah.listmatakuliah');
})->name('matakuliah');
Route::get('/tugas', function () {
    return view('tugas.listtugas');
})->name('tugas');



