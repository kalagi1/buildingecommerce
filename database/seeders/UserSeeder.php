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
        $password = Hash::make("admin");

        User::create([
            'name' => 'Administrator',
            'email' => 'info@admin.com',
            'password' => $password,
            'type' => 3,
            'status' => 1,
        ]);
    }
}
