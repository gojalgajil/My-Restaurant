<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Ahmad Pelayan',
                'email' => 'pelayan@restaurant.com',
                'password' => Hash::make('password'),
                'role' => 'pelayan',
            ],
            [
                'name' => 'Budi Kasir',
                'email' => 'kasir@restaurant.com',
                'password' => Hash::make('password'),
                'role' => 'kasir',
            ],
            [
                'name' => 'Siti Pelayan',
                'email' => 'siti@restaurant.com',
                'password' => Hash::make('password'),
                'role' => 'pelayan',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
