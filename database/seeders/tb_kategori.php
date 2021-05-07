<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class tb_kategori extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tb_kat_barang')->insert([
            'kategori' => 'Elektronik',
            'slug' => 'elektronik'
        ]);
        DB::table('tb_kat_barang')->insert([
            'kategori' => 'Alat Tulis',
            'slug' => 'alat_tulis'
        ]);
        DB::table('tb_kat_barang')->insert([
            'kategori' => 'Fashion',
            'slug' => 'fashion'
        ]);
        DB::table('tb_kat_barang')->insert([
            'kategori' => 'Otomotif',
            'slug' => 'otomotif'
        ]);
        DB::table('tb_kat_barang')->insert([
            'kategori' => 'Olahraga',
            'slug' => 'elektronik'
        ]);
        DB::table('tb_kat_barang')->insert([
            'kategori' => 'Alat Rumah Tangga',
            'slug' => 'Alat Rumah Tangga'
        ]);
        DB::table('tb_kat_barang')->insert([
            'kategori' => 'Kesehatan',
            'slug' => 'Kesehatan'
        ]);
        DB::table('tb_kat_barang')->insert([
            'kategori' => 'Bangunan',
            'slug' => 'bangunan'
        ]);
    }
}
