<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //admin kullanıcısını oluştur

        $adminUser = User::firstOrCreate([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        $adminUser->assignRole('admin');

        //user kullanıcısını oluştur
        $user = User::firstOrCreate([
            'name' => 'user',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
        ]);

        $user->assignRole('user');

        //guest kullanıcısını oluştur
        $guest = User::firstOrCreate([
            'name' => 'guest',
            'email' => 'guest@example.com',
            'password' => Hash::make('password'),
        ]);

        $guest->assignRole('guest');
    }
}
