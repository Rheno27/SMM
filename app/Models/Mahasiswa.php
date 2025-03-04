<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Mahasiswa extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $table = 'mahasiswa';

    protected $fillable = [
        'nama', 
        'nim', 
        'email', 
        'prodi', 
        'foto', 
        'alamat', 
        'no_hp', 
        'tanggal_lahir', 
        'jenis_kelamin',
        'password'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'password' => 'hashed',
    ];
}
