<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            tb_akun::class,
            tb_alamat_user::class,
            tb_user::class,
            tb_kategori::class,
            tb_toko::class,
            tb_barang::class,
        ]);
    }
}
