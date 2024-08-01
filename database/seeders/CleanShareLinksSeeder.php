<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CleanShareLinksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cartOrders = DB::table('cart_orders')->get();

        foreach ($cartOrders as $cartOrder) {
            // Decode the JSON data stored in the cart column
            $cartData = json_decode($cartOrder->cart, true);

            // Check if the type in the JSON data is 'project'
            if (isset($cartData['type']) && $cartData['type'] === 'project') {
                // Retrieve the Housing model using the item_id from the JSON data
                if (isset($cartData['item']['id'])) {
                    $project = Project::find($cartData['item']['id']);

                    if ($project) {
                        $project->is_sold = NULL;
                        $project->save();
                    }
                }
            }
        }
    }
}
