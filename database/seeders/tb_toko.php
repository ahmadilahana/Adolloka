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
            'alamat' => 'jalan sehat sentosa',
            'desa' => 'sijeruk',
            'kecamatan' => 'boja',
            'kota' => 'semarang',
            'provinsi' => 'jawa tengah',
            'kd_pos' => 14045,
            "domain_toko" => "adolloka-1",
            "akun_id" => 1
        ]);
        Toko::create([
            "nama_toko" => "adolloka 2",
            'alamat' => 'jalan sehat sentosa',
            'desa' => 'sijeruk',
            'kecamatan' => 'boja',
            'kota' => 'semarang',
            'provinsi' => 'jawa tengah',
            'kd_pos' => 14045,
            "domain_toko" => "adolloka-2",
            "akun_id" => 2
        ]);
        Toko::create([
            "nama_toko" => "adolloka 3",
            'alamat' => 'jalan sehat sentosa',
            'desa' => 'sijeruk',
            'kecamatan' => 'boja',
            'kota' => 'semarang',
            'provinsi' => 'jawa tengah',
            'kd_pos' => 14045,
            "domain_toko" => "adolloka-3",
            "akun_id" => 3
        ]);
    }
}
