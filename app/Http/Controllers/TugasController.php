<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tugas;
use Illuminate\Support\Facades\Auth;


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

    public function store(Request $request)
    {
        $request->validate([
            'nama_tugas' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'tanggal_pemberian_tugas' => 'required|date',
            'tanggal_pengumpulan' => 'required|date',
            'status' => 'required|string',
        ]);
        $mahasiswa_id = Auth::user()->id;
        
        $tugas = Tugas::create([
            'nama_tugas' => $request->nama_tugas,   
            'deskripsi' => $request->deskripsi,
            'tanggal_pemberian_tugas' => $request->tanggal_pemberian_tugas,
            'tanggal_pengumpulan' => $request->tanggal_pengumpulan,
            'status' => $request->status,
            'mahasiswa_id' => $mahasiswa_id,
        ]);

        return response()->json([
            'message' => 'Tugas berhasil ditambahkan!',
            'data' => $tugas
        ]);
    }
    
    
}
