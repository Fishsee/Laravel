<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        foreach (range(1, 10) as $index) 
        {
            DB::table('users')->insert([
                'name' => 'User ' . $index,
                'email' => 'user' . $index . '@example.com',
                'password' => Hash::make('password'),
            ]);
        }
    }
}
