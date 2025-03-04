<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tugas;

class TugasController extends Controller
{
    public function index()
    {
        $tugas = Tugas::all();

        return response()->json([
            'message' => 'Tugas berhasil ditampilkan!',
            'data' => $tugas
        ]);
    }

    public function show($identifier)
    {
        if (!is_numeric($identifier)) {
            return response()->json([
                'message' => 'Parameter harus berupa angka!',
                'data' => []
            ], 400);
        }
    
        $tugas = Tugas::find($identifier);
    
        if ($tugas) {
            return response()->json([
                'message' => 'Tugas berhasil ditampilkan!',
                'data' => $tugas
            ]);
        }
    
        $tugasByMahasiswa = Tugas::where('mahasiswa_id', $identifier)->get();
    
        if ($tugasByMahasiswa->isEmpty()) {
            return response()->json([
                'message' => 'Tugas tidak ditemukan!',
                'data' => []
            ], 404);
        }
    
        return response()->json([
            'message' => 'Tugas mahasiswa berhasil ditampilkan!',
            'data' => $tugasByMahasiswa
        ]);
    }
    
    
}
