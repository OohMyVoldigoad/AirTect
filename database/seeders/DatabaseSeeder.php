<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $Admin = User::create([
            'name' => 'admin ganteng',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            ]);
    }
}
