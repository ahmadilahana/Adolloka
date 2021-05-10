<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barang;

class tb_barang extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i <= 3; $i++) { 
            Barang::create([
                'nama' => 'Mesin Cuci SHARP',
                'jumlah' => 12,
                'harga' => 1000,
                'deskripsi' => 'Mencuci dengan cepat dan bersih tanpa merusak baju',
                'kategori_id' => 1,
                'toko_id' => $i,
            ]);
            Barang::create([
                'nama' => 'Pensil Ajaib',
                'jumlah' => 12,
                'harga' => 100,
                'deskripsi' => 'Pensil yang dapat menulis sendiri, membantu anda mempercepat menulis',
                'kategori_id' => 2,
                'toko_id' => $i,
            ]);
            Barang::create([
                'nama' => 'Baju Bekas',
                'jumlah' => 12,
                'harga' => 200,
                'deskripsi' => 'Baju sekali pakai terus buang',
                'kategori_id' => 3,
                'toko_id' => $i,
            ]);
            Barang::create([
                'nama' => 'Ninja Kawasaki Honda Yamaha',
                'jumlah' => 12,
                'harga' => 10000,
                'deskripsi' => 'Motor tapi mobil tapi bukan motor juga bukan mobil',
                'kategori_id' => 4,
                'toko_id' => $i,
            ]);
            Barang::create([
                'nama' => 'Sepatu Lari DITINDAS',
                'jumlah' => 12,
                'harga' => 500,
                'deskripsi' => 'Sepatu bisa lari sendiri, sudah mandiri',
                'kategori_id' => 5,
                'toko_id' => $i,
            ]);
            Barang::create([
                'nama' => 'Kompor LPG',
                'jumlah' => 12,
                'harga' => 1000,
                'deskripsi' => 'Kompor bisa masak sendiri',
                'kategori_id' => 6,
                'toko_id' => $i,
            ]);
            Barang::create([
                'nama' => 'Vitamin ABCDEF',
                'jumlah' => 12,
                'harga' => 1000,
                'deskripsi' => 'Vitamin supaya bisa baca',
                'kategori_id' => 7,
                'toko_id' => $i,
            ]);
            Barang::create([
                'nama' => 'Semen Lemah KEK TANAH',
                'jumlah' => 12,
                'harga' => 1000,
                'deskripsi' => 'Semen yang bisa membangun rumah sendiri',
                'kategori_id' => 8,
                'toko_id' => $i,
            ]);
        }
    }
}
