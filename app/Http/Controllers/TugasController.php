<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tugas;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ResponseHelper;

class TugasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }
    public function index()
    {
        $tugas = Tugas::all();
        return ResponseHelper::success('Tugas berhasil ditampilkan!', $tugas);
    }

    public function show($identifier)
    {
        if (!is_numeric($identifier)) {
            return ResponseHelper::error('Parameter harus berupa angka!', 400);
        }
    
        $tugas = Tugas::find($identifier);
        if ($tugas) {
            return ResponseHelper::success('Tugas berhasil ditampilkan!', $tugas);
        }
    
        $tugasByMahasiswa = Tugas::where('mahasiswa_id', $identifier)->get();
        if ($tugasByMahasiswa->isEmpty()) {
            return ResponseHelper::error('Tugas tidak ditemukan!', 404);
        }
    
        return ResponseHelper::success('Tugas mahasiswa berhasil ditampilkan!', $tugasByMahasiswa);
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

        return ResponseHelper::success('Tugas berhasil ditambahkan!', $tugas);
    }

    public function update(Request $request, $id)
    {
        $tugas = Tugas::find($id);
        $user_id = Auth::user()->id;
        if (!$tugas) {
            return ResponseHelper::error('Tugas tidak ditemukan!', 404);
        }
        if ($tugas->mahasiswa_id !== $user_id) {
            return ResponseHelper::error('Anda tidak memiliki akses untuk mengubah tugas ini!', 403); 
        }
    
        $request->validate([
            'nama_tugas' => 'sometimes|string|max:100',
            'deskripsi' => 'sometimes|string',
            'tanggal_pemberian_tugas' => 'sometimes|date',
            'tanggal_pengumpulan' => 'sometimes|date',
            'status' => 'sometimes|string',
        ]);
    
        $tugas->update($request->only(['nama_tugas', 'deskripsi', 'tanggal_pemberian_tugas', 'tanggal_pengumpulan', 'status']));
        return ResponseHelper::success('Tugas berhasil diubah!', $tugas);
    }

    public function destroy($id)
    {
        $tugas = Tugas::find($id);
        $user_id = Auth::user()->id;
        if (!$tugas) {
            return ResponseHelper::error('Tugas tidak ditemukan!', 404);
        }
        if ($tugas->mahasiswa_id !== $user_id) {
            return ResponseHelper::error('Anda tidak memiliki akses untuk menghapus tugas ini!', 403); 
        }
        $tugas->delete();
        return ResponseHelper::success('Tugas berhasil dihapus!', $tugas);
    }
}
