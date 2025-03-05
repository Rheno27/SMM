<?php

namespace App\Http\Controllers;

use App\Models\Matakuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ResponseHelper;

class MatakuliahController extends Controller
{
    public function index()
    {
        $matakuliah = Matakuliah::all();
        return ResponseHelper::success('Mata Kuliah berhasil ditampilkan!', $matakuliah);
    }

    public function show($id)
    {
        $matakuliah = Matakuliah::find($id);
        if (!$matakuliah) {
                return ResponseHelper::error('Mata Kuliah tidak ditemukan!', 404);
        }
        return ResponseHelper::success('Mata Kuliah berhasil ditampilkan!', $matakuliah);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_mata_kuliah' => 'required|string|max:100',
            'kode_mata_kuliah' => 'required|string|max:10|unique:mata_kuliah,kode_mata_kuliah',
            'sks' => 'required|integer|min:1|max:6',
        ]);

        $matakuliah = Matakuliah::create([
            'nama_mata_kuliah' => $request->nama_mata_kuliah,
            'kode_mata_kuliah' => $request->kode_mata_kuliah,
            'sks' => $request->sks,
        ]);
        return ResponseHelper::success('Mata Kuliah berhasil ditambahkan!', $matakuliah);
    }

    public function update(Request $request, $id)
    {
        $matakuliah = Matakuliah::find($id);
        if (!$matakuliah) {
            return ResponseHelper::error('Mata Kuliah tidak ditemukan!', 404);
        }
        $request->validate([
            'nama_mata_kuliah' => 'sometimes|string|max:100',
            'kode_mata_kuliah' => 'sometimes|string|max:10|unique:mata_kuliah,kode_mata_kuliah',
            'sks' => 'sometimes|integer|min:1|max:6',
        ]);

        $matakuliah->update($request->only('nama_mata_kuliah', 'kode_mata_kuliah', 'sks'));
    
        return ResponseHelper::success('Mata Kuliah berhasil diubah!', $matakuliah);
    }

    public function destroy($id)
    {
        $matakuliah = Matakuliah::find($id);
        $matakuliah->mahasiswa()->detach();
        if (!$matakuliah) {
            return ResponseHelper::error('Mata Kuliah tidak ditemukan!', 404);
        }
    
        $matakuliah->delete();
        return ResponseHelper::success('Mata Kuliah berhasil dihapus!', $matakuliah);
    }
    
}
