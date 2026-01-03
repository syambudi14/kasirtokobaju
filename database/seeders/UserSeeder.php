<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@tokobaju.com',
            'role' => 'admin',
            'password' => Hash::make('password123'),
        ]);

        // Staff
        User::create([
            'name' => 'Kasir Staff',
            'email' => 'kasir@tokobaju.com',
            'role' => 'staff',
            'password' => Hash::make('kasir123'),
        ]);
    }
}
