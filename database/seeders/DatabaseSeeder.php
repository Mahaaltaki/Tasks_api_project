<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'maha',
            'email' => 'mmm360616@gmail.com',
            'password'=>Hash::make('123456789'),
            'role'=>'admin',
        ]);
        \App\Models\User::factory()->create([
            'name' => 'manager',
            'email' => 'manager@manager.com',
            'password'=>Hash::make('123456789'),
            'role'=>'admin',
        ]);
    }
}
