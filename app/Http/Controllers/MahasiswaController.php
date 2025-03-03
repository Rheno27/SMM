<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

use App\Models\Mahasiswa;

class MahasiswaController extends Controller
{
    /**
     * show the form for creating a new resource
     */
    public function create()
    {
        return response()->json(Mahasiswa::all()->get());
    }

    /**
     * store a newly created resource in storage
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nim' => 'required',
            'email' => 'required',
            'prodi' => 'required',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'alamat' => 'required',
            'no_hp' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
        ]);
        $path = $request->file('foto') ? $request->file('foto')->store('posts', 'public') : null;

        $post = Mahasiswa::create([
            'nama' => $request->nama,
            'nim' => $request->nim,
            'email' => $request->email,
            'prodi' => $request->prodi,
            'foto' => $path,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
        ]);

        return response()->json($post);
    }

    /**
     * display the specified resource
     */
    public function show($id)
    {
        $post = Mahasiswa::where('id', $id)->first();

        return response()->json($post);

    }
}
