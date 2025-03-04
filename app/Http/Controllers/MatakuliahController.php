<?php

namespace App\Http\Controllers;

use App\Models\Matakuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MatakuliahController extends Controller
{
    public function index()
    {
        $matakuliah = Matakuliah::all();
        return response()->json([
            'message' => 'Mata Kuliah berhasil ditampilkan!',
            'data' => $matakuliah
        ]);
    }

    public function show($id)
    {
        $matakuliah = Matakuliah::findOrFail($id);
        return response()->json([
            'message' => 'Mata Kuliah berhasil ditampilkan!',
            'data' => $matakuliah
        ]);
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
        return response()->json([
            'message' => 'Mata Kuliah berhasil ditambahkan!',
            'data' => $matakuliah
        ]);
    }

    public function update(Request $request, Matakuliah $matakuliah)
    {
        $matakuliah->update([
            'nama_mata_kuliah' => $request->nama_mata_kuliah,   
            'kode_mata_kuliah' => $request->kode_mata_kuliah,
            'sks' => $request->sks,
        ]);
    
        return response()->json([
            'message' => 'Mata Kuliah berhasil diubah!',
            'data' => $matakuliah
        ]);
    }
    

    public function destroy($id)
    {
        $matakuliah = Matakuliah::findOrFail($id);
        $matakuliah->delete();
        return response()->json([
            'message' => 'Mata Kuliah berhasil dihapus!',
            'data' => $matakuliah
        ]);
    }
}
