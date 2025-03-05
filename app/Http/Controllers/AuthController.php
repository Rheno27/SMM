<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Helpers\ResponseHelper;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $mahasiswa = Mahasiswa::where('email', $request->email)->first();
        if (!$mahasiswa || !Hash::check($request->password, $mahasiswa->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah!'],
            ]);
        }

        $token = $mahasiswa->createToken('API TOKEN')->plainTextToken;
        return ResponseHelper::success('Login berhasil!', [
            'token' => $token,
            'data' => $mahasiswa
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return ResponseHelper::success('Logout berhasil!', []);
    }
}

