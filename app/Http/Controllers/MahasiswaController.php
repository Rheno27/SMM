<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class MahasiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show', 'store']);
    }
    /**
     * Menampilkan daftar mahasiswa
     */
    public function index()
    {
        $mahasiswa = Mahasiswa::all();
        return ResponseHelper::success('Mahasiswa berhasil ditampilkan!', $mahasiswa);
    }

    /**
     * Menampilkan detail mahasiswa berdasarkan ID
     */
    public function show($id)
    {
        $mahasiswa = Mahasiswa::find($id);
        if (!$mahasiswa) {
            return ResponseHelper::error('Mahasiswa tidak ditemukan!', 404);
        }
        return ResponseHelper::success('Mahasiswa berhasil ditampilkan!', $mahasiswa);
    }

    /**
     * Menyimpan data mahasiswa baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'nim' => 'required|string|max:10|unique:mahasiswa,nim',
            'email' => 'required|email|max:100|unique:mahasiswa,email',
            'prodi' => 'required|string|max:100',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'alamat' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'password' => 'required|string|min:6'
        ]);

        $path = $request->file('foto') ? $request->file('foto')->store('mahasiswa_foto', 'public') : null;
        
        $mahasiswa = Mahasiswa::create([
            'nama' => $request->nama,
            'nim' => $request->nim,
            'email' => $request->email,
            'prodi' => $request->prodi,
            'foto' => $path,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'password' => bcrypt($request->password)
        ]);

        return ResponseHelper::success('Mahasiswa berhasil ditambahkan!', $mahasiswa);
    }

    /**
     * Mengubah data mahasiswa berdasarkan ID
     */
    public function update(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::find($id);
        $user_id = Auth::user()->id;
        if (!$mahasiswa) {
            return ResponseHelper::error('Mahasiswa tidak ditemukan!', 404);
        }
        if ($mahasiswa->id !== $user_id) {
            return ResponseHelper::error('Anda tidak memiliki akses untuk mengubah data ini!', 403);
        }

        $request->validate([
            'nama' => 'sometimes|string|max:100',
            'nim' => 'sometimes|string|max:10|unique:mahasiswa,nim,' ,
            'prodi' => 'sometimes|string|max:100',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'alamat' => 'sometimes|string|max:255',
            'no_hp' => 'sometimes|string|max:15',
            'tanggal_lahir' => 'sometimes|date',
            'jenis_kelamin' => 'sometimes|in:Laki-laki,Perempuan',
        ]);

        if ($request->hasFile('foto')) {
            if ($mahasiswa->foto) {
                Storage::disk('public')->delete($mahasiswa->foto);
            }

            $path = $request->file('foto')->store('mahasiswa_foto', 'public');
            $mahasiswa->foto = $path;
        }

        $mahasiswa->update($request->except('foto'));

        if(empty($request->input('nama')) && empty($request->input('nim')) && empty($request->input('email')) && empty($request->input('prodi')) && empty($request->input('alamat')) && empty($request->input('no_hp')) && empty($request->input('tanggal_lahir')) && empty($request->input('jenis_kelamin'))){
            return ResponseHelper::error('Tidak ada data yang diubah!', 400);
        }

        return ResponseHelper::success('Mahasiswa berhasil diubah!', $mahasiswa);
    }

    /**
     * Menghapus data mahasiswa berdasarkan ID
     */
    public function destroy($id)
    {
        $mahasiswa = Mahasiswa::find($id);
        $user_id = Auth::user()->id;
        if (!$mahasiswa) {
            return ResponseHelper::error('Mahasiswa tidak ditemukan!', 404);
        }
    
        if ($mahasiswa->id !== $user_id) {
            return ResponseHelper::error('Anda tidak memiliki akses untuk menghapus data ini!', 403);
        }
        $mahasiswa->matakuliah()->detach();
    
        $mahasiswa->tugas()->delete();
    
        $mahasiswa->delete();
    
        if ($mahasiswa->tokens()) {
            $mahasiswa->tokens()->delete();
        }
        return ResponseHelper::success('Akun berhasil dihapus dan Anda telah logout!', []);
    }

    /**
     * Menambahkan mata kuliah ke mahasiswa
     */ 
    public function tambahMatakuliah(Request $request, $mahasiswa_id)
    {
        $mahasiswa = Mahasiswa::find($mahasiswa_id);
        $user_id = Auth::user()->id;
        
        if (!$mahasiswa) {
            return ResponseHelper::error('Mahasiswa tidak ditemukan!', 404);
        }
    
        if ($mahasiswa->id !== $user_id) {
            return ResponseHelper::error('Anda tidak memiliki akses untuk menambahkan mata kuliah ini!', 403);
        }
    
        $matakuliah_id = $request->input('mata_kuliah_id');
        $matakuliah = Matakuliah::find($matakuliah_id);
    
        if (!$matakuliah) {
            return ResponseHelper::error('Mata kuliah tidak ditemukan!', 404);
        }
    
        if ($mahasiswa->matakuliah()->where('mata_kuliah_id', $matakuliah_id)->exists()) {
            return ResponseHelper::error('Mata kuliah sudah diambil oleh mahasiswa ini!', 400);
        }
    
        $mahasiswa->matakuliah()->attach($matakuliah_id);
    
        return ResponseHelper::success('Mata kuliah berhasil ditambahkan ke mahasiswa!', $mahasiswa->matakuliah);
    }


}
