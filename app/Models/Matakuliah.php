<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Matakuliah extends Model
{
    use HasFactory;
    
    protected $table = 'mata_kuliah';

    protected $fillable = [
        'nama_mata_kuliah',
        'kode_mata_kuliah',
        'sks',
    ];
    
}