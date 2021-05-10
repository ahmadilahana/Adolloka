<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Toko;

class tb_toko extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Toko::create([
            "nama_toko" => "adolloka 1",
            "alamat" => "semarang",
            "akun_id" => 1
        ]);
        Toko::create([
            "nama_toko" => "adolloka 2",
            "alamat" => "magelang",
            "akun_id" => 2
        ]);
        Toko::create([
            "nama_toko" => "adolloka 3",
            "alamat" => "kediri",
            "akun_id" => 3
        ]);
    }
}
