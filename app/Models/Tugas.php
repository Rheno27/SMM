<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    protected $fillable = [
        'nama_tugas', 
        'deskripsi', 
        'tanggal_pemberian_tugas', 
        'tanggal_pengumpulan', 
        'status'
    ];

}
