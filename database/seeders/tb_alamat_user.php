<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AlamatUser;

class tb_alamat_user extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AlamatUser::create([
                'penerima' => "tes1",
                'no_hp' => '08130813013',
                'alamat' => 'jalan sehat sentosa',
                'desa' => 'sijeruk',
                'kecamatan' => 'boja',
                'kota' => 'semarang',
                'provinsi' => 'jawa tengah',
                'kd_pos' => 14045,
                'jns_alamat' => 'Alamat Utama',
                'status' => 'eneble',
                'akun_id' => 1
        ]);
        AlamatUser::create([
                'penerima' => "tes2",
                'no_hp' => '08130813013',
                'alamat' => 'jalan sehat sentosa',
                'desa' => 'sijeruk',
                'kecamatan' => 'boja',
                'kota' => 'semarang',
                'provinsi' => 'jawa tengah',
                'kd_pos' => 14045,
                'jns_alamat' => 'Alamat Utama',
                'status' => 'eneble',
                'akun_id' => 2
        ]);
        AlamatUser::create([
                'penerima' => "tes3",
                'no_hp' => '08130813013',
                'alamat' => 'jalan sehat sentosa',
                'desa' => 'sijeruk',
                'kecamatan' => 'boja',
                'kota' => 'semarang',
                'provinsi' => 'jawa tengah',
                'kd_pos' => 14045,
                'jns_alamat' => 'Alamat Utama',
                'status' => 'eneble',
                'akun_id' => 3
        ]);
    }
}
