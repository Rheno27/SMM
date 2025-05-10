<?php

use Illuminate\Support\Facades\Route;

// Halaman utama
Route::view('/', 'layouts.app')->name('home');

// Halaman login
Route::view('/login', 'login')->name('login');

// Halaman lainnya
Route::view('/mahasiswa', 'mahasiswa.listmahasiswa')->name('mahasiswa');
Route::view('/matakuliah', 'matakuliah.listmatakuliah')->name('matakuliah');
Route::view('/tugas', 'tugas.listtugas')->name('tugas');
