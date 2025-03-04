<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tugas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_tugas');
            $table->string('deskripsi');
            $table->date('tanggal_pemberian_tugas');
            $table->date('tanggal_pengumpulan');
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('mahasiswa_id')->constrained('mahasiswa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas');
    }
};
