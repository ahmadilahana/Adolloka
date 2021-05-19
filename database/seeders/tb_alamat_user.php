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
                'alamat' => 'semarang',
                'jns_alamat' => 'Alamat Utama',
                'status' => 'eneble',
                'user_id' => 1
        ]);
        AlamatUser::create([
                'penerima' => "tes2",
                'no_hp' => '08130813013',
                'alamat' => 'semarang',
                'jns_alamat' => 'Alamat Utama',
                'status' => 'eneble',
                'user_id' => 2
        ]);
        AlamatUser::create([
                'penerima' => "tes3",
                'no_hp' => '08130813013',
                'alamat' => 'semarang',
                'jns_alamat' => 'Alamat Utama',
                'status' => 'eneble',
                'user_id' => 3
        ]);
    }
}
