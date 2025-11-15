<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Pengguna::updateOrCreate(
            ['email' => 'admin@photobooth.com'],
            [
                'nama_pengguna' => 'admin',
                'password' => Hash::make('123456'),
                'role' => 'admin',
            ]
        );
    }
}
