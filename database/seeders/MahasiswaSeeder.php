<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i = 1; $i <= 50; $i++) {
            DB::table('mahasiswa')->insert([
                'nama' => $faker->name,
                'nim' => '22' . str_pad($i, 8, '0', STR_PAD_LEFT), // Contoh: 2200000001
                'email' => $faker->unique()->safeEmail,
                'prodi' => $faker->randomElement(['Informatika', 'Sistem Informasi', 'Teknik Elektro', 'Teknik Sipil']),
                'foto' => null,
                'alamat' => $faker->address,
                'no_hp' => substr($faker->phoneNumber, 0, 15),
                'tanggal_lahir' => $faker->date('Y-m-d', '2005-01-01'),
                'jenis_kelamin' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
