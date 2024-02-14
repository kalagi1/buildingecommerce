<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderChangeSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('type', '2')
            ->where('status', '1')
            ->where('corporate_account_status', '1')
            ->get();

        $order = 1;

        foreach ($users as $user) {
            $user->update(['order' => $order]);
            $order++;
        }
    }
}
