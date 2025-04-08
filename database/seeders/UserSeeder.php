<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'jay',
            'email' => 'jay@example.com',
            'password' => Hash::make('1'),
            'role' => 'admin',
        ]);
        User::create([
            'name' => 'Seller',
            'email' => 'seller@example.com',
            'password' => Hash::make('1'),
            'role' => 'seller',
        ]);
        User::create([
            'name' => 'buyer',
            'email' => 'buyer@example.com',
            'password' => Hash::make('1'),
            'role' => 'end_user',
        ]);
    }
}
