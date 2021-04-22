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
                'alamat' => 'semarang',
                'jns_alamat' => 'Alamat Utama',
                'user_id' => 1
        ]);
        AlamatUser::create([
                'alamat' => 'semarang',
                'jns_alamat' => 'Alamat Utama',
                'user_id' => 2
        ]);
        AlamatUser::create([
                'alamat' => 'semarang',
                'jns_alamat' => 'Alamat Utama',
                'user_id' => 3
        ]);
    }
}
