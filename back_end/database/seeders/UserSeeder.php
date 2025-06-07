<?php

namespace Database\Seeders;

use App\Models\User;

use Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // register  user



        User::create([
            'name' => 'mintesnot',
            'email' => 'mintesnot@gmail.com',
            'password' => Hash::make('password123'), // Always hash passwords

        ]);




    }
}
