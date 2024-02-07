<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UpdateUserSeeder extends Seeder
{
    /**
    * Run the database seeds.
    */
    public function run(): void
    {
        $users = User::whereNotNull('parent_id')->get();

        $users->each(function ($user) {
            $user->update([
                'code' => $user->id + 1000000 + $user->parent_id
            ]);
        });
    }
}
