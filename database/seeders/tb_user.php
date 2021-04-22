<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Profile;

class tb_user extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Profile::create([
                'nama' => 'test 1',
                'tgl_lahir' => '1999-02-01',
                'gender' => 'L',
                'akun_id' => 1
        ]);
        Profile::create([
                'nama' => 'test 2',
                'tgl_lahir' => '1999-02-01',
                'gender' => 'L',
                'akun_id' => 2
        ]);
        Profile::create([
                'nama' => 'test 3',
                'tgl_lahir' => '1999-02-01',
                'gender' => 'L',
                'akun_id' => 3
        ]);
    }
}
