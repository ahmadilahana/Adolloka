<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class tb_akun extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
                'username' => 'test1',
                'email' => 'test1@email.com',
                'no_hp' => '08130183013',
                'password' => Hash::make('123123')
        ]);

        User::create([
                'username' => 'test2',
                'email' => 'test2@email.com',
                'no_hp' => '08130183013',
                'password' => Hash::make('123123')
        ]);

        User::create([
            'username' => 'test3',
            'email' => 'test3@email.com',
            'no_hp' => '08130183013',
            'password' => Hash::make('123123')
        ]);
    }
}
