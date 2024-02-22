<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            'id' => 44,
            'name' => 'SuperAdmin',
        ]);
        DB::table('roles')->insert([
            'id' => 77,
            'name' => 'default',
        ]);
        DB::table('users')->insert([
            'name' => 'AZERazer1234',
            'email' => 'abdellahbardichwork@gmail.com',
            //password using password hash
            'password' => Hash::make('AZERazer1234'),
            'address' => 'Rabat',
            'role_id' => 44,
        ]);
    }
}
