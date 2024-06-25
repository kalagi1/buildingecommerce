<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Listeners\UpdateHousingsCache;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // $this->call(OrderChangeSeeder::class);
        // $this->call(InstitutionSeeder::class);

        // $this->call(HousingSeeder::class);
        $this->call(UpdateHousingTypesSeeder::class);
    }   
}
