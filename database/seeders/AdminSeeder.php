<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->updateOrInsert(
            ['id' => 1],
            [
                'first_name' => 'Rabeya Bosri',
                'last_name' => 'Tamanna',
                'email' => 'rbtamannarbt@gmail.com',
                'password' => Hash::make('welcome'),
                'user_type' => Config::get('variable_constants.user_type.admin'),
            ]
        );
    }
}
