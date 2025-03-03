<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nama', 
        'nim', 
        'email', 
        'prodi', 
        'foto', 
        'alamat', 
        'no_hp', 
        'tanggal_lahir', 
        'jenis_kelamin'
    ];


}

